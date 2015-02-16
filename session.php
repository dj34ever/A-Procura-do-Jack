<?php
if(session_status()!==PHP_SESSION_ACTIVE)
{
    session_start();   
}

if (!isset($_SESSION['utilizador_nome'])) {
        die(header('Location: logout.php'));
}

?>
