<?php

require ('config.php');
require ('session.php');

if(isset($_POST['u_submit'])){//registar conta utilizador
    if(empty($_POST['u_nome']) || empty($_POST['upass']) || empty($_POST['u_email'])){
        die(header('Location: interface.php?false=0'));//campos vazios
    }
    
    $user = mysqli_escape_string($dbConn, $_POST['u_nome']);
    $pass = mysqli_escape_string($dbConn, $_POST['u_pass']);
    $passHash = hash("sha512", $pass);
    $email = mysqli_escape_string($dbConn, $_POST['u_email']);
    $ativa = 1;
    $tipo = mysqli_escape_string($dbConn, $_POST['tipo_conta']);
    
    if(empty($_POST['tipo_conta'])){//não exista um tipo selecionado
        $tipo = 0;
    }
    
    //já existe utilizador?
    $sql = "SELECT * FROM utilizador WHERE username='" . $user . "' LIMIT 1";
    $query = mysqli_query($dbConn, $sql);
    $result = mysql_num_row($query);
    
    if($result > 0){
        die(header('Location: interface.php?false=1'));//existe
    }
    
    $moedas = 0;
    $ouro = 0;
    
    $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa)".
            "VALUES ('" . $user . "','" . $pass . "','" . $email . "','" . $moedas ."','" . $ouro . "";
    $query = mysql_query();
    
    if($query){
        die(header('Location: interface.php?r=0'));
    }else{
        die(header('Location: interface.php?r=1'));
    }
    
    
    
}

?>
