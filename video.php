<html>
  <head>
    <meta charset="utf-8">
    <title>WRC</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="mhw1css.css">
    <script src="sezVideo.js" defer="true"></script>
    <script src="menu.js" defer="true"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kurale&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Permanent+Marker&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
  <nav id = mobile>
    <div id = 'tendina' class = 'hidden'>
      <a id='close'>
        <img src = 'Immagini/Back.png'>
      </a>
      <a href = "home.php">Home</a>
      <a href = "news.php">News</a>
      <a class = 'token'>Video</a>
    </div>
    <div id="menu">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div class= logo>
      <img src="Immagini/logo.png"/>
    </div>
    <div id = "signin">
    <?php 
    require_once 'auth.php';
    if (checkAuth()) {
      $userinfo = checkLogout();
      echo "<div class = 'avatar__bar'><a href='member.php' class = 'icon__bar'><div class = 'avatar__text_bar'>";
      $nome = $userinfo['nome'];
      $cognome = $userinfo['cognome']; 
      echo $nome['0'].$cognome['0'];
      echo '</div> </a> </div>';
                      
                  
      echo '<a href="logout.php">Logout</a>';
    }else{
      echo '<a href="login.php">Login</a>';
    }
    ?>
  </div>
  </nav>
</header>
<section id = 'carouselVid'>


  <div id = 'divDot'>

  </div>

</section>

<section>
    <div id = 'TitoloSearch'>
        <img src ="Immagini/syt.png">
        <h1>Cerca nel nostro canale:</h1>
    </div>
    <form id = 'ricercavid'>
        <input type='text' id='casella' placeholder="Ricerca Video">
        <input type='submit' id='submitvid' value='Search'>
        <input type="image" id = 'iconSer' src="Immagini/search.png" alt="Submit Form" />
    </form>
    <div id = 'sezVideo'>

    </div>
</section>

  <footer class="colorVideo">
    <div id = 'flex'>
      <img class= "youtube" src="Immagini/yt.png"/>
    
    
      <img class= "instagram" src="Immagini/insta.png"/>
    
   
      <img class= "facebook" src="Immagini/fb.png"/>
    </div>
    <div id = 'nome'>
      <a class="colorTxtVideo">Gabriele Sinatra</a>
      <p class="colorTxtVideo">Matricola: O46002283</p>
    </div>
    
  </footer>

  </body>