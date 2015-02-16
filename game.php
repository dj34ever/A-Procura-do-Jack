<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require ('action.php');

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
        <link rel="stylesheet" media="screen" type="text/css" href="css/general.css" />
        <title>Jack Search</title>
        <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
        <script src="jquery/jquery-1.11.2.min.js" ></script>
        <script src="jquery/jquery-ui.js" ></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <link rel="stylesheet" href="jquery/jquery-ui.css">

        <script>

            //Função drag/drop
            $(function () {
                $(".drags").draggable({revert: "invalid"});
                $(".drops").droppable({
                    // activeClass: "ui-state-default",
                    // hoverClass: "ui-state-hover",
                    drop: function (event, ui) {
                        // $(this).addClass("ui-state-highlight");
                        var p = this.id.slice(1);//posicao
                        var ed = $(ui.draggable).attr("id").slice(2);//edificio
                        $.post("construir.php", {pos: p, id: ed}, function (msg) {
                            $("<div>" + msg + "</div>").dialog({
                                modal: true,
                                buttons: {
                                    Ok: function () {
                                        window.location.reload(true);
                                    }
                                }
                            });
                        });
                    }
                });
            });
            //adiciona counter a edificios em construção
            //pos==posição (div no mapa), tempo==segundos ate terminar a construção
            function temporizador(pos, tempo) {
                if (tempo > 0)
                    setInterval(function () {
                        $(pos).find("p").html(tempo + " S");
                        tempo--;
                        if (tempo < 0)
                            window.location.reload(true);
                    }, 1000);
            }
   
            function dialogo(value) {
                
                var msg = [
                    "<h3>Insanity: doing the same thing over and over again and expecting different results.</h3><br>Albert Einstein",
                    "<h3>Education is what remains after one has forgotten what one has learned in school.</h3><br>Albert Einstein" 
                ];
                
        $("<div>" + msg[value] + "</div>").dialog({ modal:true}); 
               
            }


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
                        //obtem edificios construidos
                        getconstructedbuildings();
                        //percorre cada edificio e verifica se existe algum em construcao
                        //envia esse tempo para o javascript temporizador
                        foreach ($_SESSION['edificio_cidade'] as $edificios) {
                            if (($edificios['tempo_construcao_final'] - time()) > 0) {
                                $tempo = ($edificios['tempo_construcao_final'] - time());
                            } else {
                                $tempo = 0;
                            }
                            echo"<span id=p" . $edificios['pos'] . " class=drops ><img src=" . $edificios['img'] . " /><p><script>temporizador(p" . $edificios['pos'] . ",$tempo);</script></p></span>";
                        }
                        ?>
                    </div>
                </div>
                <div id="gm-window">
                    Edificio Disponiveis
                    <div id="draggables" >
                        <?php
                        //obtem todos os edificios disponiveis para construção
                        getallbuildings();
                        if (!empty($_SESSION['edificio'])) {
                            foreach ($_SESSION['edificio'] as $row) {
                                echo"<span id=ed" . $row['id'] . " class=drags><img src=" . $row['img'] . " /></span><span>" . $row['preco'] . " N</span>";
                            }
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

                    echo "<div><p>Jogador: " . $_SESSION['utilizador']['nome'] . "</p></div>"
                    . "<div><p>Cidade: " . $_SESSION['cidade']['nome'] . "</p></div>"
                    . "<div><p>Moedas: " . $_SESSION['utilizador']['moedas'] . "</p></div>"
                    . "<div><p>Ouro:" . $_SESSION['utilizador']['ouro'] . "</p></div>";
                    ?>
                </div>
                <div id="dica">
                    <div>
                        <p><span>Dicas</span></p>
                        <span id="lb"><input class="dicas" type="button" value="&NestedLessLess;" onclick="dialogo(0)" /></span>
                        <span id="rg"><input class="dicas" type="button" value="&NestedGreaterGreater;"  onclick="dialogo(1)"/></span>
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
