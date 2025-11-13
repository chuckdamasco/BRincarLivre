<?php
session_start();
include 'conexao.php';

if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $result = mysqli_query($conexao, $sql);

    if(mysqli_num_rows($result) == 1) {
        $usuario = mysqli_fetch_assoc($result);
        
        if(password_verify($senha, $usuario['senha'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            header('Location: dashboard.php');
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Email não cadastrado!";
    }
}

$sucesso = isset($_GET['sucesso']) ? "Cadastro realizado com sucesso! Faça login." : "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/login.css">
    <title>BRincar Livre | Login</title>
</head>
<body>
    <a href="index.php">← Voltar</a>
    
    <div class="main">
        <h1>Login</h1>
        
        <?php if(isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
        <?php if($sucesso) echo "<p style='color: green;'>$sucesso</p>"; ?>
        
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <br><br>
            <input type="password" name="senha" placeholder="Senha" required>
            <br><br>
            <input class="inputSubmit" type="submit" name="submit" value="Entrar">
            <br><br>
            <a href="cadastro.php"><input class="inputSubmit" type="button" value="Criar Cadastro"></a>
        </form>
    </div>
</body>
</html>