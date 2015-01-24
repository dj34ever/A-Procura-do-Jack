<?php
include ("action.php");
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Cidade</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/cidade.css" media="screen" />
        <!--<script src="js1.js"></script>-->
    </head>
    <body>
        <?php
        if (!isset($_SESSION['utilizador_nome']))
            die(header('Location: logout.php'));

//obtem valores da bd e armazena na sessão do user
        
        getuservalues();
        ?>

        <div id="top">
            <span>
                <?php print($_SESSION['utilizador_nome']); ?>
            </span> 
            <span>
                <?php echo($_SESSION['moedas'] . "$"); ?>
            </span>
            <span>
                <?php echo $_SESSION['ouro'] . "G"; ?>
            </span>
            <span>

            </span>
            <span>
                <input type="button" value="Sair" onclick="window.location.href = 'logout.php'" />
            </span>
        </div>
        <div id="content">
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

    </body>
</html>
