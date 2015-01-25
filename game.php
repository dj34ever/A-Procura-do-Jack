<?php 
session_start();
require ('action.php');
if (!isset($_SESSION['utilizador_nome']))
            die(header('Location: logout.php'));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />

        <link rel="stylesheet" media="screen" type="text/css" href="css/game.css" />
        <title>Jack Search</title>
        <script type="text/javascript" src="js/game.js"></script>
        <script type="text/javascript" src="js/mt.js"></script>
    </head>
    <body>
        <div id="header">
            <img src="images/draco_ico_temp.png" alt="Procura o Jack" />
        </div>
        <div id="menu">
            <input type="button" value="button1"/>
            <input type="button" value="button2"/>
            <input type="button" value="button3"/>
            <input type="button" value="Logout" onclick="window.location.href = 'logout.php'"/>
        </div>
        <div id="g-window">
            <div id="g-map">
               
            </div>
            <div id="gm-window" class="inline">
                <p>buy menu</p>
            </div>
        </div>
        <div id="g-window2">
            <div id="g-info">
                <?php
                    getuservalues();//preenche o $_SESSION com os dados do user
                    /*VOCABULARIO*/
                    $v_user = "Jogador: ";
                    $v_cidade = "Atualmente em: ";
                    $v_ouro = "Ouro: ";
                    $v_nota = "Notas: ";

                    /*VALORES*/
                    $username = $_SESSION['utilizador_nome']; 
                    $cidade = $_SESSION['cidade_nome']; 
                    $moedas= $_SESSION['utilizador_moedas'];
                    $ouro = $_SESSION['utilizador_ouro'];
                    
                        echo "<div><p>".$v_user.$username."</p></div>"
                            ."<div><p>".$v_cidade.$cidade."</p></div>"
                            ."<div><p>".$v_ouro.$ouro."</p></div>"
                            ."<div><p>".$v_nota.$moedas."</p></div>";
                    ?>
            </div>
            <div id="dica">
                        <div>
                            <p><span>Dicas</span></p>
                            <span id="lb"><input class="" type="button" value="&NestedLessLess;" onclick="alert('systema de dicas')" /></span>
                            <span id="rg"><input class="" type="button" value="&NestedGreaterGreater;" onclick="alert('systema de dicas')" /></span>
                        </div>
                        <div>
                            <p><span>Dicas muda consoante o botão pressionado</span></p>
                        </div>
            </div>
        </div>
        <div id="news">stuff</div>
        <footer id="footer"></footer>
    </body>
</html>
