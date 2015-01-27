<?php //session_start();

$totalQuest = 0;
?>

<!DOCTYPE html>
<!--
Interface para admin
Implementar:
    Restrigir acesso a contas tipo 1 (admin)
    Adicionar elementos à base de dados sem imagens
    Adicionar elementos à base de dados com imagens
    Vizulaizar base de dados
    Acesso a tabelas de apoio à base de dados
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
                    <?php echo 'Nº total de Missões' . $totalQuest . '\n' ?>
                    <label for="areas">Area:</label>
                    <select id="areas">
                        <option value="1">Bellbroke Fort</option>
                        <option value="2">Forest Citadel</option>
                        <option value="3">Sky Scratch</option>
                        <option value="4">Lost City</option>
                        <option value="5">Undefined</option>
                    </select>
                    <label for="nome">Nome da Quest:</label>
                    <input type="text" id="nome" name="Nome da Missão" value="" />
                    <label for="descricao">Nome:</label>
                    <input type="text" id="descricao" name="descrição" value="" />
                    <label for="vida">Consumo de Vida:</label>
                    <input type="text" id="vida" name="Vida" value="" />
                    <label for="energia">Consumo de Energia:</label>
                    <input type="text" id="energia" name="Energia" value="" />
                    <label for="tempo">Duração da Missão:</label>
                    <input type="text" id="tempo" name="Tempo" value="" />
                    <label for="exp">Recompensa Experiencia:</label>
                    <input type="text" id="exp" name="Experiencia" value="" />
                    <label for="moedas">Recompensa Moedas:</label>
                    <input type="text" id="moedas" name="Moedas" value="" />
                    <label for="gold">Comsumo Ouro:</label>
                    <input type="text" id="gold" name="Ouro" value="" />
                    
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
