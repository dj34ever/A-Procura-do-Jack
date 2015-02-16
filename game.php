<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require ('session.php');
require ('action.php');
//require_once ('operation.php');


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/game.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/general.css" />
        <title>Jack Search</title>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">


        <script>

            //Função drag/drop
            $(function () {
                $(".drags").draggable({revert: "invalid"});
                $(".drops").droppable({
                    activeClass: "ui-state-default",
                    hoverClass: "ui-state-hover",
                    drop: function (event, ui) {
                        $(this)
                                .append("<p>Dropped!</p>")
                                .addClass("ui-state-highlight");

                        alert(this.id); //posicao
                        alert($(ui.draggable).attr("id")); //edificio
                        $.post("action.php", {pos: this.id, id: $(ui.draggable).attr("id")});
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
            <div id="menu"><!--ALTEREI AQUI-->
                <input class="btn" type="button" value="button1"/>
                <input class="btn" type="button" href="#openModal" value="Mapa"/>
                <input class="btn" type="button" value="button3"/>
                <input class="btn" type="button" value="Logout" onclick="window.location.href = 'logout.php'"/>
            </div>
        </div>
        <div id="content" >
            <div id="g-window">
                <div id="g-map">
                    <div id="droppables">
                        <?php
                        getconstructedbuildings();
                        foreach ($_SESSION['edificios_construidos'] as $edificios)
                        {
                            echo"<span id=p" . $edificios['pos'] . " class=drops><img src=" . $edificios['img'] . " /></span>";
                        } 
                        ?>
                       
                    </div>
                </div>
                <div id="gm-window">
                    Edificio Disponiveis
                    <div id="draggables" >
                        <?php
                        getallbuildings();
                        foreach ($_SESSION['edificios_disponiveis'] as $edificios) {
                            echo"<span id=ed" . $edificios['id'] . " class=drags><img src=" . $edificios['img'] . " /></span>";
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div id="g-window2">
                <div id="g-info">
<!--                    <script>
                    $("<div>" + "msg" + "</div>").dialog({
                        modal: true,
                        buttons: {
                            Ok: function () {
                                location.reload(true);
                            }
                        }
                    });
                    </script>-->
                    <?php
                        getuservalues(); //preenche o $_SESSION com os dados do user
                        /* VALORES */

                        echo "<div><p>Jogador: " . $_SESSION['utilizador_nome'] . "</p></div>"
                         . "<div><p>Cidade: " . $_SESSION['cidade_nome'] . "</p></div>"
                         . "<div><p>Moedas: " . $_SESSION['utilizador_moedas'] . "</p></div>"
                         . "<div><p>Ouro:" . $_SESSION['utilizador_ouro'] . "</p></div>";
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