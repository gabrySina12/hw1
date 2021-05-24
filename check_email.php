<?php
    require_once 'dbmsconfig.php';
    
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $email = mysqli_real_escape_string($conn, $_GET["q"]);

    $query = "SELECT p.email, c.email
              FROM pilota p join squadra s on p.squadra = s.Codice join copilota c on s.Codice = c.squadra
              WHERE p.email = '$email' OR c.email = '$email'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    mysqli_close($conn);

    /*  SELECT p.nome as nomeP, p.cognome as cognomeP,p.data_nascita as dataP, p.email as emailP, p.username as usernameP, s.Codice as codSquadra, s.nome as squadra, c.nome as nomeC, c.cognome as cognomeC, c.data_nascita as dataC, c.email as emailC, c.username as usernameC, c.password as passwordC
        FROM pilota p join squadra s on p.squadra = s.Codice join copilota c on s.Codice = c.squadra  */
?>

