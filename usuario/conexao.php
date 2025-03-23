<?php
// Configurações do banco de dados
$host = 'localhost';        // Host do banco de dados
$dbname = 'quitanda_bom_preco';  // Nome do banco de dados
$username = 'root';         // Usuário do banco de dados
$password = 'root';             // Senha do banco de dados (se houver)

try {
    // Criando a conexão com o banco de dados usando PDO
    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Definindo o modo de erro para exceção
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Definindo a codificação de caracteres como UTF-8
    $conexao->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    // Se houver erro na conexão, exibe a mensagem de erro
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit();
}
?>
