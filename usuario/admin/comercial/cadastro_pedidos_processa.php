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
$razao_social = $_POST['razao_social'];
$cnpj = $_POST['cnpj'];
$cod_produto = $_POST['codigo_produto'];
$produto = $_POST['produto'];
$tipo = $_POST['tipo'];
$tipo_alimento = $_POST['tipo_alimento'];
$quantidade = $_POST['quantidade'];
$usuario_registro = $_POST['usuario_registro'];
$nome_usuario = $_POST['nome_usuario'];
$num_pedido = $_POST['num_pedido'];
$valor_unitario = $_POST['valor_unitario'];
$valor_total = $_POST['valor_total'];
$data_de_entrega = $_POST['data_de_entrega'];
$status = "Não Iniciado";  // Definindo o status padrão

// Verifica se o número do pedido já está em uso para outro CNPJ
$stmt = $conn->prepare("SELECT COUNT(*) FROM pedidos_comercial WHERE num_pedido = ? AND cnpj != ?");
$stmt->bind_param("ss", $num_pedido, $cnpj);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_pedidos_processa.css'>
            <title>Atenção!</title>
        </head>
        <body>
            <div class='main-container'>
                <h2> <span class='fonte-error'>Atenção!</span></h2>
                <h2> O número do pedido <span class='fonte-error'> $num_pedido </span> já está em uso para outro CNPJ.</h2>
            </div>
            <a class='button' href='cadastro_pedidos.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
    exit;
}

// Verifica se o produto já foi adicionado ao pedido
$stmt = $conn->prepare("SELECT COUNT(*) FROM pedidos_comercial WHERE num_pedido = ? AND cod = ?");
$stmt->bind_param("ss", $num_pedido, $cod_produto);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_pedidos_processa.css'>
            <title>Atenção!</title>
        </head>
        <body>
            <div class='main-container'>
                <h2> <span class='fonte-error'>Atenção!</span></h2>
                <h2> O produto já foi adicionado ao pedido número <span class='fonte-error'> $num_pedido </span>.</h2>
            </div>
            <a class='button' href='cadastro_pedidos.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
    exit;
}

// Insere os dados na tabela pedidos_comercial
$stmt = $conn->prepare("INSERT INTO pedidos_comercial (razao_social, cnpj, cod, produto, tipo, tipo_alimento, qtd, usuario_registro, nome_usuario, num_pedido, status, valor_unitario, valor_total, data_de_entrega) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssissssdds", $razao_social, $cnpj, $cod_produto, $produto, $tipo, $tipo_alimento, $quantidade, $usuario_registro, $nome_usuario, $num_pedido, $status, $valor_unitario, $valor_total, $data_de_entrega);

if ($stmt->execute()) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_pedidos_processa.css'>
            <title>Sucesso</title>
        </head>
        <body>
            <div class='main-container'>
                <h2>Pedido <span class='sucess'>Cadastrado</span> com Sucesso!</h2>
            </div>
            <a class='button' href='cadastro_pedidos.php'>
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
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_pedidos_processa.css'>
            <title>Erro</title>
        </head>
        <body>
            <div class='main-container'>
                <h2>Pedido Não Cadastrado! Erro: " . $stmt->error . "</h2>
                <a class='button' href='cadastro_pedidos.php'>
                    <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                    Voltar
                </a>
            </div>
        </body>
        </html>";
}

$stmt->close();
$conn->close();
?>