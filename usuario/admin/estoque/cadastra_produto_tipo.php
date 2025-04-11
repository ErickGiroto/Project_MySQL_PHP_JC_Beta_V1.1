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
    <link rel="stylesheet" href="/usuario/admin/css/estoque/cadastra_produto_tipo.css">
</head>

<body>
    <div class="main-container">
        <div class="form-container">
            <h2>Cadastrar Tipo de Produto</h2>
            <form action="cadastra_produto_processa_tipo.php" method="POST">
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

                <div class="button-container">
                    <button class="submit-button" type="submit">Cadastrar</button>
                    <a class="link" href="/usuario/admin/estoque/menu_estoque.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>