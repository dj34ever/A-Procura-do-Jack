<?php

require ("action.php");

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['utilizador']['nome'])) {
    die(header('Location: logout.php'));
}
$id=absint(dbEscapeString($_POST['id']));
$pos=absint(dbEscapeString($_POST['pos']));


if (empty($id) || empty($pos)) die(header('Location: logout.php'));

    $cidade = $_SESSION['cidade']['id'];
    //encontra edificio atualmente construido na posicao
    foreach ($_SESSION['edificio_cidade'] as $edificio) {
        if ($edificio['pos'] === $pos) {
            $edifio_atual = $edificio;
        }
    }

//em contrucao
    if ($edifio_atual['tempo_construcao_final'] > time()) {
        echo "Área já em construção";
    }

// incia nova tarefa
    elseif ($edifio_atual['tempo_construcao_final'] == 0) {
        //procura edificio a ser construido
        foreach ($_SESSION['edificio'] as $edificio) {
            if ($edificio['id'] === $id) {
                $edificio_futuro = $edificio;
            }
        }
        //adiciona o tempo de construcao final
        $tempo_construcao = time() + $edificio_futuro['tempo_construcao'];
        $edifio_atual['tempo_construcao_final'] = $tempo_construcao;

        //desconta custo de construcao do edificio
        $dinheiro = $_SESSION['utilizador']['moedas'] - $edificio_futuro['preco'];
        if ($dinheiro <= 0)
            die("Notas Insuficientes");
        $sql = "Update utilizador set moedas=$dinheiro where id=" . $_SESSION['utilizador']['id'];
        $query = dbFetch($sql);

        //define construcao
        $sql = "Update edificio_cidade set tempo_construcao_final=$tempo_construcao, id_edificio_construcao=$id where id_cidade=$cidade and pos=$pos";
        $query = dbFetch($sql);

        echo "Comecou a construção";
    }
//completou o timer
//Reimplementado através de outra funcao no action php
//    else {
//        $edifio_atual['tempo_construcao_final'] = 0;
//        $tempo_construcao = 0;
//        $sql = "Update edificio_cidade set id_edificio=id_edificio_construcao, tempo_construcao_final=$tempo_construcao, id_edificio_construcao=NULL where id_cidade=$cidade and pos=$pos";
//        $query = mysqli_query($GLOBALS['dbConn'], $sql);
//        echo 0;
//    }

else die(header('Location: logout.php'))
?>

