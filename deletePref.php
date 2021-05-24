<?php
require 'dbmsconfig.php';
require 'auth.php';


$username = checkAuth();

header('Contnent-Type:  application/json');
$titolo = mysqli_real_escape_string($conn, $_GET['q']);
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$titolo = mysqli_real_escape_string($conn, $_GET['q']);
$query_2 = "SELECT* FROM preferiti WHERE titolo = '$titolo' AND username = '$username'";
$res_2 = mysqli_query($conn, $query_2) or die("Errore: ".mysqli_error($conn));

if(mysqli_num_rows($res_2)>0){
$query_1 = "DELETE FROM preferiti WHERE username = '$username' AND titolo = '$titolo'";
$res_1 = mysqli_query($conn, $query_1) or die("Errore: ".mysqli_error($conn));
}

mysqli_close($conn);
?>