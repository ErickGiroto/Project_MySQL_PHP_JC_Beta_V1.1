<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $telefone1 = trim($_POST['telefone1']);
    $email = trim($_POST['email']);
    $departamento = trim($_POST['departamento']);

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE empresa_cliente SET nome=?, telefone1=?, email=?, departamento=? WHERE id=?");
    $stmt->bind_param("ssssi", $nome, $telefone1, $email, $departamento, $id);

    if ($stmt->execute()) {
        header("Location: consulta_cliente.php");
        exit;
    } else {
        echo "Erro ao atualizar cliente.";
    }

    $stmt->close();
    $conn->close();
}
?>
