<?php
session_start();
require ('action.php');
if (!isset($_SESSION['utilizador_nome'])) {
    die(header('Location: logout.php'));
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />

        <link rel="stylesheet" media="screen" type="text/css" href="css/game.css" />
        <title>Jack Search</title>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script>
            $(function () {
                
                $(".drags").draggable({revert: "invalid"});
                $(".drops").droppable({
                    activeClass: "ui-state-default",
                    hoverClass: "ui-state-hover",
                    drop: function (event, ui) {
                        $(this)
                                .addClass("ui-state-highlight")
                                .find("p")
                                .html("Dropped!");
                    }
                });
            });
        </script>

    </head>
    <body>
        <div id="top" >
            <div id="header">
                <img src="images/draco_ico_temp.png" alt="Procura o Jack" />
            </div>
            <div id="menu">
                <input type="button" value="button1"/>
                <input type="button" value="button2"/>
                <input type="button" value="button3"/>
                <input type="button" value="Logout" onclick="window.location.href = 'logout.php'"/>
            </div>
        </div>
        <div id="content" >
            <div id="g-window">
                <div id="g-map">
                    <div id="droppables" >
                        <span id="p1" class="drops"><img src="images/h_base.png" /></span>
                        <span id="p2" class="drops"><img src="images/h_base.png" /></span>
                        <span id="p3" class="drops"><img src="images/h_base.png" /></span>
                        <span id="p4" class="drops"><img src="images/h_base.png" /></span>
                        <span id="p5" class="drops"><img src="images/h_base.png" /></span>
                    </div>
                </div>
                <div id="gm-window">
                    Edificio Disponiveis
                    <div id="draggables" >
                        <span id="ed1" class="drags"><img src="images/h_1a.png" /></span>
                        <span id="ed2" class="drags"><img src="images/h_1b.png" /></span>
                        <span id="ed3" class="drags"><img src="images/ph_casa_ev0_96w.png" /></span>
                        <span id="ed4" class="drags"><img src="images/ph_casa_ev0_96w.png" /></span>
                        <span id="ed5" class="drags"><img src="images/ph_casa_ev0_96w.png" /></span>
                    </div>
                </div>

            </div>
            <div id="g-window2">
                <div id="g-info">
                    <?php
                    getuservalues(); //preenche o $_SESSION com os dados do user
                    /* VOCABULARIO */
                    $v_user = "Jogador: ";
                    $v_cidade = "Atualmente em: ";
                    $v_ouro = "Ouro: ";
                    $v_nota = "Notas: ";

                    /* VALORES */
                    $username = $_SESSION['utilizador_nome'];
                    $cidade = $_SESSION['cidade_nome'];
                    $moedas = $_SESSION['utilizador_moedas'];
                    $ouro = $_SESSION['utilizador_ouro'];

                    echo "<div><p>" . $v_user . $username . "</p></div>"
                    . "<div><p>" . $v_cidade . $cidade . "</p></div>"
                    . "<div><p>" . $v_ouro . $ouro . "</p></div>"
                    . "<div><p>" . $v_nota . $moedas . "</p></div>";
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
        </div>
        <div id="news">stuff</div>
        <footer id="footer"></footer>



    </body>
</html>
