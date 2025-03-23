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
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="/usuario/admin/css/usuario/cadastro_usuario.css">
</head>

<body>
    <div class="main-container">

    <!-- Links à direita do formulário -->
        <div class="link-container">
            <p class="forgot-password">
                <a class="link" href="/usuario/admin/usuarios/menu_usuario.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </p>

            <p class="forgot-password">
                <a class="link" href="/usuario/logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Voltar">
                    Sair
                </a>
            </p>
            
           
        </div>

        <!-- Formulário de Cadastro -->
        <div class="form-container">
            <form action="cadastro_usuario_processa.php" method="POST">
                <h2>Cadastro de Usuário</h2>

                <div class="form-row">
                    <input class="input-field" type="text" name="nome_completo" placeholder="Nome Completo" required>
                    <input class="input-field" type="password" name="senha" placeholder="Senha" required>
                    <input class="input-field" type="email" name="email" placeholder="E-mail" required>
                    

                </div>

                <h3 class="section-title">Perguntas de Segurança</h3>
                
                <div class="form-row">
                    <select class="select-field" name="pergunta1" required>
                        <option value="">Pergunta 1</option>
                        <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                        <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                        <option value="Qual foi o modelo do seu primeiro carro?">Qual foi o modelo do seu primeiro carro?</option>
                        <option value="Qual é o nome da sua cidade natal?">Qual é o nome da sua cidade natal?</option>
                        <option value="Qual é o nome do seu melhor amigo de infância?">Qual é o nome do seu melhor amigo de infância?</option>
                    </select>
                    <input class="input-field" type="text" name="resposta1" placeholder="Resposta" required>
                </div>

                <div class="form-row">
                    <select class="select-field" name="pergunta2" required>
                        <option value="">Pergunta 2</option>
                        <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                        <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                        <option value="Qual foi o modelo do seu primeiro carro?">Qual foi o modelo do seu primeiro carro?</option>
                        <option value="Qual é o nome da sua cidade natal?">Qual é o nome da sua cidade natal?</option>
                        <option value="Qual é o nome do seu melhor amigo de infância?">Qual é o nome do seu melhor amigo de infância?</option>
                    </select>
                    <input class="input-field" type="text" name="resposta2" placeholder="Resposta" required>
                </div>

                <div class="form-row">
                    <select class="select-field" name="pergunta3" required>
                        <option value="">Pergunta 3</option>
                        <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                        <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                        <option value="Qual foi o modelo do seu primeiro carro?">Qual foi o modelo do seu primeiro carro?</option>
                        <option value="Qual é o nome da sua cidade natal?">Qual é o nome da sua cidade natal?</option>
                        <option value="Qual é o nome do seu melhor amigo de infância?">Qual é o nome do seu melhor amigo de infância?</option>
                    </select>
                    <input class="input-field" type="text" name="resposta3" placeholder="Resposta" required>
                </div>

                <p class="alerta">
                    <span class="format"> Alerta: Perda de Senha </span>  <br><br>
                    Aviso Importante: Se você perder sua senha, não será possível recuperá-la. Para proteger sua conta, recomendamos que você guarde sua senha com segurança.
                    Caso tenha perdido sua senha, será necessário realizar o processo de criação de uma nova conta ou seguir as instruções específicas da plataforma para redefinir sua senha,
                    ou comunicar seu gestor!
                    <br><br> Por favor, tome precauções para evitar a perda de suas informações de acesso.
                </p>
                <br>
                <select class="select-field" name="tipo_usuario">
                    <option value="admin">Administrador</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="gerencia">Gerencia</option>
                    <option value="estoque">Estoque</option>
                    <option value="rh">Recursos Humanos</option>
                    <option value="comercial">Comercial</option>

                 </select><br>
                 <br>

                <button class="submit-button" type="submit">Cadastrar</button>
            </form>
        </div>

        
    </div>
</body>

</html>
