<?php

require ('action.php');

if(isset($_POST['u_submit'])){//registar conta utilizador
    if(empty($_POST['u_nome']) || empty($_POST['upass']) || empty($_POST['u_email'])){
        die(header('Location: interface.php?false=0'));//campos vazios
    }
    
    $user = dbEscapeString($_POST['u_nome']);
    $pass = dbEscapeString($_POST['u_pass']);
    $passHash = hash("sha512", $pass);
    $email = dbEscapeString($_POST['u_email']);
    $ativa = 1;
    $tipo = dbEscapeString($_POST['tipo_conta']);
    
    if(empty($_POST['tipo_conta'])){//não exista um tipo selecionado
        $tipo = 0;
    }
    
    //já existe utilizador?
    $sql = "SELECT * FROM utilizador WHERE username='" . $user . "' LIMIT 1";
    $query = dbFetch($sql);
    $result = mysql_num_row($query);
    
    if($result > 0){
        die(header('Location: interface.php?false=1'));//existe
    }
    
    $moedas = 0;
    $ouro = 0;
    
    $sql = "INSERT INTO utilizador (username, password, email, moedas, ouro, ativa)".
            "VALUES ('" . $user . "','" . $pass . "','" . $email . "','" . $moedas ."','" . $ouro . "')";
    $query = dbFetch($sql);
    
    if($query){
        die(header('Location: interface.php'));
    }else{
        echo 'Não foi possivel criar registo!';
        die(header('Location: interface.php'));
    }
    
}

if(isset($_POST['ed_submit'])){//registar conta utilizador
    if(empty($_POST['NomeEd']) || empty($_POST['edvol']) || empty($_POST['edtipo']) || empty($_POST['imgEd']) || empty($_POST['Cedificios'])){
        die(header('Location: interface.php?false=0'));//campos vazios
    }
    
    $ed_nome = dbEscapeString($_POST['NomeEd']);
    $ed_vol = dbEscapeString($_POST['edvol']);
    $ed_tp = dbEscapeString($_POST['edtipo']);
    $ed_img = dbEscapeString($_POST['imgEd']);
    $ed_custo = dbEscapeString($_POST['Cedificios']);
    
    //já existe utilizador?
    $sql = "SELECT * FROM edificio WHERE nome='$ed_nome' AND evol=$ed_vol AND tipo=$ed_tp AND img=$ed_img AND preco=$ed_custo LIMIT 1";
    $query = dbFetch($sql);
    $result = mysql_num_row($query);
    
    if($result > 0){
        die(header('Location: interface.php?false=1'));//existe
    }
    
    $sql = "INSERT INTO edificio (nome, evol, tipo, img, preco)".
            "VALUES ('" . $ed_nome . "','" . $ed_vol . "','" . $ed_tp . "','" . $ed_img ."','" . $ed_custo . "')";
    $query = dbFetch($sql);
    
    if($query){
        die(header('Location: interface.php'));
    }else{
        echo 'Não foi possivel criar registo!';
        die(header('Location: interface.php'));
    }
    
}

if(isset($_POST['q_submit'])){//registar conta utilizador
    if(empty($_POST['Marea']) || empty($_POST['Mnome']) || empty($_POST['MDesc']) || empty($_POST['Mhp']) || empty($_POST['Men'])
            || empty($_POST['Mtemp']) || empty($_POST['Mexp']) || empty($_POST['Mmoeda']) || empty($_POST['Mouro'])){
        die(header('Location: interface.php?false=0'));//campos vazios
    }
    
    $m_area = dbEscapeString($_POST['Marea']);
    $m_nome = dbEscapeString($_POST['Mnome']);
    $m_desc = dbEscapeString($_POST['MDesc']);
    $m_hp = dbEscapeString($_POST['Mhp']);
    $m_en = dbEscapeString($_POST['Men']);
    $m_temp = dbEscapeString($_POST['Mtemp']);
    $m_exp = dbEscapeString($_POST['Mexp']);
    $m_moeda = dbEscapeString($_POST['Mmoeda']);
    $m_ouro = dbEscapeString($_POST['Mouro']);
    
    //já existe utilizador?
    $sql = "SELECT * FROM quest WHERE area=$m_area AND nome=$m_nome AND desc=$m_desc AND hp=$m_hp AND en=$m_en AND temp=$m_temp AND exp=$m_exp AND moedas=$m_moeda AND ouro=$m_ouro LIMIT 1";
    $query = dbFetch($sql);
    $result = mysql_num_row($query);
    
    if($result > 0){
        die(header('Location: interface.php?false=1'));//existe
    }
    
    $sql = "INSERT INTO edificio (area,nome, desc, hp, en, temp, exp, ouro, moedas)".
            "VALUES ('$m_area','$m_nome','$m_desc','$m_hp', '$m_en', '$m_temp', '$m_exp', '$m_ouro', '$m_moeda')";
    $query = dbFetch($sql);
    
    if($query){
        die(header('Location: interface.php'));
    }else{
        echo 'Não foi possivel criar registo!';
        die(header('Location: interface.php'));
    }
    
}

