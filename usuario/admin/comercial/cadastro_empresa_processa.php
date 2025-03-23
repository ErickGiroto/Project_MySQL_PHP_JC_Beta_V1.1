<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $razao_social = trim($_POST['razao_social']);
    $cnpj = trim($_POST['cnpj']);
    $endereco = trim($_POST['endereco']);
    $bairro = trim($_POST['bairro']);
    $municipio = trim($_POST['municipio']);
    $estado = trim($_POST['estado']);
    $cep = trim($_POST['cep']);
    $pais = trim($_POST['pais']);
    $numero = trim($_POST['numero']);
    $observacao = trim($_POST['observacao']);
    $usuario_registro = $_POST['usuario_registro']; // O email do usuário
    $nome_usuario = $_POST['nome_usuario'];
    $data_registro = date("Y-m-d H:i:s");

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Verifica se o CNPJ já existe na tabela
    $stmt_check = $conn->prepare("SELECT id FROM empresas WHERE cnpj = ?");
    $stmt_check->bind_param("s", $cnpj);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Se o CNPJ já existe, exibe uma mensagem de erro
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_empresa_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro: CNPJ já cadastrado!</h2>
                <div class='button-container'>
                        <a class='button' href='/usuario/admin/comercial/cadastro_empresa.php'>
                            <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                            Voltar
                        </a>
                    </div>
            </div>
        </body>
        </html>";
    } else {
        // Se o CNPJ não existe, insere um novo registro na tabela empresas
        $stmt = $conn->prepare("INSERT INTO empresas (razao_social, cnpj, endereco, bairro, municipio, estado, cep, pais, numero, observacao, usuario_registro, nome_usuario, data_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssss", $razao_social, $cnpj, $endereco, $bairro, $municipio, $estado, $cep, $pais, $numero, $observacao, $usuario_registro, $nome_usuario, $data_registro);

        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
            <html lang='pt-br'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Sucesso</title>
                <link rel='stylesheet' href='/usuario/admin/css/comercial/cadastro_empresa_processa.css'>
            </head>
            <body>
                <div class='main-container'>
                    <h2>Empresa cadastrada com sucesso!</h2>
                    <!-- Botão Voltar -->
                    <div class='button-container'>
                        <a class='button' href='/usuario/admin/comercial/cadastro_empresa.php'>
                            <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                            Voltar
                        </a>
                    </div>
                </div>
            </body>
            </html>";
        } else {
            echo "<h2>Erro ao cadastrar empresa</h2>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>