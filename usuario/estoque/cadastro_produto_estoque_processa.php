<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = trim($_POST['codigo']);
    $produto = trim($_POST['produto']);
    $tipo = trim($_POST['tipo']);
    $tipo_alimento = trim($_POST['tipo_alimento']);
    $quantidade = (int) trim($_POST['quantidade']);
    $usuario_registro = $_POST['usuario_registro']; // O email do usuário
    $nome_usuario = $_POST['nome_usuario'];
    $data_registro = date("Y-m-d H:i:s");

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Insere um novo registro na tabela produto_quantidade
    $stmt = $conn->prepare("INSERT INTO produto_quantidade (cod, produto, tipo, tipo_alimento, qtd, data_registro, usuario_registro, nome_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $codigo, $produto, $tipo, $tipo_alimento, $quantidade, $data_registro, $usuario_registro, $nome_usuario);

    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Sucesso</title>
            <link rel='stylesheet' href='css/cadastro_produto_estoque_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Produto cadastrado no estoque!</h2>
                <a href='/usuario/portal_usuario.php'>Voltar</a>
            </div>
        </body>
        </html>";
    } else {
        echo "<h2>Erro ao cadastrar no estoque</h2>";
    }

    $stmt->close();
    $conn->close();
}
?>
