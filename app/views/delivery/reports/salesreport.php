<?php

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(23,24,23);
$pdf->AddPage();


$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt,Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Delivery Report',0,1,'C');

$pdf->Ln(20);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'Dealer ID',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": ".$data['name'] ,0,0,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,"",0,1,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30,5,'From',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(90,5,": ".$data['from'],0,0,'l');
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(20,5,'To',0,0,'l');
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,": ".$data['to'],0,1,'l');

$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(25,5,'Product Name',0,0,'L');
$pdf->Cell(50,5,'Quantity',0,0,'R');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Times', '', 12);
for ($i=0; $i <count($data['tableArr']); $i++) { 
    if($i==0){
        continue;
    }else{
        $pdf->Cell(25,5,$data['tableArr'][$i][0],0,0,'L');
        $pdf->Cell(50,5,$data['tableArr'][$i][1],0,0,'R');
        $pdf->Ln();
        //$sum +=floatval(str_replace(',','',$data['tableArr'][$i][3]));
    }
    
}

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+165, $y);

$pdf->Ln();
$pdf->Cell(25,5,'Total Earnngs',0,0,'R');
// $total = number_format($data['total']).'.00';
$pdf->Cell(50,5,'Rs.'.$data['revenue'],0,0,'R');
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