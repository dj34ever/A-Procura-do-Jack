<?php

require ('config.php');

//redireciona o user ao abrir a pagina manualmente
//debug_backtrace() || die(header('Location: logout.php'));
//Obtem valores do utilizador (ouro, moedas ...)
function getuservalues() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    //Dados de User
    $sql = "SELECT id, moedas, ouro, ativa FROM utilizador where username='" . $_SESSION['utilizador']['nome'] . "'";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['utilizador']['id'] = $result['id'];
    $_SESSION['utilizador']['moedas'] = $result['moedas'];
    $_SESSION['utilizador']['ouro'] = $result['ouro'];
    $_SESSION['utilizador']['ativa'] = $result['ativa'];

    //Dados da cidade
    $sql = "SELECT id, nome FROM cidade where id_utilizador='" . $_SESSION['utilizador']['id'] . "'";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['cidade']['id'] = $result['id'];
    $_SESSION['cidade']['nome'] = $result['nome'];
    //mysqli_close($GLOBALS['dbConn']);
}

//Obtem todos os edificios contruiveis do jogo
function getallbuildings() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    $sql = "SELECT * FROM edificio where tipo!=0";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    if ($query) {
        unset($_SESSION['edificio']);
        while($row=mysqli_fetch_assoc($query)) {
        $_SESSION['edificio'][]=$row; 
        } 

    } else {
        //$_SESSION['edificio'] = null;
        unset($_SESSION['edificio']);
    }
}

//obtem todos os edifios já contruidos na cidade
function getconstructedbuildings() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    getuservalues();
    $sql = "SELECT ed.pos, ed.tempo_construcao_final, edi.img FROM edificio_cidade ed, edificio edi where ed.id_edificio=edi.id and ed.id_cidade=" . $_SESSION['cidade']['id'];

    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    
    if ($query) {
     unset($_SESSION['edificio_cidade']);
        while($row=mysqli_fetch_assoc($query)) {
        $_SESSION['edificio_cidade'][]=$row; 
        } 

    } else {
        //$_SESSION['edificio'] = null;
        unset($_SESSION['edificio_cidade']);
    }
  

}

?>