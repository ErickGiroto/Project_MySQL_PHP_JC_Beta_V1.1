<?php
// editar_usuario.php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Busca os dados do usuário
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        die("Usuário não encontrado.");
    }

    $stmt->close();
    $conn->close();
} else {
    die("ID do usuário não fornecido.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualiza os dados do usuário
    $nome = trim($_POST['nome_completo']);
    $email = trim($_POST['email']);
    $tipo_usuario = trim($_POST['tipo_usuario']);
    $pergunta1 = trim($_POST['pergunta1']);
    $resposta1 = trim($_POST['resposta1']);
    $pergunta2 = trim($_POST['pergunta2']);
    $resposta2 = trim($_POST['resposta2']);
    $pergunta3 = trim($_POST['pergunta3']);
    $resposta3 = trim($_POST['resposta3']);

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $sql = "UPDATE usuarios SET nome_completo = ?, email = ?, tipo_usuario = ?, pergunta1 = ?, resposta1 = ?, pergunta2 = ?, resposta2 = ?, pergunta3 = ?, resposta3 = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $nome, $email, $tipo_usuario, $pergunta1, $resposta1, $pergunta2, $resposta2, $pergunta3, $resposta3, $id);

    if ($stmt->execute()) {
        header("Location: consulta_usuario.php?mensagem=Usuário atualizado com sucesso.");
    } else {
        header("Location: consulta_usuario.php?mensagem=Erro ao atualizar usuário.");
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="css/editar_usuario.css">
</head>

<body class="corpo_body">
    <div class="main-container">
        <div class="form-container">
            <h2 class="font">Editar Usuário</h2>
            <form action="editar_usuario.php?id=<?php echo $id; ?>" method="POST">
                <div class="form-row">
                    <input class="input-field" type="text" name="nome_completo"
                        value="<?php echo $usuario['nome_completo']; ?>" placeholder="Nome Completo" required>
                    <input class="input-field" type="email" name="email" value="<?php echo $usuario['email']; ?>"
                        placeholder="E-mail" required>
                    <select class="select-field" name="tipo_usuario" required>
                        <option value="admin" <?php echo ($usuario['tipo_usuario']=='admin' ) ? 'selected' : '' ; ?>
                            >Administrador</option>
                        <option value="funcionario" <?php echo ($usuario['tipo_usuario']=='funcionario' ) ? 'selected'
                            : '' ; ?>>Funcionário</option>
                        <option value="gerencia" <?php echo ($usuario['tipo_usuario']=='gerencia' ) ? 'selected' : '' ;
                            ?>>Gerência</option>
                        <option value="estoque" <?php echo ($usuario['tipo_usuario']=='estoque' ) ? 'selected' : '' ; ?>
                            >Estoque</option>
                        <option value="rh" <?php echo ($usuario['tipo_usuario']=='rh' ) ? 'selected' : '' ; ?>>Recursos
                            Humanos</option>
                        <option value="comercial" <?php echo ($usuario['tipo_usuario']=='comercial' ) ? 'selected' : ''
                            ; ?>>Comercial</option>
                    </select>
                </div>
                <div class="form-row">
                    <select class="select-field" name="pergunta1" required>
                        <option value="">Pergunta 1</option>
                        <option value="Qual é o nome do seu primeiro animal de estimação?" <?php echo
                            ($usuario['pergunta1']=='Qual é o nome do seu primeiro animal de estimação?' ) ? 'selected'
                            : '' ; ?>>Qual é o nome do seu primeiro animal de estimação?</option>
                        <option value="Qual é o nome da sua mãe?" <?php echo
                            ($usuario['pergunta1']=='Qual é o nome da sua mãe?' ) ? 'selected' : '' ; ?>>Qual é o nome
                            da sua mãe?</option>
                        <option value="Qual foi o modelo do seu primeiro carro?" <?php echo
                            ($usuario['pergunta1']=='Qual foi o modelo do seu primeiro carro?' ) ? 'selected' : '' ; ?>
                            >Qual foi o modelo do seu primeiro carro?</option>
                        <option value="Qual é o nome da sua cidade natal?" <?php echo
                            ($usuario['pergunta1']=='Qual é o nome da sua cidade natal?' ) ? 'selected' : '' ; ?>>Qual é
                            o nome da sua cidade natal?</option>
                        <option value="Qual é o nome do seu melhor amigo de infância?" <?php echo
                            ($usuario['pergunta1']=='Qual é o nome do seu melhor amigo de infância?' ) ? 'selected' : ''
                            ; ?>>Qual é o nome do seu melhor amigo de infância?</option>
                    </select>
                    <input class="input-field" type="text" name="resposta1" value="<?php echo $usuario['resposta1']; ?>"
                        placeholder="Resposta" required>
                </div>
                <div class="form-row">
                    <select class="select-field" name="pergunta2" required>
                        <option value="">Pergunta 2</option>
                        <option value="Qual é o nome do seu primeiro animal de estimação?" <?php echo
                            ($usuario['pergunta2']=='Qual é o nome do seu primeiro animal de estimação?' ) ? 'selected'
                            : '' ; ?>>Qual é o nome do seu primeiro animal de estimação?</option>
                        <option value="Qual é o nome da sua mãe?" <?php echo
                            ($usuario['pergunta2']=='Qual é o nome da sua mãe?' ) ? 'selected' : '' ; ?>>Qual é o nome
                            da sua mãe?</option>
                        <option value="Qual foi o modelo do seu primeiro carro?" <?php echo
                            ($usuario['pergunta2']=='Qual foi o modelo do seu primeiro carro?' ) ? 'selected' : '' ; ?>
                            >Qual foi o modelo do seu primeiro carro?</option>
                        <option value="Qual é o nome da sua cidade natal?" <?php echo
                            ($usuario['pergunta2']=='Qual é o nome da sua cidade natal?' ) ? 'selected' : '' ; ?>>Qual é
                            o nome da sua cidade natal?</option>
                        <option value="Qual é o nome do seu melhor amigo de infância?" <?php echo
                            ($usuario['pergunta2']=='Qual é o nome do seu melhor amigo de infância?' ) ? 'selected' : ''
                            ; ?>>Qual é o nome do seu melhor amigo de infância?</option>
                    </select>
                    <input class="input-field" type="text" name="resposta2" value="<?php echo $usuario['resposta2']; ?>"
                        placeholder="Resposta" required>
                </div>
                <div class="form-row">
                    <select class="select-field" name="pergunta3" required>
                        <option value="">Pergunta 3</option>
                        <option value="Qual é o nome do seu primeiro animal de estimação?" <?php echo
                            ($usuario['pergunta3']=='Qual é o nome do seu primeiro animal de estimação?' ) ? 'selected'
                            : '' ; ?>>Qual é o nome do seu primeiro animal de estimação?</option>
                        <option value="Qual é o nome da sua mãe?" <?php echo
                            ($usuario['pergunta3']=='Qual é o nome da sua mãe?' ) ? 'selected' : '' ; ?>>Qual é o nome
                            da sua mãe?</option>
                        <option value="Qual foi o modelo do seu primeiro carro?" <?php echo
                            ($usuario['pergunta3']=='Qual foi o modelo do seu primeiro carro?' ) ? 'selected' : '' ; ?>
                            >Qual foi o modelo do seu primeiro carro?</option>
                        <option value="Qual é o nome da sua cidade natal?" <?php echo
                            ($usuario['pergunta3']=='Qual é o nome da sua cidade natal?' ) ? 'selected' : '' ; ?>>Qual é
                            o nome da sua cidade natal?</option>
                        <option value="Qual é o nome do seu melhor amigo de infância?" <?php echo
                            ($usuario['pergunta3']=='Qual é o nome do seu melhor amigo de infância?' ) ? 'selected' : ''
                            ; ?>>Qual é o nome do seu melhor amigo de infância?</option>
                    </select>
                    <input class="input-field" type="text" name="resposta3" value="<?php echo $usuario['resposta3']; ?>"
                        placeholder="Resposta" required>
                </div>
                <button class="submit-button" type="submit">Atualizar</button>
            </form>
            

            <!-- Links de Voltar e Sair -->
            <div class="link-container">
                <p class="forgot-password">
                    <a class="link" href="/usuario/gerencia/consulta_usuario.php">
                        <img src="/midias/image/icon/icone_voltar.png" alt="Voltar">
                        Voltar
                    </a>
                </p>

                <p class="forgot-password">
                    <a class="link" href="/usuario/logout.php">
                        <img src="/midias/image/icon/icone_sair.png" alt="Sair">
                        Sair
                    </a>
                </p>
            </div>





        </div>


    </div>
</body>

</html>