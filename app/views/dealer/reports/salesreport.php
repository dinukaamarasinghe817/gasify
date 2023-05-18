<?php

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();


$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt,Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Sales Report',0,1,'C');

$pdf->Ln(20);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Dealer ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": {$data['dealer_id']}",0,0,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Issue Date',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": {$data['issue_date']}",0,1,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Business Name',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": {$data['business_name']}",0,0,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Issue Time',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": {$data['issue_time']}",0,1,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'From',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": {$data['start_date']}",0,1,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'To',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": {$data['end_date']}",0,1,'l');
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(25,5,'Product ID',0,0,'L');
$pdf->Cell(32,5,'Product Name',0,0,'L');
$pdf->Cell(19,5,'Catagory',0,0,'L');
$pdf->Cell(25,5,'Quantity',0,0,'C');
$pdf->Cell(35,5,'Total Amount (Rs)',0,0,'R');
$pdf->Cell(30,5,'Percentage',0,0,'R');
$pdf->Ln();
$pdf->Ln();

$products = $data['tabledata'];
$pdf->SetFont('Times', '', 12);
$total_earnings = 0;
$total_qty = 0;
foreach($products as $product){
    $pdf->Cell(25,5,"{$product['id']}",0,0,'L');
    $pdf->Cell(32,5,"{$product['name']}",0,0,'L');
    $product['catagory'] = ucwords($product['catagory']);
    $pdf->Cell(19,5,"{$product['catagory']}",0,0,'L');
    $pdf->Cell(25,5,"{$product['sold_quantity']}",0,0,'C');
    $unit_price = number_format($product['total_earnings'],2);
    $pdf->Cell(35,5,"{$unit_price }",0,0,'R');
    // $subtotal = number_format($product['subtotal']).'.00';
    $pdf->Cell(30,5,"{$product['percentage']} %",0,0,'R');
    $pdf->Ln();
    $total_earnings += $product['total_earnings'];
    $total_qty += $product['sold_quantity'];
}

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);

$pdf->Ln();
$pdf->Cell(76,5,'Total',0,0,'R');
$total_earnings = number_format($total_earnings,2);
$total_qty = number_format($total_qty);
$pdf->Cell(25,5,"{$total_qty}",0,0,'C');
$pdf->Cell(35,5,"{$total_earnings}",0,0,'R');
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