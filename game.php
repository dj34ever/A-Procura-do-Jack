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
        <script type="text/javascript" src="http://demos111.mootools.net/demos/mootools.svn.js"></script> 
         <!-- <script type="text/javascript" src="js/mt.js" ></script> -->
        <script type="text/javascript">
            window.addEvent('domready', function () {
               
               //tooltip
                 var Tips1 = new Tips($$('.Tips1'));
        
        
                 //drag-drop
                var fx = [];
                
                $$('#draggables div').each(function (drag) {
                    new Drag.Move(drag, {
                        droppables: $$('#droppables div')
                    });

                    drag.addEvent('emptydrop', function () {
                        //this.setStyle('background-color', '#faec8f');
                    });
                });

                $$('#droppables div').each(function (drop, index) {
                    fx[index] = drop.effects({transition: Fx.Transitions.Back.easeOut});
                    drop.addEvents({
                        'over': function (el, obj) {
                            this.setStyle('background-color', '#1d1d20');
                        },
                        'leave': function (el, obj) {
                            //this.setStyle('background-color', '#1d1d20');
                            this.setStyle('background-color', '');

                        },
                        'drop': function (el, obj) {
                            el.remove();
                            fx[index].start({
                                //  'height': this.getStyle('height').toInt() + 30,
                                //'background-color': ['#78ba91', '#1d1d20']
                                //Chamar funcção construir
                            });
                        }
                    });
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

                    <div id="droppables">
                        <div id="p1" class="drop"><img src="images/h_base.png" /></div>
                        <div id="p2" class="drop"><img src="images/h_base.png" /></div>
                        <div id="p3" class="drop"><img src="images/h_base.png" /></div>
                        <div id="p4" class="drop"><img src="images/h_base.png" /></div>
                        <div id="p5" class="drop"><img src="images/h_base.png" /></div>
                    </div>
                </div>
                <div id="gm-window">
                    Edificio Disponiveis
                    <div id="draggables">
                        
                        <div id="c1" class="drag"><img src="images/h_1a.png" class="Tips1" title="Casa 1 :: Utilizador <?php echo $_SESSION['utilizador_id']; ?>" /></div>
                        <div id="c2" class="drag"><img src="images/h_1b.png" class="Tips1" title="Casa 2 :: Cidade <?php echo $_SESSION['cidade_id']; ?>" /></div>
                        <div id="c3" class="drag"><img src="images/ph_casa_ev0_96w.png" class="Tips1" title="Casa 3 :: Utilizador <?php echo $_SESSION['utilizador_id']; ?>" /></div>
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
