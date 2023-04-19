<?php 

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();

$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt , Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Gas Distribution Report',0,1,'C');
$pdf->Ln(7);

$details = $data['reportdetails'];
$pdf->Ln();
$pdf->Ln();

$details = $data['reportdetails'];
$products = $details['quantites'];
$details = $details['details'];

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(30,5,'Distribution No',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(90,5,": {$details['distribution_no']}",0,0,'l');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(20,5,'Date',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(0,5,": {$details['date']}",0,0,'l');
    $pdf->Ln();

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(30,5,'Dealer ID',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(90,5,": {$details['dealer_id']}",0,0,'l');

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(20,5,'Time',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(0,5,": {$details['time']}",0,0,'l');
    $pdf->Ln();

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(30,5,'Business Name',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(90,5,": {$details['name']}",0,0,'l');
    $pdf->Ln();

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(30,5,'Distributor ID',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(90,5,": {$details['distributor_id']}",0,0,'l');
    $pdf->Ln(15);

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(40,5,'Product ID',0,0,'C');
    $pdf->Cell(40,5,'Unit Price (Rs)',0,0,'C');
    $pdf->Cell(40,5,'Sold Quantity',0,0,'C');
    $pdf->Cell(40,5,'Sub Total (Rs)',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Times', '', 12);
    $total =0;
    foreach($products as $product){
    $pdf->Cell(33,5,"{$product['product_id']}",0,0,'C');
    $unit_price = number_format($product['unit_price']).'.00';
    $pdf->Cell(33,5,"{$unit_price}",0,0,'R');
    $pdf->Cell(33,5,"{$product['quantity']}",0,0,'R');
    
    $subtotal = $product['unit_price'] * $product['quantity'];
    // $subtotal = number_format($subtotal).'.00';
    $pdf->Cell(50,5,"{$subtotal}.00",0,0,'R');
    $pdf->Ln();
    $total += $subtotal;
}

$pdf->Ln();

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(40,5,'Total Amount',0,0,'C');
$pdf->Cell(40,5,' ',0,0,'L');
$pdf->Cell(40,5,' ',0,0,'L');
// $total = number_format($data['total']).'.00';
$pdf->Cell(30,5,"{$total}.00",0,0,'R');
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