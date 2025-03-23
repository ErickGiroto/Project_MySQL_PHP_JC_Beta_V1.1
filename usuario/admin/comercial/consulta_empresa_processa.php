<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Exclui a empresa
    $stmt = $conn->prepare("DELETE FROM empresas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: consulta_empresa.php?sucesso=1");
    } else {
        header("Location: consulta_empresa.php?erro=1");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: consulta_empresa.php");
}
?>