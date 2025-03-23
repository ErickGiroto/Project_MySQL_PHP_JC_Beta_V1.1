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
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Empresa</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/cadastro_empresa.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <div class="form-container">
            <h2>Cadastrar Empresa</h2>
            <form action="cadastro_empresa_processa.php" method="POST">
                <!-- Campos distribuídos em duas colunas -->
                <div class="form-grid">
                    <div class="form-row">
                        <label>Razão Social</label>
                        <input class="input-field" type="text" name="razao_social" required>
                    </div>

                    <div class="form-row">
                        <label>CNPJ</label>
                        <input class="input-field" type="text" name="cnpj" required>
                    </div>

                    <div class="form-row">
                        <label>Endereço</label>
                        <input class="input-field" type="text" name="endereco" required>
                    </div>

                    <div class="form-row">
                        <label>Bairro</label>
                        <input class="input-field" type="text" name="bairro" required>
                    </div>

                    <div class="form-row">
                        <label>Município</label>
                        <input class="input-field" type="text" name="municipio" required>
                    </div>

                    <div class="form-row">
                        <label>Estado</label>
                        <input class="input-field" type="text" name="estado" maxlength="2" required>
                    </div>

                    <div class="form-row">
                        <label>CEP</label>
                        <input class="input-field" type="text" name="cep" required>
                    </div>

                    <div class="form-row">
                        <label>País</label>
                        <input class="input-field" type="text" name="pais" required>
                    </div>

                    <div class="form-row">
                        <label>Número</label>
                        <input class="input-field" type="text" name="numero" required>
                    </div>

                    <div class="form-row">
                        <label>Observação (Opcional)</label>
                        <textarea class="input-field" name="observacao"></textarea>
                    </div>
                </div>

                <!-- Campos ocultos -->
                <input type="hidden" name="usuario_registro" value="<?= $usuario_email ?>">
                <input type="hidden" name="nome_usuario" value="<?= $nome_usuario ?>">

                <!-- Botão de envio -->
                <button class="submit-btn" type="submit">Cadastrar</button>

                <!-- Botão Voltar -->
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