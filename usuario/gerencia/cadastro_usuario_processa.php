<?php
// cadastro_usuario_processa.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta dos dados do formulário
    $nome = trim($_POST['nome_completo']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
      
    // Perguntas de Segurança
    $pergunta1 = $_POST['pergunta1'];
    $resposta1 = trim($_POST['resposta1']); // Removida a criptografia
    $pergunta2 = $_POST['pergunta2'];
    $resposta2 = trim($_POST['resposta2']); // Removida a criptografia
    $pergunta3 = $_POST['pergunta3'];
    $resposta3 = trim($_POST['resposta3']); // Removida a criptografia



    
    $tipo_usuario = trim($_POST['tipo_usuario']); 


    
    // Validação das Perguntas de Segurança (não devem ser iguais)
    if ($pergunta1 === $pergunta2 || $pergunta1 === $pergunta3 || $pergunta2 === $pergunta3) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro no Cadastro</title>
            <link rel='stylesheet' href='css/cadastro_usuario_processa.css'>

        </head>
        <body>
            
            <div class='corpo_body'>

                <div class='main-container'>
                    

                        <div class='link-container'>

                            <h2 class='h2format'>Verifique suas perguntas!</h2>
                            <p class='forgot-password'>
                            
                                <span class='descri_perguntas_respostas'> As perguntas devem ser diferentes. </span>
                                <a class='link' href='/usuario/gerencia/cadastro_usuario.php'>
                                    <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                                    Voltar
                                </a>
                                <br>
                                
                            </p>
                           
                        </div>
                   
                </div>
                
            </div>
        </body>
        </html>";
        exit;
    }
    
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");
    
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

     // Verificar se o e-mail já existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro no Cadastro</title>
            <link rel='stylesheet' href='css/cadastro_usuario_processa.css'>

        </head>
        <body>
            
            <div class='corpo_body'>

                <div class='main-container'>
                    

                        <div class='link-container'>

                            <h2 class='h2format'>Erro no Cadastro</h2>
                            <p class='forgot-password'>
                            
                                <span class='descri'> E-mail já cadastrado! </span>
                                <a class='link' href='/usuario/gerencia/cadastro_usuario.php'>
                                    <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                                    Voltar
                                </a>
                                <br>
                                
                            </p>
                           
                        </div>
                   
                </div>
                
            </div>
        </body>
        </html>";
        exit;
    }
    
// Preparação da consulta
    $stmt = $conn->prepare("INSERT INTO usuarios 
        (nome_completo, email, senha, pergunta1, resposta1, pergunta2, resposta2, pergunta3, resposta3, tipo_usuario) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }
    
    // Hash da senha (mantida a criptografia)
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
   // Bind dos parâmetros (respostas sem criptografia)
    $stmt->bind_param(
        "ssssssssss",
        $nome,
        $email,
        $senha_hash, // Corrigido para usar a senha com hash
        $pergunta1,
        $resposta1,
        $pergunta2,
        $resposta2,
        $pergunta3,
        $resposta3,
        $tipo_usuario,
    );
    
    // Execução da consulta
    if ($stmt->execute()) {
        echo"<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro no Cadastro</title>
            <link rel='stylesheet' href='css/cadastro_usuario_processa.css'>

        </head>
        <body>
            
            <div class='corpo_body'>

                <div class='main-container'>
                    

                        <div class='link-container'>

                            <h2 class='h2format'>Cadastro de Usuário</h2>
                            <p class='forgot-password'>
                            
                                <span class='descri_ok'> E-mail cadastrado com sucesso! </span>
                                <a class='link' href='/usuario/gerencia/cadastro_usuario.php'>
                                    <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                                    Voltar
                                </a>
                                <br>
                                
                            </p>
                           
                        </div>
                   
                </div>
                
            </div>
        </body>
        </html>";
    } else {
        // Mensagem de erro mais detalhada
        echo "Erro no cadastro: " . $stmt->error;
    }
    
    // Fechamento da conexão
    $stmt->close();
    $conn->close();
}
?>