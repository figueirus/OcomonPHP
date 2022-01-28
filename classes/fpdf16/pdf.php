<?php
define('FPDF_FONTPATH', 'font/');
require('fpdf.php'); // onde xxx é a versão da FPDF
$pdf = new FPDF();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Write(4, 'Olá Mundo!!');
$pdf->Output();
?>
