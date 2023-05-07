<?php

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(18,24,15);
$pdf->AddPage();


$pdf->SetFont('Times', '', 12);
$pdf->Cell(0,5,'Gasify (Pvt,Ltd)',0,1,'C');
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0,5,'Sales Report',0,1,'C');

$pdf->Ln(20);

$company_id = $data['filter_by'];
if($company_id != 'all'){
    $products = $data['table_info'];
    $product = $products[0];
    $company_name = $product['company'];
}else{
    $company_name = 'all';
}
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$todaydate = date('Y-m-d');
$todaytime = date('H:i:s');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30,5,'Company ID',0,0,'l');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(103,5,": {$company_id}",0,0,'l');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(20,5,'Time',0,0,'l');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,5,": {$todaytime}",0,1,'l');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30,5,'Company Name',0,0,'l');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(103,5,": {$company_name}",0,0,'l');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(20,5,'Date',0,0,'l');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,5,": {$todaydate}",0,1,'l');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30,5,'From',0,0,'l');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(103,5,": {$start_date}",0,1,'l');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(30,5,'To',0,0,'l');
$pdf->SetFont('Times', '', 10);
$pdf->Cell(90,5,": {$end_date}",0,0,'l');

$pdf->Ln(15);

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(7,5,'ID',0,0,'L');
$pdf->Cell(20,5,'Company',0,0,'L');
$pdf->Cell(25,5,'Product Name',0,0,'L');
$pdf->Cell(25,5,'Current Stock',0,0,'R');
$pdf->Cell(22,5,'Total Sale',0,0,'R');
$pdf->Cell(23,5,'Monthly Sale',0,0,'R');
$pdf->Cell(28,5,'Total Revenue',0,0,'R');
$pdf->Cell(25,5,'Availability',0,1,'R');
$pdf->Cell(122,5,'',0,0,'C');
$pdf->Cell(30,5,'(Rs.)',0,0,'C');
$pdf->Ln();
$pdf->Ln();

$total_sale = 0; $total_revenue = 0;
$pdf->SetFont('Times', '', 10);
foreach($data['table_info'] as $product){

    if($product['availability'] == PHP_INT_MAX){
        $product['availability'] = 'well-stocked';
    }elseif($product['availability'] == 1){
        $product['availability'] = $product['availability'].' month';
    }else{
        $product['availability'] = $product['availability'].' months';
    }

    $total_sale += $product['total_sale'];
    $total_revenue += $product['total_revenue'];
    $product['total_revenue'] = number_format($product['total_revenue'], 2);
    $pdf->Cell(7,5,"{$product['product_id']}",0,0,'L');
    $pdf->Cell(20,5,"{$product['company']}",0,0,'L');
    $pdf->Cell(25,5,"{$product['product_name']}",0,0,'L');
    $pdf->Cell(25,5,"{$product['current_stock']}",0,0,'R');
    $pdf->Cell(20,5,"{$product['total_sale']}",0,0,'R');
    $pdf->Cell(23,5,"{$product['monthly_sale']}",0,0,'R');
    $pdf->Cell(28,5,"{$product['total_revenue']}",0,0,'R');
    $pdf->Cell(25,5,"{$product['availability']}",0,0,'R');
    $pdf->Ln();
}

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+172, $y);

$pdf->Ln();
$pdf->Cell(77,5,'Total',0,0,'R');
$total_revenue = number_format($total_revenue,2);
$pdf->Cell(20,5,"{$total_sale}",0,0,'R');
$pdf->Cell(51,5,"{$total_revenue}",0,0,'R');
$pdf->Ln();

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+172, $y);
$pdf->Ln(1);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Line($x, $y, $x+172, $y);

$pdf->Output();
?>