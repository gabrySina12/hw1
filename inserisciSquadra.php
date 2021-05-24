<?php
require 'dbmsconfig.php';
require 'auth.php';
header('Contnent-Type:  application/json');
$conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['password'],$dbconfig['name']);
$squadra = mysqli_real_escape_string($conn, $_GET['q']);
$error = array();
$username = mysqli_real_escape_string($conn, checkAuth());

$query_2 = "SELECT p.nome as nome, p.cognome as cognome,p.data_nascita as data1, p.email as email, p.username as username, s.Codice as codSquadra, s.nome as squadra
                  FROM pilota p join squadra s on p.squadra = s.Codice 
                  WHERE p.username = '$username' AND s.nome LIKE 'Non in squadra'";
        $res_2 = mysqli_query($conn, $query_2);

$query_4 = "SELECT s.Codice as codSquadra, s.nome as squadra, c.nome as nome, c.cognome as cognome, c.data_nascita as data1, c.email as email, c.username as username
                  FROM squadra s join copilota c on s.Codice = c.squadra  
                  WHERE c.username = '$username' AND s.nome LIKE 'Non in squadra'";
        $res_4 = mysqli_query($conn, $query_4); 

        if(mysqli_num_rows($res_2) > 0){
            $query = "SELECT nome
                      FROM squadra
                      WHERE nome = '$squadra'";
            $res_3 = mysqli_query($conn, $query);
            if (mysqli_num_rows($res_3) > 0) {
                $error[] = "Nome già utilizzato";
            }

        }else if(mysqli_num_rows($res_4) > 0)
        {
            $query = "SELECT nome
                      FROM squadra
                      WHERE nome = '$squadra'";
            $res_3 = mysqli_query($conn, $query);
            if (mysqli_num_rows($res_3) > 0) {
                $error[] = "Nome già utilizzato";
            } 
        }else{
          $error[]="Già in una squadra";
        }
        if (count($error) == 0) {
          $query_1 = "INSERT INTO squadra(nome) VALUES('$squadra')";
          $res = mysqli_query($conn, $query_1);
          $query_5 = "SELECT Codice FROM squadra WHERE nome = '$squadra'";
          $res_5 =mysqli_query($conn, $query_5);
          while($row = mysqli_fetch_assoc($res_5)){
            $json_array[] = $row;
          }
        }
          $cod = $json_array['0']['Codice'];
          if(mysqli_num_rows($res_2) > 0){
          $update_1 = "UPDATE pilota SET squadra = '$cod' WHERE username = '$username'";
          $res_6 = mysqli_query($conn, $update_1);
          }else if(mysqli_num_rows($res_4) > 0){
            $update_2 = "UPDATE copilota SET squadra = '$cod' WHERE username = '$username'";
            $res_7 = mysqli_query($conn, $update_2);
          }
            print_r($error);
            mysqli_close($conn);
          
?>