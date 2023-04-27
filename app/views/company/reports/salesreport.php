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
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);

$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(25,5,'Product name',0,0,'L');
$pdf->Cell(40,5,'Unit price (Rs)',0,0,'C');
$pdf->Cell(45,5,'Sold Quantity',0,0,'C');
$pdf->Cell(50,5,'Total Amount (Rs)',0,0,'R');
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
$sum=0;
for ($i=0; $i <count($data['tableArr'])-1; $i++) { 
    if($i==0){
        continue;
    }else{
        $pdf->Cell(25,5,$data['tableArr'][$i][0],0,0,'L');
        $pdf->Cell(40,5,$data['tableArr'][$i][1],0,0,'C');
        $pdf->Cell(45,5,$data['tableArr'][$i][2],0,0,'C');
        $pdf->Cell(50,5,$data['tableArr'][$i][3],0,0,'R');
        $pdf->Ln();
        $sum +=floatval(str_replace(',','',$data['tableArr'][$i][3]));
    }
    
}
$pdf->Ln();
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);
$pdf->Cell(25,5,'',0,0,'L');
$pdf->Cell(40,5,'',0,0,'L');
$pdf->Cell(45,5,'',0,0,'C');
$pdf->Cell(50,5,number_format($sum,2),0,0,'R');
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

//$pdf->Output('',$data['distname'].' Report'.'('.$data['from'].'-'.$data['to'].')');
$pdf->Output();

?>