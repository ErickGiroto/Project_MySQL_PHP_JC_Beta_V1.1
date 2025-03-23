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

// Excluir registro
if (isset($_GET['excluir'])) {
    $cod = intval($_GET['excluir']);

    $stmt = $conn->prepare("DELETE FROM produto_tipo WHERE cod = ?");
    $stmt->bind_param("i", $cod);

    if ($stmt->execute()) {
        echo "<script>alert('Registro excluído com sucesso!'); window.location.href='consulta_produto_tipo.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir registro!'); window.location.href='consulta_produto_tipo.php';</script>";
    }
    $stmt->close();
}

$conn->close();
?>
