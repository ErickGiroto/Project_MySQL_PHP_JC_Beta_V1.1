<?php
// consulta_usuario_processa.php

if (isset($_GET['acao']) && $_GET['acao'] === 'deletar' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Deleta o usuário
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: consulta_usuario.php?mensagem=Usuário deletado com sucesso.");
    } else {
        header("Location: consulta_usuario.php?mensagem=Erro ao deletar usuário.");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: consulta_usuario.php");
}