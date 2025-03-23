<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta os dados da tabela produto_tipo
$sql = "SELECT cod, produto, tipo, tipo_alimento FROM produto_tipo";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Produto Tipo</title>
    <link rel="stylesheet" href="/usuario/admin/css/estoque/consulta_produto_tipo.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2 class="h2format">Consulta de Produtos por Tipo</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Tipo de Alimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['cod']); ?></td>
                            <td><?= htmlspecialchars($row['produto']); ?></td>
                            <td><?= htmlspecialchars($row['tipo']); ?></td>
                            <td><?= htmlspecialchars($row['tipo_alimento']); ?></td>
                            <td>
                                <a class="edit-link" href="editar_produto_tipo.php?cod=<?= urlencode($row['cod']); ?>">Editar</a>
                                <a class="delete-link" href="consulta_produto_tipo_processa.php?excluir=<?= urlencode($row['cod']); ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="button-container">
        <button class="button" onclick="window.location.href='/usuario/admin/estoque/menu_estoque.php'">
            <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
        </button>
    </div>
</body>
</html>

<?php
$conn->close();
?>
