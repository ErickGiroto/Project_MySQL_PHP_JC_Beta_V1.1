<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_usuario.php");
    exit;
}

$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Usuário</title>
    <link rel="stylesheet" href="css/portal_usuario.css">
</head>

<body>
    <!-- Contêiner da logo -->
    <div class="logo-container">
        <!-- img src="/midias/image/logo/image_logo.png" alt="Logo da Empresa" class="logo"> -->
        <h1 class="welcome_title" >Bem-vindo, <span class="fonte"> <?php echo $_SESSION['nome_usuario']; ?> </span>! </h1>
    

    <!--------------------------------Admin--------------------------------->
        <?php if ($tipo_usuario === "admin"): ?>
        <h2 class="section_title">Seção de Administração</h2>
        <p class="section_description">Aqui você pode gerenciar usuários, produtos e relatórios.</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="/usuario/admin/estoque/menu_estoque.php">
                    <img src="/midias/image/icon/icone_estoque_menu.png" alt="Menu Estoque">
                    Menu Estoque
                </a>

                 <a href="/usuario/admin/usuarios/menu_usuario.php">
                    <img src="/midias/image/icon/icone_usuario_menu.png" alt="Menu Usuários">
                    Menu Usuários
                </a>

                <a href="/usuario/admin/comercial/menu_comercial.php">
                    <img src="/midias/image/icon/icone_comercial_menu.png" alt="Menu Comercial">
                    Menu Comercial
                </a>

                <a href="/usuario/admin/rh/menu_rh.php">
                    <img src="/midias/image/icon/icone_rh_menu.png" alt="Menu Recursos Humanos">
                    Menu Recursos Humanos
                </a>                         
            </div>
       
            <!---------------------Grupo 05---------------------->
            <div class="button-container_admin">
                <a href="portal_usuario_editar.php">
                    <img src="/midias/image/icon/icone_editar_perfil.png" alt="Editar Perfil">
                    Editar Perfil
                </a>

                <a href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </div>

        </div>

    <!--------------------------------Gerencia--------------------------------->
        <?php elseif ($tipo_usuario === "gerencia"): ?>
        <h2 class="section_title">Seção de Gerência</h2>
        <p class="section_description">Aqui você pode gerenciar a estratégia da empresa e tomar decisões importantes.</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_cadastro.png" alt="Cadastrar Produtos">
                    Cadastrar Produtos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_busca.png" alt="Consulta Produtos">
                    Consulta Produtos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_pedido_cadastro.png" alt="Cadastrar Pedidos">
                    Cadastrar Pedidos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_busca.png" alt="Consulta Pedidos">
                    Consulta Pedidos
                </a>
            </div>

            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_cliente_cadastro.png" alt="Cadastrar Cliente">
                    Cadastrar Cliente
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_cliente_consulta.png" alt="Consulta Cliente">
                    Consulta Cliente
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_empresa_cadastro.png" alt="Cadastrar Empresa">
                    Cadastrar Empresa
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_empresas_consulta.png" alt="Consulta Empresa">
                    Consulta Empresa
                </a>
            </div>

            <!---------------------Grupo 03---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_registro_funcionario.png" alt="Cadastro de funcionario">
                    Cadastrar Funcionário
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_consulta_funcionario.png" alt="Consulta de funcionario">
                    Consulta Funcionário
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_cadastro_usuario.png" alt="Cadastrar Usuário">
                    Cadastrar Usuário
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_consulta_usuario.png" alt="Consulta Usuário">
                    Consulta Usuário
                </a>
            </div>

            <!---------------------Grupo 04---------------------->
            <div class="button-container_admin">

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_cadastro.png" alt="Criar Relatório">
                    Criar Relatório
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_consulta.png" alt="Consulta Relatório">
                    Consulta Relatório
                </a>

                <a href="portal_usuario_editar.php">
                    <img src="/midias/image/icon/icone_editar_perfil.png" alt="Editar Perfil">
                    Editar Perfil
                </a>

                <a href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>

            </div>
        </div>

    <!--------------------------------Estoque--------------------------------->
        <?php elseif ($tipo_usuario === "estoque"): ?>
        <h2 class="section_title">Seção de Estoque</h2>
        <p class="section_description">Aqui você pode gerenciar o estoque de produtos.</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_cadastro.png" alt="Cadastrar Tipos de Produtos">
                    Cadastrar Tipos de Produtos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_busca.png" alt="Consulta Tipos de Produtos">
                    Consulta Tipos de Produtos
                </a>
            </div>

             <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_cadastro.png" alt="Cadastrar Produtos">
                    Cadastrar Produtos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_busca.png" alt="Consulta Produtos">
                    Consulta Produtos
                </a>
            </div>

           

            <!---------------------Grupo 03---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_busca.png" alt="Consulta Pedidos">
                    Consulta Pedidos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_consulta.png" alt="Consulta Relatório">
                    Consulta Relatório
                </a>
            </div>

            <!---------------------Grupo 03---------------------->
            <div class="button-container_admin">
                <a href="portal_usuario_editar.php">
                    <img src="/midias/image/icon/icone_editar_perfil.png" alt="Editar Perfil">
                    Editar Perfil
                </a>

                <a href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </div>
        </div>
        
    <!--------------------------------RH--------------------------------->
        <?php elseif ($tipo_usuario === "rh"): ?>      
        <h2 class="section_title">Seção de Recursos Humanos</h2>
        <p class="section_description">Aqui você pode gerenciar os funcionários e a folha de pagamento.</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_folha_pagamento.png" alt="Cadastrar Folha de Pagamento">
                    Cadastrar Folha de Pagamento
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_folha_pagamento.png" alt="Consulta Folha de Pagamento">
                    Consulta Folha de Pagamento
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_registro_funcionario.png" alt="Cadastro de funcionario">
                    Cadastro de Funcionário
                </a>
            </div>

            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">

                <a href="#">
                    <img src="/midias/image/icon/icone_consulta_funcionario.png" alt="Consulta de funcionario">
                    Consulta de Funcionário
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_cadastro.png" alt="Criar Relatório">
                    Criar Relatório
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_consulta.png" alt="Consulta Relatório">
                    Consulta Relatório
                </a>
            </div>

            <!---------------------Grupo 03---------------------->
            <div class="button-container_admin">

                <a href="portal_usuario_editar.php">
                    <img src="/midias/image/icon/icone_editar_perfil.png" alt="Editar Perfil">
                    Editar Perfil
                </a>

                <a href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </div>
        </div>


    <!--------------------------------Comercial--------------------------------->
        <?php elseif ($tipo_usuario === "comercial"): ?>
        <h2 class="section_title">Seção Comercial</h2>
        <p class="section_description">Aqui você pode gerenciar vendas e interações com clientes.</p>
        <div class="button-container">
            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">

                <a href="#">
                    <img src="/midias/image/icon/icone_busca.png" alt="Consulta de Pedidos">
                    Consulta de Pedidos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_pedido_cadastro.png" alt="Cadastro de Pedidos">
                    Cadastro de Pedidos
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_cliente_consulta.png" alt="Consulta Cliente">
                    Consulta Cliente
                </a>
            </div>

            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_cliente_cadastro.png" alt="Cadastrar Cliente">
                    Cadastrar Cliente
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_empresas_consulta.png" alt="Consulta Empresa">
                    Consulta Empresa
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_empresa_cadastro.png" alt="Cadastrar Empresa">
                    Cadastrar Empresa
                </a>
            </div>

            <!---------------------Grupo 03---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_orcamento_consulta.png" alt="Consulta Orçamento">
                    Consulta Orçamento
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_orcamento_cadastro.png" alt="Cadastro Orçamento">
                    Cadastro Orçamento
                </a>

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_cadastro.png" alt="Criar Relatório">
                    Criar Relatório
                </a>
            </div>

            <!---------------------Grupo 03---------------------->
            <div class="button-container_admin">
                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_consulta.png" alt="Consulta Relatório">
                    Consulta Relatório
                </a>

                <a href="portal_usuario_editar.php">
                    <img src="/midias/image/icon/icone_editar_perfil.png" alt="Editar Perfil">
                    Editar Perfil
                </a>

                <a href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>

            </div>
        </div>

    <!--------------------------------Usuários--------------------------------->
        <?php else: ?>
        <h2 class="section_title">Seção Funcionário</h2>
        <p class="section_description">Aqui você pode acessar suas tarefas diárias.</p>
        <div class="button-container">
        
            <div class="button-container_admin">
                <a href="/usuario/funcionario/consulta_pedido.php">
                    <img src="/midias/image/icon/icone_busca.png" alt="Consulta de Pedidos">
                    Pedidos Individuais
                </a>

                <a href="/usuario/funcionario/consulta_pedido_filtro.php">
                    <img src="/midias/image/icon/icone_orcamento_cadastro.png" alt="Filtro Consulta Pedido">
                    Filtro de Pedidos
                </a>


                <a href="portal_usuario_editar.php">
                    <img src="/midias/image/icon/icone_editar_perfil.png" alt="Editar Perfil">
                    Editar Perfil
                </a>
                <a href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </div>
        </div>
    </div>

    <?php endif; ?>

</body>

</html>