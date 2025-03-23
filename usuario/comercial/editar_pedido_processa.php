<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coleta os dados do formulário
$id = $_POST['id'];
$razao_social = $_POST['razao_social'];
$cnpj = $_POST['cnpj'];
$cod_produto = $_POST['codigo_produto'];
$produto = $_POST['produto'];
$quantidade = $_POST['quantidade'];

// Atualiza os dados do pedido, exceto o num_pedido
$query = "UPDATE pedidos_comercial SET razao_social = ?, cnpj = ?, cod = ?, produto = ?, qtd = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssii", $razao_social, $cnpj, $cod_produto, $produto, $quantidade, $id);

if ($stmt->execute()) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Sucesso</title>
            <link rel='stylesheet' href='#'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Pedido Atualizado com Sucesso!</h2>
                <a href='/usuario/gerencia/consulta_pedido.php'>Voltar</a>
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
            <link rel='stylesheet' href='#'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao atualizar pedido!</h2>
                <a href=/usuario/gerencia/consulta_pedido.php'>Voltar</a>
            </div>
        </body>
        </html>";
}

$stmt->close();
$conn->close();
?>
