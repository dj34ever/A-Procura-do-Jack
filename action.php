<?php

//Obtem valores do utilizador (ouro, moedas ...)
function getuservalues() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    //Dados de User
    $sql = "SELECT id, moedas, ouro, ativa FROM utilizador where username='" . $_SESSION['utilizador']['nome'] . "'";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['utilizador']['id'] = $result['id'];
    $_SESSION['utilizador']['moedas'] = $result['moedas'];
    $_SESSION['utilizador']['ouro'] = $result['ouro'];
    $_SESSION['utilizador']['ativa'] = $result['ativa'];

    //Dados da cidade
    $sql = "SELECT id, nome FROM cidade where id_utilizador='" . $_SESSION['utilizador']['id'] . "'";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['cidade']['id'] = $result['id'];
    $_SESSION['cidade']['nome'] = $result['nome'];
}

//Obtem todos os edificios contruiveis do jogo menos os já construidos
function getallbuildings() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    $sql = "SELECT * FROM edificio where tipo!=0 and id NOT IN(select id_edificio from edificio_cidade where id_cidade=".$_SESSION['cidade']['id']." and id_edificio is not null union select id_edificio_construcao from edificio_cidade where id_cidade=".$_SESSION['cidade']['id']." and id_edificio_construcao is not null)";
    $query = dbFetch($sql);
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

//obtem todos os edifios já contruidos na cidade para o mapa
function getconstructedbuildings() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    //repreenche os dados de sessao
    getuservalues();
    //obtem os edificios da cidade
    $sql = "SELECT ed.id, ed.pos, ed.tempo_construcao_final, edi.img FROM edificio_cidade ed, edificio edi where ed.id_edificio=edi.id and ed.id_cidade=" . $_SESSION['cidade']['id'];
    $query = dbFetch($sql);
    
    if ($query) {
        //elimina o atual conteudo do array
     unset($_SESSION['edificio_cidade']);
        while($row=mysqli_fetch_assoc($query)) {
            //termina a construcao do edificio
            if($row['tempo_construcao_final']<=time())
            {
                $sql= "Update edificio_cidade set id_edificio=id_edificio_construcao, tempo_construcao_final=0, id_edificio_construcao=NULL where id=".$row['id'];
                dbFetch($sql);
            }
            //volta a preencher o array
        $_SESSION['edificio_cidade'][]=$row; 
        } 
    } else {
        unset($_SESSION['edificio_cidade']);
    }
  

}
//executa a query; termina a ligacao; retorna um result do mysqli_query
function dbFetch($sql){
    require ("config.php");
    $result=mysqli_query($GLOBALS['dbConn'], $sql);
    mysqli_close($GLOBALS['dbConn']);
    return $result;
    
}
?>