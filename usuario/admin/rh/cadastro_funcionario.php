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

// Busca o email e nome do usuário com base no ID
$stmt = $conn->prepare("SELECT email, nome_completo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($usuario_email, $nome_usuario);

if ($stmt->fetch()) {
    // Dados do usuário
} else {
    echo "Usuário não encontrado!";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="/usuario/admin/css/rh/cadastro_funcionario.css">
    <script>
        let filhoCount = 1;

        function adicionarFilho() {
            if (filhoCount >= 7) {
                alert("Número máximo de filhos atingido!");
                return;
            }

            filhoCount++;

            const divFilho = document.createElement('div');
            divFilho.id = `filho${filhoCount}`;
            divFilho.innerHTML = `
                <div class="form-row">
                    <label>Nome do Filho ${filhoCount}</label>
                    <input class="input-field" type="text" name="filho${filhoCount}">
                </div>
                <div class="form-row">
                    <label>Data de Nascimento do Filho ${filhoCount}</label>
                    <input class="input-field" type="date" name="data_nascimento_filho${filhoCount}">
                </div>
            `;

            document.getElementById('filhos-container').appendChild(divFilho);
        }
    </script>
</head>
<body class="corpo_body">
    <div class="main-container">
       <div class="form-container">
            <h2>Cadastrar Funcionário</h2>
            <form action="cadastro_funcionario_processa.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <!-- Coluna 1 -->
                    <div>
                        <div class="form-row">
                            <label>Código do Funcionário</label>
                            <input class="input-field" type="text" name="cod" required>
                        </div>
                        <div class="form-row">
                            <label>Nome Completo</label>
                            <input class="input-field" type="text" name="nome_completo" required>
                        </div>
                        <div class="form-row">
                            <label>Nome Social</label>
                            <input class="input-field" type="text" name="nome_social">
                        </div>
                        <div class="form-row">
                            <label>Nome do Pai</label>
                            <input class="input-field" type="text" name="nome_pai">
                        </div>
                        <div class="form-row">
                            <label>Nome da Mãe</label>
                            <input class="input-field" type="text" name="nome_mae">
                        </div>
                        <div class="form-row">
                            <label>Pronome</label>
                            <input class="input-field" type="text" name="pronome">
                        </div>
                        <div class="form-row">
                            <label>Sexo</label>
                            <input class="input-field" type="text" name="sexo">
                        </div>
                        <div class="form-row">
                            <label>Data de Nascimento</label>
                            <input class="input-field" type="date" name="data_de_nascimento" required>
                        </div>

                        <div class="form-row">
                            <label>Estado Civil</label>
                            <input class="input-field" type="text" name="estado_civil" required>
                        </div>

                         <div class="form-row">
                            <label>Endereço</label>
                            <input class="input-field" type="text" name="endereco" required>
                        </div>

                        <div class="form-row">
                            <label>Número da Casa</label>
                            <input class="input-field" type="text" name="num_casa">
                        </div>

                         <div class="form-row">
                            <label>Nacionalidade</label>
                            <input class="input-field" type="text" name="nacionalidade">
                        </div>
               

                    </div>

                    <!-- Coluna 2 -->
                    <div>
                        
                        <div class="form-row">
                            <label>CPF</label>
                            <input class="input-field" type="text" name="cpf" required>
                        </div>
                        <div class="form-row">
                            <label>RG</label>
                            <input class="input-field" type="text" name="rg" required>
                        </div>
                        <div class="form-row">
                            <label>CNH</label>
                            <input class="input-field" type="text" name="cnh" required>
                        </div>
                        <div class="form-row">
                            <label>Telefone Principal</label>
                            <input class="input-field" type="text" name="telefone_1" required>
                        </div>
                        <div class="form-row">
                            <label>Telefone de Emergência</label>
                            <input class="input-field" type="text" name="telefone_emergencia" required>
                        </div>
                        <div class="form-row">
                            <label>E-mail</label>
                            <input class="input-field" type="email" name="email" required>
                        </div>
                        <div class="form-row">
                            <label>Naturalidade</label>
                            <input class="input-field" type="text" name="naturalidade" required>
                        </div>

                        <div class="form-row">
                            <label>CEP</label>
                            <input class="input-field" type="text" name="cep" required>
                        </div>

                        <div class="form-row">
                            <label>Estado</label>
                            <input class="input-field" type="text" name="estado" required>
                        </div>

                         <div class="form-row">
                            <label>Bairro</label>
                            <input class="input-field" type="text" name="bairro" required>
                        </div>
                        
                        <!-- Campo de upload de imagem -->
                        <div class="form-row">
                            <label>Imagem do Funcionário</label>
                            <input class="input-field" type="file" name="imagem" accept="image/*" required>
                        </div>



                    </div>
                </div>

                <!-- Campos que ocupam a largura total -->
               

                <!-- Campos dos filhos -->
                <div id="filhos-container">
                    <div class="form-row">
                        <label>Nome do Filho 1</label>
                        <input class="input-field" type="text" name="filho1">
                    </div>
                    <div class="form-row">
                        <label>Data de Nascimento do Filho 1</label>
                        <input class="input-field" type="date" name="data_nascimento_filho1">
                    </div>
                </div>

                <button type="button" onclick="adicionarFilho()">Adicionar Filho</button>
                

                <!-- Botões -->
                <input type="hidden" name="usuario_registro" value="<?= $usuario_email ?>">
                <input type="hidden" name="nome_usuario" value="<?= $nome_usuario ?>">
                <button class="submit-btn" type="submit">Cadastrar</button>
                <div class="button-container">
                    <a class="button" href="/usuario/admin/rh/menu_funcionarios.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>