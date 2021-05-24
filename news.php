<html>
  <head>
    <meta charset="utf-8">
    <title>WRC</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="mhw1css.css">
    <script src="weather.js" defer="true"></script>
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
<section class = onSearch>
<input type='text' name ='squadra' placeholder="Cerca un evento" id='search' autocomplete = 'off'>
</section>
<section class = 'weather'>
<img src = 'Immagini/loading1.gif' id = 'loading'>
    

</section>

<footer class="colorNews"> 
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