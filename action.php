<?php

//Obtem valores do utilizador (ouro, moedas ...)
function getuservalues() {
    if (!isset($_SESSION['utilizador']['nome'])) {
        die(header('Location: logout.php'));
    }
    //Dados de User
    $sql = "SELECT id, moedas, ouro, ativa, tipo FROM utilizador where username='" . $_SESSION['utilizador']['nome'] . "'";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['utilizador']['id'] = $result['id'];
    $_SESSION['utilizador']['moedas'] = $result['moedas'];
    $_SESSION['utilizador']['ouro'] = $result['ouro'];
    $_SESSION['utilizador']['ativa'] = $result['ativa'];
    $_SESSION['utilizador']['tipo'] = $result['tipo'];//adicionei isto!

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
    $sql = "SELECT * FROM edificio where tipo!=0 and id NOT IN(select id_edificio from edificio_cidade where id_cidade=" . $_SESSION['cidade']['id'] . " and id_edificio is not null union select id_edificio_construcao from edificio_cidade where id_cidade=" . $_SESSION['cidade']['id'] . " and id_edificio_construcao is not null)";
    $query = dbFetch($sql);
    if ($query) {
        unset($_SESSION['edificio']);
        while ($row = mysqli_fetch_assoc($query)) {
            $_SESSION['edificio'][] = $row;
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
        while ($row = mysqli_fetch_assoc($query)) {
            //termina a construcao do edificio
            if ($row['tempo_construcao_final'] <= time()) {
                $sql = "Update edificio_cidade set id_edificio=id_edificio_construcao, tempo_construcao_final=0, id_edificio_construcao=NULL where id=" . $row['id'];
                dbFetch($sql);
            }
            //volta a preencher o array
            $_SESSION['edificio_cidade'][] = $row;
        }
    } else {
        unset($_SESSION['edificio_cidade']);
    }
}

//executa a query; termina a ligacao; retorna um result do mysqli_query
function dbFetch($sql) {
    require_once ("config.php");
    $dbconn = dbConnect();
    $result = mysqli_query($dbconn, $sql);
    mysqli_close($dbconn);
    return $result;
}

function dbEscapeString($string) {
    require_once ("config.php");
    $dbconn = dbConnect();
    $result = mysqli_escape_string($dbconn, $string);
    mysqli_close($dbconn);
    return $result;
}

/* A PARTIR DAQUI É NOVO! */

/* INTERFACE */

function countAll($table) {//contar o nº de registos p/tabela
    if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
    }

    $sql = "SELECT COUNT(*) FROM " . $table . "";
    $query = dbFetch($sql);
    $result = mysqli_num_rows($query);
    return $result;
}

function showPlayerCreature() {//show all creatures from player in session
    getuservalues();
    $sql = "SELECT a.*, b.username as buser FROM criatura_utilizador a, utilizador b WHERE a.u_id=b.id AND b.username='" . $_SESSION['utilizador']['nome'] . "'";
    $query = dbFetch($sql);
    $i = 0;
    if ($query) {
        while ($result = mysqli_fetch_assoc($query)) {
            echo "<div id='c'>"
            . "<div>Id: " . $result['id'] . "</div>"
            . "<div>Jogador: " . $result['buser'] . "<div>"
            . "<div>Criatura: " . $result['c_id'] . "<div>"
            . "<div>Imagem: <img src='" . $result['img'] . "' alt='criatura " . $result['id'] . "'/></div>"
            . "<div>Nome: " . $result['nome'] . "</div>"
            . "<div>Evolução: " . $result['evol'] . "</div>"
            . "<div>HP: " . $result['hp'] . "</div>"
            . "<div>EN: " . $result['en'] . "</div>"
            . "<br/>";
        }
    } else {
        echo "<div id='c'>Sem Registos</div>";
}
}

