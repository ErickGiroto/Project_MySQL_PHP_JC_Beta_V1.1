<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coleta o id do pedido para edição
$id_pedido = $_GET['id'];

// Busca os dados do pedido
$query = "SELECT * FROM pedidos_comercial WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
$pedido = $result->fetch_assoc();

if (!$pedido) {
    echo "Pedido não encontrado!";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="/usuario/admin/css/estoque/cadastro_produto_estoque.css">
</head>
<body>
    <div class="main-container">
        <h2>Editar Pedido</h2>
        <form action="editar_pedido_processa.php" method="POST">
            <div class="form-row">
                <label>Num. Pedido</label>
                <input type="text" name="num_pedido" value="<?= $pedido['num_pedido'] ?>" readonly>
            </div>

            <div class="form-row">
                <label>Razão Social</label>
                <input type="text" name="razao_social" value="<?= $pedido['razao_social'] ?>" required>
            </div>

            <div class="form-row">
                <label>CNPJ</label>
                <input type="text" name="cnpj" value="<?= $pedido['cnpj'] ?>" required>
            </div>

            <div class="form-row">
                <label>Código do Produto</label>
                <input type="text" name="codigo_produto" value="<?= $pedido['cod'] ?>" required>
            </div>

            <div class="form-row">
                <label>Produto</label>
                <input type="text" name="produto" value="<?= $pedido['produto'] ?>" required>
            </div>

            <div class="form-row">
                <label>Quantidade</label>
                <input type="number" name="quantidade" value="<?= $pedido['qtd'] ?>" required>
            </div>

            <div class="form-row">
                <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                <button class="submit-btn" type="submit">Salvar Alterações</button>

                <div>
                    <a class="button" href="/usuario/gerencia/consulta_pedido.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </div>

            </div>
        </form>
    </div>
</body>
</html>
