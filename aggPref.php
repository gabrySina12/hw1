<?php
require 'dbmsconfig.php';
require 'auth.php';


$username = checkAuth();

header('Contnent-Type:  application/json');

$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$titolo = mysqli_real_escape_string($conn, $_GET['q']);
$query_2 = "SELECT* FROM preferiti WHERE titolo = '$titolo' AND username = '$username'";
$res_2 = mysqli_query($conn, $query_2) or die("Errore: ".mysqli_error($conn));

if(mysqli_num_rows($res_2)<1){
$query = "SELECT* FROM evento WHERE nome = '$titolo'";
$res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
while($row = mysqli_fetch_assoc($res)){
    $json_array[] = $row;
}
$nome = $json_array['0']['nome'];
$link = $json_array['0']['link'];
$pic = $json_array['0']['pic'];
$descrizione = $json_array['0']['descrizione'];



$query_1 = "INSERT INTO preferiti(username, titolo,link,pic, descrizione)VALUES('$username','$nome','$link','$pic','$descrizione')";
$res_1 = mysqli_query($conn, $query_1) or die("Errore: ".mysqli_error($conn));
}

mysqli_close($conn);
?>