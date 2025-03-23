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

// Verifica se foi enviado um número de pedido para filtrar
$num_pedido = isset($_GET['num_pedido']) ? trim($_GET['num_pedido']) : '';

// Busca os pedidos com base no número do pedido, se fornecido
if (!empty($num_pedido)) {
    $query = "SELECT id, num_pedido, razao_social, cnpj, produto, tipo, tipo_alimento, qtd, usuario_registro, nome_usuario, status, data_registro, valor_unitario, valor_total, data_de_entrega 
              FROM pedidos_comercial 
              WHERE num_pedido = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $num_pedido);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Se nenhum número de pedido for fornecido, não exibe resultados
    $result = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pedidos</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/consulta_pedido_filtro.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2 class="h2format">Imprimir Pedidos</h2>
        
        <!-- Formulário de pesquisa por número de pedido -->
        <form method="GET" action="consulta_pedido_filtro_processa.php">
            <label for="num_pedido">Número do Pedido:</label>
            <input type="text" id="num_pedido" name="num_pedido" value="<?= htmlspecialchars($num_pedido) ?>" placeholder="Digite o número do pedido" required>
            <button type="submit">Pesquisar</button>
        </form>

        <!-- Exibe os resultados da pesquisa -->
        <?php if (!empty($num_pedido)) : ?>
            <div class="table-container">
                <table class="tabela-consulta">
                    <thead>
                        <tr>
                            <th>Num. Pedido</th>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th>Produto</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Valor Total</th>
                            <th>Data de Entrega</th>
                            <th>Status</th>
                            <th>Data Registro</th>
                            <th>Usuário Registro</th>
                            <th>Nome Usuário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0) : ?>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['num_pedido']) ?></td>
                                    <td><?= htmlspecialchars($row['razao_social']) ?></td>
                                    <td><?= htmlspecialchars($row['cnpj']) ?></td>
                                    <td><?= htmlspecialchars($row['produto']) ?></td>
                                    <td><?= htmlspecialchars($row['tipo']) ?></td>
                                    <td><?= htmlspecialchars($row['qtd']) ?></td>
                                    <td>R$ <?= number_format($row['valor_unitario'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['data_de_entrega'])) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($row['data_registro'])) ?></td>
                                    <td><?= htmlspecialchars($row['usuario_registro']) ?></td>
                                    <td><?= htmlspecialchars($row['nome_usuario']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="13">Nenhum pedido encontrado para o número <?= htmlspecialchars($num_pedido) ?>.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botão de Imprimir (gera PDF) -->
            <?php if ($result && $result->num_rows > 0) : ?>
                <div class="button-container">
                    <a href="gerar_pdf_pedido.php?num_pedido=<?= urlencode($num_pedido) ?>" target="_blank" class="button">
                        <img src="/midias/image/icon/icone_imprimir.png" alt="Imprimir"> Imprimir
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="button-container">
            <button class="button" onclick="window.location.href='/usuario/admin/comercial/menu_comercial.php'">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </button>
        </div>
    </div>
</body>
</html>