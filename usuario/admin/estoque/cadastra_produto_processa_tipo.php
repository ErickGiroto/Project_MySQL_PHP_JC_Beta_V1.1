<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta dos dados do formulário
    $codigo = trim($_POST['codigo']);
    $produto = trim($_POST['produto']);
    $tipo = trim($_POST['tipo']);
    $tipo_alimento = trim($_POST['tipo_alimento']);

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o código já existe
    $checkStmt = $conn->prepare("SELECT cod FROM produto_tipo WHERE cod = ?");
    if (!$checkStmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }
    $checkStmt->bind_param("s", $codigo);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Código já existe, exibe erro
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro</title>
            <link rel='stylesheet' href='/usuario/admin/css/estoque/cadastra_produto_processa_tipo.css'>
        </head>
        <body>
            <div class='corpo_body'>
                <div class='main-container'>
                    <div class='link-container'>
                        <h2 class='h2format'>Erro no Cadastro</h2>
                        <p class='forgot-password'>
                            <span class='descri'> O código do produto já existe. Escolha outro código. </span>
                            <a class='link' href='/usuario/admin/estoque/cadastra_produto_tipo.php'>
                                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                                Voltar
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </body>
        </html>";
    } else {
        // Prepara a inserção no banco de dados
        $stmt = $conn->prepare("INSERT INTO produto_tipo (cod, produto, tipo, tipo_alimento) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        // Bind dos parâmetros
        $stmt->bind_param("ssss", $codigo, $produto, $tipo, $tipo_alimento);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
            <html lang='pt-br'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Sucesso</title>
                <link rel='stylesheet' href='/usuario/admin/css/estoque/cadastra_produto_processa_tipo.css'>
            </head>
            <body>
                <div class='corpo_body'>
                    <div class='main-container'>
                        <div class='link-container'>
                            <h2 class='h2format'>Tipo de Produto Cadastrado</h2>
                            <p class='forgot-password'>
                                <span class='descri_ok'> Tipo de produto cadastrado com sucesso! </span>
                                <a class='link' href='/usuario/admin/estoque/cadastra_produto_tipo.php'>
                                    <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                                    Voltar
                                </a>
                            </p>
                        </div>
                    </div>
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
                <link rel='stylesheet' href='/usuario/admin/css/estoque/cadastra_produto_processa_tipo.css'>
            </head>
            <body>
                <div class='corpo_body'>
                    <div class='main-container'>
                        <div class='link-container'>
                            <h2 class='h2format'>Erro no Cadastro</h2>
                            <p class='forgot-password'>
                                <span class='descri'> Erro ao cadastrar o tipo de produto. </span>
                                <a class='link' href='/usuario/admin/estoque/cadastra_produto_tipo.php'>
                                    <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                                    Voltar
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </body>
            </html>";
        }

        // Fecha a consulta
        $stmt->close();
    }

    // Fecha a consulta de verificação e a conexão
    $checkStmt->close();
    $conn->close();
}
?>
