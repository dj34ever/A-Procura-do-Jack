<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['utilizador']['nome'])) {
    die(header('Location: logout.php'));
}

require ('action.php');
//require ('quest.php');
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="css/general.css" />
        <script src="jquery/jquery-1.11.2.min.js" ></script>
        <script src="jquery/jquery-ui.js" ></script>
        <link href="jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <link href="jquery/jquery-ui.structure.css" rel="stylesheet" type="text/css"/>
        <link href="css/QuestShow.css" rel="stylesheet" type="text/css"/>
        <title>Mapa Elellor</title>

        <script>

            //gera combobox com lista de quests
            function cbArea(quests) {
                //adiciona 1ª opção à lista
                $('#quest').append($("<option>Escolha uma das opções</option>").attr("selected", "selected"));
                //adiciona restantes
                $.each(quests, function (value) {
                    $('#quest').append($("<option></option>").attr("value", quests[value][0]).text(quests[value][2]));
                });
                //adiciona o evento
                $(function () {
                    $("#quest").selectmenu({
                        change: function (event, data) {
                            
                            
                            
                            msg = "Quest " + data.item.label;
                            console.log(data.item.value);
                            $("<div>" + msg + "</div>").dialog({modal: true, buttons: {"Enviar para a Quest": function () {
                                        $(this).dialog("close");
                                    }
                                }
                            });
                        }
                    });
                });
            }
        </script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div id="jp"><!--JANELA PRINCIPAL-->
            <div id="openMap"><!--JANELA MAPA-->
                <div id="mapTitle"><img src="images/map_elellor_2.png" alt="Elellor" /></div>
                <div id="mapImg">
                    <a id="m1" href="QuestShow.php?gocu=0&goq=0&area=1">1</a>
                    <a id="m2" href="QuestShow.php?gocu=0&goq=0&area=2">2</a>
                    <a id="m3" href="QuestShow.php?gocu=0&goq=0&area=3">3</a>
                    <a id="m4" href="QuestShow.php?gocu=0&goq=0&area=4">4</a>
                </div>
                <div class="zi">
                    <a class="button" href="game.php" value="">Return</a>
                </div>
            </div>




            <div id="openQuest"><!--JANELA QUEST-->

                <?php
                /* Ao clicar numa das areas do mapa quero enviar
                 * o id do mapa
                 * quest unlocked?
                 * botão de iniciar quest
                 */
                getuservalues();
//Mostrar quest de acordo com a area selecionada
                if (!empty($_GET['area'])) {//ambas têm de estar preenchidas
                    $area = dbEscapeString($_GET['area']);
                    echo "AREA Nº: $area MOSTRA: "; //debug
                    if ($area > 0 && $area < 5) {//show tem de ser true //t tem de ser de 1 a 4
                        echo "<p>" . $area . "</p>"; //debug
                        $arrayquest = questSearch($area); //este está a ser problemátivo
                        if (!empty($arrayquest)) {
                            $arrayquest = json_encode($arrayquest); //converte array para json-> enviar para javascript
                            //echo "<label for=\"quest\">Selecionar Quest</label>"; //imprime a label
                            echo "<p>Quest: <select id=\"quest\"></select></p>"; //cria a combobox  
                            echo "<script>cbArea($arrayquest);</script>"; //adiciona conteudo
                        }
                    } else {
                        echo " URL FOI MEXIDA!";
                    }
                }//recebo o id da quest $_GET['q']
                ?>
                <div id="openCreature">

                    <?php
                    $arrayCreatures = showPlayerCreature(); //mostra todas as criaturas do player
                    if (!empty($_GET['q'])) {//preenchido
                        $q = dbEscapeString($_GET['q']);
                        echo "ESCOLHE QUEST Nº: " . $_GET['q']; //debug
                        if ($q > 0 || $q != null) {
                            $arrayCreaturesQuest = showCreatureQuest($_GET['q']);
                        }
                    }

                    if (!empty($_GET['gocu'] && !empty($_GET['goq']))) {//recebe utilizador_criatura e id da quest
                        $cu = dbEscapeString($_GET['gocu']);
                        $qi = dbEscapeString($_GET['goq']);
                        echo "criatura_utilizador: " . $cu . ", Quest: " . $qi; //debug
                        if ($cu != NULL || $qi != NULL || $cu > 0 || $qi > 0) {
                            //inserir na tabela quest_utilizador
                            //$uid, $qi, $cuid, $tmp
                            insertQUValue($_SESSION['utilizador']['nome'], $qi, $cu); //insere na tabela
                        }
                    }

                    // test();
                    //showCreature(100, 1);
                    //$qid=2;
                    //echo "Quest existe? ".existQuestUtilizador($qid);//funcional
                    //echo "Quest Ativa? ".isQuestActive($qid);//funcional
                    //echo "\n".$_SESSION['utilizador']['nome'];
                    ?>
                </div>
                <div id="Quests Actuais">
                    <div id="users-contain" class="ui-widget">
                        <h2>Quests a Decorrer:</h2>
                        <table id="users" class="ui-widget ui-widget-content">
                            <thead>
                                <tr class="ui-widget-header ">
                                    <th>Criatura</th>
                                    <th>Nome</th>
                                    <th>HP</th>
                                    <th>EN</th>
                                    <th>Tempo Restante</th>
                                    <th>Quest a Participar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $questsActivas = listarQuestsAtivas();
                                //print_r($questsActivas);
                                foreach ($questsActivas as $row) {
                                    echo "<tr>";
                                    echo "<td><img src=$row[0] alt=\"Criatura\" /></td>";
                                    echo "<td>$row[6]</td>";
                                    echo "<td>$row[7]</td>";
                                    echo "<td>$row[8]</td>";
                                    echo "<td>$row[5]</td>";
                                    echo "<td>$row[9]</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
