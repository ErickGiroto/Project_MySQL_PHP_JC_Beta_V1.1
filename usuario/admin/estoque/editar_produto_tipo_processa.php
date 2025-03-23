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

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod = intval($_POST['cod']);
    $produto = trim($_POST['produto']);
    $tipo = trim($_POST['tipo']);
    $tipo_alimento = trim($_POST['tipo_alimento']);

    // Atualiza os dados no banco
    $stmt = $conn->prepare("UPDATE produto_tipo SET produto = ?, tipo = ?, tipo_alimento = ? WHERE cod = ?");
    $stmt->bind_param("sssi", $produto, $tipo, $tipo_alimento, $cod);

    if ($stmt->execute()) {
        echo "<script>alert('Produto atualizado com sucesso!'); window.location.href='consulta_produto_tipo.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o produto!'); window.location.href='consulta_produto_tipo.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
