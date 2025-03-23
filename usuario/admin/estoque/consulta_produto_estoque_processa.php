<?php
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta os produtos em estoque
$sql = "SELECT id, cod, produto, tipo, tipo_alimento, qtd, data_registro, usuario_registro, nome_usuario FROM produto_quantidade ORDER BY data_registro DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>"; // Exibe o ID
        echo "<td>" . htmlspecialchars($row['cod']) . "</td>";
        echo "<td>" . htmlspecialchars($row['produto']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tipo_alimento']) . "</td>";
        echo "<td>" . htmlspecialchars($row['qtd']) . "</td>";
        echo "<td>" . htmlspecialchars($row['data_registro']) . "</td>";
        echo "<td>" . htmlspecialchars($row['usuario_registro']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nome_usuario']) . "</td>";
        echo "<td>
                <a class='edit-link' href='editar_produto_estoque.php?id=" . $row['id'] . "'>Editar</a>
                <a class='delete-link' href='excluir_produto_estoque.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>Excluir</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>Nenhum produto encontrado.</td></tr>";
}

$conn->close();
?>