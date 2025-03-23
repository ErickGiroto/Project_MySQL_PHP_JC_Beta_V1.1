<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_usuario.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se há dados enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_completo = $_POST['nome_completo'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $pergunta1 = $_POST['pergunta1'] ?? '';
    $resposta1 = $_POST['resposta1'] ?? '';
    $pergunta2 = $_POST['pergunta2'] ?? '';
    $resposta2 = $_POST['resposta2'] ?? '';
    $pergunta3 = $_POST['pergunta3'] ?? '';
    $resposta3 = $_POST['resposta3'] ?? '';


    // Verifica se a senha foi fornecida e a protege com hash
    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Cria um hash seguro da senha
    } else {
        // Se a senha não foi fornecida, mantém a senha atual no banco de dados
        $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->bind_result($senha_hash);
        $stmt->fetch();
        $stmt->close();
    }



    
    $query = "UPDATE usuarios SET nome_completo=?, senha=?, email=?, pergunta1=?, resposta1=?, pergunta2=?, resposta2=?, pergunta3=?, resposta3=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssi", $nome_completo, $senha_hash, $email, $pergunta1, $resposta1, $pergunta2, $resposta2, $pergunta3, $resposta3, $usuario_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Seus dados foram atualizados com sucesso!";
    } else {
        $_SESSION['error_message'] = "Erro ao atualizar os dados. Tente novamente.";
    }
    $stmt->close();
}
$conn->close();

header("Location: portal_usuario_editar.php");
exit;
?>
