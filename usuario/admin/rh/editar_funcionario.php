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

// Verifica se o código do funcionário foi passado na URL
if (!isset($_GET['cod'])) {
    die("Código do funcionário não informado.");
}

$cod_funcionario = $_GET['cod'];

// Busca os dados do funcionário
$sql = "SELECT 
            cod, nome_completo, nome_social, nome_pai, nome_mae, pronome, sexo, 
            data_de_nascimento, estado_civil, cpf, rg, cnh, telefone_1, telefone_emergencia, 
            email, naturalidade, nacionalidade, endereco, bairro, cep, estado, num_casa,
            filho1, data_nascimento_filho1, filho2, data_nascimento_filho2, 
            filho3, data_nascimento_filho3, filho4, data_nascimento_filho4, 
            filho5, data_nascimento_filho5, filho6, data_nascimento_filho6, 
            filho7, data_nascimento_filho7
        FROM funcionario_registro 
        WHERE cod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cod_funcionario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(
    $cod, $nome_completo, $nome_social, $nome_pai, $nome_mae, $pronome, $sexo, 
    $data_de_nascimento, $estado_civil, $cpf, $rg, $cnh, $telefone_1, $telefone_emergencia, 
    $email, $naturalidade, $nacionalidade, $endereco, $bairro, $cep, $estado, $num_casa,
    $filho1, $data_nascimento_filho1, $filho2, $data_nascimento_filho2, 
    $filho3, $data_nascimento_filho3, $filho4, $data_nascimento_filho4, 
    $filho5, $data_nascimento_filho5, $filho6, $data_nascimento_filho6, 
    $filho7, $data_nascimento_filho7
);
$stmt->fetch();
$stmt->close();

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $nome_completo = $_POST['nome_completo'];
    $nome_social = $_POST['nome_social'];
    $nome_pai = $_POST['nome_pai'];
    $nome_mae = $_POST['nome_mae'];
    $pronome = $_POST['pronome'];
    $sexo = $_POST['sexo'];
    $data_de_nascimento = $_POST['data_de_nascimento'];
    $estado_civil = $_POST['estado_civil'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $cnh = $_POST['cnh'];
    $telefone_1 = $_POST['telefone_1'];
    $telefone_emergencia = $_POST['telefone_emergencia'];
    $email = $_POST['email'];
    $naturalidade = $_POST['naturalidade'];
    $nacionalidade = $_POST['nacionalidade'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $num_casa = $_POST['num_casa'];

    // Coleta os dados dos filhos
    $filhos = [];
    for ($i = 1; $i <= 7; $i++) {
        if (!empty($_POST["filho$i"]) && !empty($_POST["data_nascimento_filho$i"])) {
            $filhos["filho$i"] = $_POST["filho$i"];
            $filhos["data_nascimento_filho$i"] = $_POST["data_nascimento_filho$i"];
        } else {
            $filhos["filho$i"] = null;
            $filhos["data_nascimento_filho$i"] = null;
        }
    }

    // Atualiza os dados no banco de dados
    $sql_update = "UPDATE funcionario_registro SET 
                    nome_completo = ?, nome_social = ?, nome_pai = ?, nome_mae = ?, 
                    pronome = ?, sexo = ?, data_de_nascimento = ?, estado_civil = ?, 
                    cpf = ?, rg = ?, cnh = ?, telefone_1 = ?, telefone_emergencia = ?, 
                    email = ?, naturalidade = ?, nacionalidade = ?, endereco = ?, 
                    bairro = ?, cep = ?, estado = ?, num_casa = ?,
                    filho1 = ?, data_nascimento_filho1 = ?, 
                    filho2 = ?, data_nascimento_filho2 = ?, 
                    filho3 = ?, data_nascimento_filho3 = ?, 
                    filho4 = ?, data_nascimento_filho4 = ?, 
                    filho5 = ?, data_nascimento_filho5 = ?, 
                    filho6 = ?, data_nascimento_filho6 = ?, 
                    filho7 = ?, data_nascimento_filho7 = ?
                  WHERE cod = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param(
        "ssssssssssssssssssssssssssssssssssss", 
        $nome_completo, $nome_social, $nome_pai, $nome_mae, $pronome, $sexo, 
        $data_de_nascimento, $estado_civil, $cpf, $rg, $cnh, $telefone_1, 
        $telefone_emergencia, $email, $naturalidade, $nacionalidade, $endereco, 
        $bairro, $cep, $estado, $num_casa,
        $filhos['filho1'], $filhos['data_nascimento_filho1'],
        $filhos['filho2'], $filhos['data_nascimento_filho2'],
        $filhos['filho3'], $filhos['data_nascimento_filho3'],
        $filhos['filho4'], $filhos['data_nascimento_filho4'],
        $filhos['filho5'], $filhos['data_nascimento_filho5'],
        $filhos['filho6'], $filhos['data_nascimento_filho6'],
        $filhos['filho7'], $filhos['data_nascimento_filho7'],
        $cod_funcionario
    );

    if ($stmt_update->execute()) {
        echo "<script>alert('Funcionário atualizado com sucesso!'); window.location.href='consulta_funcionario.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar funcionário: " . $stmt_update->error . "');</script>";
    }

    $stmt_update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="/usuario/admin/css/rh/editar_funcionario.css">
    <script>
        function adicionarFilho() {
            const filhosContainer = document.getElementById('filhos-container');
            const totalFilhos = document.querySelectorAll('.filho-item').length;

            if (totalFilhos >= 7) {
                alert('Número máximo de filhos atingido!');
                return;
            }

            const novoFilho = document.createElement('div');
            novoFilho.classList.add('filho-item');
            novoFilho.innerHTML = `
                <div class="form-row">
                    <label>Nome do Filho ${totalFilhos + 1}</label>
                    <input class="input-field" type="text" name="filho${totalFilhos + 1}">
                </div>
                <div class="form-row">
                    <label>Data de Nascimento do Filho ${totalFilhos + 1}</label>
                    <input class="input-field" type="date" name="data_nascimento_filho${totalFilhos + 1}">
                </div>
                <button type="button" class="remover-filho" onclick="removerFilho(this)">Remover</button>
            `;

            filhosContainer.appendChild(novoFilho);
        }

        function removerFilho(botao) {
            const filhoItem = botao.closest('.filho-item');
            filhoItem.remove();
        }
    </script>
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2>Editar Funcionário</h2>
        <form action="editar_funcionario.php?cod=<?= htmlspecialchars($cod_funcionario); ?>" method="POST">
            <div class="form-grid">
                <!-- Coluna 1 -->
                <div class="form-column">
                    <div class="form-row">
                        <label>Código do Funcionário</label>
                        <input class="input-field" type="text" name="cod" value="<?= htmlspecialchars($cod); ?>" readonly>
                    </div>

                    <div class="form-row">
                        <label>Nome Completo</label>
                        <input class="input-field" type="text" name="nome_completo" value="<?= htmlspecialchars($nome_completo); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Nome Social</label>
                        <input class="input-field" type="text" name="nome_social" value="<?= htmlspecialchars($nome_social); ?>">
                    </div>

                    <div class="form-row">
                        <label>Nome do Pai</label>
                        <input class="input-field" type="text" name="nome_pai" value="<?= htmlspecialchars($nome_pai); ?>">
                    </div>

                    <div class="form-row">
                        <label>Nome da Mãe</label>
                        <input class="input-field" type="text" name="nome_mae" value="<?= htmlspecialchars($nome_mae); ?>">
                    </div>

                    <div class="form-row">
                        <label>Pronome</label>
                        <input class="input-field" type="text" name="pronome" value="<?= htmlspecialchars($pronome); ?>">
                    </div>

                    <div class="form-row">
                        <label>Sexo</label>
                        <input class="input-field" type="text" name="sexo" value="<?= htmlspecialchars($sexo); ?>">
                    </div>
                </div>

                <!-- Coluna 2 -->
                <div class="form-column">
                    <div class="form-row">
                        <label>Data de Nascimento</label>
                        <input class="input-field" type="date" name="data_de_nascimento" value="<?= htmlspecialchars($data_de_nascimento); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Estado Civil</label>
                        <input class="input-field" type="text" name="estado_civil" value="<?= htmlspecialchars($estado_civil); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>CPF</label>
                        <input class="input-field" type="text" name="cpf" value="<?= htmlspecialchars($cpf); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>RG</label>
                        <input class="input-field" type="text" name="rg" value="<?= htmlspecialchars($rg); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>CNH</label>
                        <input class="input-field" type="text" name="cnh" value="<?= htmlspecialchars($cnh); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Telefone Principal</label>
                        <input class="input-field" type="text" name="telefone_1" value="<?= htmlspecialchars($telefone_1); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Telefone de Emergência</label>
                        <input class="input-field" type="text" name="telefone_emergencia" value="<?= htmlspecialchars($telefone_emergencia); ?>" required>
                    </div>
                </div>

                <!-- Coluna 3 -->
                <div class="form-column">
                    <div class="form-row">
                        <label>E-mail</label>
                        <input class="input-field" type="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Naturalidade</label>
                        <input class="input-field" type="text" name="naturalidade" value="<?= htmlspecialchars($naturalidade); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Nacionalidade</label>
                        <input class="input-field" type="text" name="nacionalidade" value="<?= htmlspecialchars($nacionalidade); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Endereço</label>
                        <input class="input-field" type="text" name="endereco" value="<?= htmlspecialchars($endereco); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Bairro</label>
                        <input class="input-field" type="text" name="bairro" value="<?= htmlspecialchars($bairro); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>CEP</label>
                        <input class="input-field" type="text" name="cep" value="<?= htmlspecialchars($cep); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Estado</label>
                        <input class="input-field" type="text" name="estado" value="<?= htmlspecialchars($estado); ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Número da Casa</label>
                        <input class="input-field" type="text" name="num_casa" value="<?= htmlspecialchars($num_casa); ?>">
                    </div>
                </div>
            </div>

            <!-- Seção de Filhos -->
            <div class="filhos-section">
                <h3>Filhos</h3>
                <div id="filhos-container">
                    <?php for ($i = 1; $i <= 7; $i++) : ?>
                        <?php if (!empty(${"filho$i"})) : ?>
                            <div class="filho-item">
                                <div class="form-row">
                                    <label>Nome do Filho <?= $i; ?></label>
                                    <input class="input-field" type="text" name="filho<?= $i; ?>" value="<?= htmlspecialchars(${"filho$i"}); ?>">
                                </div>
                                <div class="form-row">
                                    <label>Data de Nascimento do Filho <?= $i; ?></label>
                                    <input class="input-field" type="date" name="data_nascimento_filho<?= $i; ?>" value="<?= htmlspecialchars(${"data_nascimento_filho$i"}); ?>">
                                </div>
                                <button type="button" class="remover-filho" onclick="removerFilho(this)">Remover</button>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <button type="button" class="adicionar-filho" onclick="adicionarFilho()">Adicionar Filho</button>
            </div>

            <button class="submit-btn" type="submit">Salvar Alterações</button>
        </form>

        <div class="button-container">
            <a class="button" href="/usuario/admin/rh/consulta_funcionario.php">
                <img src="/midias/image/icon/icone_voltar.png" alt="Voltar"> Voltar
            </a>
        </div>
    </div>
</body>
</html>