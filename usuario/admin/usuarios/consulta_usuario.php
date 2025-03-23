<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuário</title>
    <link rel="stylesheet" href="/usuario/admin/css/usuario/consulta_usuario.css">
</head>

<body class="corpo_body">
    <div class="main-container">

        <!-- Título da Página -->
        <div class="table-container">
            <h2 class="font">Consulta de Usuários</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nome Completo</th>
                        <th>E-mail</th>
                        <th>Tipo de Usuário</th>
                        <th>Pergunta 1</th>
                        <th>Resposta 1</th>
                        <th>Pergunta 2</th>
                        <th>Resposta 2</th>
                        <th>Pergunta 3</th>
                        <th>Resposta 3</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Conexão com o banco de dados
                    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

                    if ($conn->connect_error) {
                        die("Erro de conexão: " . $conn->connect_error);
                    }

                    // Busca todos os usuários
                    $sql = "SELECT id, nome_completo, email, tipo_usuario, pergunta1, resposta1, pergunta2, resposta2, pergunta3, resposta3 FROM usuarios";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Exibe os dados de cada usuário
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['nome_completo']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['tipo_usuario']}</td>
                                    <td>{$row['pergunta1']}</td>
                                    <td>{$row['resposta1']}</td>
                                    <td>{$row['pergunta2']}</td>
                                    <td>{$row['resposta2']}</td>
                                    <td>{$row['pergunta3']}</td>
                                    <td>{$row['resposta3']}</td>
                                    <td class='acoes'>
                                        <a href='editar_usuario.php?id={$row['id']}' class='btn-editar'>Editar</a>
                                        <a href='consulta_usuario_processa.php?acao=deletar&id={$row['id']}' class='btn-deletar' onclick='return confirm(\"Tem certeza que deseja deletar este usuário?\");'>Excluir</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Nenhum usuário cadastrado.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Links de Voltar e Sair -->
            <div class="link-container">
                <p class="forgot-password">
                    <a class="link" href="/usuario/admin/usuarios/menu_usuario.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </p>

                <p class="forgot-password">
                    <a class="link" href="/usuario/logout.php">
                        <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                        Sair
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>