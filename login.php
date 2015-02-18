<?php

require("action.php");
if (isset($_POST['submit'])) {
    if (empty($_POST['username'])) {
        die(header('Location: main.php?false=1'));
    } elseif (empty($_POST['password'])) {
        die(header('Location: main.php?false=1'));
    }
    
    $username = dbEscapeString($_POST['username']);
    $password = dbEscapeString($_POST['password']);
    $password = hash("sha512", $password);
    $sql = "SELECT id FROM utilizador WHERE username = '" . $username . "' AND password = '" . $password . "' LIMIT 1";
    $query = dbFetch($sql);
    if (mysqli_num_rows($query)) { //O nome de utilizador e palavra passe está correcto
        session_start();
        $_SESSION['utilizador']['nome'] = $username;
        header('Location: game.php');
    } else {
        die(header('Location: main.php?false=2'));    
    }
}
else{
    die(header('Location: main.php?false=3'));
}
?>
 
