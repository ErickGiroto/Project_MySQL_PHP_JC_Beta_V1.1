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

$id = $_GET['id'];
$sql = "SELECT * FROM empresa_cliente WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    echo "Cliente não encontrado!";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/editar_cliente.css">
</head>
<body>
    <div class="main-container">
        <h2>Editar Cliente</h2>
        <form action="editar_cliente_processa.php" method="POST">
            <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

            <label>Telefone:</label>
            <input type="text" name="telefone1" value="<?= htmlspecialchars($cliente['telefone1']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

            <label>Departamento:</label>
            <input type="text" name="departamento" value="<?= htmlspecialchars($cliente['departamento']) ?>" required>

            <button type="submit">Salvar Alterações</button>

            <div class="button-container">
            <a class="button" href="/usuario/admin/comercial/consulta_cliente.php">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
            </a>
        </div>
        </form>
    </div>
</body>
</html>
