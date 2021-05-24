<?php
    require_once 'dbmsconfig.php';
    session_start();

    function checkAuth() {
        // Se esiste già una sessione, la ritorno, altrimenti ritorno 0
        if(isset($_SESSION['username'])) {
            return $_SESSION['username'];
        } else 
            return 0;
    }

    function checkLogout(){
        $username = checkAuth();
        $conn = mysqli_connect('127.0.0.1', 'root', '', 'rally');
        $username = mysqli_real_escape_string($conn, $username);

        $query = "SELECT p.nome as nome, p.cognome as cognome,p.data_nascita as data1, p.email as email, p.username as username, s.Codice as codSquadra, s.nome as squadra
                  FROM pilota p join squadra s on p.squadra = s.Codice 
                  WHERE p.username = '".$username."'";
        $res_1 = mysqli_query($conn, $query);
        if(mysqli_num_rows($res_1) > 0){
          $userinfo = mysqli_fetch_assoc($res_1); 
        }else
        {
          $query1 = "SELECT s.Codice as codSquadra, s.nome as squadra, c.nome as nome, c.cognome as cognome, c.data_nascita as data1, c.email as email, c.username as username
                  FROM squadra s join copilota c on s.Codice = c.squadra  
                  WHERE c.username = '".$username."'";
          $res_2 = mysqli_query($conn, $query1);
          $userinfo = mysqli_fetch_assoc($res_2); 
        }

        return $userinfo;
    }
?>