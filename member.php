<?php 
    require_once 'auth.php';
    if (!$username = checkAuth()) {
        header("Location: login.php");
        exit;
    }
?>

<html>
<?php 
        // Carico le informazioni dell'utente loggato per visualizzarle nella sidebar (mobile)
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
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


  
  mysqli_close($conn);
    ?>

  <head>
    <meta charset="utf-8">
    <title>WRC</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="mhw1css.css">
    <link rel="stylesheet" href="membercss.css">
    <script src="menu.js" defer="true"></script>
    <script src="membernav.js" defer="true"></script>
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
      echo "<div href='member.php' class = 'avatar__bar'><div class = 'avatar__text_bar'>";
      $nome = $userinfo['nome'];
      $cognome = $userinfo['cognome']; 
      echo $nome['0'].$cognome['0'];
      echo '</div> </div>';
                      
                  
      echo '<a href="logout.php">Logout</a>';
    }else{
      echo '<a href="login.php">Login</a>';
    }
    ?>
  </div>
  </nav>
  </header>
  <div class = 'sidebar-view'>
        <div class = 'sidebar'>
                    <div class = 'sidebar_header'>
                      <div class = 'avatar'>

                            <div class = 'avatar__text'>
                                <?php 
                                  $nome = $userinfo['nome'];
                                  $cognome = $userinfo['cognome']; 
                                  echo $nome['0'].$cognome['0'];
                      
                                ?>
                            </div>
                      </div>
                      <?php 
                        echo "<h1 class = 'sidebar__heading'>$nome $cognome</h1>";
                        $email = $userinfo['email'];
                        echo "<h2 class = 'sidebar__subheading'>$email</h2>";
                      ?>
                    </div>
                  <div class = 'nav--vertical'>
                      <a id = 'gSquadra_but' class = 'nav__item active'>
                        <span class = 'nav__icon'>
                          <img src = 'Immagini/team.png'>
                        </span>
                        <span class = 'nav__text'>
                          Gestione squadra
                        </span>
                      </a>
                      <a id = 'favorite_but' class = 'nav__item'>
                        <span class = 'nav__icon'>
                          <img src = 'Immagini/favorite.png'>
                        </span>
                        <span class = 'nav__text'>
                          Preferiti
                        </span>
                      </a>
                      <a id='option_but' class = 'nav__item'>
                        <span class = 'nav__icon'>
                          <img src = 'Immagini/option.png'>
                        </span>
                        <span class = 'nav__text'>
                          Impostazioni
                        </span>
                      </a>
                   </div> 
      </div>
      <div id = 'option' class ='sidebar-view__content'>
          <div class = 'setting'>
          <div class="sidebar-view__header desktop__header">
                <h1 class="sidebar-view__heading">Impostazioni profilo</h1>
                </div>
                <div class="sidebar-view__inner">
                  <div class="row__label">Nome</div>
                  <?php 
                    $nome = $userinfo['nome'];
                    $cognome = $userinfo['cognome']; 
                    echo "<div class='row__content'>$nome $cognome</div>";    
                  ?>
                  <div class="row__label">Email</div>
                  <?php 
                    $email = $userinfo['email']; 
                    echo "<div class='row__content'>$email</div>";    
                  ?>
                  <div>
                    <div class="row__label"><span>Password</span>

                  </div>
                  <div class="row__content">********</div>
                </div>
              </div>
          </div>
      </div>

      <div id = 'favorite' class ='sidebar-view__content'>
            <div class="sidebar-view__header desktop__header">
                  <h1 class="sidebar-view__heading">Eventi</h1>
            </div>
              <div id = 'fav_items' class="sidebar-view__inner">
              
              </div>
      </div>

      <div id = 'gSquadra' class ='sidebar-view__content'>
      <div class = 'setting'>
          <div class="sidebar-view__header desktop__header">
                <h1 class="sidebar-view__heading">Gestione squadra</h1>
          </div>
          <div class="sidebar-view__inner">
          <div id = 'sezTeam' class="row__label">
          <h2>La tua squadra</h2>
          <div id = 'my_teams'>
          </div>
          </div>
          <h2>Vuoi creare una squadra? Inserisci il nome</h2>
            <div class='row__content'>
            <div id = 'new__team'>
              <input type='text' name ='squadra' placeholder="es. Hyundai" class ='my_team' autocomplete = 'off' >
            </div>
            <div><img src='Immagini/check.gif' alt ='check img' class = 'gif hidden'></div>
            </div>
            <span class = 'squadra_err'></span>
            <h2>Squadre</h2>
            <div id = 'team_lable'>
              <input type='submit' class='my_sub showTeam' value='Mostra squadre'>
              <input type='submit' id = 'hideTeams' class='my_sub showTeam hidden' value='Nascondi squadre'>
              
            </div>
            <h2>Inserisci l'evento di cui vuoi sapere quante squadre sono iscritte</h2>
            <div id = 'team_lable' class = 'contaSq'>
              <input type='text' name ='squadra' placeholder="es. W.R.C" id='conta' class='my_team' autocomplete = 'off'>
              

                  </div>
              
            </div>

          </div>
        </div>
      </div>

  </body>