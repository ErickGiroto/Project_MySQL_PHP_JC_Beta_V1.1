<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o banco
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $nova_senha = trim($_POST['nova_senha']);

    if (!empty($nova_senha)) {
        // Criptografa a senha
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        // Atualiza a senha no banco de dados
        $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
        $stmt->bind_param("ss", $senha_hash, $email);

        if ($stmt->execute()) {
            echo "<!DOCTYPE html>
        <html lang='pt-br'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Erro de Login</title>
                <link rel='stylesheet' href='css/nova_senha.css'>
            </head>
                <div class='corpo_body'>
                    <div class='main-container'>

                        <body>
                            <div class='form-container'>
                                <h2>Senha Alterada</h2> <br>
                                <div class='message'>
                                    <p class='font'>Sua senha foi alterada com sucesso!</p><br>
                                    <p><a href='login_usuario.php' class='link'>Fazer login.</a></p>
                                </div>
                            </div>
                        </body>
                    </div>
                </div>
        </html>";
        } else {
            echo "Erro ao atualizar a senha. Tente novamente.";
        }

        $stmt->close();
    } else {
        echo "A nova senha não pode estar vazia.";
    }

    $conn->close();
}
?>
