<?php
// echo "all sell products pdf report";

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();

$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt , Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Solt Items Report',0,1,'C');
$pdf->Ln(7);


$details = $data['details'];
$pdf->Ln();
$pdf->Ln();

$details = $data['details'];
$duration = $details['duration'];
$quantities = $details['quantites'];

$today = date('Y-m-d');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Issued Date',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": $today",0,0,'l');

$current_time = date("H:i:s");

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Issued Time',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": $current_time",0,0,'l');

$pdf->Ln();
$pdf->Ln();
// $pdf->Ln();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Time Duration',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": $duration ",0,0,'l');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(40,5,'Product ID',0,0,'C');
$pdf->Cell(40,5,'Product Name',0,0,'C');
$pdf->Cell(40,5,'Sold Quantity',0,0,'C');
$pdf->Ln();
$pdf->Ln();

$details = $data['details'];
// $duration = $details['duration'];
$quantities = $details['quantites'];
// var_dump($quantities);



$pdf->SetFont('Times', '', 12);
foreach($quantities as $quantity){
    $product_id = $capacity['product_id'];
    // $product_name = $capacity['name'];
    // $quantity = $capacity['quantity'];
    

    // $pdf->Cell(33,5,"{$capacity['product_id']}",0,0,'C');
    $pdf->Cell(33,5,"{$product_id}",0,0,'C');
    $pdf->Cell(33,5,"{$capacity['name']}",0,0,'C');
    $pdf->Cell(33,5,"{$capacity['quantity']}",0,0,'R');
    $pdf->Ln();
}

$pdf->Ln();












// $x = $pdf->GetX();
// $y = $pdf->GetY();
// $pdf->Line($x, $y, $x+165, $y);
// $pdf->Ln(1);

// $x = $pdf->GetX();
// $y = $pdf->GetY();
// $pdf->Line($x, $y, $x+165, $y);

$pdf->Output();


?>