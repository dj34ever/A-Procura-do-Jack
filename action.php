<?php

require ('config.php');
require ('session.php');

//redireciona o user ao abrir a pagina manualmente
//debug_backtrace() || die(header('Location: logout.php'));

function getuservalues() {
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    //Dados de User
    $sql = "SELECT id, moedas, ouro, ativa, tipo FROM utilizador where username='" . $_SESSION['utilizador_nome'] . "'";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['utilizador_id'] = $result['id'];
    $_SESSION['utilizador_moedas'] = $result['moedas'];
    $_SESSION['utilizador_ouro'] = $result['ouro'];
    $_SESSION['utilizador_ativo'] = $result['ativa'];
    $_SESSION['utilizador_tipo'] = $result['tipo'];//adicionei isto
    
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

/*A PARTIR DAQUI É NOVO!*/

/*INTERFACE*/
function countAll($table){//contar o nº de registos p/tabela
    
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }
    
    $sql = "SELECT COUNT(*) FROM " . $table . "";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    $result = mysqli_num_rows($query);
    
    return $result;
}

function showPlayerCreature(){//show all creatures from player in session
    $sql = "SELECT a.*, b.username as buser FROM criatura_utilizador a, utilizador b WHERE a.u_id=b.id AND b.username='" . $_SESSION['utilizador_nome'] . "'";
    $query = mysqli_query($GLOBALS['dbConn'],$sql);
    $i=0;
    if($query){
        while($result = mysqli_fetch_assoc($query)){
            echo "<div id='c'>"
                ."<div>Id: " . $result['id'] . "</div>"
                ."<div>Jogador: " . $result['buser'] . "<div>"
                ."<div>Criatura: " . $result['c_id'] . "<div>"
                ."<div>Imagem: <img src='" . $result['img'] . "' alt='criatura " . $result['id'] . "'/></div>"
                ."<div>Nome: " . $result['nome'] . "</div>"
                ."<div>Evolução: " . $result['evol'] . "</div>"
                ."<div>HP: " . $result['hp'] . "</div>"
                ."<div>EN: " . $result['en'] . "</div>"
                ."<br/>";
        }
    }else{echo "<div id='c'>Sem Registos</div>";}
}

function showCreatureQuest($id){
    /* verificar se a quest está ativa
     * verificar qual a criatura que está disponivel
     * selecionar todas as criaturas
     * 
     */
    //obtem quest
    $q_id= mysqli_escape_string($dbConn,$id);
    $sql = "SELECT * FROM quest WHERE id=" . $q_id;
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    
    if($query){//existe a quest
        $result = mysqli_fetch_assoc($query);//recolher en e hp
        $en = $result['en'];
        $hp = $result['hp'];
    }else{ die(header('Location: QuestShow.php'));}
    
    //procura criatura
    showCreature($en, $hp);
    
}

function showCreature($en, $hp){
    $sql = "SELECT a.*, b.username as buser FROM criatura_utilizador a, utilizador"
          ." WHERE a.u_id=b.id AND b.username='" . $_SESSION['utilizador_nome']
          ."' AND a.en>=$en AND a.hp>=$hp";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    
    while($result = mysqli_fetch_assoc($query)){        
        echo "<div id='c'>"
                ."<div>Id: " . $result['id'] . "</div>"
                ."<div>Jogador: " . $result['buser'] . "<div>"
                ."<div>Criatura: " . $result['c_id'] . "<div>"
                ."<div>Imagem: <img src='" . $result['img'] . "' alt='criatura " . $result['id'] . "'/></div>"
                ."<div>Nome: " . $result['nome'] . "</div>"
                ."<div>Evolução: " . $result['evol'] . "</div>"
                ."<div>HP: " . $result['hp'] . "</div>"
                ."<div>EN: " . $result['en'] . "</div>"
                ."<br/>";
    }
}

/*QUEST*/
function questSearch($area){//adicionei isto
    $a =  mysqli_escape_string($GLOBALS['dbConn'], $area);
    //$sql = "SELECT id, a.nome, desc, hp, en, temp, ouro, moedas, exp, unlock, ativa, b.nome FROM quest a, area b WHERE b.area='" . $a . "' AND a.area=b.area";
            //. "'" . $a . "' AND";
    //$sql="SELECT a.*, b.nome as bnome FROM quest a, area b WHERE a.area='" . $a . "' AND b.area=a.area";//debug
//    $sql="SELECT a.*, b.nome as bnome FROM quest a, area b WHERE a.area='" . $a . "' AND b.area=a.area AND a.unlock=0";//deu!
    //$sql="SELECT a.*, b.nome as bnome FROM quest a, area b WHERE a.area=b.area AND b.area IN (SELECT area FROM area WHERE area=$a)";
    $sql = "SELECT a.*, b.nome as bnome FROM quest a, area b WHERE $a=b.area AND b.area=a.area";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    
    if($query){
        while($result = mysqli_fetch_assoc($query)){//area
                echo "<div id='q'>"
                   . "<div> Area: " . $result['bnome'] . "</div>"
                   . "<div> Nome: " . $result['nome'] . "</div>"
                   . "<div> Desc: " . $result['desc'] . "</div>"
                   . "<div> HP: " . $result['hp'] . "</div>"
                   . "<div> EN: " . $result['en'] . "</div>"
                   . "<div> Tempo: " . $result['temp'] . "</div>"
                   . "<div> Ouro: " . $result['ouro'] . "</div>"
                   . "<div> Moedas: " . $result['moedas'] . "</div>"
                   . "<div> Exp: " . $result['exp'] . "</div>"
                   . "<div> Bloqueada: " . $result['unlock'] . "</div>"
                   . "<div> Ativa: " . $result['ativa'] . "</div>"
                   . "<a href='quest.php?q=" . $result['id'] . "&t=0&show=0'> accept </a>"
                   . "</div><br/>";
                   
        }
    }else{
        echo "<div id='q'> Sem resultado </div>";
    } 
}



/*SISTEMA MONETARIO*/
/*ssValue -> Session Value*/
    function valSumValue($ssValue,$value){//adicionei isto
        if($ssValue + $value < 0){//soma total é negativa
            return false;//não pode
        }
        //($ssValue + $value >= 0){//soma total é 0 ou superior
            return true;//pode
    }

    function valSubValue($ssValue, $value){//adicionei isto
        if($ssValue - $value < 0){
            return false;//não pode
        }
        //($ssValue - $value >= 0){//soma total é 0 ou superior
        return true;//pode
        
    }
?>