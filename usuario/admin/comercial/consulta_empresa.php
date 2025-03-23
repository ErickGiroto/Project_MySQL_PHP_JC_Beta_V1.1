<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta todas as empresas
$sql = "SELECT id, razao_social, cnpj, endereco, bairro, municipio, estado, cep, pais, numero, observacao, usuario_registro, nome_usuario, data_registro FROM empresas";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Empresas</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/consulta_empresa.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2>Consulta de Empresas</h2>
        <table class="tabela-consulta">
            <thead>
                <tr>
                    <th>Razão Social</th>
                    <th>CNPJ</th>
                    <th>Endereço</th>
                    <th>Bairro</th>
                    <th>Município</th>
                    <th>Estado</th>
                    <th>CEP</th>
                    <th>País</th>
                    <th>Número</th>
                    <th>Observação</th>
                    <th>Usuário Registro</th>
                    <th>Nome do Usuário</th>
                    <th>Data de Registro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $row['razao_social'] ?></td>
                            <td><?= $row['cnpj'] ?></td>
                            <td><?= $row['endereco'] ?></td>
                            <td><?= $row['bairro'] ?></td>
                            <td><?= $row['municipio'] ?></td>
                            <td><?= $row['estado'] ?></td>
                            <td><?= $row['cep'] ?></td>
                            <td><?= $row['pais'] ?></td>
                            <td><?= $row['numero'] ?></td>
                            <td><?= $row['observacao'] ?></td>
                            <td><?= $row['usuario_registro'] ?></td>
                            <td><?= $row['nome_usuario'] ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($row['data_registro'])) ?></td>
                            <td>
                                <a href="editar_empresa.php?id=<?= $row['id'] ?>" class="btn-editar">Editar</a>
                                <a href="consulta_empresa_processa.php?acao=excluir&id=<?= $row['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta empresa?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="14">Nenhuma empresa cadastrada.</td>
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