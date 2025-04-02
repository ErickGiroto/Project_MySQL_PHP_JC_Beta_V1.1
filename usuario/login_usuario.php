<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: portal_usuario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Usuário</title>
    <link rel="stylesheet" href="css/login_usuario.css">
</head>

<body>
   
        <div class="main-container">
            <!-- Formulário de login -->
            <div class="form-container">
                <form action="login_usuario_processa.php" method="POST">
                    <h2 class="login-title">Login de Usuário</h2>
                    <div class="form-row">
                        <div class="input-group">
                            <img src="/midias/image/icon/icone_email.png" alt="Ícone E-mail">
                            <input class="input-field" type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="input-group">
                            <img src="/midias/image/icon/icone_senha.png" alt="Ícone Senha">
                            <input class="input-field" type="password" name="senha" placeholder="Senha" required>
                        </div>
                    </div>
                    <button class="submit-button" type="submit">Entrar</button>
                </form>

                <!-- Links abaixo do formulário -->
                <div class="link-container">
                    <a class="link" href="/index.html">
                        <img src="/midias/image/icon/icone_menu.png" alt="Ícone Home">
                        Home/Início
                    </a>

                    <a class="link" href="recupera_usuario.php">
                        <img src="/midias/image/icon/icone_esqueceu_senha.png" alt="Ícone Esqueceu Senha">
                        Esqueceu sua senha?
                    </a>
                </div>
            </div>
        </div>
   
</body>
</html>