function showCreatureQuest($id) {
    //obtem quest
    $qid = dbEscapeString($id); //id da quest
    $sql = "SELECT a.*, c.username as cuser FROM criatura_utilizador a, quest b, utilizador c WHERE a.en>=b.en AND b.en IN(SELECT en FROM quest WHERE id=$qid) AND"
      ." a.hp>=b.hp AND b.hp IN(SELECT hp FROM quest WHERE id=$qid) AND c.id='" . $_SESSION['utilizador']['id'] . "' AND a.c_id NOT IN(SELECT cu_id FROM quest_utilizador)";
    $query = dbFetch($sql);
    if ($query) {//existe a quest        
        while ($result = mysqli_fetch_assoc($query)) {
            echo "<div id='c'>"
            . "<div>Id: " . $result['id'] . "</div>"
            . "<div>Jogador: " . $result['cuser'] . "<div>"
            . "<div>Criatura: " . $result['c_id'] . "<div>"
            . "<div>Imagem: <img src='" . $result['img'] . "' alt='criatura " . $result['id'] . "'/></div>"
            . "<div>Nome: " . $result['nome'] . "</div>"
            . "<div>Evolução: " . $result['evol'] . "</div>"
            . "<div>HP: " . $result['hp'] . "</div>"
            . "<div>EN: " . $result['en'] . "</div>"
            . "<a class='' href='QuestShow.php?gocu=" . $result['id'] . "&goq=" . $qid . "&t=0&show=0'> accept </a></div><br/>";
        }
    } else {
        echo 'Não existem criaturas.'; die(header('Location: QuestShow.php?gocu=0&goq=0&t=0&show=0'));
    }
}

///////////////////////////////////////////////////TESTE///////////////////////////////////////////////////////
function test() {//update 1
    $sql = "SELECT * FROM quest_utilizador WHERE u_id=" . $_SESSION['utilizador']['id'];
    $query = dbFetch($sql);
    while ($result = mysqli_fetch_assoc($query)) {//ERRO?
        echo "<div id='q'>"
        . "<div>Id: " . $result['id'] . "</div>"
        . "<div>Jogador ID: " . $result['u_id'] . "<div>"
        . "<div>Quest ID: " . $result['q_id'] . "<div>"
        . "<div>Criatura ID: " . $result['cu_id'] . "<div>"
        . "<div>TEMPO: " . $result['tempo'] . "<div>"
        . "<div>ATIVA: " . $result['ativa'] . "</div>"
        . "<br/>";
    }
}

///PROBLEMA!
function insertQUValue($qid, $cuid) { 
    require_once ("config.php");
    getuservalues();
    $aux = $_SESSION['utilizador']['id'];
    $sql="SELECT id FROM utilizador WHERE id=".$aux;
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);
    $uid = $result['id'];
    
    $temp = getQuestTime($qid);
    //INSERT INTO `david_dicas`.`quest_utilizador` (`id`, `u_id`, `q_id`, `cu_id`, `tempo`) VALUES (NULL, '1', '2', '3', '00:06:00');
    $sql = "INSERT INTO quest_utilizador (u_id, q_id, cu_id, temp) VALUES (NULL, '$uid', '$qid', '$cuid', '$temp')";
    echo $sql;
    //"INSERT INTO edificio_cidade (id_cidade, id_edificio,tempo_construcao_final,pos) VALUES ( " . $result['id'] . ", 5, '00:00:00', $i)";
    //$query = dbFetch($sql);
    //$query = dbFetch($sql);
    $query = dbFetch($sql);
    if(!$query){echo 'yes: '.$query;}else { echo 'no: '.$query;}
}

//function updateQUValue($id, $cuid, $qtemp){
//    $sql = "UPDATE quest_utilizador SET cu_id=$cuid, temp=$qtemp, ativa=1 WHERE id=$id";
//    //$query = dbFetch($sql);
//    dbFetch($sql);
//}

function getQuestTime($qid) {//tempo da quest
    $sql = "SELECT temp FROM quest WHERE id=$qid";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);
    return $result['temp'];
}

function LowerStat($cuid, $qid) {//Diminui EN e HP automático
    //quest status
    $sql = "SELECT en, hp FROM quest Where id=$qid";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);

    $qen = $result['en'];
    $qhp = $result['hp'];

    //criatura status
    $sql = "SELECT en, hp FROM criatura_utilizador Where id=$qid AND c_id=$cuid AND u_id='" . $_SESSION['utilizador']['id'] . "'";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);

    $cen = $result['en'];
    $chp = $result['hp'];

    //calcular
    $EN = $cen - $qen;
    $HP = $chp - $qhp;

    //exp da quest
    $exp = getExpQuest($qid);
    updateCreatureUtilizador($qid, $cuid, $exp, $HP, $EN);
}

function updateCreatureUtilizador($qid, $cuid, $exp, $HP, $EN) {//faz update da criatura, eh, hp, exp
        $sql = "UPDATE criatura_utilizador SET en=$EN, hp=$HP WHERE c_id=$cuid AND u_id='" . $_SESSION['utilizador']['id'] . "'";
        $query = dbFetch($sql);
    }

