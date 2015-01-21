<?php

            function getuservalues() {
            $sql = "SELECT moedas, ouro, ativa FROM utilizador where username='" . $_SESSION['user'] . "'";
            $query = mysqli_query($GLOBALS['dbConn'], $sql);
            $result = mysqli_fetch_assoc($query);
            $_SESSION['moedas'] = $result['moedas'];
            $_SESSION['ouro'] = $result['ouro'];
            $_SESSION['ativo'] = $result['ativa'];
            mysqli_close($GLOBALS['dbConn']);
        }

?>