<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: consulta_empresa.php");
    exit;
}

$id = (int) $_GET['id'];

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Busca os dados da empresa
$stmt = $conn->prepare("SELECT id, razao_social, cnpj, endereco, bairro, municipio, estado, cep, pais, numero, observacao FROM empresas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $razao_social, $cnpj, $endereco, $bairro, $municipio, $estado, $cep, $pais, $numero, $observacao);

if (!$stmt->fetch()) {
    header("Location: consulta_empresa.php");
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
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/editar_empresa.css">
</head>
<body class="corpo_body">
    <div class="main-container">
        <h2>Editar Empresa</h2>
        <form action="editar_empresa_processa.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">

            <!-- Duas colunas para os campos do formulário -->
            <div class="form-grid">
                <!-- Coluna 1 -->
                <div class="form-column">
                    <div class="form-row">
                        <label>Razão Social</label>
                        <input class="input-field" type="text" name="razao_social" value="<?= $razao_social ?>" required>
                    </div>

                    <div class="form-row">
                        <label>CNPJ</label>
                        <input class="input-field" type="text" name="cnpj" value="<?= $cnpj ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Endereço</label>
                        <input class="input-field" type="text" name="endereco" value="<?= $endereco ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Bairro</label>
                        <input class="input-field" type="text" name="bairro" value="<?= $bairro ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Município</label>
                        <input class="input-field" type="text" name="municipio" value="<?= $municipio ?>" required>
                    </div>
                </div>

                <!-- Coluna 2 -->
                <div class="form-column">
                    <div class="form-row">
                        <label>Estado</label>
                        <input class="input-field" type="text" name="estado" value="<?= $estado ?>" maxlength="2" required>
                    </div>

                    <div class="form-row">
                        <label>CEP</label>
                        <input class="input-field" type="text" name="cep" value="<?= $cep ?>" required>
                    </div>

                    <div class="form-row">
                        <label>País</label>
                        <input class="input-field" type="text" name="pais" value="<?= $pais ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Número</label>
                        <input class="input-field" type="text" name="numero" value="<?= $numero ?>" required>
                    </div>

                    <div class="form-row">
                        <label>Observação (Opcional)</label>
                        <textarea class="input-field" name="observacao"><?= $observacao ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Botão de envio -->
            <button class="submit-btn" type="submit">Salvar Alterações</button>

            <!-- Botão Voltar -->
            <div class="button-container">
                <a class="button" href="/usuario/admin/comercial/consulta_empresa.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</body>
</html>