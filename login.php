<?php

require("config.php");

$erro = "Utilizador ou Palavra Passe incorrecta.";


if (isset($_POST['submit'])) {
    if (!isset($_POST['username'])) {
        die(printf("Campo Utilizador não preenchido"));
    } elseif (!isset($_POST['password'])) {
        die(printf("Campo Password não preenchido"));
    }

    $username = mysqli_escape_string($dbConn, $_POST['username']);
    $password = mysqli_escape_string($dbConn, $_POST['password']);
    $password = hash("sha512", $password);
    
    $sql = "SELECT id FROM utilizador WHERE username = '" . $username . "' AND password = '" . $password . "' LIMIT 1";
   //$sql = "SELECT id FROM utilizador WHERE username = '$username' AND password = '$password' LIMIT 1";

    $query = mysqli_query($dbConn, $sql);
    mysqli_close($dbConn);
    if (mysqli_num_rows($query)) { // The user name and email address are correct
        session_start();
        $_SESSION['user'] = $username;
        header('Location: game.php');
    } else {
          
        die(header('Location: main.php?false=1'));
       
       
    }
}
else die(header('Location: main.php?false=1'));
?>
 