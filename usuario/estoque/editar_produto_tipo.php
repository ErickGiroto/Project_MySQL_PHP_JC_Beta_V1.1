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

// Verifica se um código foi passado na URL
if (!isset($_GET['cod'])) {
    die("Código do produto não especificado.");
}

$cod = intval($_GET['cod']);

// Busca os dados do produto no banco de dados
$stmt = $conn->prepare("SELECT produto, tipo, tipo_alimento FROM produto_tipo WHERE cod = ?");
$stmt->bind_param("i", $cod);
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
    <link rel="stylesheet" href="css/consulta_produto_tipo.css">
</head>
<body>
    <div class="corpo_body">
        <div class="main-container">
            <h2 class="h2format">Editar Produto</h2>
            <form action="editar_produto_tipo_processa.php" method="POST">
                <input type="hidden" name="cod" value="<?= htmlspecialchars($cod); ?>">

                <div class="form-row">
                    <input class="input-field" type="text" name="produto" value="<?= htmlspecialchars($produto['produto']); ?>" required>
                </div>

                <div class="form-row">
                    <input class="input-field" type="text" name="tipo" value="<?= htmlspecialchars($produto['tipo']); ?>" required>
                </div>

                <div class="form-row">
                    <input class="input-field" type="text" name="tipo_alimento" value="<?= htmlspecialchars($produto['tipo_alimento']); ?>" required>
                </div>

                <button class="submit-button" type="submit">Salvar Alterações</button>
            </form>

            <p class="forgot-password">
                <a class="link" href="consulta_produto_tipo.php">
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
