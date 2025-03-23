<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cnpj = trim($_POST['cnpj']);
    $razao_social = trim($_POST['razao_social']);
    $nome = trim($_POST['nome']);
    $telefone1 = trim($_POST['telefone1']);
    $telefone2 = isset($_POST['telefone2']) ? trim($_POST['telefone2']) : null;
    $email = trim($_POST['email']);
    $departamento = trim($_POST['departamento']);
    $observacao = isset($_POST['observacao']) ? trim($_POST['observacao']) : null;
    $usuario_registro = $_POST['usuario_registro'];
    $nome_usuario = $_POST['nome_usuario'];
    $data_registro = date("Y-m-d H:i:s");

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o CNPJ existe na tabela empresas
    $stmt_check_cnpj = $conn->prepare("SELECT id FROM empresas WHERE cnpj = ?");
    $stmt_check_cnpj->bind_param("s", $cnpj);
    $stmt_check_cnpj->execute();
    $stmt_check_cnpj->store_result();

    if ($stmt_check_cnpj->num_rows === 0) {
        echo "<h2>Erro: CNPJ não cadastrado!</h2>";
        exit;
    }
    $stmt_check_cnpj->close();

    // Verifica se o e-mail já está cadastrado na tabela empresa_cliente
    $stmt_check_email = $conn->prepare("SELECT id FROM empresa_cliente WHERE email = ?");
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $stmt_check_email->store_result();

    if ($stmt_check_email->num_rows > 0) {
        // E-mail já existe, exibir mensagem de erro
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro ao cadastrar!</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_cliente_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2> <span class='errorcadastro'>Erro: </span> Já existe um cliente cadastrado com esse <span class='errorcadastro'> e-mail!</span></h2>
                <a href='/usuario/admin/comercial/cadastro_cliente.php'>Voltar</a>
            </div>
        </body>
        </html>";
        exit;
    }
    $stmt_check_email->close();

    // Inserir cliente na tabela empresa_cliente
    $stmt = $conn->prepare("INSERT INTO empresa_cliente (razao_social, cnpj, nome, telefone1, telefone2, email, departamento, observacao, usuario_registro, nome_usuario, data_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $razao_social, $cnpj, $nome, $telefone1, $telefone2, $email, $departamento, $observacao, $usuario_registro, $nome_usuario, $data_registro);

    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Sucesso</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_cliente_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2> <span class='sucesso'>Cliente cadastrado(a) com sucesso!</span></h2>
                <a href='/usuario/admin/comercial/cadastro_cliente.php'>Voltar</a>
            </div>
        </body>
        </html>";
    } else {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro ao cadastrar!</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_cliente_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2> <span class='errorcadastro'>Erro ao cadastrar!</span></h2>
                <a href='/usuario/admin/comercial/cadastro_cliente.php'>Voltar</a>
            </div>
        </body>
        </html>";
    }
    $stmt->close();
    $conn->close();
}
?>
