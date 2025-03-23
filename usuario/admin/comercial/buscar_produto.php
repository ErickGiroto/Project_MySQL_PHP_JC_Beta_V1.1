<?php
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$cod_produto = $_GET['cod'];

// Alteração da consulta SQL para buscar na tabela 'produto_tipo' ao invés de 'produto_quantidade'
$stmt = $conn->prepare("SELECT produto, tipo, tipo_alimento FROM produto_tipo WHERE cod = ?");
$stmt->bind_param("s", $cod_produto);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($produto, $tipo, $tipo_alimento);

$response = [];
if ($stmt->fetch()) {
    $response = [
        'produto' => $produto,
        'tipo' => $tipo,
        'tipo_alimento' => $tipo_alimento
    ];
} else {
    $response = ['erro' => 'Produto não encontrado'];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
