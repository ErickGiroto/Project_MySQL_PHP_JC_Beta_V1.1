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
    <title>Administração - Comercial</title>
    <link rel="stylesheet" href="/usuario/admin/css/comercial/menu_comercial.css">
</head>

<body>
   <!-- Contêiner da logo -->
    <div class="logo-container">
        <!-- img src="/midias/image/logo/image_logo.png" alt="Logo da Empresa" class="logo"> -->
        <h1 class="welcome_title" >Bem-vindo, <span class="fonte"> <?php echo $_SESSION['nome_usuario']; ?> </span>! </h1>
    

    <!--------------------------------Admin--------------------------------->
        <?php if ($tipo_usuario === "admin"): ?>
        <h2 class="section_title">Seção de Administração</h2>
        <p class="section_description">Aqui você pode gerenciar o comercial!</p>
        <div class="button-container">

            <!---------------------Grupo 01---------------------->
            <div class="button-container_admin">
                <a href="/usuario/admin/comercial/cadastro_pedidos.php">
                    <img src="/midias/image/icon/icone_pedido_cadastro.png" alt="Cadastrar Pedidos">
                    Cadastrar Pedidos (Produção)
                </a>

                <a href="/usuario/admin/comercial/consulta_pedido.php">
                    <img src="/midias/image/icon/icone_busca.png" alt="Consulta Pedidos">
                    Consulta Pedidos (Produção)
                </a> 

                <a href="/usuario/admin/comercial/consulta_pedido_filtro.php">
                    <img src="/midias/image/icon/icone_orcamento_cadastro.png" alt="Filtro Consulta Pedido">
                    Imprimir Pedido
                </a>
         

                 <a href="/usuario/admin/comercial/cadastro_cliente.php">
                    <img src="/midias/image/icon/icone_cliente_cadastro.png" alt="Cadastrar Cliente">
                    Cadastrar Cliente
                </a>
                 



            </div>

            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">

                <a href="/usuario/admin/comercial/consulta_cliente.php">
                    <img src="/midias/image/icon/icone_cliente_consulta.png" alt="Consulta Cliente">
                    Consulta Cliente
                </a>

                <a href="/usuario/admin/comercial/cadastro_empresa.php">
                    <img src="/midias/image/icon/icone_empresa_cadastro.png" alt="Cadastrar Empresa">
                    Cadastrar Empresa
                </a>

                <a href="/usuario/admin/comercial/consulta_empresa.php">
                    <img src="/midias/image/icon/icone_empresas_consulta.png" alt="Consulta Empresa">
                    Consulta Empresa
                </a>

               
                

                 <a href="#">
                    <img src="/midias/image/icon/icone_orcamento_consulta.png" alt="Consulta Orçamento">
                    Consulta Orçamento
                </a>


            </div>


            <!---------------------Grupo 02---------------------->
            <div class="button-container_admin">
                
                <a href="#">
                    <img src="/midias/image/icon/icone_estoque_consulta.png" alt="Consulta de Produtos">
                    Consulta de Produtos
                </a> 

                <a href="#">
                    <img src="/midias/image/icon/icone_relatorio_cadastro.png" alt="Criar Relatório">
                    Criar Relatório
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