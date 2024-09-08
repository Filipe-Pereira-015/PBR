<?php
require_once('../bancodados/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imprimir_boleto'])) {
    session_start();

    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $localEntrega = isset($_POST['localEntrega']) ? $_POST['localEntrega'] : '';
    $carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];

    require_once('../tcpdf/tcpdf.php');

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Boleto Gerado', 0, 1);

    $pdfPath = '../boletocarrinho/boletosalvo/boleto_gerado_' . date('YmdHis') . '.pdf';
    
    $pdf->Output($pdfPath, 'F');

    try {
    
        $conteudo = file_get_contents($pdfPath);

        $stmt = $conn->prepare("INSERT INTO Boletos (numero_fiscal, data_geracao, conteudo_pdf) VALUES (:numero_fiscal, CURDATE(), :conteudo_pdf)");
        $numeroFiscal = date('His');
        $stmt->bindParam(':numero_fiscal', $numeroFiscal);
        $stmt->bindParam(':conteudo_pdf', $conteudo, PDO::PARAM_LOB);
        $stmt->execute();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($pdfPath) . '"');
        header('Content-Length: ' . filesize($pdfPath));
        readfile($pdfPath);

        exit();
    } catch (PDOException $e) {
        echo "Erro ao armazenar o boleto no banco de dados: " . $e->getMessage();
    }
}
?>