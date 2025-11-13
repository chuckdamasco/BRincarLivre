<?php
session_start();
include 'conexao.php';

if(!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Buscar dados do usuário
$sql = "SELECT * FROM usuario WHERE id_usuario = $id_usuario";
$result = mysqli_query($conexao, $sql);
$usuario = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);
    $geolocalizacaoAtiva = isset($_POST['geolocalizacaoAtiva']) ? 1 : 0;
    
    // Se senha foi preenchida, atualizar
    if(!empty($_POST['senha'])) {
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql_update = "UPDATE usuario SET nome = '$nome', email = '$email', senha = '$senha', 
                      endereco = '$endereco', geolocalizacaoAtiva = $geolocalizacaoAtiva 
                      WHERE id_usuario = $id_usuario";
    } else {
        $sql_update = "UPDATE usuario SET nome = '$nome', email = '$email', 
                      endereco = '$endereco', geolocalizacaoAtiva = $geolocalizacaoAtiva 
                      WHERE id_usuario = $id_usuario";
    }
    
    if(mysqli_query($conexao, $sql_update)) {
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        $sucesso = "Perfil atualizado com sucesso!";
    } else {
        $erro = "Erro ao atualizar perfil: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/formulario.css">
    <title>BRincar Livre | Meu Perfil</title>
</head>
<body>
    <a href="dashboard.php">← Voltar</a>
    
    <div class="box">
        <form action="meu_perfil.php" method="POST">
            <fieldset>
                <legend><b>Meu Perfil</b></legend>
                
                <?php if(isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
                <?php if(isset($sucesso)) echo "<p style='color: green;'>$sucesso</p>"; ?>
                
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required 
                           value="<?php echo $usuario['nome']; ?>">
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required 
                           value="<?php echo $usuario['email']; ?>">
                    <label for="email" class="labelInput">Email</label>
                </div>
                
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser">
                    <label for="senha" class="labelInput">Nova Senha (deixe em branco para manter a atual)</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required 
                           value="<?php echo $usuario['endereco']; ?>">
                    <label for="endereco" class="labelInput">Endereço Completo</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" value="<?php echo $usuario['cpf']; ?>" class="inputUser" disabled>
                    <label class="labelInput">CPF (não pode ser alterado)</label>
                </div>
                
                <div class="inputBox">
                    <input type="text" value="<?php echo $usuario['rg']; ?>" class="inputUser" disabled>
                    <label class="labelInput">RG (não pode ser alterado)</label>
                </div>
                
                <div class="inputBox">
                    <input type="checkbox" name="geolocalizacaoAtiva" id="geolocalizacaoAtiva" 
                           <?php echo $usuario['geolocalizacaoAtiva'] ? 'checked' : ''; ?>>
                    <label for="geolocalizacaoAtiva">Permitir geolocalização para encontrar famílias próximas</label>
                </div>
                
                <input type="submit" class="inputsub" name="submit" id="submit" value="Atualizar Perfil">
            </fieldset>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="excluir_perfil.php" onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')">
                <button style="background-color: #ff4444; color: white;">Excluir Minha Conta</button>
            </a>
        </div>
    </div>
</body>
</html>