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

// Consulta os dados da tabela funcionario_registro
$sql = "SELECT 
            id, cod, nome_completo, nome_social, nome_pai, nome_mae, pronome, sexo, 
            data_de_nascimento, estado_civil, cpf, rg, cnh, telefone_1, telefone_emergencia, 
            email, naturalidade, nacionalidade, endereco, bairro, cep, estado, num_casa, 
            data_registro, usuario_registro, nome_usuario 
        FROM funcionario_registro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Funcionários</title>
    <link rel="stylesheet" href="/usuario/admin/css/rh/consulta_funcionario.css">
    <script>
        function abrirModalFilhos(codFuncionario) {
            fetch(`buscar_filhos.php?cod_funcionario=${codFuncionario}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('modal-conteudo').innerHTML = data;
                    document.getElementById('modal-filhos').style.display = 'block';
                })
                .catch(error => console.error('Erro ao buscar filhos:', error));
        }

        function fecharModal() {
            document.getElementById('modal-filhos').style.display = 'none';
        }
    </script>
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2 class="h2format">Consulta de Funcionários</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome Completo</th>
                        <th>Nome Social</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>CNH</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Data Nasc.</th>
                        <th>Estado Civil</th>
                        <th>Naturalidade</th>
                        <th>Nacionalidade</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>CEP</th>
                        <th>Estado</th>
                        <th>Nº Casa</th>
                        <th>Data Registro</th>
                        <th>Usuário Registro</th>
                        <th>Nome Usuário</th>
                        <th>Imagem</th> <!-- Coluna para ações de imagem -->
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['cod']); ?></td>
                            <td><?= htmlspecialchars($row['nome_completo']); ?></td>
                            <td><?= htmlspecialchars($row['nome_social']); ?></td>
                            <td><?= htmlspecialchars($row['cpf']); ?></td>
                            <td><?= htmlspecialchars($row['rg']); ?></td>
                            <td><?= htmlspecialchars($row['cnh']); ?></td>
                            <td><?= htmlspecialchars($row['telefone_1']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['data_de_nascimento']); ?></td>
                            <td><?= htmlspecialchars($row['estado_civil']); ?></td>
                            <td><?= htmlspecialchars($row['naturalidade']); ?></td>
                            <td><?= htmlspecialchars($row['nacionalidade']); ?></td>
                            <td><?= htmlspecialchars($row['endereco']); ?></td>
                            <td><?= htmlspecialchars($row['bairro']); ?></td>
                            <td><?= htmlspecialchars($row['cep']); ?></td>
                            <td><?= htmlspecialchars($row['estado']); ?></td>
                            <td><?= htmlspecialchars($row['num_casa']); ?></td>
                            <td><?= htmlspecialchars($row['data_registro']); ?></td>
                            <td><?= htmlspecialchars($row['usuario_registro']); ?></td>
                            <td><?= htmlspecialchars($row['nome_usuario']); ?></td>
                            <td>
                                <!-- Botão para editar imagem -->
                                <a class="edit-link" href="editar_imagem.php?cod=<?= urlencode($row['cod']); ?>" class="button-imagem">Editar</a>
                                <!-- Botão para visualizar imagem -->
                                <a class="filhos-link" href="visualizar_imagem.php?cod=<?= urlencode($row['cod']); ?>" class="button-imagem">Visualizar</a>
                            </td>
                            <td>
                                <a class="edit-link" href="editar_funcionario.php?cod=<?= urlencode($row['cod']); ?>">Editar</a>
                                <a class="delete-link" href="consulta_funcionario_processa.php?excluir=<?= urlencode($row['cod']); ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                                <button class="filhos-link" onclick="abrirModalFilhos(<?= $row['cod']; ?>)">Ver Filhos</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            
        </div>
        <div class="button-container">
            <button class="button" onclick="window.location.href='/usuario/admin/rh/menu_funcionarios.php'">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </button>
        </div>
    </div>

    <!-- Modal para exibir os filhos -->
    <div id="modal-filhos" class="modal">
        <div class="modal-conteudo">
            <span class="fechar-modal" onclick="fecharModal()">&times;</span>
            <div id="modal-conteudo"></div>
        </div>
    </div>

    
</body>
</html>

<?php
$conn->close();
?>