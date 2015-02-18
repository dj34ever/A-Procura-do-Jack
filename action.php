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
    $sql = "SELECT a.*, b.username as buser FROM criatura_utilizador a, utilizador b WHERE a.u_id=b.id AND b.username='" . $_SESSION['utilizador_nome'] . "'";
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
    /* verificar se a quest está ativa
     * verificar qual a criatura que está disponivel
     * selecionar todas as criaturas
     * 
     */
    //obtem quest
    $q_id = dbEscapeString($id);
    $sql = "SELECT * FROM quest WHERE id=" . $q_id;
    $query = dbFetch($sql);

    if ($query) {//existe a quest
        $result = mysqli_fetch_assoc($query); //recolher en e hp
        $en = $result['en'];
        $hp = $result['hp'];
    } else {
        die(header('Location: QuestShow.php'));
    }

    //procura criatura
    showCreature($en, $hp);
}

function showCreature($en, $hp) {
    $sql = "SELECT a.*, b.username as buser FROM criatura_utilizador a, utilizador"
            . " WHERE a.u_id=b.id AND b.username='" . $_SESSION['utilizador_nome']
            . "' AND a.en>=$en AND a.hp>=$hp";
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
        . "<br/>";
    }
}

/* QUEST */

function questSearch($area) {//adicionei isto
    require("config.php");

    $a = dbEscapeString($area);
    $sql = "SELECT a.*, b.nome as bnome FROM quest a, area b WHERE $a=b.area AND b.area=a.area";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);
    mysqli_close($GLOBALS['dbConn']);
    if ($query) {
        while ($result = mysqli_fetch_assoc($query)) {//area
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
    } else {
        echo "<div id='q'> Sem resultado </div>";
    }
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