if(isset($_POST['ed_submit'])){//registar conta utilizador
    if(empty($_POST['NomeEd']) || empty($_POST['edvol']) || empty($_POST['edtipo']) || empty($_POST['imgEd']) || empty($_POST['Cedificios'])){
        die(header('Location: interface.php?false=0'));//campos vazios
    }
    
    $ed_nome = dbEscapeString($_POST['NomeEd']);
    $ed_vol = dbEscapeString($_POST['edvol']);
    $ed_tp = dbEscapeString($_POST['edtipo']);
    $ed_img = dbEscapeString($_POST['imgEd']);
    $ed_custo = dbEscapeString($_POST['Cedificios']);
    
    //já existe utilizador?
    $sql = "SELECT * FROM edificio WHERE nome='$ed_nome' AND evol=$ed_vol AND tipo=$ed_tp AND img=$ed_img AND preco=$ed_custo LIMIT 1";
    $query = dbFetch($sql);
    $result = mysql_num_row($query);
    
    if($result > 0){
        die(header('Location: interface.php?false=1'));//existe
    }
    
    $sql = "INSERT INTO edificio (nome, evol, tipo, img, preco)".
            "VALUES ('" . $ed_nome . "','" . $ed_vol . "','" . $ed_tp . "','" . $ed_img ."','" . $ed_custo . "')";
    $query = dbFetch($sql);
    
    if($query){
        die(header('Location: interface.php'));
    }else{
        echo 'Não foi possivel criar registo!';
        die(header('Location: interface.php'));
    }
    
}

if(isset($_POST['c_submit'])){//registar conta utilizador
    if(empty($_POST['Cnome']) || empty($_POST['Cevol']) || empty($_POST['Ctipo']) || empty($_POST['Chp']) || empty($_POST['Cen'])
            || empty($_POST['Craro'])){
        die(header('Location: interface.php?false=0'));//campos vazios
    }
    
    $c_nome = dbEscapeString($_POST['Cnome']);
    $c_evol = dbEscapeString($_POST['Cevol']);
    $c_tipo = dbEscapeString($_POST['Ctipo']);
    $c_hp = dbEscapeString($_POST['Chp']);
    $c_en = dbEscapeString($_POST['Cen']);
    $c_raro = dbEscapeString($_POST['Craro']);
    
    //já existe utilizador?
    $sql = "SELECT * FROM quest WHERE nome=$c_nome AND evol=$c_evol AND tipo=$c_tipo AND hp=$c_hp AND en=$c_en AND raro=$c_raro LIMIT 1";
    $query = dbFetch($sql);
    $result = mysql_num_row($query);
    
    if($result > 0){
        die(header('Location: interface.php?false=1'));//existe
    }
    
    $sql = "INSERT INTO edificio (nome, tipo, evol, hp, en, raro)".
            "VALUES ('$c_nome','$c_tipo','$c_evol','$c_hp', '$c_en', '$c_raro')";
    $query = dbFetch($sql);
    
    if($query){
        die(header('Location: interface.php'));
    }else{
        echo 'Não foi possivel criar registo!';
        die(header('Location: interface.php'));
    }
    
}

?>
