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

// Busca todos os pedidos cadastrados, ordenados pelo ID em ordem decrescente
$query = "SELECT id, num_pedido, razao_social, cnpj, produto, tipo, tipo_alimento, qtd, status, data_de_entrega 
          FROM pedidos_comercial 
          ORDER BY id DESC"; // Ordena por ID em ordem decrescente
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pedidos</title>
    <link rel="stylesheet" href="/usuario/funcionario/css/consulta_pedido.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2 class="h2format">Consulta de Pedidos</h2>
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
                        <th>Data de Entrega</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['num_pedido']) ?></td>
                                <td><?= htmlspecialchars($row['razao_social']) ?></td>
                                <td><?= htmlspecialchars($row['cnpj']) ?></td>
                                <td><?= htmlspecialchars($row['produto']) ?></td>
                                <td><?= htmlspecialchars($row['tipo']) ?></td>
                                <td><?= htmlspecialchars($row['qtd']) ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_de_entrega'])) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Não Iniciado') : ?>
                                        <a class="filhos-link" href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Iniciado">Iniciar</a>
                                    <?php elseif ($row['status'] == 'Iniciado') : ?>
                                        <a class="filhos-link" href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Finalizado">Finalizar</a>
                                    <?php endif; ?>
                                    <!-- Botão de Imprimir sempre visível -->
                                    <a class="filhos-link" href="gerar_pdf.php?id=<?= $row['id'] ?>" target="_blank">Imprimir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9">Nenhum pedido cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <button class="button" onclick="window.location.href='/usuario/portal_usuario.php'">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </button>
        </div>
    </div>
</body>
</html>