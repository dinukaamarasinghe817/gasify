<?php

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();


$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt,Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Purchase Order Details',0,1,'C');

$pdf->Ln(20);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Stock Request ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": {$data['stock_req_id']}",0,0,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Date',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": {$data['date']}",0,1,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Distributor ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": {$data['distributor_id']}",0,0,'l');

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Time',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": {$data['time']}",0,1,'l');

$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(33,5,'Item Code',0,0,'L');
$pdf->Cell(33,5,'Description',0,0,'L');
$pdf->Cell(33,5,'Quantity',0,0,'R');
$pdf->Cell(33,5,'Unit Price (Rs)',0,0,'R');
$pdf->Cell(33,5,'SubTotal (Rs)',0,0,'R');
$pdf->Ln();
$pdf->Ln();

$products = $data['products'];
$pdf->SetFont('Times', '', 12);
foreach($products as $product){
    $pdf->Cell(33,5,"{$product['product_id']}",0,0,'L');
    $pdf->Cell(33,5,"{$product['product_name']}",0,0,'L');
    $pdf->Cell(33,5,"{$product['quantity']}",0,0,'R');
    $unit_price = number_format($product['unit_price']).'.00';
    $pdf->Cell(33,5,"{$unit_price}",0,0,'R');
    $subtotal = number_format($product['subtotal']).'.00';
    $pdf->Cell(33,5,"{$subtotal}",0,0,'R');
    $pdf->Ln();
}

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);

$pdf->Ln();
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(132,5,'Total Amount (Rs)',0,0,'R');
$total = number_format($data['total']).'.00';
$pdf->Cell(33,5,"{$total}",0,0,'R');
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
