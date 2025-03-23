<?php
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$razao_social = $_GET['razao_social'];

$stmt = $conn->prepare("SELECT cnpj FROM empresas WHERE razao_social = ?");
$stmt->bind_param("s", $razao_social);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($cnpj);

$response = [];
if ($stmt->fetch()) {
    $response = ['cnpj' => $cnpj];
} else {
    $response = ['erro' => 'Empresa não encontrada'];
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
