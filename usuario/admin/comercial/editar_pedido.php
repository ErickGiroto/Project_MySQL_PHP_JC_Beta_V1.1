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
    <link rel="stylesheet" href="/usuario/admin/css/comercial/editar_pedido.css">
    <script>
        function calcularValorTotal() {
            var quantidade = parseFloat(document.getElementById("quantidade").value);
            var valorUnitario = parseFloat(document.getElementById("valor_unitario").value);
            var valorTotal = quantidade * valorUnitario;
            document.getElementById("valor_total").value = valorTotal.toFixed(2);
        }
    </script>
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2 class="h2format">Editar Pedido</h2>
        <form action="editar_pedido_processa.php" method="POST">
            <div class="form-grid">
                <div class="form-row">
                    <label>Num. Pedido</label>
                    <input class="input-field" type="text" name="num_pedido" value="<?= $pedido['num_pedido'] ?>" readonly>
                </div>

                <div class="form-row">
                    <label>Razão Social</label>
                    <input class="input-field" type="text" name="razao_social" value="<?= $pedido['razao_social'] ?>" readonly>
                </div>

                <div class="form-row">
                    <label>CNPJ</label>
                    <input class="input-field" type="text" name="cnpj" value="<?= $pedido['cnpj'] ?>" readonly>
                </div>

                <div class="form-row">
                    <label>Código do Produto</label>
                    <input class="input-field" type="text" name="codigo_produto" value="<?= $pedido['cod'] ?>" readonly>
                </div>

                <div class="form-row">
                    <label>Produto</label>
                    <input class="input-field" type="text" name="produto" value="<?= $pedido['produto'] ?>" readonly>
                </div>

                <div class="form-row">
                    <label>Quantidade</label>
                    <input id="quantidade" class="input-field" type="number" name="quantidade" value="<?= $pedido['qtd'] ?>" oninput="calcularValorTotal()" required>
                </div>

                <div class="form-row">
                    <label>Valor Unitário</label>
                    <input id="valor_unitario" class="input-field" type="number" step="0.01" name="valor_unitario" value="<?= $pedido['valor_unitario'] ?>" oninput="calcularValorTotal()" required>
                </div>

                <div class="form-row">
                    <label>Valor Total</label>
                    <input id="valor_total" class="input-field" type="text" name="valor_total" value="<?= $pedido['valor_total'] ?>" readonly>
                </div>

                <div class="form-row">
                    <label>Data de Entrega</label>
                    <input class="input-field" type="date" name="data_de_entrega" value="<?= $pedido['data_de_entrega'] ?>" required>
                </div>
            </div>

            <div class="button-container">
                <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                <button class="submit-btn" type="submit">Salvar Alterações</button>
                <a class="button" href="/usuario/admin/comercial/consulta_pedido.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</body>
</html>