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

    // Preparando o comando para excluir a linha com o id fornecido
    $stmt = $conn->prepare("DELETE FROM pedidos_comercial WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: consulta_pedido.php");
        exit;
    } else {
        echo "Erro ao excluir o pedido.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID não fornecido.";
}
?>
