<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
require ('action.php');

//require ('./construir.php');

if (!isset($_SESSION['utilizador']['nome'])) {
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

            //Função drag/drop
            $(function () {
                $(".drags").draggable({revert: "invalid"});
                $(".drops").droppable({
                    activeClass: "ui-state-default",
                    hoverClass: "ui-state-hover",
                    drop: function (event, ui) {
               
                        $(this).addClass("ui-state-highlight");
                        var p = this.id.slice(1);//posicao
                        var ed = $(ui.draggable).attr("id").slice(2);//edificio
                        $.post("construir.php", {pos: p, id: ed}, function (op) {
                            
                            tempo = op;
                            alert(tempo);
                         location.reload();
                            
                            
                        });
                           
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
                        <?php
                        getconstructedbuildings();
                        foreach ($_SESSION['edificio_cidade'] as $edificios) {
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
                        foreach ($_SESSION['edificio'] as $row) {
                            echo"<span id=ed" . $row['id'] . " class=drags><img src=" . $row['img'] . " /></span>";
                        }
                        ?>
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
                    $username = $_SESSION['utilizador']['nome'];
                    $cidade = $_SESSION['cidade']['nome'];
                    $moedas = $_SESSION['utilizador']['moedas'];
                    $ouro = $_SESSION['utilizador']['ouro'];

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
