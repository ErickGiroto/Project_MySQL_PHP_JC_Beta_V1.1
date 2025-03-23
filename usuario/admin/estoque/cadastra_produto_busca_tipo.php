<?php
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die(json_encode(["erro" => "Erro de conexão: " . $conn->connect_error]));
    }

    $stmt = $conn->prepare("SELECT produto, tipo, tipo_alimento FROM produto_tipo WHERE cod = ?");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["erro" => "Produto não encontrado"]);
    }

    $stmt->close();
    $conn->close();
}
?>
