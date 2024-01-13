<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/plugins/custom/TCPDF-main/tcpdf.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/api/api.php';
$api = new Api();

$id_requerimento = isset($_GET['id_requerimento']) && !empty($_GET['id_requerimento']) ? $_GET['id_requerimento'] : null;

$informacao_requerimento = $api->fetch('requerimentos/ver', null, $id_requerimento);
if($informacao_requerimento['status'] == false){
    echo "Erro ao obter informação do requerimento";
    die();
}else{
    $informacao_requerimento = $informacao_requerimento['response']['data'];
    $avaliacao = $informacao_requerimento['avaliacao'];
    if(count($avaliacao) <= 0){
        echo "Erro ao obter informação do requerimento";
        die();
    }
}

// Create new PDF document
class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        $informacao_requerimento = $GLOBALS['informacao_requerimento'];
        $avaliacao = $informacao_requerimento['avaliacao'];

        // Set font
        $this->SetFont('helvetica', '', 9);

        //$this->setCellMargins(0, 2, 0, 0);
        //this->setCellPaddings(2, 0, 0, 0);

        // Image 1
        $imageFile = $_SERVER['DOCUMENT_ROOT'] . '/assets/media/uploads/logos_pdf/logo_rps.png';
        $size = getimagesize($imageFile);
        $width = $size[0] / 7;
        $height = $size[1] / 7;
        $xPos = 6;
        $yPos = $this->GetY() + 10;
        $this->Image($imageFile, $xPos, $yPos, $width, $height, '', '', '', false, 300, '', false, false, 0);

        // Image 2
        $imageFile = $_SERVER['DOCUMENT_ROOT'] . '/assets/media/uploads/logos_pdf/logo_sns.png';
        $size = getimagesize($imageFile);
        $rps_width_save = $width;
        $width = $size[0] / 7;
        $height = $size[1] / 7;
        $xPos = $this->GetX() + $rps_width_save + 5;
        $yPos = $this->GetY() + 10;
        $this->Image($imageFile, $xPos, $yPos, $width, $height, '', '', '', false, 300, '', false, false, 0);

        // MULTI CELL AT CENTER
        $top_y = $this->GetY() + 10;
        $center_x = $this->GetX() + 5;
        $this->SetY($top_y);
        $this->SetX($center_x);
        $this->MultiCell(0, 0, 'Requerimento de Atestado Médico ', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->SetY($this->GetY() + 3);
        $this->SetX($center_x);
        $this->MultiCell(0, 0, 'de Incapacidade', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M', false);
        $this->SetY($this->GetY() + 3);

        // CELL AT RIGHT
        $this->SetY($top_y);
        $this->SetX(0);
        $this->Cell(0, 0, 'Nº de Requerimento: '.$informacao_requerimento['numero_requerimento'], 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->SetY($this->GetY() + 3);
        $this->Cell(0, 0, 'Data de Avaliação: ' . $avaliacao['data_avaliacao'], 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-5);
        // Set font
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('helvetica', '', 8);
        $this->SetFillColor(231, 231, 231);

        $this->setCellPaddings(2, 0, 0, 0);
        $this->Cell(100, 5, 'Gerado informaticamente por JMAI' . ' - ' . date('d/m/Y H:i:s'), 0, false, 'L', 1, '', 0, false, 'C', 'M');
        $this->Cell(100, 5, 'Página: ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 1, '', 0, false, 'C', 'M');

        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// content margins
$pdf->SetMargins(5, 20, 5);

// Set document information
$pdf->SetCreator('Software JMAI');
$pdf->SetAuthor('Software JMAI');
$pdf->SetTitle('Requerimento de Atestado Médico de Incapacidade - ' . $informacao_requerimento['numero_requerimento']);
$pdf->SetSubject('Requerimento de Atestado Médico de Incapacidade - ' . $informacao_requerimento['numero_requerimento']);
$pdf->SetKeywords('Requerimento de Atestado Médico de Incapacidade - ' . $informacao_requerimento['numero_requerimento']);

// Set default header data
$pdf->setHeaderFont(array('helvetica', '', 12));
$pdf->setFooterFont(array('helvetica', '', 10));

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 25);


// Add a page
$pdf->AddPage();
// Set font size for the rest of the document
$pdf->SetFont('helvetica', '', 12);


/* 
    FIRST PAGE LETTER TEMPLATE ?? BEGINS HERE
*/

$pdf->SetFont('helvetica', '', 13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetY($pdf->GetY() + 10);
$pdf->SetX(5);
$pdf->Cell(0, 0, 'Requerimento de Atestado Médico de Incapacidade', 0, false, 'L', 0, '', 0, false, 'T', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->SetY($pdf->GetY() + 7);
$pdf->SetX(5);
$pdf->MultiCell(0, 0, 'O requerimento de atestado médico de incapacidade é um documento que permite ao cidadão solicitar a avaliação da sua incapacidade para o trabalho, com vista à atribuição de uma pensão de invalidez ou de uma pensão social de invalidez.', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M', false);

$pdf->SetY($pdf->GetY() + 5);
//TABLE WITH 1 ROW AND 2 CELLS

$pdf->Ln(15);
$pdf->SetDrawColor(245, 245, 245);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
//Border Width
$pdf->SetLineWidth(0.1);
//BORDER COLOR BLACK
$pdf->SetFillColor(211, 211, 211);
$pdf->SetDrawColor(0, 0, 0);

$pdf->Cell(45, 15, 'Médico Especialista', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(155, 15, 'Dr. ' . $avaliacao['nome_utilizador'], 1, false, 'L', 0, '', 0, false, 'C', 'M');

$pdf->SetY($pdf->GetY());

$pdf->Ln(15);
$pdf->SetDrawColor(245, 245, 245);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
//Border Width
$pdf->SetLineWidth(0.1);
//BORDER COLOR BLACK
$pdf->SetFillColor(211, 211, 211);
$pdf->SetDrawColor(0, 0, 0);

$pdf->Cell(200, 5, 'Utente', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->Ln(7.5);
$pdf->Cell(45, 10, 'Nome', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(155, 10, $informacao_requerimento['informacao_utente']['nome'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->Ln(10);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(45, 10, 'Data de Nascimento', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(60, 10, $informacao_requerimento['data_nascimento'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(45, 10, 'Nº de Iden. Fiscal', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(50, 10, $informacao_requerimento['numero_contribuinte'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->Ln(10);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(45, 10, 'Nº de Utente', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(60, 10, $informacao_requerimento['informacao_utente']['numero_utente'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(45, 10, $informacao_requerimento['texto_tipo_documento'], 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(50, 10, $informacao_requerimento['numero_documento'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->Ln(10);
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(45, 10, 'Residência', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(60, 10, $informacao_requerimento['morada'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(45, 10, 'Código Postal', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(50, 10, $informacao_requerimento['codigo_postal'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->Ln(10);
$pdf->setFont('helvetica', 'B', 10);
//SHOW FREQUESIA; CONCELHO; DISTRITO IN THE SAME ROW
$pdf->Cell(25, 10, 'Freguesia', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(41.66, 10, $informacao_requerimento['nome_freguesia_residencia'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(25, 10, 'Concelho', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(41.66, 10, $informacao_requerimento['nome_concelho_residencia'], 1, false, 'L', 0, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', 'B', 10);
$pdf->Cell(25, 10, 'Distrito', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(41.66, 10, $informacao_requerimento['nome_distrito_residencia'], 1, false, 'L', 0, '', 0, false, 'C', 'M');


$pdf->Ln(15);
$pdf->SetFont('helvetica', 'B', 10);
$y = $pdf->GetY();
$pdf->Cell(200, 5, 'Avaliação da Incapacidade', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->SetY($y+2);
$pdf->MultiCell(0, 0, $avaliacao['notas'], 1, 'L', 0, 1, '', '', true, 0, false, true, 0, 'M', false);

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 10);
$y = $pdf->GetY();
$pdf->Cell(105, 5, '', 0, false, 'C', 0, '', 0, false, 'C', 'M');
$pdf->Cell(50, 5, 'Grau de Incapacidade', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 9);
$pdf->Cell(45, 5, $avaliacao['grau_avaliacao'].'%', 1, false, 'R', 0, '', 0, false, 'C', 'M');


$pdf->Ln(25);
$pdf->SetFont('helvetica', 'B', 10);
$y = $pdf->GetY();
$pdf->Cell(200, 5, 'Assinatura do Médico', 1, false, 'C', 1, '', 0, false, 'C', 'M');
$pdf->setFont('helvetica', '', 8);
$pdf->Ln(12.5);
$pdf->setTextColor(211, 211, 211);//
$pdf->Cell(200, 20, ' Carimbo da Entidade Prestadora ', 1, false, 'C', 0, '', 0, false, 'C', 'TC');
$pdf->setTextColor(0, 0, 0);//


/* 
    FIRST PAGE LETTER TEMPLATE ?? ENDS HERE
*/

/* 
    SECOND PAGE LETTER TEMPLATE ?? BEGINS HERE
*/





// Generate PDF as a blob
$pdfContent = $pdf->Output('', 'S');
// Return the PDF as a blob
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="example.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($pdfContent));
//ob_clean();
flush();
echo $pdfContent;
exit();

// SAVE TO SERVER
//$pdf->Output('name.pdf', 'F');