<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Busca os dados do usuário logado
$stmt = $conn->prepare("SELECT email, nome_completo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($usuario_email, $nome_usuario);
$stmt->fetch();
$stmt->close();

// Busca os CNPJs e Razões Sociais da tabela 'empresas'
$result_empresas = $conn->query("SELECT cnpj, razao_social FROM empresas");
$empresas = [];
while ($row = $result_empresas->fetch_assoc()) {
    $empresas[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/cadastro_cliente.css">
    <script>
        function preencherRazaoSocial() {
            let cnpjSelecionado = document.getElementById("cnpj").value;
            let empresas = <?= json_encode($empresas) ?>;
            
            let razaoInput = document.getElementById("razao_social");
            let empresaEncontrada = empresas.find(emp => emp.cnpj === cnpjSelecionado);
            
            if (empresaEncontrada) {
                razaoInput.value = empresaEncontrada.razao_social;
            } else {
                razaoInput.value = "";
            }
        }

        function validarFormulario() {
            let cnpj = document.getElementById("cnpj").value;
            if (cnpj === "") {
                alert("O campo CNPJ é obrigatório!");
                return false; // Impede o envio do formulário
            }
            return true; // Permite o envio do formulário
        }
    </script>
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <h2>Cadastrar Cliente</h2>
            <form action="cadastro_cliente_processa.php" method="POST" onsubmit="return validarFormulario()">
                <div class="form-row">
                    <label>CNPJ</label>
                    <select class="input-field" name="cnpj" id="cnpj" onchange="preencherRazaoSocial()" required>
                        <option value="">Selecione um CNPJ</option>
                        <?php foreach ($empresas as $empresa) : ?>
                            <option value="<?= $empresa['cnpj'] ?>"><?= $empresa['cnpj'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <label>Razão Social</label>
                    <input class="input-field" type="text" id="razao_social" name="razao_social" readonly required>
                </div>

                <div class="form-row">
                    <label>Nome</label>
                    <input class="input-field" type="text" name="nome" required>
                </div>

                <div class="form-row">
                    <label>Telefone 1</label>
                    <input class="input-field" type="text" name="telefone1" required>
                </div>

                <div class="form-row">
                    <label>Telefone 2 (Opcional)</label>
                    <input class="input-field" type="text" name="telefone2">
                </div>

                <div class="form-row">
                    <label>Email</label>
                    <input class="input-field" type="email" name="email" required>
                </div>

                <div class="form-row">
                    <label>Departamento</label>
                    <input class="input-field" type="text" name="departamento" required>
                </div>

                <div class="form-row">
                    <label>Observação (Opcional)</label>
                    <textarea class="input-field" name="observacao"></textarea>
                </div>

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
