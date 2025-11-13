<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Excluir participações do usuário
$sql_participacoes = "DELETE FROM participacao WHERE id_usuario = $id_usuario";
mysqli_query($conexao, $sql_participacoes);

// Excluir eventos do usuário (e suas participações)
$sql_eventos = "SELECT id_evento FROM evento WHERE id_usuario = $id_usuario";
$result = mysqli_query($conexao, $sql_eventos);
while($evento = mysqli_fetch_assoc($result)) {
    $sql_delete_participacoes_evento = "DELETE FROM participacao WHERE id_evento = " . $evento['id_evento'];
    mysqli_query($conexao, $sql_delete_participacoes_evento);
}

$sql_delete_eventos = "DELETE FROM evento WHERE id_usuario = $id_usuario";
mysqli_query($conexao, $sql_delete_eventos);

// Excluir usuário
$sql_delete_usuario = "DELETE FROM usuario WHERE id_usuario = $id_usuario";
mysqli_query($conexao, $sql_delete_usuario);

session_destroy();
header('Location: index.php?conta_excluida=1');
exit();
?>