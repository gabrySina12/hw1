<?php
require_once 'auth.php';


// Imposto l'header della risposta


    $query = urlencode($_GET["q"]);
    $token = urldecode($_GET["access_key"]);
    $key = 'AIzaSyARaCrXptTw5ZthpFFEj1OFHhIokQlg-Rc';
    $url = "https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=UC5G6kTnHXDz0WIBC2VGBOqg&type=video&maxResults=6&q=".$query."&key=".$key;
    $ch = curl_init($url);//inizializza la sessione cURL
    $header = array();
    $header[] ='Authorization: Bearer '.$token;
    $header[] ='Accept : application/json';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $res=curl_exec($ch);
    $res = json_decode($res, true);
    curl_close($ch);
    print_r($res);
    echo $token;
    
    //$new_json = array('weather_icons' => $res['current']['weather_icons']['0'], 'cloudcover' => $res['current']['cloudcover'], 'humidity' => $res['current']['humidity'], 'precip' => $res['current']['precip']);

    //echo json_encode($new_json);

    /*
    curl \
curl \
curl \
  'https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=UC5G6kTnHXDz0WIBC2VGBOqg&maxResults=6&q=artic&key=[YOUR_API_KEY]' \
  --header 'Authorization: Bearer [YOUR_ACCESS_TOKEN]' \
  --header 'Accept: application/json' \
  --compressed



     */
?>