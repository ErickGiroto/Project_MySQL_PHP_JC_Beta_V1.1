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

// Busca as razoes sociais das empresas cadastradas
$result_empresas = $conn->query("SELECT razao_social, cnpj FROM empresas");
$empresas = [];
while ($row = $result_empresas->fetch_assoc()) {
    $empresas[] = $row;
}

// Busca os códigos dos produtos cadastrados
$result_produtos = $conn->query("SELECT cod, produto, tipo, tipo_alimento FROM produto_tipo");
$produtos = [];
while ($row = $result_produtos->fetch_assoc()) {
    $produtos[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pedido</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/cadastro_pedidos.css">
    <script>
        function preencherEmpresa() {
            var razaoSocialSelecionada = document.getElementById("razao_social").value;
            if (razaoSocialSelecionada) {
                fetch('buscar_empresa.php?razao_social=' + razaoSocialSelecionada)
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) {
                            alert(data.erro);
                        } else {
                            document.getElementById("cnpj").value = data.cnpj;
                        }
                    })
                    .catch(error => console.error('Erro na busca da empresa:', error));
            }
        }

        function preencherProduto() {
            var codSelecionado = document.getElementById("codigo_produto").value;
            if (codSelecionado) {
                fetch('buscar_produto.php?cod=' + codSelecionado)
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
                    .catch(error => console.error('Erro na busca do produto:', error));
            }
        }

        function calcularValorTotal() {
            var quantidade = parseFloat(document.getElementById("quantidade").value);
            var valorUnitario = parseFloat(document.getElementById("valor_unitario").value);
            var valorTotal = quantidade * valorUnitario;
            document.getElementById("valor_total").value = valorTotal.toFixed(2);
        }
    </script>
</head>
<body class="corpo_body">
    <div class="main-container">
        <div class="form-container">
            <h2>Cadastrar Pedido</h2>
            <form action="cadastro_pedidos_processa.php" method="POST">
                <div class="form-grid">
                    <!-- Coluna 1 -->
                    <div>
                        <div class="form-row">
                            <label>Razão Social</label>
                            <select id="razao_social" name="razao_social" class="input-field" onchange="preencherEmpresa()" required>
                                <option value="">Selecione uma empresa</option>
                                <?php foreach ($empresas as $empresa) : ?>
                                    <option value="<?= $empresa['razao_social'] ?>"><?= $empresa['razao_social'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <label>Código do Produto</label>
                            <select id="codigo_produto" name="codigo_produto" class="input-field" onchange="preencherProduto()" required>
                                <option value="">Selecione um código</option>
                                <?php foreach ($produtos as $produto) : ?>
                                    <option value="<?= $produto['cod'] ?>"><?= $produto['cod'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        

                        <div class="form-row">
                            <label>Número do Pedido</label>
                            <input class="input-field" type="text" name="num_pedido" required>
                        </div>

                        <div class="form-row">
                            <label>Quantidade</label>
                            <input id="quantidade" class="input-field" type="number" name="quantidade" oninput="calcularValorTotal()" required>
                        </div>

                        <div class="form-row">
                            <label>Valor Unitário Reais (R$)</label>
                            <input id="valor_unitario" class="input-field" type="number" step="0.01" name="valor_unitario" oninput="calcularValorTotal()" required>
                        </div>

                        <div class="form-row">
                            <label>Valor Total Reais (R$)</label>
                            <input id="valor_total" class="input-field" type="text" name="valor_total" readonly>
                        </div>
                    </div>

                    <!-- Coluna 2 -->
                    <div>
                        <div class="form-row">
                            <label>CNPJ</label>
                            <input id="cnpj" class="input-field" type="text" name="cnpj" readonly>
                        </div>

                        <div class="form-row">
                            <label>Produto</label>
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
                            <label>Data de Entrega</label>
                            <input class="input-field" type="date" name="data_de_entrega" required>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <input type="hidden" name="usuario_registro" value="<?= $usuario_email ?>">
                <input type="hidden" name="nome_usuario" value="<?= $nome_usuario ?>">
                <button class="submit-btn" type="submit">Cadastrar</button>
                <div class="button-container">
                    <a class="button" href="/usuario/admin/comercial/menu_comercial.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>