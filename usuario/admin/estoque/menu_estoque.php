<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Estoque</title>
    <link rel="stylesheet" href="/usuario/admin/css/estoque/menu_estoque.css">
</head>

<body>
   <!-- Contêiner da logo -->
    <div class="logo-container">
        <!-- img src="/midias/image/logo/image_logo.png" alt="Logo da Empresa" class="logo"> -->
        <h1 class="welcome_title" >Bem-vindo, <span class="fonte"> <?php echo $_SESSION['nome_usuario']; ?> </span>! </h1>
    

    <!--------------------------------Admin--------------------------------->
        <?php if ($tipo_usuario === "admin"): ?>
        <h2 class="section_title">Seção de Administração</h2>
        <p class="section_description">Aqui você pode gerenciar o estoque!</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="/usuario/admin/estoque/cadastra_produto_tipo.php">
                    <img src="/midias/image/icon/icone_estoque_cadastro_tipos.png" alt="Cadastro de Tipos">
                    Cadastro de Tipos
                </a>

                <a href="/usuario/admin/estoque/consulta_produto_tipo.php">
                    <img src="/midias/image/icon/icone_estoque_consulta_tipos.png" alt="Consulta de Tipos">
                    Consulta de Tipos
                </a>

                <a href="/usuario/admin/estoque/cadastro_produto_estoque.php">
                    <img src="/midias/image/icon/icone_estoque_cadastro.png" alt="Cadastro de Produtos">
                    Cadastro de Produtos
                </a>

                <a href="/usuario/admin/estoque/consulta_produto_estoque.php">
                    <img src="/midias/image/icon/icone_estoque_consulta.png" alt="Consulta de Produtos">
                    Consulta de Produtos
                </a>             
            </div>


            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">
                <a href="/usuario/portal_usuario.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>

                <a href="/usuario/logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </div>

        </div>
    </div>


  <?php endif; ?>
</body>

</html>