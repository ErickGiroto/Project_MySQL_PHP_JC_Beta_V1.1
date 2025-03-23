<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Tipo de Produto</title>
    <link rel="stylesheet" href="css/cadastra_produto_tipo.css">
</head>

<body>
    <div class="main-container">

        <!-- Links à direita do formulário -->
        <div class="link-container">
            <p class="forgot-password">
                <a class="link" href="/usuario/portal_usuario.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </p>

            <p class="forgot-password">
                <a class="link" href="/usuario/logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </p>
        </div>

        <!-- Formulário de Cadastro de Tipo de Produto -->
        <div class="form-container">
            <form action="cadastra_produto_processa_tipo.php" method="POST">
                <h2>Cadastrar Tipo de Produto</h2>

                <div class="form-row">
                    <input class="input-field" type="text" name="codigo" placeholder="Código do Produto" required>
                </div>

                <div class="form-row">
                    <input class="input-field" type="text" name="produto" placeholder="Nome do Produto" required>
                </div>

                <div class="form-row">
                    <input class="input-field" type="text" name="tipo" placeholder="Tipo do Produto" required>
                </div>

                <div class="form-row">
                    <input class="input-field" type="text" name="tipo_alimento" placeholder="Tipo de Alimento" required>
                </div>

                <button class="submit-button" type="submit">Cadastrar</button>
            </form>
        </div>
    </div>
</body>

</html>
