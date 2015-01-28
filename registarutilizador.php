<?php

require("config.php");
$erro = "Utilizador ou Palavra Passe incorrecta.";
$ativo = 1;
$moedas = 100000;
$ouro = 100;


/* Criei um novo utilizador em branco e aceitou na base de dados sem qualquer mensagem */

if (isset($_POST['submit'])) {
    if (empty($_POST['username'])) {
        die(header('Location: novoutilizador.php?false=1'));
    } elseif (empty($_POST['password'])) {
        die(header('Location: novoutilizador.php?false=1'));
    } elseif (empty($_POST['email'])) {
        die(header('Location: novoutilizador.php?false=1'));
    }

    //$username = mysqli_escape_string($dbConn, $_POST['username']);
    $username = mysqli_escape_string($dbConn, $_POST['username']);

    $email = mysqli_escape_string($dbConn, $_POST['email']);

    $password = mysqli_escape_string($dbConn, $_POST['password']);
    $password = hash("sha512", $password);
    $cidade = mysqli_escape_string($dbConn, $_POST['cidade']);
    if (!empty($cidade)) {
        $cidade = "Nova Cidade";
    }


    if (!($username === null || $email === null || $password === null)) {
//        if(!is_null($username) && !is_null($email) && !is_null($password)) //problemático
        $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $moedas . "', '" . $ouro . "', '" . $ativo . "')";
        $query = mysqli_query($dbConn, $sql);

        if ($query) { // The user name and email address are correct
            session_start();
            $_SESSION['utilizador_nome'] = $username;
            header('Location: game.php');
        } else {
            die(header('Location: novoutilizador.php?false=2'));
        }
    } else {
        die(header('Location: novoutilizador.php?false=3'));
    }
}
?>
