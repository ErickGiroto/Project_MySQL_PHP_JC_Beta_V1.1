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
    <link rel="stylesheet" href="css/consulta_produto_tipo.css">
</head>
<body>
    <div class="corpo_body">
        <div class="main-container">
            <h2 class="h2format">Consulta de Produtos por Tipo</h2>
            <table border="1">
                <tr>
                    <th>Código</th>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Tipo de Alimento</th>
                    <th>Ações</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['cod']); ?></td>
                        <td><?= htmlspecialchars($row['produto']); ?></td>
                        <td><?= htmlspecialchars($row['tipo']); ?></td>
                        <td><?= htmlspecialchars($row['tipo_alimento']); ?></td>
                        <td>
                            <a class="link" href="editar_produto_tipo.php?cod=<?= urlencode($row['cod']); ?>">Editar</a> |
                            <a class="link" href="consulta_produto_tipo_processa.php?excluir=<?= urlencode($row['cod']); ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <p class="forgot-password">
                <a class="link" href="/usuario/portal_usuario.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </p>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
