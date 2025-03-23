<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if (isset($_GET['num_pedido'])) {
    $num_pedido = trim($_GET['num_pedido']);
    header("Location: consulta_pedido_filtro.php?num_pedido=" . urlencode($num_pedido));
    exit;
} else {
    header("Location: consulta_pedido_filtro.php");
    exit;
}
?>