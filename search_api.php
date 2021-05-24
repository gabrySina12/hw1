<?php
require_once 'auth.php';


// Imposto l'header della risposta
header('Content-Type: application/json');


    $apiKey = '';

    $query = urlencode($_GET["q"]);
    $url = "http://api.weatherstack.com/current?access_key=$apiKey&query=$query";
    $ch = curl_init($url);//inizializza la sessione cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $url);
    $res=curl_exec($ch);
    $res = json_decode($res, true);
    curl_close($ch);

    $new_json = array('weather_icons' => $res['current']['weather_icons']['0'], 'cloudcover' => $res['current']['cloudcover'], 'humidity' => $res['current']['humidity'], 'precip' => $res['current']['precip']);

    echo json_encode($new_json);
?>
