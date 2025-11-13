<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Buscar usuários com geolocalização ativa (simulação - em produção usar coordenadas reais)
$sql_usuarios = "SELECT nome, email, endereco 
                 FROM usuario 
                 WHERE geolocalizacaoAtiva = 1 
                 AND id_usuario != $id_usuario 
                 LIMIT 20";
$usuarios = mysqli_query($conexao, $sql_usuarios);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/lista.css">
    <title>BRincar Livre | Famílias Próximas</title>
</head>
<body>
    <div class="cabecalho">
        <h1>Famílias Próximas</h1>
        <div class="menu">
            <a href="dashboard.php"><button>Voltar</button></a>
        </div>
    </div>

    <div class="main">
        <h2>Famílias Cadastradas no Sistema</h2>
        <p>Conecte-se com outras famílias interessadas em brincadeiras presenciais</p>
        
        <?php if(mysqli_num_rows($usuarios) > 0): ?>
            <div class="lista-itens">
                <?php while($usuario = mysqli_fetch_assoc($usuarios)): ?>
                    <div class="item-card">
                        <h3><?php echo $usuario['nome']; ?></h3>
                        <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
                        <p><strong>Localização aproximada:</strong> <?php echo $usuario['endereco']; ?></p>
                        <p><em>Disponível para conexões e eventos</em></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Nenhuma família próxima encontrada no momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>