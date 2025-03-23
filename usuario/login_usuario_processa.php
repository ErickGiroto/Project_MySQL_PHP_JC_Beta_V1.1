<?php
session_start();
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome_completo, senha, tipo_usuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome_completo, $senha_hash, $tipo_usuario);
        $stmt->fetch();

        if (password_verify($senha, $senha_hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['nome_usuario'] = $nome_completo;
            $_SESSION['tipo_usuario'] = $tipo_usuario;
            $_SESSION['email'] = $email; // Adiciona o e-mail à sessão
            $_SESSION['expire_time'] = time() + 3600; // Sessão válida por 1 hora

            // Redireciona para o portal de usuários
            header("Location: portal_usuario.php");
            exit;
        } else {
            exibirMensagemErro("Senha incorreta.");
        }
    } else {
        exibirMensagemErro("E-mail não encontrado.");
    }

    $stmt->close();
}
$conn->close();

function exibirMensagemErro($mensagem) {
    echo "<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erro de Login</title>
        <link rel='stylesheet' href='css/login_usuario_processa.css'>
    </head>
    <body>
        <div class='corpo_body'>
            <div class='main-container'>
            
                <div class='form-container'>
                    <h2>Erro de Login</h2>
                    <div class='message'>
                        <p class='font'>$mensagem <br><br><a href='login_usuario.php' class='link'>Tente novamente</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>";
    exit;
}
?>
