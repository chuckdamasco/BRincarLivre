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
    // Verificar se já está participando
    $sql_verifica = "SELECT id_participacao FROM participacao WHERE id_usuario = $id_usuario AND id_evento = $id_evento";
    $result = mysqli_query($conexao, $sql_verifica);
    
    if(mysqli_num_rows($result) == 0) {
        // Inserir participação
        $sql_inserir = "INSERT INTO participacao (id_usuario, id_evento, recebe_aviso, status) 
                        VALUES ($id_usuario, $id_evento, 1, 'pendente')";
        
        if(mysqli_query($conexao, $sql_inserir)) {
            header('Location: minhas_participacoes.php?sucesso=1');
            exit();
        }
    } else {
        header('Location: eventos.php?erro=1');
        exit();
    }
}

header('Location: eventos.php');
exit();
?>