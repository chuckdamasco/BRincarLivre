<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Buscar participações do usuário
$sql_participacoes = "SELECT p.*, e.titulo, e.tipo, e.data, e.horario, e.local, e.descricao 
                      FROM participacao p 
                      JOIN evento e ON p.id_evento = e.id_evento 
                      WHERE p.id_usuario = $id_usuario 
                      ORDER BY e.data, e.horario";
$participacoes = mysqli_query($conexao, $sql_participacoes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/lista.css">
    <title>BRincar Livre | Minhas Participações</title>
</head>
<body>
    <div class="cabecalho">
        <h1>Minhas Participações</h1>
        <div class="menu">
            <a href="dashboard.php"><button>Voltar</button></a>
        </div>
    </div>

    <div class="main">
        <h2>Eventos que Estou Participando</h2>
        
        <?php if(mysqli_num_rows($participacoes) > 0): ?>
            <div class="lista-itens">
                <?php while($participacao = mysqli_fetch_assoc($participacoes)): ?>
                    <div class="item-card">
                        <h3><?php echo $participacao['titulo']; ?></h3>
                        <p><strong>Tipo:</strong> <?php echo $participacao['tipo']; ?></p>
                        <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($participacao['data'])); ?></p>
                        <p><strong>Horário:</strong> <?php echo date('H:i', strtotime($participacao['horario'])); ?></p>
                        <p><strong>Local:</strong> <?php echo $participacao['local']; ?></p>
                        <p><strong>Status:</strong> 
                            <span style="color: <?php echo $participacao['status'] == 'confirmado' ? 'green' : 'orange'; ?>">
                                <?php echo ucfirst($participacao['status']); ?>
                            </span>
                        </p>
                        <p><?php echo $participacao['descricao']; ?></p>
                        
                        <div class="acoes">
                            <?php if($participacao['status'] == 'pendente'): ?>
                                <a href="confirmar_participacao.php?id=<?php echo $participacao['id_participacao']; ?>">
                                    <button>Confirmar Presença</button>
                                </a>
                            <?php endif; ?>
                            <a href="cancelar_participacao.php?id=<?php echo $participacao['id_participacao']; ?>" 
                               onclick="return confirm('Tem certeza que deseja cancelar sua participação?')">
                                <button class="excluir">Cancelar</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Você ainda não está participando de nenhum evento.</p>
            <a href="eventos.php"><button>Explorar Eventos</button></a>
        <?php endif; ?>
    </div>
</body>
</html>