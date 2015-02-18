<?php 
session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/main.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <div id="top">
            <a href="main.php"><h1><img src="images/draco_ico_temp.png" />À procura de Jack</h1></a>
        </div>
        <div> 
            <?php
            if (!isset($_SESSION['utilizador']['nome'])) {
                ?>
                <form name="login" action="login.php" method="POST">
                    <div>Username:<input type="text" name="username" value="" /></div>
                    <div>Password:<input type="password" name="password" value="" /></div>
                    <div>
                        <input type="submit" value="Login" name="submit" />
                        <span><input type="button" value="Registar" onclick="window.location.href = 'novoutilizador.php'" /></span>
                    </div>
                </form>
                <?php
                
                if (!empty($_GET['false']) == 1) {
                    echo 'Utilizador ou Palavra Passe Incorrecto';
                } elseif (!empty($_GET['false']) == 2) {
                    echo 'Já existe um Utilizador com o mesmo Username';
                } elseif (!empty($_GET['false']) == 3) {
                    echo 'Ocorreu um erro desconhecido';
                } elseif (!empty($_GET['false']) == 4) {
                    echo 'Preencha todos os Campos';
                }
                ?>
            </div>
            <?php
            } else {
                header('Location: game.php');
            }
            ?>
        <div>

        </div>
    </body>
</html>
