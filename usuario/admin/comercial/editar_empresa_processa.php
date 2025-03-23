<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id'];
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

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Atualiza os dados da empresa
    $stmt = $conn->prepare("UPDATE empresas SET razao_social = ?, cnpj = ?, endereco = ?, bairro = ?, municipio = ?, estado = ?, cep = ?, pais = ?, numero = ?, observacao = ? WHERE id = ?");
    $stmt->bind_param("ssssssssssi", $razao_social, $cnpj, $endereco, $bairro, $municipio, $estado, $cep, $pais, $numero, $observacao, $id);

    if ($stmt->execute()) {
        header("Location: consulta_empresa.php?sucesso=1");
    } else {
        header("Location: consulta_empresa.php?erro=1");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: consulta_empresa.php");
}
?>