<?php
    //require('fpdf/makefont/makefont.php');
    //MakeFont('fpdf/makefont/Arialpl.ttf','ISO-8859-2');

    require(ROOT_PLUGINS.'fpdf/fpdf.php');//require('fpdf/fpdf.php');
    include(ROOT_PLUGINS.'phpqrcode/qrlib.php');//include('phpqrcode/qrlib.php');


    $my_name = $data["my_name"];
    $company = "Pan Obiadek";

    $my_name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $my_name);

    $pdfWidth = 62;
    $pdfHeight = 29;

    $pdf = new FPDF('L', 'mm', array($pdfHeight, $pdfWidth));
    $pdf->SetAutoPageBreak(false);

    $pdf->AddPage(); 

    $pdf->AddFont('Arialpl', '', 'Arialpl.php','font');
    $pdf->SetFont('Arialpl', '', 12);

    // Wyśrodkowanie nazwy firmy na górze
    $pdf->SetXY(0, 4);
    $pdf->MultiCell($pdfWidth, 6, $company, 0, 'C');

    // Wyśrodkowanie imienia i nazwiska poniżej nazwy firmy
    $pdf->SetXY(0, 14);
    $pdf->MultiCell($pdfWidth, 6, $my_name, 0, 'C');

    $pdf->Output(); 
    unlink($qrFileName);