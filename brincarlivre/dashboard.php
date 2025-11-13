<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/dashboard.css">
    <title>BRincar Livre | Dashboard</title>
</head>
<body>
    <div class="cabecalho">
        <h1>BRincar Livre</h1>
        <p>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</p>
        <div class="menu">
            <a href="dashboard.php"><button class="BtTroca">Início</button></a>
            <a href="meu_perfil.php"><button class="BtTroca">Meu Perfil</button></a>
            <a href="eventos.php"><button class="BtTroca">Eventos</button></a>
            <a href="localizar_usuarios.php"><button class="BtTroca">Famílias Próximas</button></a>
            <a href="minhas_participacoes.php"><button class="BtTroca">Minhas Participações</button></a>
            <a href="logout.php"><button class="BtTroca">Sair</button></a>
        </div>
    </div>

    <div class="main">
        <h2>Funcionalidades Principais</h2>
        
        <div class="funcionalidades">
            <div class="card-funcionalidade">
                <h3>📅 Criar Eventos</h3>
                <p>Organize encontros presenciais para brincadeiras em grupo</p>
                <a href="criar_evento.php"><button>Criar Evento</button></a>
            </div>
            
            <div class="card-funcionalidade">
                <h3>👨‍👩‍👧‍👦 Encontrar Famílias</h3>
                <p>Conecte-se com outras famílias em um raio de 3km</p>
                <a href="localizar_usuarios.php"><button>Buscar Famílias</button></a>
            </div>
            
            <div class="card-funcionalidade">
                <h3>📍 Eventos Próximos</h3>
                <p>Descubra brincadeiras e encontros na sua região</p>
                <a href="eventos.php"><button>Ver Eventos</button></a>
            </div>
            
            <div class="card-funcionalidade">
                <h3>👤 Meu Perfil</h3>
                <p>Gerencie suas informações e configurações</p>
                <a href="meu_perfil.php"><button>Editar Perfil</button></a>
            </div>
        </div>
    </div>
</body>
</html>