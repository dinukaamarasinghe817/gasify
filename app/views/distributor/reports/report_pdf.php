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
// $pdf ->Cell(0,5,'Hello',0,1,'');
// $pdf ->Cell(0,5,count($details),0,1,'');
$pdf->Ln();
$pdf->Ln();


// $pdf->SetFont('Times', '', 12);

// $details = $data['reportdetails'];
// foreach($details as $detail) {
//     $row1 = $detail['details'];

//     $distribution_no = $row1['distribution_no'];
// }

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(30,5,'Distribution No',0,0,'l');
    $pdf->SetFont('Times', '', 12);
    // $pdf->Cell(90,5,": {$row1['distribution_no']}",0,0,'l');
    // $pdf->Cell(90,5,": $distribution_no",0,0,'l');
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
    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(40,5,'4',0,0,'C');
    $pdf->Cell(40,5,'2300.00',0,0,'C');
    $pdf->Cell(40,5,'2',0,0,'C');
    $pdf->Cell(40,5,'4600.00',0,0,'C');
    $pdf->Ln();




// $row = mysqli_fetch_assoc($details);
// echo count($details);
// echo "HI";
// $name = "Hashini";
// $distribution_no = $details['distribution_no'];




// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(30,5,'Distribution No',0,0,'l');
// $pdf->SetFont('Times', '', 12);
// // $pdf->Cell(90,5,": {$data['distribution_no']}",0,0,'l');
// $pdf->Cell(90,5,": $distribution_no",0,0,'l');
// $pdf->Cell(90,5,": 58",0,0,'l');

// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(20,5,'Date',0,0,'l');
// $pdf->SetFont('Times', '', 12);
// // $pdf->Cell(0,5,": {$data['date']}",0,1,'l');
// $pdf->Cell(0,5,": 2023.03.04",0,1,'l');

// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(30,5,'Dealer ID',0,0,'l');
// $pdf->SetFont('Times', '', 12);
// // $pdf->Cell(90,5,": {$data['dealer_id']}",0,0,'l');
// $pdf->Cell(90,5,": 06",0,0,'l');

// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(20,5,'Time',0,0,'l');
// $pdf->SetFont('Times', '', 12);
// // $pdf->Cell(0,5,": {$data['time']}",0,1,'l');
// $pdf->Cell(0,5,": 13:40:20",0,1,'l');

// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(30,5,'Business Name',0,0,'l');
// $pdf->SetFont('Times', '', 12);
// // $pdf->Cell(90,5,": {$data['business_name']}",0,1,'l');
// $pdf->Cell(90,5,": ABC",0,1,'l');

// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(30,5,'Distributor ID',0,0,'l');
// $pdf->SetFont('Times', '', 12);
// // $pdf->Cell(90,5,": {$data['distributor_id']}",0,1,'l');
// $pdf->Cell(90,5,": 26",0,1,'l');
// $pdf->Ln(10);

// $pdf->SetFont('Times', 'B', 12);
// $pdf->Cell(40,5,'Product ID',0,0,'C');
// $pdf->Cell(40,5,'Unit Prie (Rs)',0,0,'C');
// $pdf->Cell(40,5,'Sold Quantity',0,0,'C');
// $pdf->Cell(40,5,'Sub Total (Rs)',0,0,'C');
// $pdf->Ln();
// $pdf->Ln();

// $details = $data['reportdetails'];
// $pdf->SetFont('Times', '', 12);
// foreach($details as $detail) {
//     $pdf->Cell(40,5,"{$detail['product_id']}",0,0,'L');
//     $pdf->Cell(40,5,"{$detail['quantity']}",0,0,'L');
//     $unit_price = number_format($detail['unit_price']).'.00';
//     $pdf->Cell(40,5,"{$unit_price}",0,0,'L');
    // $subtotal = number_format($detail['subtotal']).'.00';
    // $pdf->Cell(40,5,"{$subtotal}",0,0,'L');
//     $pdf->Ln();
// }


// $pdf->SetFont('Times', '', 12);
// $pdf->Cell(40,5,'4',0,0,'C');
// $pdf->Cell(40,5,'2300.00',0,0,'C');
// $pdf->Cell(40,5,'2',0,0,'C');
// $pdf->Cell(40,5,'4600.00',0,0,'C');
// $pdf->Ln();

// $pdf->SetFont('Times', '', 12);
// $pdf->Cell(40,5,'5',0,0,'C');
// $pdf->Cell(40,5,'2000.00',0,0,'C');
// $pdf->Cell(40,5,'1',0,0,'C');
// $pdf->Cell(40,5,'4000.00',0,0,'C');
// $pdf->Ln();

// $pdf->SetFont('Times', '', 12);
// $pdf->Cell(40,5,'6',0,0,'C');
// $pdf->Cell(40,5,'1500.00',0,0,'C');
// $pdf->Cell(40,5,'2',0,0,'C');
// $pdf->Cell(40,5,'3000.00',0,0,'C');
// $pdf->Ln();

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
$pdf->Cell(40,5,23000,0,0,'C');
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