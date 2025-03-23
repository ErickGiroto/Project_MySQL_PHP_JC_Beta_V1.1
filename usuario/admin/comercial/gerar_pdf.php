<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

require 'C:\Project\Quitanda_Bom_Preco\vendor\autoload.php';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        die("Erro: ID inválido.");
    }

    $conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT num_pedido, razao_social, produto, tipo, tipo_alimento, qtd, status, data_registro, nome_usuario FROM pedidos_comercial WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();
    $stmt->close();

    $query_empresa = "SELECT razao_social, cnpj, endereco, bairro, municipio, estado, cep, pais, numero FROM empresas LIMIT 1";
    $result_empresa = $conn->query($query_empresa);
    $empresa = $result_empresa->fetch_assoc();

    if ($pedido && $empresa) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Quitanda Bom Preço');
        $pdf->SetTitle('Ordem de Serviço #' . $pedido['num_pedido']);
        $pdf->SetSubject('Detalhes do Pedido');
        $pdf->SetKeywords('Pedido, Quitanda, PDF');

        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);

        $dataAtual = date('d/m/Y H:i:s');
        $dataFormatada = date('d/m/Y', strtotime($pedido['data_registro']));

        $html = <<<EOD
<style>
    body { font-family: helvetica, sans-serif; color: #333; }
    h1 { color: #002060; font-size: 18px; text-align: center; margin-bottom: 10px; }
    h2 { font-size: 12px; color: #0044cc; border-bottom: 1px solid #0044cc; padding-bottom: 4px; margin-top: 20px; } 
    .empresa-container { background-color: #f1f4ff; padding: 10px; border-radius: 5px; margin-top: 10px; }
    .empresa-info { font-size: 11px; line-height: 1.4; color: #333; }
    .empresa-titulo { font-size: 13px; font-weight: bold; color: #002060; }
    table { width: 100%; border-collapse: collapse; table-layout: auto; margin-top: 20px; } 
    th, td { padding: 6px; text-align: left; border: 1px solid #ccc; word-wrap: break-word; }
    th { background-color: #0074cc; color: #ffffff; font-weight: bold; font-size: 10px; }
    td { background-color: #ffffff; font-size: 9px; }
    .destaque { color: #d9534f; font-weight: bold; }
    .rodape { margin-top: 30px; font-size: 9px; text-align: center; color: #777; }
    .info-empresa-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    .info-empresa-table td { padding: 5px; border: none; }
</style>

<h1>Ordem de Serviço #{$pedido['num_pedido']}</h1>

<h2>Informações da Empresa</h2>
<div class="empresa-container">
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
    </table>
</div>

<h2>Detalhes do Pedido</h2>

<table>
    <tr>
        <th>Nº Pedido</th>
        <th>Produto</th>
        <th>Tipo Aliment.</th>
        <th>Qtd</th>
        <th>Tipo</th>
        <th>Status</th>
        <th>Registro</th>
        <th>Usuário</th>
    </tr>
    <tr>
        <td>{$pedido['num_pedido']}</td>
        <td>{$pedido['produto']}</td>
        <td>{$pedido['tipo_alimento']}</td>
        <td class="destaque">{$pedido['qtd']}</td>
        <td>{$pedido['tipo']}</td>
        <td class="destaque">{$pedido['status']}</td>
        <td>{$dataFormatada}</td>
        <td>{$pedido['nome_usuario']}</td>
    </tr>
</table>

<div class="rodape">
    <p>Quitanda Bom Preço - Sistema de Pedidos</p>
    <p>Gerado em: {$dataAtual}</p>
</div>
EOD;

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('pedido_' . $pedido['num_pedido'] . '.pdf', 'I');
    } else {
        echo "Erro: Pedido ou dados da empresa não encontrados.";
    }
    $conn->close();
} else {
    echo "Erro: ID do pedido não fornecido.";
}
?>