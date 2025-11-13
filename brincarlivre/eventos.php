<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Buscar eventos do usuário
$sql_meus_eventos = "SELECT * FROM evento WHERE id_usuario = $id_usuario ORDER BY data, horario";
$meus_eventos = mysqli_query($conexao, $sql_meus_eventos);

// Buscar eventos próximos
$sql_eventos_proximos = "SELECT e.*, u.nome as criador 
                         FROM evento e 
                         JOIN usuario u ON e.id_usuario = u.id_usuario 
                         WHERE e.data >= CURDATE() 
                         ORDER BY e.data, e.horario 
                         LIMIT 10";
$eventos_proximos = mysqli_query($conexao, $sql_eventos_proximos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/eventos.css">
    <title>BRincar Livre | Eventos</title>
</head>
<body>
    <div class="cabecalho">
        <h1>Eventos BRincar Livre</h1>
        <div class="menu">
            <a href="dashboard.php"><button>Voltar</button></a>
            <a href="criar_evento.php"><button>+ Novo Evento</button></a>
        </div>
    </div>

    <div class="main">
        <div class="section">
            <h2>Meus Eventos</h2>
            <?php if(mysqli_num_rows($meus_eventos) > 0): ?>
                <div class="lista-eventos">
                    <?php while($evento = mysqli_fetch_assoc($meus_eventos)): ?>
                        <div class="evento-card">
                            <h3><?php echo $evento['titulo']; ?></h3>
                            <p><strong>Tipo:</strong> <?php echo $evento['tipo']; ?></p>
                            <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento['data'])); ?></p>
                            <p><strong>Horário:</strong> <?php echo date('H:i', strtotime($evento['horario'])); ?></p>
                            <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
                            <p><?php echo $evento['descricao']; ?></p>
                            <div class="acoes">
                                <a href="editar_evento.php?id=<?php echo $evento['id_evento']; ?>"><button>Editar</button></a>
                                <a href="excluir_evento.php?id=<?php echo $evento['id_evento']; ?>" 
                                   onclick="return confirm('Tem certeza que deseja excluir este evento?')">
                                    <button class="excluir">Excluir</button>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Você ainda não criou nenhum evento.</p>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>Eventos Próximos</h2>
            <?php if(mysqli_num_rows($eventos_proximos) > 0): ?>
                <div class="lista-eventos">
                    <?php while($evento = mysqli_fetch_assoc($eventos_proximos)): ?>
                        <div class="evento-card">
                            <h3><?php echo $evento['titulo']; ?></h3>
                            <p><strong>Criado por:</strong> <?php echo $evento['criador']; ?></p>
                            <p><strong>Tipo:</strong> <?php echo $evento['tipo']; ?></p>
                            <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento['data'])); ?></p>
                            <p><strong>Horário:</strong> <?php echo date('H:i', strtotime($evento['horario'])); ?></p>
                            <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
                            <p><?php echo $evento['descricao']; ?></p>
                            <a href="participar_evento.php?id=<?php echo $evento['id_evento']; ?>">
                                <button>Participar</button>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Nenhum evento próximo encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>