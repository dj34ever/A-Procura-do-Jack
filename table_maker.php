<?php
require ("config.php");
//registFail -> variavel erro de registo

if(isset($_POST['u_submit'])){//regist User
    if(empty($_POST['username'])){
        die(header('Location: interface.php?registFail=2'));
    }elseif (empty($_POST['password'])) {
        die(header('Location: interface.php?registFail=3'));
    }elseif (empty($_POST['email'])) {
        die(header('Location: interface.php?registFail=4'));
    }
    
    $username = mysqli_escape_string($dbConn, $_POST['username']);
    $password = mysqli_escape_string($dbConn, $_POST['password']);
    $hashPass = hash("sha512", $_POST['password']);
    $email = mysqli_escape_string($dbConn, $_POST['email']);
    $cidade = mysqli_escape_string($dbConn, $_POST['cidade']);
    $tipoConta =mysqli_escape_string($dbConn, $_POST['tipoConta']);
    
    if($tipoConta === null){
        $tipoConta = 0;
    }
    
    if($cidade === null || empty($cidade)){
        $cidade = "Nova Cidade";
    }
    
    if(!($username === null || $password === null || $email === null)){
        
        $sql = "SELECT id FROM utilizador WHERE username LIKE " . $username . " LIMIT 1";
        $query1 = mysqli_query($dbConn, $sql);
        //mysqli_close($dbConn);
        
        if(mysqli_num_rows($query1) !== 0){
            //Já existe um utilizador registado!
            die(header('Location: interface.php?registFail=0'));
        }
        
        $sql = "INSERT INTO utilizador (username, tipo, password, email, ativa) "
                . "VALUES ('" . $username . "','" . $tipoConta . "','" 
                . $hashPass . "','" . $email . "')";
        $query2 = mysqli_query($dbConn, $sql);
        
        if($query2){//unique username/email
        $res = getIdTable("username", "username", $username);
        $sql = "INSERT INTO cidade (nome, id_utilizador) VALUES ('" . $cidade 
                . "','" . $res ."')";
        }
    }
}

function getIdTable($tableName, $campName, $value){
    
    $sql = "SELECT id FROM " . $tableName . " where " . $campName . "='" . $value . "'";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_fetch_assoc($query);
    
    $aux = $result;
    
    return $aux;
}


?>

<!DOCTYPE html>
<!--
Description: What this script does
Version: 1.0.0
Date: 00/00/0000
Author: night8ug / email: <webrabit.63@gmail.com>
License: Do not share or use
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
