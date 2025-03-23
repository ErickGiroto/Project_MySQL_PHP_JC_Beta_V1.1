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

// Busca todos os pedidos cadastrados, incluindo os novos campos
$query = "SELECT id, num_pedido, razao_social, cnpj, produto, tipo, tipo_alimento, qtd, usuario_registro, nome_usuario, status, data_registro, valor_unitario, valor_total, data_de_entrega FROM pedidos_comercial";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pedidos</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/consulta_pedido.css">
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
                        <th>Valor Unitário</th>
                        <th>Valor Total</th>
                        <th>Data de Entrega</th>
                        <th>Status</th>
                        <th>Data Registro</th>
                        <th>Usuário Registro</th>
                        <th>Nome Usuário</th>
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
                                <td>R$ <?= number_format($row['valor_unitario'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_de_entrega'])) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($row['data_registro'])) ?></td>
                                <td><?= htmlspecialchars($row['usuario_registro']) ?></td>
                                <td><?= htmlspecialchars($row['nome_usuario']) ?></td>
                                <td>
                                    <a class="edit-link" href="editar_pedido.php?id=<?= $row['id'] ?>">Editar</a>
                                    <a class="delete-link" href="excluir_pedido.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este pedido?');">Excluir</a>
                                    <a class="filhos-link" href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Iniciado">Iniciar</a>
                                    <a class="filhos-link" href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Finalizado">Finalizar</a>
                                    <a class="filhos-link" href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Não Iniciado">Não Iniciado</a>
                                    <?php if ($row['status'] == 'Finalizado') : ?>
                                        <a class="filhos-link" href="gerar_pdf.php?id=<?= $row['id'] ?>" target="_blank">Imprimir</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="14">Nenhum pedido cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <button class="button" onclick="window.location.href='/usuario/admin/comercial/menu_comercial.php'">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </button>
        </div>
    </div>
</body>
</html>