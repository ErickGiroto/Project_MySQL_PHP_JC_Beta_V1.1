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

    // Verifica se o produto já existe no banco de dados
    $stmt = $conn->prepare("SELECT qtd FROM produto_quantidade WHERE cod = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($quantidade_existente);

    if ($stmt->fetch()) {
        // Se o produto já existe, atualiza a quantidade
        $nova_quantidade = $quantidade_existente + $quantidade;
        $stmt->close();

        $stmt = $conn->prepare("UPDATE produto_quantidade SET qtd = ?, data_registro = ?, usuario_registro = ?, nome_usuario = ? WHERE cod = ?");
        $stmt->bind_param("issss", $nova_quantidade, $data_registro, $usuario_registro, $nome_usuario, $codigo);
    } else {
        // Se o produto não existe, insere um novo registro
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO produto_quantidade (cod, produto, tipo, tipo_alimento, qtd, data_registro, usuario_registro, nome_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisss", $codigo, $produto, $tipo, $tipo_alimento, $quantidade, $data_registro, $usuario_registro, $nome_usuario);
    }

    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Sucesso</title>
            <link rel='stylesheet' href='/usuario/admin/css/estoque/cadastro_produto_estoque_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Produto cadastrado/atualizado no estoque!</h2>
                <a class='link'href='/usuario/admin/estoque/cadastro_produto_estoque.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar</a>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro</title>
            <link rel='stylesheet' href='/usuario/admin/css/estoque/cadastro_produto_estoque_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao cadastrar/atualizar o produto no estoque, tente novamente!</h2>
                <a class='link'href='/usuario/admin/estoque/cadastro_produto_estoque.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar</a>
            </div>
        </body>
        </html>";
    }

    $stmt->close();
    $conn->close();
}
?>