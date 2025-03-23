<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta os clientes
$sql = "SELECT * FROM empresa_cliente";
$result = $conn->query($sql);

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

$conn->close();

echo json_encode($clientes);
?>
