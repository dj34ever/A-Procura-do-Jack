<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "wrong answer";

require("action.php");
//require("config.php");
$erro = "Utilizador ou Palavra Passe incorrecta.";
$ativo = 1;
$moedas = 100000;
$ouro = 100;
//Verifica se foi submetido um post
if (isset($_POST['submit'])) {
    //verifica se os campos foram preenchidos
    if (empty($_POST['username'])) {
        die(header('Location: novoutilizador.php?false=1'));
    } elseif (empty($_POST['password'])) {
        die(header('Location: novoutilizador.php?false=1'));
    } elseif (empty($_POST['email'])) {
        die(header('Location: novoutilizador.php?false=1'));
    }

    //Encapsula os dados
    $username = mysqli_escape_string($dbConn, $_POST['username']);
    $email = mysqli_escape_string($dbConn, $_POST['email']);
    $password = mysqli_escape_string($dbConn, $_POST['password']);
    $cidade = mysqli_escape_string($dbConn, $_POST['cidade']);
    //Converte a password em plain text para sha512
    $password = hash("sha512", $password);

    //Caso o utilizador não tenha introduzido um nome para a cidade atribui um por defeito
    if (empty($cidade)) {
        $cidade = "Nova Cidade";
    }
    //Verifica se os campos, após encapsulamento não estão vazios
    if (!($username === null || $email === null || $password === null)) {
        //Verifica se existe um utilizador com o mesmo nome
        $sql = "SELECT id FROM utilizador WHERE username = '" . $username . "' LIMIT 1";
        //Executa a query
        $query = mysqli_query($dbConn, $sql);
        if (mysqli_num_rows($query) > 0) { // Se existir termina
            die(header('Location: novoutilizador.php?false=3'));
        }

        //cria o utilizador
        $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $moedas . "', '" . $ouro . "', '" . $ativo . "')";
        $query = mysqli_query($dbConn, $sql);
        // Se criado com sucesso
        if ($query) {
            session_start();
            //Armazena o nome do user
            $_SESSION['utilizador']['nome'] = $username;
            //Armazena os restantes valores
            getuservalues();
            //Cria a cidade
            $sql = "INSERT INTO cidade (nome, id_utilizador) VALUES ('" . $cidade . "', '" . $_SESSION['utilizador']['id'] . "')";
            $query = mysqli_query($dbConn, $sql);
            $_SESSION['cidade']['nome'] = $cidade;
            
            if ($query) {
                $sql = "SELECT id from cidade where id_utilizador=" . $_SESSION['utilizador']['id'];
                $query = mysqli_query($dbConn, $sql);
                $result = mysqli_fetch_assoc($query);
                for ($i = 1; $i <= 5; $i++) {
                    $sql = "INSERT INTO edificio_cidade (id_cidade, id_edificio,tempo_construcao_final,pos) VALUES ( " . $result['id'] . ", 5, '00:00:00', $i)";
                    $query = mysqli_query($dbConn, $sql);
                }

                //Procegue para o jogo
                header('Location: game.php');
            } else {
                die(header('Location: novoutilizador.php?false=2'));
            }
        } else {
            die(header('Location: novoutilizador.php?false=7'));
        }
    } else {
        die(header('Location: novoutilizador.php?false=1'));
    }
}
?>
