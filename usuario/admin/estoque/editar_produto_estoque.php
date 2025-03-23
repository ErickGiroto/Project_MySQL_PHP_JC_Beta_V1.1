<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se um ID foi passado na URL
if (!isset($_GET['id'])) {
    die("ID do produto não especificado.");
}

$id = intval($_GET['id']);

// Busca os dados do produto no banco de dados
$stmt = $conn->prepare("SELECT cod, produto, tipo, tipo_alimento, qtd FROM produto_quantidade WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produto não encontrado.");
}

$produto = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="/usuario/admin/css/estoque/editar_produto_estoque.css">
</head>
<body>
    <div class="corpo_body">
        <div class="main-container">
            <h2 class="h2format">Editar Produto</h2>
            <form action="editar_produto_estoque_processa.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">

                <div class="form-row">
                    <label>Produto:</label>
                    <input class="input-field" type="text" name="produto" value="<?= htmlspecialchars($produto['produto']); ?>" required>
                </div>

                <div class="form-row">
                    <label>Tipo:</label>
                    <input class="input-field" type="text" name="tipo" value="<?= htmlspecialchars($produto['tipo']); ?>" required>
                </div>

                <div class="form-row">
                    <label>Tipo Alimento:</label>
                    <input class="input-field" type="text" name="tipo_alimento" value="<?= htmlspecialchars($produto['tipo_alimento']); ?>" required>
                </div>

                <div class="form-row">
                    <label>Quantidade:</label>
                    <input class="input-field" type="number" name="qtd" value="<?= htmlspecialchars($produto['qtd']); ?>" required>
                </div>

                <button class="submit-button" type="submit">Salvar Alterações</button>
            </form>

            <a class="link" href="/usuario/admin/estoque/consulta_produto_estoque.php">
                <img src="/midias/image/icon/icone_voltar.png" alt='Voltar'>
                Voltar</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>