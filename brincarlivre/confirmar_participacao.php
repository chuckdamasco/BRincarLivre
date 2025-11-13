<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_participacao = $_GET['id'] ?? 0;

if($id_participacao > 0) {
    $sql = "UPDATE participacao SET status = 'confirmado' WHERE id_participacao = $id_participacao";
    mysqli_query($conexao, $sql);
}

header('Location: minhas_participacoes.php');
exit();
?>