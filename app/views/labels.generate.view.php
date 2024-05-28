<?php
    //require('fpdf/makefont/makefont.php');
    //MakeFont('fpdf/makefont/Arialpl.ttf','ISO-8859-2');

    require(ROOT_PLUGINS.'fpdf/fpdf.php');//require('fpdf/fpdf.php');
    include(ROOT_PLUGINS.'phpqrcode/qrlib.php');//include('phpqrcode/qrlib.php');

    $sku = $data["sku"];
    $prod_name = $data["prod_name"];
    $al = "Alergeny: ";
    $alergens = $data["alergens"];
    $txt = "Lista alergenów na stronie:";
    $link = "www.pan-obiadek.pl/alergeny";
    $prod = "Data produkcji: ";
    $date = $data["date"];

    $prod_name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $prod_name);
    $txt = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $txt);

    $pdfWidth = 29;
    $pdfHeight = 62;

    $tempDir = 'temp/';
    if (!file_exists($tempDir)) {
        mkdir($tempDir);
    }
    $qrFileName = $tempDir . 'qrcode.png';

    $textToEncode = $sku;
    QRcode::png($textToEncode, $qrFileName, QR_ECLEVEL_L, 2);

    $pdf = new FPDF('L', 'mm', array($pdfHeight, $pdfWidth));
    $pdf->SetAutoPageBreak(false);

    $pdf->AddPage(); 

    $pdf->AddFont('Arialpl', '', 'Arialpl.php','font');
    $pdf->SetFont('Arialpl', '', 8);

    $imageWidth = 16;
    $imageHeight = 16;

    $pdf->Image($qrFileName, 0, 1, $imageWidth, $imageHeight); 
    $pdf->SetXY(16, 3);
    $pdf->MultiCell(44, 3, $prod_name, 0, 1);
    $pdf->SetXY(0, 15); 
    $pdf->MultiCell(62, 5, $al . $alergens, 0, 'L');
    $pdf->SetXY(12, 19);
    $pdf->MultiCell(62, 5, $txt, 0, 'L');
    $pdf->SetXY(11, 22);
    $pdf->MultiCell(62, 5, $link, 0, 'L');
    $pdf->SetXY(14, 10);
    $pdf->Cell(0, 5, $prod . $date, 0, 1);

    $pdf->Output(); 
    unlink($qrFileName);