drop database Rally;
create database Rally;
use Rally;

create table video(
link varchar(255) primary key,
pic varchar(255)
)Engine = 'InnoDB';

create table preferiti(
username varchar(255) not null,
titolo varchar(255) not null,
link varchar(255),
pic varchar(255),
descrizione varchar(255)
)Engine = 'InnoDB';

create table Squadra(
Codice integer auto_increment primary key,
nome varchar(255) not null unique
)Engine = 'InnoDB';

create table Pilota(
nome varchar(255) not null,
cognome varchar(255)not null,
data_nascita date not null,
email varchar(255) not null primary key,
username varchar(255) unique,
password varchar(255)not null,
squadra integer not null,
index idx_squadra(squadra),
foreign key(squadra) references Squadra(codice)
)Engine = 'InnoDB';

create table Copilota(
nome varchar(255) not null,
cognome varchar(255) not null,
data_nascita date not null,
email varchar(255) not null primary key,
username varchar(255) not null unique,
password varchar(255) not null,
squadra integer not null,
index idx_squadra(squadra),
foreign key(squadra) references Squadra(codice)
)Engine = 'InnoDB';

create table Categoria(
codice integer auto_increment primary key,
nome varchar(255),
n_squadre integer default 0
)Engine = 'InnoDB';


create table Veicolo(
targa varchar(255) primary key,
modello varchar(255),
cilindrata integer
)Engine = 'InnoDB';


create table Categoria_squadra_veicolo(
categoria integer,
squadra integer,
veicolo varchar(255),
index idx_categoria(categoria),
index idx_squadra(squadra),
index idx_targa(veicolo),
foreign key(categoria) references Categoria(codice),
foreign key(squadra) references Squadra(codice),
foreign key(veicolo) references Veicolo(targa),
primary key(categoria, squadra, veicolo)
)Engine = 'InnoDB';

create table Evento(
codice  integer auto_increment primary key,
nome varchar(255),
citta varchar(255),
link varchar(255),
pic varchar(255),
descrizione varchar(255)
)Engine = 'InnoDB';

create table Categoria_Evento(
categoria integer,
evento integer,
index idx_categoria(categoria),
index idx_evento(evento),
foreign key(categoria) references Categoria(codice),
foreign key(evento) references Evento(codice),
primary key(categoria, evento)
)Engine = 'InnoDB';


create table Circuito(
ID integer auto_increment primary key,
nome varchar(255),
km integer
)Engine = 'InnoDB';

create table Luogo(
citta varchar(255),
circuito integer primary key,
regione varchar(255),
nazione varchar(255),
index idx_tappa(circuito),
foreign key(circuito) references Circuito(ID)
)Engine = 'InnoDB';


create table Edizione(
data_inizio date,
data_fine date,
evento integer not null,
circuito integer not null,
index idx_evento(evento),
index idx_circuito(circuito),
foreign key(evento) references Evento(codice),
foreign key(circuito) references Circuito(ID),
primary key(data_inizio, evento, circuito)
)Engine = 'InnoDB';

/*Allineare numero squadre per categoria --->Trigger aggiorna attributo ridontante*/
delimiter //
create trigger aggiorna_numero_squadre
after insert on categoria_squadra_veicolo
for each row
begin
if exists(select * 
          from categoria
          where codice = new.categoria)
then
 update categoria set n_squadre = n_squadre + 1 where codice = new.categoria;
end if;
end //
delimiter ;


 /*Business rule: Un evento non può avere più di 3 categoria*/  

delimiter //
create trigger controllo_categorie
before insert on evento
for each row
begin
if exists(select nome, (count(categoria)>4)
              from evento e join categoria_evento ce on e.codice = ce.evento
              where e.codice = new.codice
              group by  nome)
then
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Un evento non può avere più di 3 categorie';

end if;
end//
delimiter ;



/*Vista di supporto: Conta edizioni---> procedura 2*/
create view conta_edizioni as
select e.evento, count(*)as numero_edizioni
from edizione e
group by e.evento;



/*Operazione 1 su entità figlia: Controllare se ci sono omonimi tra i copiloti*/
delimiter //
create procedure P1()
begin
select*
from copilota c
where exists (select c1.cognome
			  from copilota c1
			  where c1.cognome = c.cognome and c1.email <> c.email);
end//
delimiter ;

/*Operazione 2 sulla storicizzazione: Dato un evento contare quante edizioni ha */

delimiter //
create procedure P2(in nome varchar(255))
begin
drop table if exists numero_edizioni;
create temporary table numero_edizioni(
evento_nome varchar(255) primary key,
edizioni_numero integer
)engine = 'InnoDB';
insert into numero_edizioni
select e.nome, ce.numero_edizioni as edizioni
from conta_edizioni ce join evento e on ce.evento = e.codice
where e.nome like concat(nome, '%');

