<?php
include 'conexao.php';

if(isset($_POST['submit'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $cpf = mysqli_real_escape_string($conexao, $_POST['cpf']);
    $rg = mysqli_real_escape_string($conexao, $_POST['rg']);
    $geolocalizacaoAtiva = isset($_POST['geolocalizacaoAtiva']) ? 1 : 0;

    // Verificar se email já existe
    $verifica_email = "SELECT id_usuario FROM usuario WHERE email = '$email'";
    $result = mysqli_query($conexao, $verifica_email);
    
    if(mysqli_num_rows($result) > 0) {
        $erro = "Email já cadastrado!";
    } else {
        $sql = "INSERT INTO usuario (nome, email, senha, endereco, cpf, rg, geolocalizacaoAtiva) 
                VALUES ('$nome', '$email', '$senha', '$endereco', '$cpf', '$rg', '$geolocalizacaoAtiva')";
        
        if(mysqli_query($conexao, $sql)) {
            header('Location: login.php?sucesso=1');
            exit();
        } else {
            $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
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
    <title>BRincar Livre | Cadastro</title>
</head>
<body>
    <a href="index.php">← Voltar</a>
    
    <div class="box">
        <form action="cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastro no BRincar Livre</b></legend>
                
                <?php if(isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
                
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço Completo</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" required maxlength="11">
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" name="rg" id="rg" class="inputUser" required maxlength="10">
                    <label for="rg" class="labelInput">RG</label>
                </div>
                
                <div class="inputBox">
                    <input type="checkbox" name="geolocalizacaoAtiva" id="geolocalizacaoAtiva" checked>
                    <label for="geolocalizacaoAtiva">Permitir geolocalização para encontrar famílias próximas</label>
                </div>
                
                <input type="submit" class="inputsub" name="submit" id="submit" value="Cadastrar">
            </fieldset>
        </form>
    </div>
</body>
</html>