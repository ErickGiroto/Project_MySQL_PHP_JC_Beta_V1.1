<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Usuário</title>
    <link rel="stylesheet" href="css/recuperacao_senha.css">
</head>

<body>

     <!-- Título principal -->
    <h1 class="font">Bem-vindo ao Sistema!</h1>


    <div class="corpo_body">
         <div class="main-container">

    <!-- Links à direita do formulário -->
        <div class="link-container">
             <p class="forgot-password">
                <a class="link" href="/index.html">
                    <img src="/midias/image/icon/icone_menu.png" alt="Ícone Home">
                    Home/Inicio
                </a>
            </p>


            <p class="forgot-password">
                <a class="link" href="login_usuario.php">
                    <img src="/midias/image/icon/icone_login_usuario.png" alt="Ícone Entrar">
                    Possui conta? Clique aqui
                </a>
            </p>
           
        </div>
















        <!-- Formulário de recuperação de senha -->
        <div class="form-container">
            <form action="recupera_usuario_processa.php" method="POST">
                <h2 class="font">Recuperação de Senha</h2>

                <div class="input-group">
                    <img src="/midias/image/icon/icone_email.png" alt="Ícone E-mail">
                    <input class="input-field" type="email" name="email" placeholder="E-mail" required>
                </div>

                <h3 class="font">Perguntas de Segurança</h3>

                <div class="input-group">
                    <img src="/midias/image/icon/icone_senha.png" alt="Ícone Pergunta 1">
                    <input class="input-field" type="text" name="resposta1" placeholder="Resposta para a Pergunta 1" required>
                </div>

                <div class="input-group">
                    <img src="/midias/image/icon/icone_senha.png" alt="Ícone Pergunta 2">
                    <input class="input-field" type="text" name="resposta2" placeholder="Resposta para a Pergunta 2" required>
                </div>

                <div class="input-group">
                    <img src="/midias/image/icon/icone_senha.png" alt="Ícone Pergunta 3">
                    <input class="input-field" type="text" name="resposta3" placeholder="Resposta para a Pergunta 3" required>
                </div>

                <button class="submit-button" type="submit">Recuperar Senha</button>

            </form>
        </div>
    </div>

    </div>


   
</body>
</html>
