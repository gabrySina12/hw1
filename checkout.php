<?php
require_once 'dbconfig.php';
function checkAuth() {
GLOBAL $dbconfig;
if(!isset($_SESSION['_agora_user_id'])) {
    if (isset($_COOKIE['_agora_user_id']) && isset($_COOKIE['_agora_token']) && isset($_COOKIE['_agora_cookie_id'])) {
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error(
        $cookieid mysqli_real_escape_string($conn, $_COOKIE['_agora_cookie_id']);
        $userid mysqli_real_escape_string($conn, $_COOKIE['_agora_user_id']);
        $res mysqli_query($conn, "SELECT * FROM cookies WHERE id = $cookieid AND user = $userid");
        if ($cookie = mysqli_fetch_assoc($res)) {
            if(time() > $cookie['expires']) {
                mysqli_query($conn, "DELETE FROM cookies WHERE id = ".$cookie['id']) or die(mysqli_error($conn));
                header("Location: logout.php");
                exit;
            } else if (password_verify($_COOKIE_' _agora_token'], $cookie['hash'])){
                }
            }
        }
    }
?>