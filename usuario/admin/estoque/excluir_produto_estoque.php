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

// Verifica se o ID foi passado via GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('ID inválido!'); window.location.href='consulta_produto_estoque.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Prepara a exclusão para garantir que apenas um registro seja deletado
$stmt = $conn->prepare("DELETE FROM produto_quantidade WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo "<script>alert('Produto excluído com sucesso!'); window.location.href='consulta_produto_estoque.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir o produto!'); window.location.href='consulta_produto_estoque.php';</script>";
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
