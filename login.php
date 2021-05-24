<?php
//http://localhost/mhw4/login.php
require_once 'auth.php';

    if (checkAuth()) 
    {
        header("Location: member.php");
        exit;
    } 

if(!empty($_POST["user_log"]) && !empty($_POST["password_log"]))
  {
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
  
    $username = mysqli_real_escape_string($conn, $_POST["user_log"]);

    $password = mysqli_real_escape_string($conn, $_POST["password_log"]);

    $query = "SELECT p.username as pilotaus
              FROM pilota p 
              WHERE p.username = '".$username."'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $query_1 = "SELECT c.username as copilotaus
                FROM copilota c 
                WHERE c.username = '".$username."'";

    $res_1 = mysqli_query($conn, $query_1) or die(mysqli_error($conn));
    echo json_encode($res);
    echo json_encode($res_1);
    if(mysqli_num_rows($res) > 0)
    {         
      $entry = mysqli_fetch_assoc($res);
      $password = password_hash($password, PASSWORD_BCRYPT);
      
      if (password_verify($_POST['password_log'], $password))
      {       
            $_SESSION["username"] = $entry['pilotaus'];
                header("Location: member.php");
                
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
      }
    }else if(mysqli_num_rows($res_1) > 0){

      $entry = mysqli_fetch_assoc($res_1);
      $password = password_hash($password, PASSWORD_BCRYPT);
      
      if (password_verify($_POST['password_log'], $password))
      {       
            $_SESSION["username"] = $entry['copilotaus'];
                header("Location: member.php");
                
                mysqli_free_result($res_1);
                mysqli_close($conn);
                exit;

      }
    $error = "Username e/o password errati.";
  }else if(isset($_POST["user_log"]) || isset($_POST["password_log"])) 
  {
    // Se solo uno dei due è impostato
    $error = "Inserisci username e password.";
  } 
}
/*-------------------------------registrazione----------------------------------------------------*/
 

    // Verifica l'esistenza di dati POST
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["nome"]) && 
        !empty($_POST["cognome"]) && !empty($_POST["data"]) && !empty($_POST["allow"]))
    {
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

      
        # USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT p.username, c.username
                      FROM pilota p join squadra s on p.squadra = s.Codice join copilota c on s.Codice = c.squadra
                      WHERE p.username = '$username' OR c.username = '$username";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
        # PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } 
        # EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT p.email, c.email
                                        FROM pilota p join squadra s on p.squadra = s.Codice join copilota c on s.Codice = c.squadra
                                        WHERE p.email = '$email' OR c.email = '$email");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['nome']);
            $surname = mysqli_real_escape_string($conn, $_POST['cognome']);
            $date = mysqli_real_escape_string($conn, $_POST['data']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);
          if($_POST['tipologia']=='pilota'){
            $query = "INSERT INTO pilota(nome, cognome, data_nascita,email,username,password,squadra) VALUES('$name', '$surname', '$date','$email', '$username', '$password', '1')";
          }else
          {
            $query = "INSERT INTO copilota(nome, cognome, data_nascita,email,username,password,squadra) VALUES('$name', '$surname', '$date','$email', '$username', '$password', '1')";
          }
            
            if (mysqli_query($conn, $query)) {
                session_start();
                $_SESSION["username"] = $_POST["username"];
                
                mysqli_close($conn);
                header("Location: member.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>WRC</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="mhw1css.css">
    <link rel="stylesheet" href="login.css">
    <script src="menu.js" defer="true"></script>
    <script src="signup.js" defer="true"></script>
    <script src="controlloRegist.js" defer="true"></script>
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
  
  <section id='boxLog'>
      <form name = "login" method="POST" id = 'login'>
        <h1>Accedi o registrati!</h1>
        <?php 
                if (isset($error)) {
                    echo "<span class='errore'>$error</span>";
                }
            ?>
        <span>Username</span>
        <input type='text' id='username' name='user_log' placeholder="es. mario.rossi12"><?php if(isset($_POST["user_log"])){echo "value=".$_POST["user_log"];} ?>></div>
                </div>
        <span>Password</span>
        <input type='password' id='password'name='password_log' placeholder="es. Password123"><?php if(isset($_POST["password_log"])){echo "value=".$_POST["password_log"];} ?>></div>
                </div>
        <input type='submit' id='bottonLog' value='Login'>


          <div class="logbut">Sei un pilota? <a class="but_reg">Registrati</a>
        </form>
      
  </section>

  <main id = 'reg_log'>
        <section class="main_left">
        </section>
        <section class="main_right">
            <h1>Registrati qui</h1>
            <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
                <div class="names">
                    <div class="name">
                        <div><label for='name'>Nome</label></div>
                        <div><input type='text' name='nome' class = 'nome' <?php if(isset($_POST["nome"])){echo "value=".$_POST["name"];} ?> ></div>
                        <span class = 'nome_err err'></span>
                    </div>
                    <div class="surname">
                        <div><label for='surname'>Cognome</label></div>
                        <div><input type='text' name='cognome' class ='cognome' <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?> ></div>
                        <span class = 'cognome_err err'></span>
                    </div>
                </div>
                <div class="email">
                    <div><label for='email'>Email</label></div>
                    <div><input type='text' name='email' class = 'email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>></div>
                    <span class = 'email_err err'></span>
                </div>
                <div class="username">
                    <div><label for='username'>Nome utente</label></div>
                    <div><input type='text' name='username' class = 'username'<?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>></div>
                    <span class = 'username_err err'></span>
                </div>
                
                <div class="password">
                    <div><label for='password'>Password</label></div>
                    <div><input type='password' name='password' class = 'password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                         <input type="button" onclick= "showPwd()" value='' id = 'showpw'>
                    </div>
                    <span class = 'password_err err'></span>
                </div>
                <div class="data_nascita">
                    <div><label for='date'>Data nascita</label></div>
                    <div><input type = 'date' name = 'data' class = 'data' <?php if(isset($_POST["data"])){echo "value=".$_POST["data"];} ?>></div>
                    <span class = 'data_err err'></span>
                </div>
                <div class="tipologia">
                    <div><label for='tipo'>Tipologia</label></div>
                    <div><select id='selezione' name="tipologia" class = 'tipo' <?php if(isset($_POST["tipologia"])){echo $_POST["tipologia"];} ?>>
                          <option value="pilota" selected="selected">pilota  </option>
                          <option value="copilota">copilota  </option>
                    </select></div>
                    <span class = 'data_err err'></span>
                </div>
                <div class="allow"> 
                    <div><label for='allow'><input type='checkbox' name='allow' value="1">
                    Acconsento al trattamento dei dati personali</label></div>
                    <span class = 'check_err err'></span>
                </div>
                <div class="submit">
                    <input type='submit' value="Registrati" id="submit" disabled>
                </div>
            </form>
            <div class="signup">Hai un account? <a class="but_log">Accedi</a>
        </section>
        </main>

  <footer id = logFoo>
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
