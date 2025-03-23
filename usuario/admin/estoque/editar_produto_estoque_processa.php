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

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $produto = trim($_POST['produto']);
    $tipo = trim($_POST['tipo']);
    $tipo_alimento = trim($_POST['tipo_alimento']);
    $qtd = intval($_POST['qtd']);

    // Atualiza apenas a linha correspondente ao ID informado
    $stmt = $conn->prepare("UPDATE produto_quantidade SET produto = ?, tipo = ?, tipo_alimento = ?, qtd = ? WHERE id = ?");
    $stmt->bind_param("sssii", $produto, $tipo, $tipo_alimento, $qtd, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Produto atualizado com sucesso!'); window.location.href='consulta_produto_estoque.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o produto!'); window.location.href='consulta_produto_estoque.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
