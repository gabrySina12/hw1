<?php
require 'dbmsconfig.php';
require 'auth.php';

header('Contnent-Type:  application/json');
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$username = mysqli_real_escape_string($conn, checkAuth());

/*$query_2 =       "SELECT p.nome as nome, p.cognome as cognome,p.data_nascita as data1, p.email as email, p.username as username, s.Codice as codSquadra, s.nome as squadra
                  FROM pilota p join squadra s on p.squadra = s.Codice 
                  WHERE p.username = '$username' AND s.nome LIKE 'Non in squadra'";
        $res_2 = mysqli_query($conn, $query_2);

        $query_4 = "SELECT s.Codice as codSquadra, s.nome as squadra, c.nome as nome, c.cognome as cognome, c.data_nascita as data1, c.email as email, c.username as username
        FROM squadra s join copilota c on s.Codice = c.squadra  
        WHERE c.username = '$username' AND s.nome LIKE 'Non in squadra'";
$res_4 = mysqli_query($conn, $query_4); */

$query = "SELECT nome FROM squadra";
$res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
while($row = mysqli_fetch_assoc($res)){
    $json_array[] = $row;
}
$json = json_encode($json_array);
echo $json;
mysqli_close($conn);
?>