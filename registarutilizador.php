<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "wrong answer";
//echo "<script type='text/javascript'>alert('$message');</script>";

require("action.php");
//require("config.php");
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
    echo "<script type='text/javascript'>alert('$message');</script>";
    
    $username = mysqli_escape_string($dbConn, $_POST['username']);

    $email = mysqli_escape_string($dbConn, $_POST['email']);

    $password = mysqli_escape_string($dbConn, $_POST['password']);
    $password = hash("sha512", $password);
    $cidade = mysqli_escape_string($dbConn, $_POST['cidade']);
    if (empty($cidade)) {
        $cidade = "Nova Cidade";
    }

    if (!($username === null || $email === null || $password === null)) {
        $sql = "SELECT id FROM utilizador WHERE username = '" . $username . "' LIMIT 1"; //Seleciona user com o mesmo nome
        $query1 = mysqli_query($dbConn, $sql);

        if (mysqli_num_rows($query1) > 0) { // Se existir termina
            die(header('Location: novoutilizador.php?false=3'));
        }
        //cria o utilizador
        $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $moedas . "', '" . $ouro . "', '" . $ativo . "')";
        $query = mysqli_query($dbConn, $sql);
       
        if ($query) { // Se criado com sucesso
            session_start();
            $_SESSION['utilizador_nome'] = $username;
            getuservalues();
            $sql = "INSERT INTO cidade (nome, id_utilizador) VALUES ('" . $cidade . "', '" . $_SESSION['utilizador_id'] . "')";
            $query = mysqli_query($dbConn, $sql);
            $_SESSION['cidade_nome'] = $cidade;
            if ($query) {
                header('Location: game.php');
            } else {
                die(header('Location: novoutilizador.php?false=2'));
            }
        } else {
            die(header('Location: novoutilizador.php?false=7&'));
        }
    } else {
        die(header('Location: novoutilizador.php?false=1'));
    }
}
?>
