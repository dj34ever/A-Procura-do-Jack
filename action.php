<?php

require ('config.php');
session_start();

function getuservalues() {

    //Dados de User
    $sql = "SELECT id, moedas, ouro, ativa FROM utilizador where username='" . $_SESSION['utilizador_nome'] . "'";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['utilizador_id'] = $result['id'];
    $_SESSION['utilizador_moedas'] = $result['moedas'];
    $_SESSION['utilizador_ouro'] = $result['ouro'];
    $_SESSION['utilizador_ativo'] = $result['ativa'];

    //Dados da cidade
    $sql = "SELECT id, nome FROM cidade where id_utilizador='" . $_SESSION['utilizador_id'] . "'";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['cidade_id'] = $result['id'];
    $_SESSION['cidade_nome'] = $result['nome'];
    
    
    mysqli_close($GLOBALS['dbConn']);
}

?>