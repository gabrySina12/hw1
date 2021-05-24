<?php
require 'dbmsconfig.php';

header('Contnent-Type:  application/json');
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$query = "SELECT* FROM evento";
$res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));
while($row = mysqli_fetch_assoc($res)){
    $json_array[] = $row;
}
$json = json_encode($json_array);
echo $json;
mysqli_close($conn);
?>