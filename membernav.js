//Menù laterale
function change(event){
    let var1 = document.getElementById('option');
    let var2 = document.getElementById('gSquadra');
    let var5= document.getElementById('favorite');
    let var3 = event.currentTarget;
    let var4 = event.currentTarget.parentNode.querySelector('.active');
        var4.classList.remove('active')
        var2.style.display = 'none';
        var5.style.display = 'none'
        var3.classList.add('active');
        var1.style.display = 'flex';   
}

function change2(event){
    let var1 = document.getElementById('option');
    let var2 = document.getElementById('gSquadra');
    let var5= document.getElementById('favorite');
    let var3 = event.currentTarget;
    let var4 = event.currentTarget.parentNode.querySelector('.active');
        var4.classList.remove('active');
        var1.style.display = 'none';
        var5.style.display = 'none';
        var3.classList.add('active');
        var2.style.display = 'flex';
}

function change3(event){
    let var1 = document.getElementById('option');
    let var2 = document.getElementById('gSquadra');
    let var5= document.getElementById('favorite');
    let var3 = event.currentTarget;
    let var4 = event.currentTarget.parentNode.querySelector('.active');
    var4.classList.remove('active');
    var1.style.display = 'none';
    var2.style.display = 'none';
    var3.classList.add('active');
    var5.style.display = 'flex';
}
//check team per la creazione ed eventuale creazione
function jsonCheckTeam(json){
    const input = document.querySelector('.my_team');
    
    if(!json.exists){
        document.querySelector('.my_team').classList.remove('errorj');
        document.querySelector('.squadra_err').textContent = "";
        check = false;
        fetch("inserisciSquadra.php?q="+encodeURIComponent(input.value));
        showGif();
    }else
    {
        document.querySelector('.squadra_err').textContent = "Nome utente già utilizzato o già in squadra";
        document.querySelector('.my_team').classList.add('errorj');        
    }
}

function fetchResponse(response){
    if(!response.ok) return null;
    return response.json();
}

function checkTeam(event){
    
    const input = document.querySelector('.my_team');
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)){
        document.querySelector('.my_team').classList.add('errorj');
        input.parentNode.parentNode.parentNode.querySelector('.squadra_err').textContent = "Sono ammesse lettere, numeri e underscore. Massimo 15 caratteri";
    }else
    {   
        input.parentNode.parentNode.parentNode.querySelector('.squadra_err').textContent = "";
        fetch("http://localhost/mhw4/checkSquadra.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckTeam);
        
    }
    
}

function showGif(){
    document.querySelector('.gif').classList.remove('hidden');
    setTimeout(hideGif, 4500);
}

function hideGif(){
    document.querySelector('.gif').classList.add('hidden');
}

function onError(error){
    console.log('Error: ' + error);
}

function jsonTeam(json){
    const sez = document.querySelector('#team_lable');
    let sez_teams = document.createElement('div');
    sez_teams.setAttribute('id', 'teamL');
    sez_teams.setAttribute('class', 'nav--vertical')
    for(c of json){
    if(c.nome !== 'Non in squadra'){
    let row = document.createElement("div");
    row.setAttribute('class', 'row');
    let left = document.createElement('div');
    left.setAttribute('class', 'left');
    let names = document.createElement("p");
    let textNames = document.createTextNode(c.nome);
    let but = document.createElement('a');
    but.setAttribute('class', 'nav__icon');
    let icon = document.createElement("img");
    icon.setAttribute('src', 'Immagini/Add.png');
    names.appendChild(textNames);
    left.appendChild(names);
    row.appendChild(left);
    //but.appendChild(icon);
    //row.appendChild(but);
    sez_teams.appendChild(row);
    sez.appendChild(sez_teams);
    }
    
    }
}

function teamList(event){
    event.preventDefault();
    const but_team = document.querySelector('.showTeam');
    const but_hide = document.querySelector('#hideTeams');
    if(but_team.style.display == ''){
    but_team.style.display = 'none';
    but_hide.classList.remove('hidden');
    fetch('http://localhost/mhw4/listaSquadre.php').then(fetchResponse, onError).then(jsonTeam);
    }
}

