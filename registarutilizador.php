<?php

require("action.php");
$ativo = 1;
$moedas = 2000;
$ouro = 100;
//Verifica se foi submetido um post
if (!isset($_POST['submit'])) die(header('Location: main.php?false=4'));
    //verifica se os campos foram preenchidos
    if (empty($_POST['username'])) {
        die(header('Location: novoutilizador.php?false=4'));
    } elseif (empty($_POST['password'])) {
        die(header('Location: novoutilizador.php?false=4'));
    } elseif (empty($_POST['email'])) {
        die(header('Location: novoutilizador.php?false=4'));
    }
    //Encapsula os dados
    $username = dbEscapeString($_POST['username']);
    $email = dbEscapeString($_POST['email']);
    $password = dbEscapeString($_POST['password']);
    $cidade = dbEscapeString($_POST['cidade']);
    //Converte a password em plain text para sha512
    $password = hash("sha512", $password);
    //Caso o utilizador não tenha introduzido um nome para a cidade atribui um por defeito
    if (empty($cidade)) {
        $cidade = "Nova Cidade";
    }
    //Verifica se os campos, após encapsulamento não estão vazios
    if ($username === null || $email === null || $password === null) die(header('Location: main.php?false=4'));
        //Verifica se existe um utilizador com o mesmo nome
        $sql = "SELECT id FROM utilizador WHERE username = '" . $username . "' LIMIT 1";
        //Executa a query
        $query = dbFetch($sql);
        // Se existir termina
        if (mysqli_num_rows($query) > 0) die(header('Location: main.php?false=2')); 
        //cria o utilizador
        $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa) VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $moedas . "', '" . $ouro . "', '" . $ativo . "')";
        $query = dbFetch($sql);
        // Se criado com sucesso
        if (!$query) die(header('Location: main.php?false=3'));
            session_start();
            //Armazena o nome do user
            $_SESSION['utilizador']['nome'] = $username;
            //Armazena os restantes valores
            getuservalues();
            //Cria a cidade
            $sql = "INSERT INTO cidade (nome, id_utilizador) VALUES ('" . $cidade . "', '" . $_SESSION['utilizador']['id'] . "')";
            $query = dbFetch($sql);
            $_SESSION['cidade']['nome'] = $cidade;
            if (!$query)  die(header('Location: main.php?false=3'));
                $sql = "SELECT id from cidade where id_utilizador=" . $_SESSION['utilizador']['id'];
                $query = dbFetch($sql);
                $result = mysqli_fetch_assoc($query);
                for ($i = 1; $i <= 5; $i++) {
                    $sql = "INSERT INTO edificio_cidade (id_cidade, id_edificio,tempo_construcao_final,pos) VALUES ( " . $result['id'] . ", 5, '00:00:00', $i)";
                    $query = dbFetch($sql);
                }
                //Prossegue para o jogo
                header('Location: game.php');

?>
