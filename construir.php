<?php
require ("config.php");
session_start();
if (!isset($_SESSION['utilizador_nome'])) {
    die(header('Location: logout.php'));
}

$id = $_POST['id'];
$pos = $_POST['pos'];
if (!(empty($id) || empty($pos))) {
    $cidade = $_SESSION['cidade_id'];
    $tempo_construcao = time() + $_SESSION['edificios_disponiveis'][$id]['tempo_construcao'];
    $tempo_construcao = "00:00:00";

    $sql = "Update edificio_cidade set id_edificio=$id, tempo_construcao_final='$tempo_construcao' where id_cidade=$cidade and pos=$pos";
    $query = mysqli_query($GLOBALS['dbConn'], $sql);

}
?>

