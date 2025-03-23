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
    // Se o usuário não for encontrado
    echo "Usuário não encontrado!";
    exit;
}

$stmt->close();

// Busca os códigos dos produtos cadastrados
$result = $conn->query("SELECT cod FROM produto_tipo");
$codigos = [];
while ($row = $result->fetch_assoc()) {
    $codigos[] = $row['cod'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto no Estoque</title>
    <link rel="stylesheet" href="/usuario/admin/css/estoque/cadastro_produto_estoque.css">
    <script>
        function preencherDados() {
            var codigoSelecionado = document.getElementById("codigo").value;
            if (codigoSelecionado) {
                fetch('cadastra_produto_busca_tipo.php?codigo=' + codigoSelecionado)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert(data.erro);
                    } else {
                        document.getElementById("produto").value = data.produto;
                        document.getElementById("tipo").value = data.tipo;
                        document.getElementById("tipo_alimento").value = data.tipo_alimento;
                    }
                })
                .catch(error => console.error('Erro na busca:', error));
            }
        }
    </script>
</head>
<body class="corpo_body">
    <div class="main-container">
        <div class="form-container">
            <h2>Cadastrar Produto no Estoque</h2>
            <form action="cadastro_produto_estoque_processa.php" method="POST">
                <div class="form-row">
                    <label>Código do Produto</label>
                    <select id="codigo" name="codigo" class="input-field" onchange="preencherDados()" required>
                        <option value="">Selecione um código</option>
                        <?php foreach ($codigos as $codigo) : ?>
                            <option value="<?= $codigo ?>"><?= $codigo ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Nome do Produto</label>
                    <input id="produto" class="input-field" type="text" name="produto" readonly>
                </div>

                <div class="form-row">
                    <label>Tipo do Produto</label>
                    <input id="tipo" class="input-field" type="text" name="tipo" readonly>
                </div>

                <div class="form-row">
                    <label>Tipo de Alimento</label>
                    <input id="tipo_alimento" class="input-field" type="text" name="tipo_alimento" readonly>
                </div>

                <div class="form-row">
                    <label>Quantidade</label>
                    <input class="input-field" type="number" name="quantidade" required>
                </div>

                <input type="hidden" name="usuario_registro" value="<?= $usuario_email ?>">
                <input type="hidden" name="nome_usuario" value="<?= $nome_usuario ?>">

                <button class="submit-btn" type="submit">Cadastrar</button>

                <div class="button-container">
                    <a class="button" href="/usuario/admin/estoque/menu_estoque.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>
