<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

// Verifica se as variáveis de sessão necessárias estão definidas
if (!isset($_SESSION['email']) || !isset($_SESSION['nome_usuario'])) {
    die("Erro: Dados do usuário não encontrados na sessão. Faça login novamente.");
}

$cod_funcionario = $_GET['cod']; // Código do funcionário

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = file_get_contents($_FILES['imagem']['tmp_name']);

        // Obtém o email e o nome do usuário da sessão
        $usuario_registro = $_SESSION['email']; // Usando $_SESSION['email']
        $nome_usuario = $_SESSION['nome_usuario'];

        // Verifica se já existe uma imagem para o funcionário
        $stmt_check = $conn->prepare("SELECT id FROM funcionario_imagens WHERE cod = ?");
        $stmt_check->bind_param("s", $cod_funcionario);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Se existir, atualiza a imagem
            $stmt = $conn->prepare("UPDATE funcionario_imagens SET imagem = ?, usuario_registro = ?, nome_usuario = ? WHERE cod = ?");
        } else {
            // Se não existir, insere uma nova imagem
            $stmt = $conn->prepare("INSERT INTO funcionario_imagens (cod, imagem, usuario_registro, nome_usuario) VALUES (?, ?, ?, ?)");
        }

        if (!$stmt) {
            die("Erro na preparação da query: " . $conn->error);
        }

        // Bind dos parâmetros
        if ($stmt_check->num_rows > 0) {
            $stmt->bind_param("ssss", $imagem, $usuario_registro, $nome_usuario, $cod_funcionario);
        } else {
            $stmt->bind_param("ssss", $cod_funcionario, $imagem, $usuario_registro, $nome_usuario);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Imagem atualizada com sucesso!'); window.location.href='consulta_funcionario.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar imagem!'); window.location.href='consulta_funcionario.php';</script>";
        }

        $stmt->close();
        $stmt_check->close();
    } else {
        echo "<script>alert('Erro no upload da imagem!'); window.location.href='consulta_funcionario.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar/Editar - Imagem</title>
    <link rel="stylesheet" href="/usuario/admin/css/rh/editar_imagem.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2>Registrar/Editar - Imagem</h2>
        <form action="editar_imagem.php?cod=<?= $cod_funcionario; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <label>Selecione a nova imagem:</label>
                <input type="file" name="imagem" accept="image/*" required>
            </div>

            <button type="submit" class="botao-atualizar">Atualizar Imagem</button>
        </form>

        <div class="button-container">
            <button class="button" onclick="window.location.href='/usuario/admin/rh/consulta_funcionario.php'">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </button>
        </div>

        

    </div>

    


</body>
</html>