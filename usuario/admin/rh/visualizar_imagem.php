<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$cod_funcionario = $_GET['cod']; // Código do funcionário

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Busca a imagem do funcionário
$sql = "SELECT imagem FROM funcionario_imagens WHERE cod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cod_funcionario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imagem);

if ($stmt->fetch()) {
    // Exibe a imagem em uma página estilizada
    echo "<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Visualizar Imagem</title>
        <link rel='stylesheet' href='/usuario/admin/css/rh/visualizar_imagem.css'>
    </head>
    <body>
        <div class='main-container'>
            <h2>Imagem do Funcionário</h2>
            <img src='data:image/jpeg;base64," . base64_encode($imagem) . "' alt='Imagem do Funcionário' class='imagem-funcionario'>
            
        </div>
         <a class='button' href='consulta_funcionario.php'>
            <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
            Voltar
        </a>
    </body>
    </html>";
} else {
    // Exibe uma mensagem de erro
    echo "<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Atenção!</title>
        <link rel='stylesheet' href='/usuario/admin/css/rh/visualizar_imagem.css'>
    </head>
    <body>
        <div class='main-container'>
            <h2>Atenção!</h2>
            <p class='mensagem-erro'>Nenhuma imagem encontrada para este funcionário.</p>

            <a class='link' href='consulta_funcionario.php'>
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