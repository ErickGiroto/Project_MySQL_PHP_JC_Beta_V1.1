<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Busca o pedido pelo ID
    $stmt = $conn->prepare("SELECT cod, produto, tipo, tipo_alimento, qtd, status FROM pedidos_comercial WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();
    $stmt->close();

    if ($pedido) {
        $cod = $pedido['cod'];
        $produto = $pedido['produto'];
        $tipo = $pedido['tipo'];
        $tipo_alimento = $pedido['tipo_alimento'];
        $qtd_pedido = $pedido['qtd'];
        $status_atual = $pedido['status'];

        // Busca a quantidade atual em estoque
        $stmt = $conn->prepare("SELECT id, qtd FROM produto_quantidade WHERE cod = ? AND produto = ? AND tipo = ? AND tipo_alimento = ?");
        $stmt->bind_param("ssss", $cod, $produto, $tipo, $tipo_alimento);
        $stmt->execute();
        $result = $stmt->get_result();
        $produto_estoque = $result->fetch_assoc();
        $stmt->close();

        if ($produto_estoque) {
            $id_produto = $produto_estoque['id'];
            $qtd_estoque = $produto_estoque['qtd'];

            if ($status == 'Iniciado' && $status_atual == 'Não Iniciado') {
                // Validação de estoque
                if ($qtd_estoque >= $qtd_pedido) {
                    // Subtrai a quantidade do pedido do estoque
                    $nova_qtd_estoque = $qtd_estoque - $qtd_pedido;
                } else {
                    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro Estoque</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/consulta_pedido_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Estoque Insuficiente!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
                    exit;
                }
            } elseif ($status == 'Finalizado' && $status_atual == 'Iniciado') {
                // Não faz alteração na quantidade do estoque
                $nova_qtd_estoque = $qtd_estoque;
            } else {
                echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro Status</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/consulta_pedido_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro: Ação não permitida!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
                exit;
            }

            // Atualiza a quantidade em estoque
            $stmt = $conn->prepare("UPDATE produto_quantidade SET qtd = ? WHERE id = ?");
            $stmt->bind_param("ii", $nova_qtd_estoque, $id_produto);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro produto!</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/consulta_pedido_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Produto não encontrado no estoque!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
            exit;
        }

        // Atualiza o status do pedido
        $stmt = $conn->prepare("UPDATE pedidos_comercial SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            header("Location: consulta_pedido.php");
            exit;
        } else {
            echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro Atualizar</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/consulta_pedido_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao atualizar o pedido!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
        }

        $stmt->close();
    } else {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro Pedido</title>
            <link rel='stylesheet' href='/usuario/admin/css/comercial/consulta_pedido_processa.css'>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro Pedido não encontrado!</h2>
            </div>
            <a class='button' href='consulta_pedido.php'>
                <img src='/midias/image/icon/icone_voltar.png' alt='Voltar'>
                Voltar
            </a>
        </body>
        </html>";
    }

    $conn->close();
}
?>