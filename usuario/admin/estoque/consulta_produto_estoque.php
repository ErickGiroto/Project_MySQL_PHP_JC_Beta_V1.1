<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Estoque</title>
    <link rel="stylesheet" href="/usuario/admin/css/estoque/consulta_produto_estoque.css">
</head>
<body>
    <div class="corpo_body">
        <div class="main-container">
            <div class="table-container">
                <h2 class="titulo">Consulta de Estoque</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Tipo</th>
                            <th>Tipo Alimento</th>
                            <th>Quantidade</th>
                            <th>Data Registro</th>
                            <th>Usuário Registro</th>
                            <th>Nome Usuário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'consulta_produto_estoque_processa.php'; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botão de Voltar -->
            <div class="button-container">
                <a class="button" href="/usuario/admin/estoque/menu_estoque.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </div>
        </div>
    </div>
</body>
</html>