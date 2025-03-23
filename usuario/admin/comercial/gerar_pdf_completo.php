<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

require 'vendor/autoload.php'; // Usa o autoload do Composer para carregar a biblioteca TCPDF

use TCPDF as TCPDF; // Importa a classe TCPDF

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Coleta o ID do pedido
$id_pedido = $_GET['id'];

// Busca os dados do pedido
$query = "SELECT * FROM pedidos_comercial WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
$pedido = $result->fetch_assoc();

if (!$pedido) {
    echo "Pedido não encontrado!";
    exit;
}

// Busca os dados da empresa
$query_empresa = "SELECT razao_social, cnpj, endereco, bairro, municipio, estado, cep, pais, numero, observacao FROM empresas LIMIT 1";
$result_empresa = $conn->query($query_empresa);
$empresa = $result_empresa->fetch_assoc();

$stmt->close();
$conn->close();

if ($pedido && $empresa) {
    // Cria uma nova instância do TCPDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Define as informações do documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Quitanda Bom Preço');
    $pdf->SetTitle('Pedido Completo #' . $pedido['num_pedido']);
    $pdf->SetSubject('Detalhes do Pedido Completo');
    $pdf->SetKeywords('Pedido, Completo, Quitanda, PDF');

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
            background-color: #0044cc;
            color: #fff;
            font-size: 12px;
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
    </style>

    <h1>Pedido Completo #{$pedido['num_pedido']}</h1>

    <div class="empresa-info">
        <h2>Informações da Empresa</h2>
        <p><strong>Razão Social:</strong> {$empresa['razao_social']}</p>
        <p><strong>CNPJ:</strong> {$empresa['cnpj']}</p>
        <p><strong>Endereço:</strong> {$empresa['endereco']}, {$empresa['numero']} - {$empresa['bairro']}</p>
        <p><strong>Município:</strong> {$empresa['municipio']} - {$empresa['estado']}</p>
        <p><strong>CEP:</strong> {$empresa['cep']}</p>
        <p><strong>País:</strong> {$empresa['pais']}</p>
        <p><strong>Observação:</strong> {$empresa['observacao']}</p>
    </div>

    <table>
        <tr class="cabecalho">
            <th>Campo</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>Número do Pedido</td>
            <td>{$pedido['num_pedido']}</td>
        </tr>
        <tr>
            <td>Razão Social</td>
            <td>{$pedido['razao_social']}</td>
        </tr>
        <tr>
            <td>CNPJ</td>
            <td>{$pedido['cnpj']}</td>
        </tr>
        <tr>
            <td>Produto</td>
            <td>{$pedido['produto']}</td>
        </tr>
        <tr>
            <td>Tipo</td>
            <td>{$pedido['tipo']}</td>
        </tr>
        <tr>
            <td>Tipo de Alimento</td>
            <td>{$pedido['tipo_alimento']}</td>
        </tr>
        <tr>
            <td>Quantidade</td>
            <td>{$pedido['qtd']}</td>
        </tr>
        <tr>
            <td>Valor Unitário</td>
            <td>R$ {$pedido['valor_unitario']}</td>
        </tr>
        <tr>
            <td>Valor Total</td>
            <td>R$ {$pedido['valor_total']}</td>
        </tr>
        <tr>
            <td>Data de Entrega</td>
            <td>{$pedido['data_de_entrega']}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="destaque">{$pedido['status']}</td>
        </tr>
        <tr>
            <td>Data do Pedido</td>
            <td>{$pedido['data_registro']}</td>
        </tr>
        <tr>
            <td>Registrado por</td>
            <td>{$pedido['nome_usuario']}</td>
        </tr>
    </table>

    <div class="rodape">
        <p>Quitanda Bom Preço - Sistema de Pedidos</p>
        <p>Gerado em: {date('d/m/Y H:i:s')}</p>
    </div>
EOD;

    // Escreve o conteúdo no PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Gera o PDF e envia para o navegador
    $pdf->Output('pedido_completo_' . $pedido['num_pedido'] . '.pdf', 'I');
} else {
    echo "Erro: Pedido ou dados da empresa não encontrados.";
}
?>