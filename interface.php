<?php session_start() ?>

<!DOCTYPE html>
<!--
Interface para admin
Implementar:
    Restrigir acesso sem conta tipo 1 (admin)
    Adicionar elementos à base de dados sem imagens
    Adicionar elementos à base de dados com imagens
    Vizulaizar base de dados
-->
<html>
    <head>
        <title>Interface Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <div>
            <label></label>
            <form action="registarutilizador.php" method="POST">
                <div>
                    <label for="area">Area<label>
                    <select id="area">
                        <?php ?>
                    </select>
                    <label for=""></label>
                    <input type="text" id="" name="" value="" />
                    <label></label>
                    <input type="text" name="" value="" />
                    <label></label>
                    <input type="text" name="" value="" />
                    <label></label>
                    <input type="text" name="" value="" />
                    <label></label>
                    <input type="text" name="" value="" />
                    <label></label>
                    <input type="text" name="" value="" />
                    <label></label>
                    <input type="text" name="" value="" />
                    
                </div>
                
                <div>Username:<input type="text" name="username" value="" /></div>
                <div>Password:<input type="password" name="password" value="" /></div>
                <div>Email:<input type="text" name="email" value="" /></div>
                <div><input type="submit" value="Registar" name="submit"/></div>
            </form>
        </div>
        <?php
            switch($_GET['false']){
                case 1 :{echo 'Email ou Username já se encontra registado!';} break;
                case 2 :{echo '';} break;
                case 3 :{echo '';} break;
                case 4 :{echo '';} break;
                default:{echo 'Necessita preencher todos os campos!';}
            }
//                if ($_GET['false'] == 1) {
//                    echo 'Email ou Username já registado!';
//                }
                ?>
        <div>

        </div>
    </body>
</html>
