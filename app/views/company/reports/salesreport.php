<?php
date_default_timezone_set("Asia/Colombo");
$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();


$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt.Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Sales Report',0,1,'C');

$pdf->Ln(20);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Company ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": GS001",0,0,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Time',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": ".date("h:i:sa"),0,1,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Company Name',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": Litro Gas",0,0,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'Date',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": ".date("Y/m/d"),0,1,'l');

$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(25,5,'Product ID',0,0,'L');
$pdf->Cell(30,5,'Product Name',0,0,'L');
$pdf->Cell(38,5,'Sold Quantity',0,0,'C');
$pdf->Cell(38,5,'Total Amount (Rs)',0,0,'R');
//$pdf->Cell(33,5,'Percentage',0,0,'R');
$pdf->Ln();
$pdf->Ln();

// $products = $data['products'];
$pdf->SetFont('Times', '', 12);
// foreach($products as $product){
//     $pdf->Cell(33,5,"{$product['product_id']}",0,0,'L');
//     $pdf->Cell(33,5,"{$product['product_name']}",0,0,'L');
//     $pdf->Cell(33,5,"{$product['quantity']}",0,0,'R');
//     $unit_price = number_format($product['unit_price']).'.00';
//     $pdf->Cell(33,5,"{$unit_price}",0,0,'R');
//     $subtotal = number_format($product['subtotal']).'.00';
//     $pdf->Cell(33,5,"{$subtotal}",0,0,'R');
//     $pdf->Ln();
// }

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);
$pdf->Ln();


$pdf->Cell(25,5,'LT001',0,0,'L');
$pdf->Cell(30,5,'Budget(Refill)',0,0,'L');
$pdf->Cell(38,5,'360',0,0,'C');
$pdf->Cell(38,5,'302,400',0,0,'R');
$pdf->Ln();
$pdf->Cell(25,5,'LT002',0,0,'L');
$pdf->Cell(30,5,'Buddy(Refill)',0,0,'L');
$pdf->Cell(38,5,'288',0,0,'C');
$pdf->Cell(38,5,'370,080',0,0,'R');
$pdf->Ln();
$pdf->Cell(25,5,'LT003',0,0,'L');
$pdf->Cell(30,5,'Regular(Refill)',0,0,'L');
$pdf->Cell(38,5,'569',0,0,'C');
$pdf->Cell(38,5,'1,820,800',0,0,'R');
$pdf->Ln();
$pdf->Cell(25,5,'LT004',0,0,'L');
$pdf->Cell(30,5,'Commercial(Refill)',0,0,'L');
$pdf->Cell(38,5,'175',0,0,'C');
$pdf->Cell(38,5,'986,125',0,0,'R');
$pdf->Ln();
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);
$pdf->Cell(25,5,'',0,0,'L');
$pdf->Cell(30,5,'',0,0,'L');
$pdf->Cell(38,5,'',0,0,'C');
$pdf->Cell(38,5,'3,479,405',0,0,'R');
//$pdf->Cell(33,5,'Percentage',0,0,'R');

// $total = number_format($data['total']).'.00';
// $pdf->Cell(33,5,"{$total}",0,0,'R');
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