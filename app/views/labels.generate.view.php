<?php
    //require('fpdf/makefont/makefont.php');
    //MakeFont('fpdf/makefont/Arialpl.ttf','ISO-8859-2');

    require(ROOT_PLUGINS.'fpdf/fpdf.php');//require('fpdf/fpdf.php');
    include(ROOT_PLUGINS.'phpqrcode/qrlib.php');//include('phpqrcode/qrlib.php');

    $sku = $data["sku"];
    $prod_name = $data["prod_name"];
    $prod_name_type = substr($prod_name,0,7);
    $prod_name_nal = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $prod_name);

    $array = explode(", ", $data["alergens"]);
    sort($array);
    $data["alergens"] = implode(", ", $array);
    
    if (strlen($prod_name) > 101) {
        $prod_name = substr($prod_name, 0, 101) . '...';
    }
    $term = "Należy spożyć do: ";
    $al = "Alergeny: ";
    $alergens = $data["alergens"];
    $link = "www.pan-obiadek.pl/alergeny";
    $txt = "Lista alergenów: ".$link;
    $prod = "Data produkcji: ";
    if($data["kcal"] > 0) {
        $kcal = "Kalorie: ".$data["kcal"]."kcal";
    } else {
        $kcal = "";
    }
    $date = $data["date"];

    $prod_name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $prod_name);
    $txt = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $txt);
    $term = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $term);

    $pdfWidth = 29;
    $pdfHeight = 62;

    $tempDir = IMG_ROOT_UPLOAD;
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

    $prod_type = substr($sku,0,4);
    if($prod_type == "1-01" || $prod_name_type == "Granola" || $data["id"] == 14) {
        if (strlen($prod_name) > 51) {
            $prod_name = substr($prod_name, 0, 51) . '...';
        }
        $dateTime = DateTime::createFromFormat('d.m.Y', $date);
        $dateTime->modify('+2 day');
        $newDate = $dateTime->format('d.m.Y');
        $pdf->SetXY(15, 10);
        $pdf->Cell(0, 10, $term . $newDate, 0, 1);
        $pdf->SetXY(15, 7);
        $pdf->Cell(0, 10, $prod . $date, 0, 1);
    } else {
        $pdf->SetXY(15, 10);
        $pdf->Cell(0, 10, $prod . $date, 0, 1);
    }

    $pdf->Image($qrFileName, 0, 1, $imageWidth, $imageHeight); 
    $pdf->SetXY(16, 3);
    $pdf->MultiCell(46, 2.5, $prod_name, 0, 1);
    $pdf->SetXY(0, 15); 
    $pdf->MultiCell(62, 6, $al . $alergens, 0, 'L');
    $pdf->SetXY(0, 19);
    $pdf->MultiCell(62, 5, $kcal, 0, 'L');
    $pdf->SetXY(0, 22);
    $pdf->MultiCell(62, 5, $txt, 0, 'L');

    $pdf->Output(); 
    unlink($qrFileName);