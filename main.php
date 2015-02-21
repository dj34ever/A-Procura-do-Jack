<?php
session_start();
?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">

        <title>A Procura de Jack - Login </title>
        <link rel="stylesheet" media="screen" type="text/css" href="css/Registar.css" />



    </head>

    <body>
        <?php
        if (!isset($_SESSION['utilizador']['nome'])) {
            ?>

            <img class="banner" src="images/banner.png" />
            <form action="login.php" method="post"  class="wrap">
                <div class="round-button"><div class="round-button-circle"><a  href="novoutilizador.php" class="round-button">Registar</a></div></div>
                <div class="avatar">
                    <img src="images/draco_ico_temp.png" onclick="window.location.href = 'story.php'">
                </div>
                <input type="text" id="ut" placeholder="Utilizador" name="username">
                <div class="bar">
                    <i></i>
                </div>
                <input type="password" placeholder="Senha" name="password">
                <br/>
                <button type="submit" name="submit">Login</button>
                <span><a href="story.php">História</a></span>
            </form>
            <?php
            if ($_GET['false'] == 1) {
                echo 'Utilizador ou Palavra Passe Incorrecto';
            } elseif ($_GET['false'] == 2) {
                echo 'Já existe um Utilizador com o mesmo Username';
            } elseif ($_GET['false'] == 3) {
                echo 'Ocorreu um erro desconhecido';
            } elseif ($_GET['false'] == 4) {
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