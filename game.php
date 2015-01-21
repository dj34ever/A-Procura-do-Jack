<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />

        <link rel="stylesheet" media="screen" type="text/css" href="lcss/game.css" />
        <title>Jack Search</title>
        <script type="text/javascript" src="lcjs/game.js"></script>
    </head>
    <body>
        <div id="header">
            <img src="limg/draco_ico_temp.png" alt="Procura o Jack" />
            <div id="rb"> 
            <?php
                if (!isset($_SESSION['user'])) {?>
                <form name="login" action="login.php" method="POST">
                    <div>Username:<input type="text" name="username" value="" /></div>
                    <div>Password:<input type="password" name="password" value="" /></div>
                    <div>
                        <input type="submit" value="Login" name="submit" />
                        <span><input type="button" value="Registar" onclick="window.open('novoutilizador.php')" /></span>
                    </div>
                </form>
                <?php
                    if ($_GET['false'] == 1) {
                        echo 'Utilizador ou Palavra passe Errada';
                    }?>
            </div>
        <?php } ?>
        </div>
        <div id="menu">
            <input type="button" value="button1"/>
            <input type="button" value="button2"/>
            <input type="button" value="button3"/>
            <input type="button" value="button4"/>
        </div>
        <div id="g-window">
            <div id="g-map" class="inline">
                <p>Game Window</p>
            </div>
            <div id="gm-window" class="inline">
                <p>buy menu</p>
            </div>
        </div>
        <div id="g-window2">
            <div id="g-info">
                <?php

                    /*VOABULARIO*/
                    $v_user = "Jogador: ";
                    $v_cidade = "Atualmente em: ";
                    $v_ouro = "Ouro: ";
                    $v_nota = "Notas: ";

                    /*VALORES*/
                    $username = $_SESSION['username']; //"A";
                    $cidade = $_SESSION['']; //"CidadeB";
                    $ouro = $_SESSION['']; //700;
                    $nota = $_SESSION['']; //3;
                        echo "<div class=''><p>".$v_user.$username."</p></div>\n"
                            ."<div class=''><p>".$v_cidade.$cidade."</p></div>\n"
                            ."<div class=''><p>".$v_ouro.$ouro."</p></div>\n"
                            ."<div class=''><p>".$v_nota.$nota."</p></div>";
                    ?>
    <!--                <div class=""><p>Username</p></div>
                    <div class=""><p>Nome Cidade</p>"</div>
                    <div class=""><p>O: 999999999</p></div>
                    <div class=""><p>$: 999999999</p></div>-->
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