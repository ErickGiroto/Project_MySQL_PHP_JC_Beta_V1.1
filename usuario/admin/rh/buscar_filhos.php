<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$cod_funcionario = intval($_GET['cod_funcionario']);

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Busca os filhos do funcionário
$sql = "SELECT 
            filho1, data_nascimento_filho1, 
            filho2, data_nascimento_filho2, 
            filho3, data_nascimento_filho3, 
            filho4, data_nascimento_filho4, 
            filho5, data_nascimento_filho5, 
            filho6, data_nascimento_filho6, 
            filho7, data_nascimento_filho7 
        FROM funcionario_registro 
        WHERE cod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cod_funcionario);
$stmt->execute();
$stmt->bind_result(
    $filho1, $data1, 
    $filho2, $data2, 
    $filho3, $data3, 
    $filho4, $data4, 
    $filho5, $data5, 
    $filho6, $data6, 
    $filho7, $data7
);
$stmt->fetch();
$stmt->close();

// Exibe os filhos
echo "<h3>Filhos do Funcionário</h3>";
echo "<div class='filhos-container'>";
for ($i = 1; $i <= 7; $i++) {
    $filho = ${"filho$i"};
    $data = ${"data$i"};
    if (!empty($filho)) {
        echo "<p><strong>Filho $i:</strong> $filho (Nascimento: $data)</p>";
    }
}
echo "</div>";

$conn->close();
?>