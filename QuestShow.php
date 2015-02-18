<?php

require ('session.php');
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
        <title>Mapa Elellor</title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div><!--JANELA PRINCIPAL-->
            <div id="openMap"><!--JANELA MAPA-->
                <div id="mapTitle"><img src="images/map_elellor_2.png" alt="Elellor" /></div>
                <div id="mapImg">
<!--                    <form action="quest.php" method="POST">
                        <input type="submit" id="m1" name="qa1" value="1"/>
                    </form>
                    <form action="quest.php" method="POST">
                        <input type="submit" id="m2" name="qa2" value="2"/>
                    </form>
                    <form action="quest.php" method="POST">
                        <input type="submit" id="m3" name="qa3" value="3"/>
                    </form>
                    <form action="quest.php" method="POST">
                        <input type="submit" id="m4" name="qa4" value="4"/>
                    </form>-->
                    <a id="m1" href="QuestShow.php?gocu=0&goq=0&t=1&show=0">1</a>
                    <a id="m2" href="QuestShow.php?gocu=0&goq=0&t=2&show=0">2</a>
                    <a id="m3" href="QuestShow.php?gocu=0&goq=0&t=3&show=0">3</a>
                    <a id="m4" href="QuestShow.php?gocu=0&goq=0&t=4&show=0">4</a>
                </div>
                <input type="button" value="close" />
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
                    if(!empty($_GET['t']) && !empty($_GET['show']) || $_GET['show']==0 && !empty($_GET['t'])){//ambas têm de estar preenchidas
                    $area =  dbEscapeString($_GET['t']);
                    $show = dbEscapeString($_GET['show']);
                        echo "AREA Nº: ".$_GET['t']." MOSTRA: ".$_GET['show'];//debug
                        if($show == 0 && $area > 0 || $area < 5){//show tem de ser true //t tem de ser de 1 a 4
                                echo "<p>" . $area . "</p>";//debug
                                questSearch($area);//este está a ser problemátivo
                        }else{
                            echo " URL FOI MEXIDA!";
                        }
                    }//recebo o id da quest $_GET['q']
                    
                ?>
                <div id="openCreature">
                <?php
                //showPlayerCreature();//mostra todas as criaturas do player
                if(!empty($_GET['q'])){//preenchido
                $q = dbEscapeString($_GET['q']);
                echo "ESCOLHE QUEST Nº: ".$_GET['q'];//debug
                    if($q>0 || $q!=null){
                        showCreatureQuest($_GET['q']);
                    }
                }
                
                if(!empty($_GET['gocu'] && !empty($_GET['goq']))){//recebe utilizador_criatura e id da quest
                    $cu = dbEscapeString($_GET['gocu']);
                    $qi = dbEscapeString($_GET['goq']);
                    echo "criatura_utilizador: ".$cu.", Quest: ".$qi;//debug
                    if($cu!=NULL || $qi!=NULL || $cu>0 || $qi>0){
                        //inserir na tabela quest_utilizador
                        $tmp = getQuestTime($qi);//tempo quest
                        echo "tempo: ".$tmp;//debug
                        //$uid, $qi, $cuid, $tmp
                        getuservalues();
                        insertQUValue($_SESSION['utilizador']['id'], $qi, $cu, $tmp);//insere na tabela 
                    }    
                }
                
                test();
                //showCreature(100, 1);
                //$qid=2;
                //echo "Quest existe? ".existQuestUtilizador($qid);//funcional
                //echo "Quest Ativa? ".isQuestActive($qid);//funcional
                //echo "\n".$_SESSION['utilizador']['nome'];
                ?>
                </div>
                <div id="">
                </div>
            </div>
        </div>
    </body>
</html>
