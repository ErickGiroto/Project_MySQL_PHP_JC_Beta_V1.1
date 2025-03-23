<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

require 'C:\Project\Quitanda_Bom_Preco\vendor\autoload.php'; // Certifique-se de que o autoload do Composer está incluído


if (isset($_GET['num_pedido'])) {
    $num_pedido = $_GET['num_pedido'];

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Busca todos os produtos relacionados ao número do pedido
    $stmt = $conn->prepare("SELECT num_pedido, razao_social, cnpj, produto, tipo, tipo_alimento, qtd, status, data_registro, nome_usuario, valor_unitario, valor_total, data_de_entrega FROM pedidos_comercial WHERE num_pedido = ?");
    $stmt->bind_param("s", $num_pedido);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedidos = $result->fetch_all(MYSQLI_ASSOC); // Busca todos os produtos associados ao pedido
    $stmt->close();

    // Busca os dados da empresa
    $query_empresa = "SELECT razao_social, cnpj, endereco, bairro, municipio, estado, cep, pais, numero, observacao FROM empresas LIMIT 1";
    $result_empresa = $conn->query($query_empresa);
    $empresa = $result_empresa->fetch_assoc();

    if ($pedidos && $empresa) {
        // Cria uma nova instância do TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Define as informações do documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Quitanda Bom Preço');
        $pdf->SetTitle('Pedido #' . $num_pedido);
        $pdf->SetSubject('Detalhes do Pedido');
        $pdf->SetKeywords('Pedido, Quitanda, PDF');

        // Adiciona uma nova página
        $pdf->AddPage();

        // Define a fonte padrão
        $pdf->SetFont('helvetica', '', 10);

        // Conteúdo do PDF com CSS
        $html = <<<EOD
        <style>
            h1 {
                color: #0044cc;
                font-family: helvetica;
                font-size: 20px;
                text-align: center;
                margin-bottom: 20px;
            }
            h2 {
                font-size: 16px;
                color: #333;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
                font-weight: bold;
                color: #333;
            }
            .destaque {
                color: #ff0000;
                font-weight: bold;
            }
            .cabecalho {
                background-color:rgb(255, 255, 255);
                color: #333;
                font-size: 10px;
            }
            .rodape {
                margin-top: 20px;
                font-size: 10px;
                text-align: center;
                color: #666;
            }
            .empresa-info {
                margin-bottom: 20px;
                font-size: 12px;
                line-height: 1.5;
            }
            .total-geral {
                font-size: 10px;
                font-weight: bold;
                text-align: right;
                margin-top: 20px;
            }
            .fonte {
                font-size: 9px;
            }
            .info-empresa-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            .info-empresa-table td {
                padding: 5px;
                border: none;
            }
        </style>

        <h1>Pedido #{$num_pedido}</h1>

        <div class="empresa-info">
            <h2>Informações da Empresa</h2>
            <table class="info-empresa-table">
                <tr>
                    <td><strong>Razão Social:</strong> {$empresa['razao_social']}</td>
                    <td><strong>CNPJ:</strong> {$empresa['cnpj']}</td>
                </tr>
                <tr>
                    <td><strong>Endereço:</strong> {$empresa['endereco']}, {$empresa['numero']} - {$empresa['bairro']}</td>
                    <td><strong>Município:</strong> {$empresa['municipio']} - {$empresa['estado']}</td>
                </tr>
                <tr>
                    <td><strong>CEP:</strong> {$empresa['cep']}</td>
                    <td><strong>País:</strong> {$empresa['pais']}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Observação:</strong> {$empresa['observacao']}</td>
                </tr>
            </table>
        </div>

        <h2>Produtos!</h2>
        <table>
            <tr class="cabecalho">
                <th>Data Entrega</th>
                <th>Produto</th>
                <th>Tipo Aliment.</th>
                <th>Quant.</th>
                <th>Unid.</th>
                <th>Valor Unit.</th>
                <th>Valor Total</th>
                <th>Status</th>
            </tr>
EOD;

        // Calcula o total geral
        $total_geral = 0;

        // Adiciona cada produto ao PDF
        foreach ($pedidos as $pedido) {
            $total_geral += $pedido['valor_total']; // Soma ao total geral

            // Formata as datas para o padrão brasileiro
            $data_entrega_formatada = date('d/m/Y', strtotime($pedido['data_de_entrega']));
            $data_registro_formatada = date('d/m/Y H:i:s', strtotime($pedido['data_registro']));

            $html .= <<<EOD
            <tr class="fonte">
                <td>{$data_entrega_formatada}</td>
                <td>{$pedido['produto']}</td>
                <td>{$pedido['tipo_alimento']}</td>
                <td>{$pedido['qtd']}</td>
                <td>{$pedido['tipo']}</td>
                <td>R$ {$pedido['valor_unitario']}</td>
                <td>R$ {$pedido['valor_total']}</td>
                <td class="destaque">{$pedido['status']}</td>
            </tr>
EOD;
        }

        // Formata o total geral com 2 casas decimais
        $total_geral_formatado = number_format($total_geral, 2, ',', '.');

        $html .= <<<EOD
        </table>

        <table>

        <div class="total-geral">
            <strong>Total Gerado: R$ {$total_geral_formatado}</strong>
        </div>

        </table>

        <div class="rodape">
            <p>Quitanda Bom Preço - Sistema de Pedidos</p>
        </div>
EOD;

        // Escreve o conteúdo no PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Gera o PDF e envia para o navegador
        $pdf->Output('pedido_' . $num_pedido . '.pdf', 'I');
    } else {
        echo "Erro: Pedido ou dados da empresa não encontrados.";
    }

    $conn->close();
} else {
    echo "Erro: Número do pedido não fornecido.";
}
?>