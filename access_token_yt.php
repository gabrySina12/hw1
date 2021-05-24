<?php
require_once 'auth.php';


    $token = urlencode($_GET["access_token"]);
    
    $ch = curl_init($url);//inizializza la sessione cURL

    $res = json_encode($token, true);
    echo $res;
    
    //$new_json = array('weather_icons' => $res['current']['weather_icons']['0'], 'cloudcover' => $res['current']['cloudcover'], 'humidity' => $res['current']['humidity'], 'precip' => $res['current']['precip']);

    //echo json_encode($new_json);
?>