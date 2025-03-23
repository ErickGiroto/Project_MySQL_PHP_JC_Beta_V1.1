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

// Consulta os clientes cadastrados
$sql = "SELECT id, razao_social, cnpj, nome, telefone1, email, departamento, usuario_registro, nome_usuario, data_registro FROM empresa_cliente";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Clientes</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/consulta_cliente.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2>Lista de Clientes</h2>
        <table class="tabela-consulta">
            <thead>
                <tr>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Departamento</th>
                    <th>Usuário Registro</th>
                    <th>Nome Usuário</th>
                    <th>Data Registro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['razao_social']) ?></td>
                            <td><?= htmlspecialchars($row['cnpj']) ?></td>
                            <td><?= htmlspecialchars($row['nome']) ?></td>
                            <td><?= htmlspecialchars($row['telefone1']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['departamento']) ?></td>
                            <td><?= htmlspecialchars($row['usuario_registro']) ?></td>
                            <td><?= htmlspecialchars($row['nome_usuario']) ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($row['data_registro'])) ?></td>
                            <td>
                                <a class="edit-link" href="editar_cliente.php?id=<?= $row['id'] ?>" class="btn-editar">Editar</a>
                                <a class="delete-link" href="excluir_cliente.php?id=<?= $row['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10">Nenhum cliente cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="button-container">
            <a class="button" href="/usuario/admin/comercial/menu_comercial.php">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                Voltar
            </a>
        </div>
    </div>
</body>
</html>