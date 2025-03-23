<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_usuario.php"); // Se não estiver logado, redireciona para o login
    exit;
}

$nome_usuario = $_SESSION['nome_usuario']; // Recupera o nome do usuário da sessão
$usuario_id = $_SESSION['usuario_id']; // Recupera o id do usuário da sessão

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta para buscar as informações do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fechando a conexão com o banco de dados
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/portal_usuario_edita.css">
</head>

<body>
    <!-- Codigo para deixar o campo do nome na parte superior da pagina
    <div class="user-info">
        <span class="user-name">Olá, <?php echo htmlspecialchars($nome_usuario); ?>!</span>
        <a href="logout.php" class="logout-button">Sair</a>
    </div>

    -->

    <div class="main-container">
        

        <div class="link-container">
            <!-- Menu Lateral -->
            <p class="forgot-password">
                <a class="link" href="portal_usuario.php">
                    <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                    Voltar
                </a>
            </p>

            <p class="forgot-password">
                <a class="link" href="logout.php">
                    <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                    Sair
                </a>
            </p>
        </div>



        <div>
           

            <!-- Formulário de Edição -->
            <div class="form-container">
                <h2 class="fonth2">Olá <?php echo htmlspecialchars($nome_usuario); ?>! Bem vindo(a) á tela de modificação.</h2>
                

                <form action="portal_usuario_editar_processa.php" method="post">

                    <!-- Exibição de mensagens de sucesso ou erro -->
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="success-message">
                            <?php 
                            echo $_SESSION['success_message']; 
                            unset($_SESSION['success_message']); // Remove a mensagem após exibição
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="error-message">
                            <?php 
                            echo $_SESSION['error_message']; 
                            unset($_SESSION['error_message']); // Remove a mensagem após exibição
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-row">                        
                        <input class="input-field" type="text" id="nome_completo" name="nome_completo" value="<?php echo htmlspecialchars($user['nome_completo']); ?>" placeholder="Nome Completo">
                        <input class="input-field" type="password" id="senha" name="senha" placeholder="Senha">
                        <input class="input-field" type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="E-mail">
                    </div>

                    <h3 class="section-title">Perguntas de Segurança</h3>

                    

                    <div class="form-row">                        
                        <select class="select-field" name="pergunta1" required>
                            <option value="<?php echo htmlspecialchars($user['pergunta1']); ?>" selected><?php echo htmlspecialchars($user['pergunta1']); ?></option>
                            <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                            <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                            <option value="Qual foi o modelo do seu primeiro carro?">Qual foi o modelo do seu primeiro carro?</option>
                            <option value="Qual é o nome da sua cidade natal?">Qual é o nome da sua cidade natal?</option>
                            <option value="Qual é o nome do seu melhor amigo de infância?">Qual é o nome do seu melhor amigo de infância?</option>
                        </select>
                        <input class="input-field" type="text" name="resposta1" value="<?php echo htmlspecialchars($user['resposta1']); ?>" placeholder="Resposta" required>
                    </div>   


                    <div class="form-row">
                        <select class="select-field" name="pergunta2" required>
                            <option value="<?php echo htmlspecialchars($user['pergunta2']); ?>" selected><?php echo htmlspecialchars($user['pergunta2']); ?></option>
                            <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                            <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                            <option value="Qual foi o modelo do seu primeiro carro?">Qual foi o modelo do seu primeiro carro?</option>
                            <option value="Qual é o nome da sua cidade natal?">Qual é o nome da sua cidade natal?</option>
                            <option value="Qual é o nome do seu melhor amigo de infância?">Qual é o nome do seu melhor amigo de infância?</option>
                        </select>
                            <input class="input-field" type="text" name="resposta2" value="<?php echo htmlspecialchars($user['resposta2']); ?>" placeholder="Resposta" required>
                    </div>
                    

                    <div class="form-row">
                            <select class="select-field" name="pergunta3" required>
                                <option value="<?php echo htmlspecialchars($user['pergunta3']); ?>" selected><?php echo htmlspecialchars($user['pergunta3']); ?></option>
                                <option value="Qual é o nome do seu primeiro animal de estimação?">Qual é o nome do seu primeiro animal de estimação?</option>
                                <option value="Qual é o nome da sua mãe?">Qual é o nome da sua mãe?</option>
                                <option value="Qual foi o modelo do seu primeiro carro?">Qual foi o modelo do seu primeiro carro?</option>
                                <option value="Qual é o nome da sua cidade natal?">Qual é o nome da sua cidade natal?</option>
                                <option value="Qual é o nome do seu melhor amigo de infância?">Qual é o nome do seu melhor amigo de infância?</option>
                            </select>
                            <input class="input-field" type="text" name="resposta3" value="<?php echo htmlspecialchars($user['resposta3']); ?>" placeholder="Resposta" required>     
                    </div>


                    <div class="form-row">
                        
                        <div class="alerta">
                            <span class="format"> ATENÇÃO: Guarde suas senhas de recuperação! </span>  <br><br>
                            <p class="fonte">Mantenha suas senhas de recuperação em um local seguro. Elas são essenciais para recuperar o acesso à sua conta em 
                                caso de perda, esquecimento ou problemas de login.
                                Uma vez perdido o acesso, sem as senhas de recuperação, pode ser impossível recuperar sua conta.</p>
                        </div>
                    </div>
                    <br>
                    <button class="submit-button" type="submit">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
