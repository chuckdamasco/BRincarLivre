<?php
include 'conexao.php';

// Buscar eventos públicos (futuros)
$sql_eventos = "SELECT e.*, u.nome as criador 
                FROM evento e 
                JOIN usuario u ON e.id_usuario = u.id_usuario 
                WHERE e.data >= CURDATE() 
                ORDER BY e.data, e.horario 
                LIMIT 10";
$eventos = mysqli_query($conexao, $sql_eventos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/lista.css">
    <title>BRincar Livre | Eventos Públicos</title>
</head>
<body>
    <div class="cabecalho">
        <h1>Eventos Públicos</h1>
        <div class="menu">
            <a href="index.php"><button>Voltar</button></a>
            <a href="cadastro.php"><button>Cadastrar-se</button></a>
        </div>
    </div>

    <div class="main">
        <h2>Eventos da Comunidade</h2>
        <p>Confira os próximos eventos organizados pela nossa comunidade. Faça login ou cadastre-se para participar!</p>
        
        <?php if(mysqli_num_rows($eventos) > 0): ?>
            <div class="lista-itens">
                <?php while($evento = mysqli_fetch_assoc($eventos)): ?>
                    <div class="item-card">
                        <h3><?php echo $evento['titulo']; ?></h3>
                        <p><strong>Criado por:</strong> <?php echo $evento['criador']; ?></p>
                        <p><strong>Tipo:</strong> <?php echo $evento['tipo']; ?></p>
                        <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($evento['data'])); ?></p>
                        <p><strong>Horário:</strong> <?php echo date('H:i', strtotime($evento['horario'])); ?></p>
                        <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
                        <p><?php echo $evento['descricao']; ?></p>
                        <p><em>Faça login para participar deste evento</em></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Nenhum evento público encontrado no momento.</p>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="cadastro.php"><button style="background: #4a90e2; color: white; padding: 12px 30px; border: none; border-radius: 25px; cursor: pointer;">
                Cadastre-se para Criar e Participar de Eventos
            </button></a>
        </div>
    </div>
</body>
</html>