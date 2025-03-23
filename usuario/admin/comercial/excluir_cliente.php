<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM empresa_cliente WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: consulta_cliente.php");
        exit;
    } else {
        echo "Erro ao excluir cliente.";
    }

    $stmt->close();
    $conn->close();
}
?>
