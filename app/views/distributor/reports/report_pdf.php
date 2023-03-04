<?php 

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();


$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt , Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Gas Distribution Report',0,1,'C');
$pdf->Ln(20);

// $details = $data['reportdetails'];
// echo count($details);
// $pdf->SetFont('Times', '', 12);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Distribution No',0,0,'l');
$pdf->SetFont('Times', '', 12);
// $pdf->Cell(90,5,": {$data['po_id']}",0,0,'l');
$pdf->Cell(90,5,": 58",0,0,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Date',0,0,'l');
$pdf->SetFont('Times', '', 12);
// $pdf->Cell(0,5,": {$data['date']}",0,1,'l');
$pdf->Cell(0,5,": 2023.03.04",0,1,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Dealer ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
// $pdf->Cell(90,5,": {$data['dealer_id']}",0,0,'l');
$pdf->Cell(90,5,": 06",0,0,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Time',0,0,'l');
$pdf->SetFont('Times', '', 12);
// $pdf->Cell(0,5,": {$data['time']}",0,1,'l');
$pdf->Cell(0,5,": 13:40:20",0,1,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Business Name',0,0,'l');
$pdf->SetFont('Times', '', 12);
// $pdf->Cell(90,5,": {$data['business_name']}",0,1,'l');
$pdf->Cell(90,5,": ABC",0,1,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Distributor ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
// $pdf->Cell(90,5,": {$data['distributor_id']}",0,1,'l');
$pdf->Cell(90,5,": 26",0,1,'l');
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(40,5,'Product ID',0,0,'C');
$pdf->Cell(40,5,'Unit Prie (Rs)',0,0,'C');
$pdf->Cell(40,5,'Sold Quantity',0,0,'C');
$pdf->Cell(40,5,'Sub Total (Rs)',0,0,'C');
// $pdf->Cell(33,5,'Percentage',0,0,'R');
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Times', '', 12);
$pdf->Cell(40,5,'4',0,0,'C');
$pdf->Cell(40,5,'2300.00',0,0,'C');
$pdf->Cell(40,5,'2',0,0,'C');
$pdf->Cell(40,5,'4600.00',0,0,'C');
$pdf->Ln();
// $pdf->Ln();

$pdf->SetFont('Times', '', 12);
$pdf->Cell(40,5,'5',0,0,'C');
$pdf->Cell(40,5,'2000.00',0,0,'C');
$pdf->Cell(40,5,'1',0,0,'C');
$pdf->Cell(40,5,'4000.00',0,0,'C');
$pdf->Ln();
// $pdf->Ln();

$pdf->SetFont('Times', '', 12);
$pdf->Cell(40,5,'6',0,0,'C');
$pdf->Cell(40,5,'1500.00',0,0,'C');
$pdf->Cell(40,5,'2',0,0,'C');
$pdf->Cell(40,5,'3000.00',0,0,'C');
$pdf->Ln();
$pdf->Ln();


$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);
$pdf->Ln();
$pdf->Ln();
// $pdf->Ln();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(40,5,'Total Amount',0,0,'C');
$pdf->Cell(40,5,' ',0,0,'L');
$pdf->Cell(40,5,' ',0,0,'L');
// $pdf->Cell(30,5,' ',0,0,'L');
// $pdf->Cell(30,5,' ',0,0,'L');
// $total = number_format($data['total']).'.00';
$pdf->Cell(40,5,"230 000.00",0,0,'C');
$pdf->Ln();

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);
$pdf->Ln(1);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);

$pdf->Output();
?>