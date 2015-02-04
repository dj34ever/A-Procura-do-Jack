<?php

require ('config.php');


//redireciona o user ao abrir a pagina manualmente
debug_backtrace() || die(header('Location: logout.php'));

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

function getallbuildings() {
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    $sql = "SELECT * FROM edificio where tipo!=0 ";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    if ($query) {
        $i = 0;
        while ($result = mysqli_fetch_assoc($query)) {
            $_SESSION['edificios_disponiveis'][$i] = $result;
            $i++;
        }
    } else {
        $_SESSION['edificios_disponiveis'] = mysqli_error($GLOBALS['dbConn']);
    }
}

function getconstructedbuildings(){
     if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    $sql = "SELECT ed.pos, edi.img FROM edificio_cidade ed, edificio edi where ed.id_edificio=edi.id";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);

    if ($query) {
        $i = 0;
        while ($result = mysqli_fetch_assoc($query)) {
            $_SESSION['edificios_construidos'][$i] = $result;
            $i++;
        }
    } else {
        $_SESSION['edificios_construidos'] = mysqli_error($GLOBALS['dbConn']);
    }
    
    
}

function construir($pos, $id) {
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $pos = $_POST['pos'];
        $cidade = $_SESSION['cidade_id'];
        printf($id);
    }
 
    $tempo_construcao = time() + $_SESSION['edificios_disponiveis'][$id]['tempo_construcao'];
    //echo "<script> alert(printf($tempo_construcao); </script>" ;
    $sql = "Insert into edificio_cidade (id_cidade, id_edificio, tempo_construcao_final, pos) values('".$cidade."','".$id."','".$tempo_construcao. "','".$pos."')";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    
    
}

?>