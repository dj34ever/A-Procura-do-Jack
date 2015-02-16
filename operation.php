<?php

require ('session.php');
require ('action.php');
/*

FUNCTION FROM ACTION.PHP
getuservalues();
valSumValue($ssValue,$value)
valSubValue($ssValue,$value)

*/


if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
}else{
    
    if (isset($_POST['quest'])) {
        if(empty($_POST['valMoeda'])){
            die(header('Location: game.php'));
        }elseif(empty($_POST['valOuro'])){
            die(header('Location: game.php'));
        }
    //encapsular dados
    $valMoeda = mysqli_escape_string($dbConn, $_POST['valMoeda']);
    $valOuro = mysqli_escape_string($dbConn, $_POST['valOuro']);
    
    getuservalues();
    //verifica
    $ouro = $_SESSION['utilizador_ouro'];
    $moedas = $_SESSION['utilizador_moedas'];
    
    //calculos
    $_SESSION['utilizador_moedas'] = (valSumValue($moedas,$valMoeda)) ? $moedas + $valMoeda
                                                           : $moedas;
    
    $_SESSION['utilizador_ouro'] = (valSumValue($ouro,$valOuro)) ? $ouro + $valOuro
                                                      : $ouro;
    
    $sql = "UPDATE utilizador SET moedas ='" . $_SESSION['utilizador_moedas'] 
    . "', ouro ='" . $_SESSION['utilizador_ouro'] . "' WHERE username='" . $_SESSION['utilizador_nome'] . "'";
    $query = mysqli_query($dbConn, $sql);
    print_r($query);
    header('Location: game.php');
    //header('Location: game.php?a='.$sql);
    
    }
    
    if(isset($_POST['buy'])){
        if(empty($_POST['compra'])){
            die(header('Location: game.php'));
        }
        
        $compra = mysqli_escape_string($dbConn, $_POST['compra']);
        
        getuservalues();
        //verifica
        $moedas = $_SESSION['utilizador_moedas'];
        $ouro = $_SESSION['utilizador_ouro'];
        
        
        //inserir valores
        $_SESSION['utilizador_moedas'] = (valSubValue($moedas,$valMoeda)) ? $moedas - $valMoeda
                                                           : $moedas;
    
        /*$_SESSION['utilizador_ouro'] = (valSubValue($ouro,$valOuro)) ? $ouro + $valOuro
                                                      : $ouro;*/
        
        //calculo moedas
        $sql = "UPDATE utilizador SET moedas ='" . $_SESSION['utilizador_moedas'] 
        . "', ouro ='" . $_SESSION['utilizador_ouro'] . "' WHERE username='" . $_SESSION['utilizador_nome'] . "'";
        $query = mysqli_query($dbConn, $sql);
        header('Location: game.php');
        
        
    }
}

?>