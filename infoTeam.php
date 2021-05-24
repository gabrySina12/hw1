<?php
require 'dbmsconfig.php';
require 'auth.php';

header('Contnent-Type:  application/json');
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$username = mysqli_real_escape_string($conn, checkAuth());

$query_2 =     "SELECT p.nome as nome, p.cognome as cognome,p.data_nascita as data1, p.email as email, p.username as username, s.Codice as codSquadra, s.nome as squadra
                FROM pilota p join squadra s on p.squadra = s.Codice 
                WHERE p.username = '$username'";
        $res_2 = mysqli_query($conn, $query_2) or die("Errore: ".mysqli_error($conn));

$query_4 = "SELECT s.Codice as codSquadra, s.nome as squadra, c.nome as nome, c.cognome as cognome, c.data_nascita as data1, c.email as email, c.username as username
        FROM squadra s join copilota c on s.Codice = c.squadra  
        WHERE c.username = '$username'";
$res_4 = mysqli_query($conn, $query_4) or die("Errore: ".mysqli_error($conn));

$info_squadra = array();

if(mysqli_num_rows($res_2) > 0){
while($row = mysqli_fetch_assoc($res_2)){
    $info_squadra[] = $row;
}
}else if(mysqli_num_rows($res_4) > 0){
while($row1 = mysqli_fetch_assoc($res_4)){
        $info_squadra[] = $row1;
    }
}
$len = count($info_squadra);
$codSquadra = $info_squadra['0']['codSquadra'];
$squadra = $info_squadra['0']['squadra'];
//trovo l'id della squadra dell'utente loggato 
$json_array=array('squadra'=>$squadra);




$query1 ="SELECT p.nome, p.cognome
          FROM pilota p join squadra s on p.squadra = s.Codice
          WHERE s.nome = '$squadra'";
$res1 = mysqli_query($conn, $query1) or die("Errore: ".mysqli_error($conn));
if(mysqli_num_rows($res1) > 0){
while($row = mysqli_fetch_assoc($res1)){
        $piloti[] = $row;
    }
$json_array[] = $piloti;
}

$query2 ="SELECT c.nome, c.cognome
          FROM copilota c join squadra s on c.squadra = s.Codice
          WHERE s.nome = '$squadra'";
$res2 = mysqli_query($conn, $query2) or die("Errore: ".mysqli_error($conn));
if(mysqli_num_rows($res2) > 0){
while($row = mysqli_fetch_assoc($res2)){
  $copiloti[] = $row;
}
$json_array[] = $copiloti;
}

$json = json_encode($json_array);
echo $json;
mysqli_close($conn);
?>