function hideTeams(event){
    const but_team = document.querySelector('.showTeam');
    const but_fav = document.querySelector('#favorite_but');
    const but_hide = document.querySelector('#hideTeams');
    const sez_team = document.querySelector('#teamL');
    const all = document.querySelector('#team_lable');
    if(but_team.style.display == ''){
        but_team.style.display = 'none';
        but_hide.classList.remove('hidden');
        sez_team.classList.remove('hidden');
        fetch('http://localhost/mhw4/listaSquadre.php').then(fetchResponse, onError).then(jsonTeam);
    }else{
        but_team.style.display = '';
        but_hide.classList.add('hidden');
        all.removeChild(sez_team);
    }
}

function jsonFav(json){
    for(let c in json){

        let box = document.createElement('div');
        box.setAttribute('class', 'sez');
        let topside = document.createElement('div');
        topside.setAttribute('id', 'topsideMember');
        let titolo = document.createElement('h1');
        let txtT = document.createTextNode(json[c].titolo);
        let del = document.createElement('a');
        del.style.backgroundImage = "url('Immagini/delete.png')";      
        let link =document.createElement('a');
        link.setAttribute('href', json[c].link);
        link.setAttribute('class', 'prefPic');
        let img = document.createElement('img');
        img.setAttribute('src', json[c].pic);
        
        let divDe = document.createElement('div');
        divDe.setAttribute('class', 'divDe');
        let descr = document.createElement('span');
        let descrTxt = document.createTextNode(json[c].descrizione);


        titolo.appendChild(txtT);
        topside.appendChild(titolo);
        topside.appendChild(del);
        box.appendChild(topside);
        link.appendChild(img);
        box.appendChild(link);
        descr.appendChild(descrTxt);
        divDe.appendChild(descr);
        box.appendChild(divDe);
        del.addEventListener('click', deletePref);
        sez.appendChild(box);
    }
}

function favorite(){
    fetch('http://localhost/mhw4/preferiti.php').then(fetchResponse, onError).then(jsonFav).catch(onError);
}

function deletePref(event){
    let title = event.currentTarget.parentNode.querySelector('h1').textContent;
    let father = event.currentTarget.parentNode.parentNode.parentNode;
    let child = event.currentTarget.parentNode.parentNode;
    father.removeChild(child);
    fetch('http://localhost/mhw4/deletePref.php?q=' + title);
}

function jsonInfo(json){
    //<div class="row__label">Email</div>
    let myteams = document.getElementById('my_teams');
    let dSquadra = document.createElement('div');
    dSquadra.setAttribute('class', 'row__label');
    let squadra = document.createTextNode(json.squadra);

    //posso farmi stampare le informazioni della squadra
    dSquadra.appendChild(squadra);
    myteams.appendChild(dSquadra);
    
}

function my_teams(){
    fetch('http://localhost/mhw4/infoTeam.php').then(fetchResponse, onError).then(jsonInfo).catch(onError);
}

function jsonConta(json){
    console.log(json);
    let set = document.querySelector('.contaSq');
    for(c of json){
        let row = document.createElement('div');
        row.setAttribute('class', 'row__labels');
        let span = document.createElement('span');
        let txtSpan = document.createTextNode("Per l'evento "+ c.nome_evento + ' partecipano ' + c.squadre_partecipanti + ' squadre/a');

        span.appendChild(txtSpan);
        row.appendChild(span);
        set.appendChild(row);
    }
}

function contaSquadre(event){
    event.preventDefault();
    let squadra = document.getElementById('conta');
    fetch('http://localhost/mhw4/procedura4.php?q='+ encodeURIComponent(squadra.value)).then(fetchResponse, onError).then(jsonConta).catch(onError);
}

const sez =  document.getElementById('fav_items')
let check = true;
const op =document.getElementById('option_but');
const gs = document.getElementById('gSquadra_but');
const fv = document.getElementById('favorite_but');
op.addEventListener('click', change);
gs.addEventListener('click', change2);
fv.addEventListener('click', change3);
document.querySelector('.my_team').addEventListener('blur', checkTeam);
document.querySelector('.showTeam').addEventListener('click', teamList);
document.querySelector('#hideTeams').addEventListener('click', hideTeams);
document.getElementById('conta').addEventListener('blur', contaSquadre);
my_teams();
favorite();