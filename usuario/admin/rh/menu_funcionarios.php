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
    <title>Administração - Recursos Humanos</title>
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
        <p class="section_description">Registro de Funcionário</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="/usuario/admin/rh/cadastro_funcionario.php">
                    <img src="/midias/image/icon/icone_registro_funcionario.png" alt="Cadastro de funcionario">
                    Cadastrar Funcionário
                </a>

                <a href="/usuario/admin/rh/consulta_funcionario.php">
                    <img src="/midias/image/icon/icone_consulta_funcionario.png" alt="Consulta de funcionario">
                    Consulta Funcionário
                </a>

                <a href="/usuario/admin/rh/menu_rh.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </div>        
        </div>
    </div>


  <?php endif; ?>
</body>

</html>