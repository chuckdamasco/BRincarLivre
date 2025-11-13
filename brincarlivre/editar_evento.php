<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_evento = $_GET['id'] ?? 0;

// Buscar evento
$sql = "SELECT * FROM evento WHERE id_evento = $id_evento AND id_usuario = $id_usuario";
$result = mysqli_query($conexao, $sql);
$evento = mysqli_fetch_assoc($result);

if(!$evento) {
    header('Location: eventos.php');
    exit();
}

if(isset($_POST['submit'])) {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
    $data = mysqli_real_escape_string($conexao, $_POST['data']);
    $horario = mysqli_real_escape_string($conexao, $_POST['horario']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $local = mysqli_real_escape_string($conexao, $_POST['local']);
    
    if(strlen($descricao) > 300) {
        $erro = "A descrição deve ter no máximo 300 caracteres.";
    } else {
        $sql_update = "UPDATE evento SET titulo = '$titulo', tipo = '$tipo', data = '$data', 
                      horario = '$horario', descricao = '$descricao', local = '$local' 
                      WHERE id_evento = $id_evento AND id_usuario = $id_usuario";
        
        if(mysqli_query($conexao, $sql_update)) {
            header('Location: eventos.php?sucesso=2');
            exit();
        } else {
            $erro = "Erro ao atualizar evento: " . mysqli_error($conexao);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/formulario.css">
    <title>BRincar Livre | Editar Evento</title>
</head>
<body>
    <a href="eventos.php">← Voltar</a>
    
    <div class="box">
        <form action="editar_evento.php?id=<?php echo $id_evento; ?>" method="POST">
            <fieldset>
                <legend><b>Editar Evento</b></legend>
                
                <?php if(isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
                
                <div class="inputBox">
                    <input type="text" name="titulo" id="titulo" class="inputUser" required 
                           maxlength="200" value="<?php echo $evento['titulo']; ?>">
                    <label for="titulo" class="labelInput">Título do Evento</label>
                </div>
                
                <div class="inputBox">
                    <select name="tipo" id="tipo" class="inputUser" required>
                        <option value="Brincar na Praça" <?php echo $evento['tipo'] == 'Brincar na Praça' ? 'selected' : ''; ?>>Brincar na Praça</option>
                        <option value="Piquenique" <?php echo $evento['tipo'] == 'Piquenique' ? 'selected' : ''; ?>>Piquenique</option>
                        <option value="Festa" <?php echo $evento['tipo'] == 'Festa' ? 'selected' : ''; ?>>Festa</option>
                        <option value="Grupo de Estudos" <?php echo $evento['tipo'] == 'Grupo de Estudos' ? 'selected' : ''; ?>>Grupo de Estudos</option>
                        <option value="Troca de Brinquedos" <?php echo $evento['tipo'] == 'Troca de Brinquedos' ? 'selected' : ''; ?>>Troca de Brinquedos</option>
                        <option value="Esportivo" <?php echo $evento['tipo'] == 'Esportivo' ? 'selected' : ''; ?>>Esportivo</option>
                        <option value="Cultural" <?php echo $evento['tipo'] == 'Cultural' ? 'selected' : ''; ?>>Cultural</option>
                    </select>
                    <label for="tipo" class="labelInput">Tipo de Evento</label>
                </div>
                
                <div class="inputBox">
                    <input type="date" name="data" id="data" class="inputUser" required 
                           value="<?php echo $evento['data']; ?>">
                    <label for="data" class="labelInput">Data</label>
                </div>
                
                <div class="inputBox">
                    <input type="time" name="horario" id="horario" class="inputUser" required 
                           value="<?php echo $evento['horario']; ?>">
                    <label for="horario" class="labelInput">Horário</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" name="local" id="local" class="inputUser" required 
                           maxlength="150" value="<?php echo $evento['local']; ?>">
                    <label for="local" class="labelInput">Local</label>
                </div>
                
                <div class="inputBox">
                    <textarea name="descricao" id="descricao" class="inputUser" required maxlength="300"><?php echo $evento['descricao']; ?></textarea>
                    <label for="descricao" class="labelInput">Descrição</label>
                    <div id="contador"><?php echo strlen($evento['descricao']); ?>/300 caracteres</div>
                </div>
                
                <input type="submit" class="inputsub" name="submit" id="submit" value="Atualizar Evento">
            </fieldset>
        </form>
    </div>

    <script>
        document.getElementById('descricao').addEventListener('input', function() {
            const contador = document.getElementById('contador');
            const caracteres = this.value.length;
            contador.textContent = caracteres + '/300 caracteres';
            
            if(caracteres > 300) {
                contador.style.color = 'red';
            } else {
                contador.style.color = 'green';
            }
        });
    </script>
</body>
</html>