function getExpQuest($qid) {//get exp from quest
    $sql = "SELECT exp from quest WHERE id=$qid";
    $query = dbFetch($sql);
    $result = mysqli_fetch_assoc($query);

    return $result;
}

function showCreature() {//todas as criaturas do utilizador
    $sql = "SELECT a.*, b.username as buser FROM criatura_utilizador a, utilizador b"
            . " WHERE a.u_id=b.id AND b.username='" . $_SESSION['utilizador']['nome'] . "'";
    $query = dbFetch($sql);

    while ($result = mysqli_fetch_assoc($query)) {
        echo "<div id='c'>"
        . "<div>Id: " . $result['id'] . "</div>"
        . "<div>Jogador: " . $result['buser'] . "<div>"
        . "<div>Criatura: " . $result['c_id'] . "<div>"
        . "<div>Imagem: <img src='" . $result['img'] . "' alt='criatura " . $result['id'] . "'/></div>"
        . "<div>Nome: " . $result['nome'] . "</div>"
        . "<div>Evolução: " . $result['evol'] . "</div>"
        . "<div>HP: " . $result['hp'] . "</div>"
        . "<div>EN: " . $result['en'] . "</div>"
        . "<div>EN: " . $result['ativa'] . "</div>"
        . "<br/>";
    }
}

/* QUEST */

function questSearch($area) {//adicionei isto
    //require("config.php");
    $a = dbEscapeString($area);
    //$sql = "SELECT id, a.nome, desc, hp, en, temp, ouro, moedas, exp, unlock, ativa, b.nome FROM quest a, area b WHERE b.area='" . $a . "' AND a.area=b.area";
    //. "'" . $a . "' AND";
    //$sql="SELECT a.*, b.nome as bnome FROM quest a, area b WHERE a.area='" . $a . "' AND b.area=a.area";//debug
    //$sql="SELECT a.*, b.nome as bnome FROM quest a, area b WHERE a.area='" . $a . "' AND b.area=a.area AND a.unlock=0";//deu!
    //$sql="SELECT a.*, b.nome as bnome FROM quest a, area b WHERE a.area=b.area AND b.area IN (SELECT area FROM area WHERE area=$a)";
    //$sql = "SELECT a.id, a.nome, a.desc, a.hp, a.en, a.temp, a.ouro, a.moedas, a.exp, a.unlock, a.ativa, b.nome as bnome FROM quest a, area b"; //WHERE a.area=b.area AND b.area IN (SELECT area From area WHERE area=".$a.")";
    //$sql = "SELECT a.*, b.nome FROM quest a, area b WHERE $a=b.area AND b.area=a.area";
    $sql = "SELECT a.*, b.nome as bnome FROM quest a, area b WHERE $a=b.area AND b.area=a.area";
    $query = dbFetch($sql);
    if ($query) {
        while ($result = mysqli_fetch_assoc($query)) {//area
            echo "<div id='q'>"
            . "<div> Area: " . $result['nome'] . "</div>"
            . "<div> Nome: " . $result['bnome'] . "</div>"
            . "<div> Desc: " . $result['desc'] . "</div>"
            . "<div> HP: " . $result['hp'] . "</div>"
            . "<div> EN: " . $result['en'] . "</div>"
            . "<div> Tempo: " . $result['temp'] . "</div>"
            . "<div> Ouro: " . $result['ouro'] . "</div>"
            . "<div> Moedas: " . $result['moedas'] . "</div>"
            . "<div> Exp: " . $result['exp'] . "</div>"
//            . "<div> Bloqueada: " . $result['unlock'] . "</div>"
//            . "<div> Ativa: " . $result['ativa'] . "</div>"
            . "<a href='QuestShow.php?q=" . $result['id'] . "&gocu=0&goq=0&t=0&show=0'> accept </a>"
            . "</div><br/>";
        }
    }// else {
//        echo "<div id='q'> Sem resultado </div>";
//    }
}

/* SISTEMA MONETARIO */
/* ssValue -> Session Value */

function valSumValue($ssValue, $value) {//adicionei isto
    if ($ssValue + $value < 0) {//soma total é negativa
        return false; //não pode
    }
    //($ssValue + $value >= 0){//soma total é 0 ou superior
    return true; //pode
}

function valSubValue($ssValue, $value) {//adicionei isto
    if ($ssValue - $value < 0) {
        return false; //não pode
    }
    //($ssValue - $value >= 0){//soma total é 0 ou superior
    return true; //pode
}

?>
