<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Atualiza o status do pedido
    $stmt = $conn->prepare("UPDATE pedidos_comercial SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: consulta_pedido.php");
        exit;
    } else {
        echo "Erro ao atualizar status do pedido.";
    }

    $stmt->close();
    $conn->close();
}
?>
