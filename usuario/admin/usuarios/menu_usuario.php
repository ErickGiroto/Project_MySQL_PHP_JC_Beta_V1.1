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
    <title>Administração - Usuário</title>
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
        <p class="section_description">Aqui você pode gerenciar os usuários!</p>
        <div class="button-container">
            <div class="button-container_admin">
                <a href="/usuario/admin/usuarios/cadastro_usuario.php">
                    <img src="/midias/image/icon/icone_cadastro_usuario.png" alt="Cadastrar Usuário">
                    Cadastrar Usuário
                </a>

                <a href="/usuario/admin/usuarios/consulta_usuario.php">
                    <img src="/midias/image/icon/icone_consulta_usuario.png" alt="Consulta Usuário">
                    Consulta Usuário
                </a>

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