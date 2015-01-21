<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Novo Utilizador</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <div>
            <form action="registarutilizador.php" method="POST">
                <div>Username:<input type="text" name="username" value="" /></div>
                <div>Password:<input type="password" name="password" value="" /></div>
                <div>Email:<input type="text" name="email" value="" /></div>
                <div><input type="submit" value="Registar" name="submit"/></div>
            </form>
        </div>
        <?php
                if ($_GET['false'] == 1) {
                    echo 'Email ou Username já registado!';
                }
                ?>
        <div>

        </div>
    </body>
</html>
