<?php

require("config.php");
$erro = "Utilizador ou Palavra Passe incorrecta.";
$ativo = 0;
$moedas = 100000;
$ouro = 100;

/*Criei um novo utilizador em branco e aceitou na base de dados sem qualquer mensagem*/

//if (isset($_POST['submit'])) {
//    if (!isset($_POST['username'])) {
//        die(printf("Campo Utilizador não preenchido"));
//    } elseif (!isset($_POST['password'])) {
//        die(printf("Campo Password não preenchido"));
//    } elseif (!isset($_POST['email'])) {
//        die(printf("Campo Email não preenchido"));
//    }

if(isset($_POST['submit'])){
    if(is_null($_POST['username']) || empty($_POST['username']) ){
        die(header('location: novoutilizador.php?false=0'));
    } elseif(is_null($_POST['username']) || empty($_POST['password'])) {
        die(header('location: novoutilizador.php?false=0'));
    }elseif(is_null($_POST['email']) || empty($_POST['email'])){
        die(header('location: novoutilizador.php?false=0'));
    }
    


   
    //$username = mysqli_escape_string($dbConn, $_POST['username']);
    $username = mysqli_escape_string($dbConn, $_POST['username']);
    
    $email = mysqli_escape_string($dbConn, $_POST['email']);
    
    $password = mysqli_escape_string($dbConn, $_POST['password']);
    $password = hash("sha512", $password);
    
   //testing
//     if(($username===null || $email===null || $password===null))
//          die(header('Location: novoutilizador.php?false=1'));
     
    $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $moedas . "', '" .  $ouro . "', '" . $ativo . "')";
     
    $query = mysqli_query($dbConn, $sql);
    
    if ($query) { // The user name and email address are correct
        session_start();
        $_SESSION['utilizador_nome'] = $username;
        header('Location: cidade.php');
    } else {
            
        die(header('Location: novoutilizador.php?false=1&'. $sql));

    }
}
?>
