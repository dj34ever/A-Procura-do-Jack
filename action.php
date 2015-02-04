<?php

require ('config.php');

//redireciona o user ao abrir a pagina manualmente
//debug_backtrace() || die(header('Location: logout.php'));
//Obtem valores do utilizador (ouro, moedas ...)
function getuservalues() {
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
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
    //mysqli_close($GLOBALS['dbConn']);
}

//Obtem todos os edificios contruiveis do jogo
function getallbuildings() {
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    $sql = "SELECT * FROM edificio where tipo!=0";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    if ($query) {
        unset($_SESSION['edificios_disponiveis']);
        while($row=mysqli_fetch_assoc($query)) {
        $_SESSION['edificios_disponiveis'][]=$row; 
        } 

    } else {
        //$_SESSION['edificios_disponiveis'] = null;
        unset($_SESSION['edificios_disponiveis']);
    }
}

//obtem todos os edifios já contruidos na cidade
function getconstructedbuildings() {
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    getuservalues();
    $sql = "SELECT ed.pos, edi.img FROM edificio_cidade ed, edificio edi where ed.id_edificio=edi.id and ed.id_cidade=" . $_SESSION['cidade_id'];

    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    
    if ($query) {
     unset($_SESSION['edificios_construidos']);
        while($row=mysqli_fetch_assoc($query)) {
        $_SESSION['edificios_construidos'][]=$row; 
        } 

    } else {
        //$_SESSION['edificios_disponiveis'] = null;
        unset($_SESSION['edificios_construidos']);
    }
  

}

?>