<?php
//controllo l'unicità dell'username
//require include la pagina php ma a differenza di include ritorna un errore in caso
require 'dbmsconfig.php';

header('Contnent-Type:  application/json');
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$username = mysqli_real_escape_string($conn, $_GET['q']); //leggo il campo q che prende col get dal client

$query = "SELECT username FROM pilota WHERE username = '$username'";
$res = mysqli_query($conn, $query);
$json_array = array('exists' => mysqli_num_rows($res) > 0 ? true : false);
$json = json_encode($json_array);
echo $json;
mysqli_close($conn);
?>