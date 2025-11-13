<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_evento = $_GET['id'] ?? 0;

if($id_evento > 0) {
    // Verificar se o evento pertence ao usuário
    $sql_verifica = "SELECT id_evento FROM evento WHERE id_evento = $id_evento AND id_usuario = $id_usuario";
    $result = mysqli_query($conexao, $sql_verifica);
    
    if(mysqli_num_rows($result) == 1) {
        // Excluir participações primeiro
        $sql_delete_participacoes = "DELETE FROM participacao WHERE id_evento = $id_evento";
        mysqli_query($conexao, $sql_delete_participacoes);
        
        // Excluir evento
        $sql_delete_evento = "DELETE FROM evento WHERE id_evento = $id_evento";
        if(mysqli_query($conexao, $sql_delete_evento)) {
            header('Location: eventos.php?sucesso=3');
            exit();
        }
    }
}

header('Location: eventos.php');
exit();
?>