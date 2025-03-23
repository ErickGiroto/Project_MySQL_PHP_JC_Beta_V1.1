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
$valor_unitario = $_POST['valor_unitario'];
$valor_total = $_POST['valor_total'];
$data_de_entrega = $_POST['data_de_entrega'];

// Atualiza os dados do pedido
$query = "UPDATE pedidos_comercial SET razao_social = ?, cnpj = ?, cod = ?, produto = ?, qtd = ?, valor_unitario = ?, valor_total = ?, data_de_entrega = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssiddsi", $razao_social, $cnpj, $cod_produto, $produto, $quantidade, $valor_unitario, $valor_total, $data_de_entrega, $id);

if ($stmt->execute()) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/edita_pedido_processa.css'>
            <title>Pedido Atualizado</title>
        </head>
        <body>
            <div class='main-container'>
                <h2>Pedido <span class='sucess'>Atualizado</span> com Sucesso!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
} else {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro Pedido</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/edita_pedido_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao atualizar o pedido!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
}

$stmt->close();
$conn->close();
?>