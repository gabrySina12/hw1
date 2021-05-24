<?php
require 'dbmsconfig.php';

header('Contnent-Type:  application/json');
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$squadra = mysqli_real_escape_string($conn, $_GET['q']);
$query = "CALL P4('$squadra')";
$res = mysqli_query($conn, $query) or die("Errore: ".mysqli_error($conn));


if(mysqli_num_rows($res)>0){
    while($row = mysqli_fetch_assoc($res)){
        $json_array[] = $row;
    }
$json = json_encode($json_array);
echo $json;
}

mysqli_close($conn);
?>