select* from numero_edizioni;
end //
delimiter ;


/*Operazione 3 scrittura su attributo ridondante con case: Inserimento di un pilota se nella squadra ci sono meno di 3 piloti altrimenti non metterlo in squadra*/
delimiter //
create procedure P3(in nome2 varchar(255), in cognome2 varchar(255), in data_nascita2 date, in email2 varchar(255), in username2 varchar(255), in pass2 varchar(255), in squadra2 integer)
begin
INSERT INTO `Pilota` (`nome`, `cognome`, `data_nascita`, `email`,`username`,`pass`, `squadra`) VALUES (nome2, cognome2, data_nascita2, email2, username2, pass2, case
																														when (select count(*) as piloti
                                                                                                                        from pilota p
	                                                                                                                    where p.squadra = squadra2 and p.squadra <> 1                               
	                                                                                                                    having piloti <3) then squadra2 else 1			
                                                                                                                        end);

if exists (select*
		   from pilota p
           where p.email = email2 and p.squadra = 1)
then
           SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La squadra selezionata ha già 3 piloti, non sei stato assegnato a nessuna squadra';
end if;

end //
delimiter ;


/*Operazione 4 lettura su attributo ridondante: Dato un evento contare quante squadre partecipanti ci sono*/
create view v1 as
select e.codice as codice_Evento, e.nome as nome_evento, c.codice as codice_categoria, c.nome as nome_categoria, c.n_squadre as numero_squadre
from evento e join categoria_evento ce on e.codice = ce.evento join categoria c on ce.categoria = c.codice;

delimiter //
create procedure P4(in evento2 varchar(255))
begin
drop table if exists categoria_partecipanti;
create temporary table categoria_partecipanti(
nome_evento varchar(255) primary key,
squadre_partecipanti integer
)engine = 'InnoDB';
insert into categoria_partecipanti
select nome_evento, sum(numero_squadre)
from v1
where nome_evento like concat(evento2, '%')
group by nome_evento;

select* from categoria_partecipanti;
end //
delimiter ;

/*call P4('e');*/

/*Ogni circuito a quante edizioni di evento appartiene*/

select c.ID, count(*)
from circuito c join edizione e on c.ID = e.circuito
group by c.ID;

/*Data in ingresso una squadra calcolare il numero di eventi a cui ha partecipato in una relativa categoria*/

delimiter //
create procedure P5(in squadra1 integer)
begin
drop table if exists temp;
create temporary table temp(
id integer,
categoria varchar(255),
conta integer
);
insert into temp
select c.nome as nome_categoria, count(*)
from squadra s join categoria_squadra_veicolo csv on s.Codice = csv.squadra join categoria c on csv.categoria = c.codice join categoria_evento ec on c.codice = ec.categoria
where s.Codice = squadra1
group by nome_categoria; 
end //
delimiter ;

INSERT INTO `video` (`link`, `pic`)
VALUES 
	('https://www.youtube.com/watch?v=E55AT--PnT8', 'Immagini/gif.gif'),
	('https://www.youtube.com/watch?v=ZQ7XIGVCwsA', 'Immagini/gif1.gif'),
	('https://www.youtube.com/watch?v=SPnjMhXNQ3Y', 'Immagini/gif2.gif');
    
INSERT INTO `preferiti` (`username`, `titolo`,`link`,`pic`, `descrizione`)
VALUES 
	('gabry123', 'W.R.C', 'https://autosprint.corrieredellosport.it/news/rally/mondiale/2020/12/15-3742070/wrc_annulato_il_rally_di_svezia_2021/', 'Immagini/Hagfors.jpg', 'Rally di Svezia - Hagfors city');

INSERT INTO `Squadra` (`nome`)
VALUES 
	('Non in squadra'),
	('M-Sport'),
	('Hyundai'),
	('Toyota'),
	('Citroen'),
	('Suzuki'),
	('Subaru');
    
    INSERT INTO `Pilota` (`nome`, `cognome`, `data_nascita`,`email`,`username`,`password`,`squadra`)
VALUES
	('Teemu','Suninen', '1990-01-03','teemu1@gmail.com','teemu1','123',2),
	('Esapekka','Lappi', '1992-02-07','esapekka@gmail.com','esapekka2','123',3),
	('Dani','Sordo', '1987-07-23','danisordo@gmail.com','Dani3','123',4),
	('Ott', 'Tanak', '1995-11-05','otttanak@gmail.com','Ott4','123',5);
    
    INSERT INTO `Copilota` (`nome`, `cognome`, `data_nascita`, `email`,`username`,`password`, `squadra`)
