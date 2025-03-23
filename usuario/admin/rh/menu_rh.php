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
    <link rel="stylesheet" href="/usuario/admin/css/rh/menu_rh.css">
</head>

<body>
   <!-- Contêiner da logo -->
    <div class="logo-container">
        <!-- img src="/midias/image/logo/image_logo.png" alt="Logo da Empresa" class="logo"> -->
        <h1 class="welcome_title" >Bem-vindo, <span class="fonte"> <?php echo $_SESSION['nome_usuario']; ?> </span>! </h1>
    

    <!--------------------------------Admin--------------------------------->
        <?php if ($tipo_usuario === "admin"): ?>
        <h2 class="section_title">Seção de Administração</h2>
        <p class="section_description">Aqui você pode gerenciar o rh!</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="/usuario/admin/rh/menu_funcionarios.php">
                    <img src="/midias/image/icon/icone_registro_funcionario.png" alt="Funcionário">
                    Funcionário
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_folha_pagamento.png" alt="Cadastrar Folha de Pagamento">
                    Cadastrar Folha de Pagamento
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_folha_pagamento.png" alt="Consulta Folha de Pagamento">
                    Consulta Folha de Pagamento
                </a>   
       
            </div>


            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_consulta.png" alt="Consulta Relatório">
                    Consulta Relatório
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