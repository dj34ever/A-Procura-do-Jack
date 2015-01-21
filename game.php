<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />

        <link rel="stylesheet" media="screen" type="text/css" href="css/game.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="css/cidade.css" />
        <title>Jack Search</title>
        <script type="text/javascript" src="lcjs/game.js"></script>
    </head>
    <body>
        <div id="header">header</div>
        <div id="menu">
            <input type="button" value="button1"/>
            <input type="button" value="button2"/>
            <input type="button" value="button3"/>
            <input type="button" value="button4"/>
        </div>
        <div id="g-window">
            <div id="g-map" class="inline">
               <div id="pos1">
                <img src="sprites/beary.png" alt="casa" onclick="construirCasa(this.parentNode.id)"/>
            </div>
            <div id="pos2">

                <img src="sprites/beary.png" alt="casa" onclick="construirCasa(this.parentNode.id)" />  

            </div>


            <script>
                //array de casas
                //substituir em php por var unica???
                var casas = [];
                //inicaliza o array com casas vazias
                for (var i = 1; i <= 2; i++)
                    casas[i] = new Casa(i);

                //Funcção para construir e evoluir edificio
                //recebe o id da div parent no formato "pos"+n
                function construirCasa(pos) {
                    //cria o texto com o tempo restante de construcao
                    function escrever(msg) {
                        //elimina paragrafo
                        if (parent.getElementsByTagName("p")[0])
                        {
                            var par = parent.getElementsByTagName("p")[0];
                            parent.removeChild(par);
                        }
                        //escreve msg num paragrafo
                        var texto = document.createTextNode(msg + " segundos");
                        var par = document.createElement("p");
                        par.appendChild(texto);
                        parent.appendChild(par);
                    }

                    //temporario
                    //alterar para um for
                    //apagar para php
                    var id;
                    if (pos === "pos1")
                        id = 1;
                    else if (pos === "pos2")
                        id = 2;
                    //define vars
                    var parent = document.getElementById(pos);
                    var img = parent.getElementsByTagName("img")[0];
                    //verifica se o edifico já se encontra em construção/evolucao
                    if (!(casas[id].construindo === 0) || (casas[id].evo === casas[id].maxevo))
                        return 0;
                    //marca o edifico como em construcao
                    casas[id].construindo = 1;



                    // define o temporizador
                    var myCounter = new Countdown({
                        seconds: casas[id].segundos, // number of seconds to count down
                        onUpdateStatus: function (sec) {
                            escrever(sec);
                            //console.log(sec);
                        }, // callback for each second
                        onCounterEnd: function () {

                            evoluir(casas[id]);
                            img.setAttribute("src", casas[id].img);
                            parent.removeChild(parent.getElementsByTagName("p")[0]);



                        } // final action
                    });

                    myCounter.start();

                }

                function Countdown(options) {
                    var timer,
                            instance = this,
                            seconds = options.seconds || 10,
                            updateStatus = options.onUpdateStatus || function () {
                            },
                            counterEnd = options.onCounterEnd || function () {
                            };

                    function decrementCounter() {
                        updateStatus(seconds);
                        if (seconds === 0) {
                            counterEnd();
                            instance.stop();
                        }
                        seconds--;
                    }

                    this.start = function () {
                        clearInterval(timer);
                        timer = 0;
                        seconds = options.seconds;
                        timer = setInterval(decrementCounter, 1000);
                    };

                    this.stop = function () {
                        clearInterval(timer);
                    };
                }
                function Casa(id) {
                    this.id = id;
                    this.evo = 0;
                    this.segundos = 5;
                    this.img = "";
                    this.construindo = 0;
                    this.maxevo = 2;
                }
                function evoluir(casa) {
                    if (casa.evo === 0)
                        casa.img = "images/ph_casa_ev0_96w.png";
                    else if (casa.evo === 1)
                        casa.img = "images/ph_casa_ev1_96w.png";
                    casa.segundos = casa.segundos + 5;
                    casa.evo = casa.evo + 1;
                    casa.construindo = 0;
                }



            </script>
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