VALUES
	('Enrico','La Torre','1986-06-16','enrico@gmail.com','enrico1','456','2'),
	('Marco','Rossi','1942-12-15','marco@gmail.com','marco2','456','3'),
	('Stefano','Rotondini','1983-05-03','stefano@gmail.com','stefano3','456',4),
	('Takamoto', 'Tatsuka', '1993-12-20','takamoto@gmail.com','takamoto4','456', 5);
    
    INSERT INTO `Veicolo` (`targa`,`modello`,`cilindrata`)
VALUES ('CT0122','208','2300'),
	   ('CT7177','Fiesta','2000'),
	   ('CT7547','i20','2400'),
	   ('CT4347','Yaris','2800'),
	   ('CT3212','C3','1900'),
	   ('CT5153','EVO6','3200'),
	   ('CT5435','Impreza','2700');
       
       INSERT INTO `Categoria` (`nome`)
VALUES
	('Racing start'),
	('Gruppo A'),
	('Gruppo N'),
	('Super 1600'),
	('Super 2000'),
	('Gruppo Kit car');
    
    INSERT INTO `Categoria_squadra_veicolo` (`categoria`,`squadra`,`veicolo`)
VALUES 
	(1,2,'CT7177'),
	(2, 3,'CT7547'),
	(3,4, 'CT4347'),
	(4,5,'CT3212'),
	(5,6,'CT5153'),
	(6,2,'CT5435'),
	(4,3,'CT0122'),
    (3,2,'CT7177');
    
    INSERT INTO `Evento` (`nome`, `citta`, `link`, `pic`, `descrizione`)
VALUES
	('W.R.C', 'Hagfors', 'https://autosprint.corrieredellosport.it/news/rally/mondiale/2020/12/15-3742070/wrc_annulato_il_rally_di_svezia_2021/', 'Immagini/Hagfors.jpg', 'Rally di Svezia - Hagfors city'),
	('E.R.C', 'Monte Carlo', 'https://www.newsauto.it/racing/wrc-rally-montecarlo-classifica-2021-298039/', 'Immagini/Montecarlo.jpg','Rally di Monte Carlo - Monaco'),
	('E.R.T', 'Arzachena', 'https://www.rallyitaliasardegna.com/2021/02/02/rally-italia-sardegna-ecco-le-novita-2021/', 'Immagini/Sardegna.jpg', 'Rally di Sardegna - Arzachena'),
	('FIA RGT', 'Jyväskylä', 'https://www.newsauto.it/racing/wrc-rally-finlandia-artic-classifica-2021-302262/#:~:text=Ott%20Tanak%20al%20volante%20della,le%20Toyota%20favorita%20sulle%20Hyundai.', 'Immagini/Finlandia.jpg', 'Rally di Finlandia - Jyväskylä'),
	('T.E.R', 'Barcelona', 'https://www.spain.info/it/eventi/campionato-mondo-rally-catalogna-costa-daurada/', 'Immagini/Barcelona.jpg', 'Rally di Spagna - Barcellona'),
	('Mitropa', 'Tokyo', 'https://www.oasport.it/2020/11/presentato-il-rally-del-giappone-2021-avra-un-itinerario-identico-a-quello-cancellato-questanno/', 'Immagini/Giappone.jpg', 'Rally del Giappone - Tokyo');
    
    INSERT INTO `Categoria_Evento` (`categoria`, `evento`)
VALUES
	(1,1),
	(2,2),
	(3,3),
	(4,4),
	(5,5),
	(6,6),
	(3,1);
    
    INSERT INTO `Circuito` (`nome`,`km`)
VALUES
	('circuito1',33),
	('circuito2',22),
	('circuito3',11),
	('circuito4',26),
	('circuito5',15),
	('circuito6',34),
	('circuito7',29);
    
    

INSERT INTO `Luogo` (`citta`, `circuito`, `regione`, `nazione`)
VALUES
	('Catania',1 ,'Sicilia', 'Italia'),
	('Tropea',2,'Calabria','Italia'),
	('Pompei',3,'Campania','Italia'),
	('Bari',4,'Puglia','Italia'),
	('Roma',5,'Lazio','Italia'),
	('Bologna', 6,'Emilia','Italia'),
	('Firenze',7,'Toscana','Italia');
    
    INSERT INTO `Edizione` (`data_inizio`,`data_fine`,`evento`,`circuito`)
VALUES
	('2019-01-20','2019-04-15', 1, 1),
	('2019-06-12','2019-06-30',2, 2),
	('2018-02-04','2018-04-02',3, 3),
	('2017-09-02','2017-11-17',4, 4),
	('2015-02-05','2015-04-22', 5,5),
	('2015-02-05','2015-04-22', 6,6);