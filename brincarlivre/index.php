<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/home.css">
    <title>BRincar Livre | Conectando Famílias</title>
</head>
<body>
    <div class="page">
        <header>
            <h1>BRincar Livre</h1>
            <p>Conectando famílias para uma infância com menos telas e mais brincadeiras!</p>
        </header>

        <main>
            <div class="card-container">
                <div class="card" id="cadastro">
                    <a href="cadastro.php">
                        <img src="./image/criar_perfil.png" alt="Ícone de criação de perfil">
                        <h2><span></span>Criar Perfil</h2>
                    </a>
                </div>   

                <div class="card" id="login">
                    <a href="login.php">
                        <img src="./image/acessar_perfil.png" alt="Ícone de acesso ao perfil">
                        <h2><span></span>Acessar Perfil</h2>
                    </a>
                </div> 

                <div class="card" id="sobre">
                    <a href="sobre.php">
                        <img src="./image/sobre_projeto.png" alt="Ícone sobre o projeto">
                        <h2><span></span>Sobre o Projeto</h2>
                    </a>
                </div> 

                <div class="card" id="eventos">
                    <a href="eventos_publicos.php">
                        <img src="./image/eventos.png" alt="Ícone de eventos">
                        <h2><span></span>Eventos Públicos</h2>
                    </a>
                </div>
            </div>
        </main>

        <footer>
            <p>Projeto desenvolvido para promover o brincar livre e a socialização entre famílias</p>
        </footer>
    </div>
</body>
</html>