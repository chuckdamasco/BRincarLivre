<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

if(isset($_POST['submit'])) {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $tipo = mysqli_real_escape_string($conexao, $_POST['tipo']);
    $data = mysqli_real_escape_string($conexao, $_POST['data']);
    $horario = mysqli_real_escape_string($conexao, $_POST['horario']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $local = mysqli_real_escape_string($conexao, $_POST['local']);
    
    // Validar limite de caracteres
    if(strlen($descricao) > 300) {
        $erro = "A descrição deve ter no máximo 300 caracteres.";
    } else {
        $sql = "INSERT INTO evento (titulo, tipo, data, horario, descricao, local, id_usuario) 
                VALUES ('$titulo', '$tipo', '$data', '$horario', '$descricao', '$local', $id_usuario)";
        
        if(mysqli_query($conexao, $sql)) {
            header('Location: eventos.php?sucesso=1');
            exit();
        } else {
            $erro = "Erro ao criar evento: " . mysqli_error($conexao);
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
    <title>BRincar Livre | Criar Evento</title>
</head>
<body>
    <a href="eventos.php">← Voltar</a>
    
    <div class="box">
        <form action="criar_evento.php" method="POST">
            <fieldset>
                <legend><b>Criar Novo Evento</b></legend>
                
                <?php if(isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
                
                <div class="inputBox">
                    <input type="text" name="titulo" id="titulo" class="inputUser" required maxlength="200">
                    <label for="titulo" class="labelInput">Título do Evento</label>
                </div>
                
                <div class="inputBox">
                    <select name="tipo" id="tipo" class="inputUser" required>
                        <option value="">Selecione o tipo</option>
                        <option value="Brincar na Praça">Brincar na Praça</option>
                        <option value="Piquenique">Piquenique</option>
                        <option value="Festa">Festa</option>
                        <option value="Grupo de Estudos">Grupo de Estudos</option>
                        <option value="Troca de Brinquedos">Troca de Brinquedos</option>
                        <option value="Esportivo">Esportivo</option>
                        <option value="Cultural">Cultural</option>
                    </select>
                    <label for="tipo" class="labelInput">Tipo de Evento</label>
                </div>
                
                <div class="inputBox">
                    <input type="date" name="data" id="data" class="inputUser" required min="<?php echo date('Y-m-d'); ?>">
                    <label for="data" class="labelInput">Data</label>
                </div>
                
                <div class="inputBox">
                    <input type="time" name="horario" id="horario" class="inputUser" required>
                    <label for="horario" class="labelInput">Horário</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" name="local" id="local" class="inputUser" required maxlength="150">
                    <label for="local" class="labelInput">Local</label>
                </div>
                
                <div class="inputBox">
                    <textarea name="descricao" id="descricao" class="inputUser" required maxlength="300" 
                              placeholder="Descreva o evento (máximo 300 caracteres)"></textarea>
                    <label for="descricao" class="labelInput">Descrição</label>
                    <div id="contador">0/300 caracteres</div>
                </div>
                
                <input type="submit" class="inputsub" name="submit" id="submit" value="Criar Evento">
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