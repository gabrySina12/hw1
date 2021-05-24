<html>
  <head>
    <meta charset="utf-8">
    <title>WRC</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="mhw1css.css">
    <script src="menu.js" defer="true"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kurale&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Permanent+Marker&display=swap" rel="stylesheet">
  </head>

  <body>
    <header>
    <nav id = "mobile">
    <div id = 'tendina' class = 'hidden'>
      <a id='close'>
        <img src = 'Immagini/Back.png'>
      </a>
      <a href = "home.php">Home</a>
      <a href = "news.php">News</a>
      <a class = 'token'>Video</a>
    </div>
    <a id="menu">
      <div></div>
      <div></div>
      <div></div>
    </a>
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

  <section id = Prima>
    <nav id = intro>
      <h1>
        <em>season 2021</em><br/>
        <strong>rally championship</strong><br/>
      </h1>
      </nav>
  </section>

  <section id = seconda>
    <div class = "main">
      <p>“La cosa più bella che può fare un uomo vestito è guidare di traverso” - Miki Biasion</p>
      <img src="Immagini/porche.png" />
      </div>
    <div id="details">
      <div>
        <img src="Immagini/Rally22.jpg" />
        <div class = shadow>
        <h1>WRC artic</h1>
        <p>
          per la prima volta nella sua storia il WRC affronterà il rigore e le temperature 
          glaciali del Circolo Polare Artico: sono previsti 30° sotto lo zero brr...
        </p>
      </div>
      </div>
      <div>
        <img src="Immagini\Rally1.jpg" />
        <div class>
        <h1>WRC sardegna</h1>
        <p>
          inserita nel calendario del Campionato del mondo rally nel 2004 sostituendo il Rally 
          di Sanremo in qualità di tappa italiana del campionato mondiale              
        </p>
      </div>
      </div>
    </div>
  </section>

  <footer>
    <div id = flex>
      <img class= "youtube" src="Immagini/yt.png"/>
    
    
      <img class= "instagram" src="Immagini/insta.png"/>
    
   
      <img class= "facebook" src="Immagini/fb.png"/>
    </div>
    <div id = nome>
      <a>Gabriele Sinatra</a>
      <p>Matricola: O46002283</p>
    </div>
    
  </footer>

  </body>
</html>
