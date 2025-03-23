<?php
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $resposta1 = trim($_POST['resposta1']);
    $resposta2 = trim($_POST['resposta2']);
    $resposta3 = trim($_POST['resposta3']);

    // Preparar a consulta para obter as respostas armazenadas no banco
    $stmt = $conn->prepare("SELECT resposta1, resposta2, resposta3 FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($resposta1_db, $resposta2_db, $resposta3_db);
    $stmt->fetch();
    $stmt->close();
    
    // Verificar se o e-mail existe no banco de dados
    if ($resposta1_db === null) {
        echo "E-mail não encontrado. <a href='recupera_usuario.php'>Tente novamente</a>";
        exit;
    }

    // Comparar as respostas diretamente (sem hash)
    if ($resposta1 === $resposta1_db && $resposta2 === $resposta2_db && $resposta3 === $resposta3_db) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Nova Senha</title>
            <link rel='stylesheet' href='css/recuperacao_senha_processa.css'>
            
        </head>
        <body>

            <h1 class='font'>Sistema!</h1>
            <div class='corpo_body'>
                <div class='form-wrapper'>

                    <div class='form-container'>
                        <form action='nova_senha.php' method='POST'>
                            <h2>Nova Senha</h2>
                            <input type='hidden' name='email' value='" . htmlspecialchars($email) . "'>
                            <input class='input-field' type='password' name='nova_senha' placeholder='Nova Senha' required>
                            <button class='submit-button' type='submit'>Alterar Senha</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "Respostas incorretas. <a href='recupera_usuario.php'>Tente novamente</a>";
    }
}

$conn->close();
?>