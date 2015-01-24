<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div id="top">

            <a href="main.php"><h1><img src="images/draco_ico_temp.png" />À procura de Jack</h1></a>

        </div>
        <div> 
            <?php
            if (!isset($_SESSION['user'])) {
                ?>
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
                }
                ?>
            </div>
        <?php } 
        else header('Location: game.php');     
        ?>
        <div>

        </div>
    </body>
</html>
