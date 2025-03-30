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
    $query = "SELECT id, num_pedido, razao_social, cnpj, produto, tipo, tipo_alimento, qtd, status, data_registro, data_de_entrega 
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
    <title>Ordens de Serviços</title>
    <link rel="stylesheet" href="/usuario/funcionario/css/consulta_pedido_filtro.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2 class="h2format">Ordens de Serviços</h2>
        
        <!-- Formulário de pesquisa por número de pedido -->
        <form method="GET" action="consulta_pedido_filtro_processa.php">
            <div class="button-container">
                <div class="form-container">
                    <div class="form-row">
                        <label for="num_pedido">Número do Pedido:</label>
                        <input type="text" id="num_pedido" name="num_pedido" value="<?= htmlspecialchars($num_pedido) ?>" placeholder="Digite o número do pedido" required class="input-field">
                    </div>
                </div>
                <button class="button button-pesquisar" type="submit">
                    <img src="/midias/image/icon/icone_pesquisar.png" alt="Pesquisar"> Pesquisar
                </button>
            </div>
        </form>

        <!-- Exibe os resultados da pesquisa -->
        <?php if (!empty($num_pedido)) : ?>
            <div class="table-container">
                <table class="tabela-consulta">
                    <thead>
                        <tr>
                            <th>Num. Pedido</th>
                            <th>Data de Entrega</th>
                                                     
                            <th>Produto</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>CNPJ</th>
                            <th>Razão Social</th>
                            <th>Status</th>
                            <th>Data Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0) : ?>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['num_pedido']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['data_de_entrega'])) ?></td>                        
                                    <td><?= htmlspecialchars($row['produto']) ?></td>
                                    <td><?= htmlspecialchars($row['tipo']) ?></td>
                                    <td><?= htmlspecialchars($row['qtd']) ?></td>
                                    <td><?= htmlspecialchars($row['cnpj']) ?></td>
                                    <td><?= htmlspecialchars($row['razao_social']) ?></td>
                                    <td><?= htmlspecialchars($row['status']) ?></td>
                                    <td><?= date('d/m/Y H:i:s', strtotime($row['data_registro'])) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9">Nenhum pedido encontrado para o número <?= htmlspecialchars($num_pedido) ?>.</td>
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

        <!-- Botão de Voltar -->
        <div class="button-container">
            <button class="button" onclick="window.location.href='/usuario/portal_usuario.php'">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </button>
        </div>
    </div>
</body>
</html>