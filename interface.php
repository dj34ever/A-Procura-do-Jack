<?php
//require ('session.php');
session_start();
require ('action.php');
//vocab.php
//action.php
//countAll($table)

$totalContas = countAll('utilizador');
$totalEdificio = countAll('edificio');
$totalQuest = countAll('quest');
$totalCriatura = countAll('criatura');
?>

<!DOCTYPE html>
<!--
Interface para admin
Implementar:
    Ligar à base de dados
    Restringir acesso a contas tipo 1 (admin)
    Adicionar elementos à base de dados sem imagens
    Adicionar elementos à base de dados com imagens
    Vizulaizar base de dados
    Acesso a tabelas de apoio à base de dados
-->
<html>
    <head>
        <title>Interface Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
//Verifica se existe uma sessão iniciada
        if (!isset($_SESSION['utilizador']['nome'])) {
            die(header('Location: logout.php'));
        }
        ?>
        <div id="utilizador">
            <h4>Utilizador</h4>
            <form action="" method="POST">
                <div>
                    <?php echo 'Existem ' . $totalContas . ' Contas<br/>'; ?>
                    <label for="u_nome">Nome:</label>
                    <input type="text" id="u_nome" name="u_nome" maxlength="50" value="" /><br/>
                    <label for="u_pass">Senha:</label>
                    <input type="text" id="u_pass" name="u_pass" maxlength="8" value="" /><br/>
                    <label for="u_email">Email:</label>
                    <input type="text" id="u_email" name="u_email" maxlength="50" value="" /><br/>
                    <p>Tipo de Conta:</p>
                    <input type="radio" id="comum" name="tipo_conta" tabindex="0" value="0" />
                    <label for="comum">(0)Comum</label><br/>
                    <input type="radio" id="admin" name="tipo_conta" tabindex="1" value="1" />
                    <label for="admin">(1)Admin</label><br/>
                </div>
                <div><input type="submit" value="Criar Conta" name="u_submit"/></div>
            </form>
        </div>
        <div id="edificio">
            <h4>Edificios</h4>
            <form action="" method="POST">
                <div>
                    <?php
//mensagem conta criada ou existe
                    if ($_GET['r'] == 0) {
                        echo '<p>A conta foi criada!</p>';
                    } else {
                        echo '<p>A conta já existe!</p>';
                    }
                    ?>
                    <?php echo 'Existem ' . $totalEdificio . ' Edificios</br>'; ?>
                    <label for="ed_nome">Nome:</label>
                    <input type="text" id="ed_nome" name="Nome do Edificio" maxlength="50" value="" /><br/>
                    <label for="ed_evol">Evolução:</label>
                    <select id="ed_evol">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select><br/>
                    <label for="ed_tipo">Tipo:</label>
                    <select id="ed_tipo">
                        <option value="0">(0)Dormitório</option>
                        <option value="1">(1)Armazém</option>
                        <option value="2">(2)Hospital</option>
                        <option value="3">(3)Centro de Evolução</option>
                        <option value="4">(4)Centro de Missões</option>
                    </select><br/>
                    <label for="ed_img">Imagem (100x100 px):</label>
                    <p><input type="file" id="ed_img" name="Imagem Edificio" />'Não implementado'</p><br/>
                    <p><label for="ed_preco">Custo Contrução:</label>
                        <input type="text" id="ed_preco" name="Custo Construção" style="width: 75px" maxlength="9" value="" /> Moedas</p>
                </div>
                <div><input type="submit" value="Adicionar" name="ed_submit"/></div>
            </form>
        </div>
        <div id="missao">
            <h4>Missões</h4>
            <form action="" method="POST">
                <div>
                    <?php echo 'Existem ' . $totalQuest . ' Missões<br/>'; ?>
                    <label for="areas">Area:</label>
                    <select id="areas">
                        <option value="0">(0)Bellbroke Fort</option>
                        <option value="1">(1)Forest Citadel</option>
                        <option value="2">(2)Sky Scratch</option>
                        <option value="3">(3)Lost City</option>
                        <option value="4">(4)Undefined</option>
                    </select><br/>
                    <label for="q_nome">Nome da Quest:</label>
                    <input type="text" id="q_nome" name="Nome da Missão" maxlength="50" value="" /><br/>
                    <label for="q_descricao">Nome:</label>
                    <input type="text" id="q_descricao" name="Descrição" value="" /><br/>
                    <label for="q_vida">Consumo de Vida:</label>
                    <input type="text" id="q_vida" name="Vida" value="" /><br/>
                    <label for="q_energia">Consumo de Energia:</label>
                    <input type="text" id="q_energia" name="Energia" value="" /><br/>
                    <label for="q_tempo">Duração da Missão:</label>
                    <input type="time" id="q_tempo" name="Tempo" value="" /><br/>
                    <label for="q_exp">Recompensa Experiencia:</label>
                    <input type="text" id="q_exp" name="Experiencia" value="" /><br/>
                    <label for="q_moedas">Recompensa Moedas:</label>
                    <input type="text" id="q_moedas" name="Moedas" value="" /><br/>
                    <label for="q_gold">Comsumo Ouro:</label>
                    <input type="text" id="q_gold" name="Ouro" value="" />
                </div>
                <div><input type="submit" value="Adicionar" name="q_submit"/></div>
            </form>
        </div>
        <div id="criatura">
            <h4>Criaturas</h4>
            <form action="" method="POST">
                <div>
                    <?php echo 'Existem ' . $totalCriatura . 'Crituras<br/>'; ?>
                    <label for="c_nome">Nome da Criatura:</label>
                    <input type="text" id="c_nome" name="Nome da Criatura" maxlength="50" value="" /><br/>
                    <label for="c_evol"></label>
                    <select id="c_evol">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select><br/>
                    <label for="c_tipo">Tipo:</label>
                    <select id="c_tipo">
                        <option value="0">(0)Ave</option>
                        <option value="1">(1)Anfíbio</option>
                        <option value="2">(2)Mamífero</option>
                        <option value="3">(3)Aracnídeo</option>
                        <option value="4">(4)Inseto</option>
                        <option value="5">(5)Réptil</option>
                        <option value="6">(6)Peixe</option>
                        <option value="7">(7)Crustáceo</option>
                        <option value="8">(8)Mulusculo</option>
                        <!--                        <option value="9">(9)Deva</option>Futuro?
                                                <option value="10">(10)Mõr</option>Futuro?-->
                    </select><br/>
                    <label for="c_vida">Vida Base:</label>
                    <input type="text" id="c_vida" name="Nome da Criatura" maxlength="50" value="" /><br/>
                    <label for="c_energia">Energia Base:</label>
                    <input type="text" id="c_energia" name="Nome da Criatura" maxlength="50" value="" /><br/>
                    <label for="c_raro">Raridade:</label>
                    <select id="c_raro">
                        <option value="0">(0)Comum</option>
                        <option value="1">(1)Incomum</option>
                        <option value="2">(2)Raro</option>
                        <option value="3">(3)Lendário</option>
                        <!--                        <option value="4">(4)Deva</option>Futuro?
                                                <option value="5">(5)Mõr</option>Futuro?-->
                    </select>
                </div>
                <div><input type="submit" value="Addicionar" name="c_submit"/></div>
            </form>
        </div>
        <div>

        </div>
    </body>
</html>
