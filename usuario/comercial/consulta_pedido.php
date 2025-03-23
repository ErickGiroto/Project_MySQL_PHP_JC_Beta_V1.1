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

// Busca todos os pedidos cadastrados
$query = "SELECT id, num_pedido, razao_social, cnpj, produto, tipo, tipo_alimento, qtd, usuario_registro, nome_usuario, status FROM pedidos_comercial";
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
<body>
    <div class="main-container">
        <h2>Consulta de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Num. Pedido</th>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['num_pedido'] ?></td>
                        <td><?= $row['razao_social'] ?></td>
                        <td><?= $row['cnpj'] ?></td>
                        <td><?= $row['produto'] ?></td>
                        <td><?= $row['qtd'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td>
                            <!-- Verifica se o status do pedido não é 'Finalizado' -->
                            <?php if ($row['status'] != 'Finalizado'): ?>
                                <a href="editar_pedido.php?id=<?= $row['id'] ?>">Editar</a> | 
                                <a href="excluir_pedido.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este pedido?');">Excluir</a> | 
                            <?php endif; ?>

                            <!-- Botão Iniciar (apenas se o status não for Finalizado) -->
                            <?php if ($row['status'] != 'Finalizado'): ?>
                                <a href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Iniciado">Iniciar</a> | 
                            <?php endif; ?>

                            <!-- Botão Finalizar -->
                            <a href="consulta_pedido_processa.php?id=<?= $row['id'] ?>&status=Finalizado">Finalizar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div>
            <a class="button" href="/usuario/portal_usuario.php">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                Voltar
            </a>
        </div>
    </div>
</body>
</html>
