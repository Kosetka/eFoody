<?php
    require(ROOT_PLUGINS.'fpdf/fpdf.php');//require('fpdf/fpdf.php');
    include(ROOT_PLUGINS.'phpqrcode/qrlib.php');//include('phpqrcode/qrlib.php');

    $prod_name = $data["prod"]["name"];
    $full_products = strtolower($data["prod"]["full_products"]);

    $ingr = "Składniki: ";
    $txt = "Lista alergenów: ";
    $txt_ale = strtolower($data["prod"]["alergen"]);
    
    if (strlen($prod_name) > 101) {
        $prod_name = substr($prod_name, 0, 101) . '...';
    }
    $prod = "Data produkcji: ";
    $prod_d = $data["prod"]["date_prod"];
    $term = "Należy spożyć do: ";
    $term_d = $data["prod"]["date_term"];
    $netto = "Zawartość netto: ";
    $netto_g = $data["prod"]["netto"];

    $war_p = "Warunki przechowywania: ";
    $war = "Przechowywać w suchym i chłodnym miejscu. Chronić przed działaniem promieni słonecznych. Nie zamrażać.";


    $producent = "Producent: ";
    $producent_adr1 = $data["comp"]["name"];
    $producent_adr2 = $data["comp"]["address"];
    $producent_adr3 = $data["comp"]["address2"];

    

    $date = $data["date"];

    
    
    $prod_name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $prod_name);
    $ingr = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $ingr);
    $full_products = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $full_products);
    $txt = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $txt);
    $txt_ale = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $txt_ale);
    $prod = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $prod);
    $term = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $term);
    $netto = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $netto);
    $war = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $war);
    $war_p = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $war_p);
    $producent_adr1 = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $producent_adr1);
    $producent_adr2 = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $producent_adr2);
    $producent_adr3 = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $producent_adr3);
    
    $pdfWidth = 100;
    $pdfHeight = 102;

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
    $pdf->SetFont('Arialpl', '', 12);

    $imageWidth = 24;
    $imageHeight = 24;

    $prod_type = substr($sku,0,4);
    
    if (strlen($prod_name) > 80) {
        $prod_name = substr($prod_name, 0, 80) . '...';
    }

    //nazwa
    $pdf->SetFont('Arialpl', '', 16);
    $pdf->SetXY(3, 5); 
    $pdf->MultiCell(46, 2.5, $prod_name, 0, 1);
    $pdf->SetXY(3, 5); 
    $pdf->MultiCell(46, 2.5, $prod_name, 0, 1);
    $pdf->SetXY(3, 5); 
    $pdf->MultiCell(46, 2.5, $prod_name, 0, 1);

    //składniki
    $pdf->SetFont('Arialpl', '', 9);
    $pdf->SetXY(3, 18); 
    $pdf->MultiCell(96, 4, $ingr.$full_products, 0, 1);
    $pdf->SetXY(3, 18); 
    $pdf->MultiCell(96, 4, $ingr, 0, 1);
    $pdf->SetXY(3, 18); 
    $pdf->MultiCell(96, 4, $ingr, 0, 1);

    //alergeny
    $pdf->SetFont('Arialpl', '', 9);
    $pdf->SetXY(3, 40); 
    $pdf->MultiCell(96, 4, $txt.$txt_ale, 0, 1);
    $pdf->SetXY(3, 40); 
    $pdf->MultiCell(96, 4, $txt, 0, 1);
    $pdf->SetXY(3, 40); 
    $pdf->MultiCell(96, 4, $txt, 0, 1);

    //netto i daty
    $pdf->SetFont('Arialpl', '', 9);
    $pdf->SetXY(3, 55); 
    $pdf->MultiCell(96, 4, $netto.$netto_g."g", 0, 1);
    $pdf->SetXY(3, 55); 
    $pdf->MultiCell(96, 4, $netto, 0, 1);
    $pdf->SetXY(3, 55); 
    $pdf->MultiCell(96, 4, $netto, 0, 1);

    $pdf->SetXY(52, 52); 
    $pdf->MultiCell(96, 4, $prod.$prod_d, 0, 1);
    $pdf->SetXY(52, 52); 
    $pdf->MultiCell(96, 4, $prod, 0, 1);
    $pdf->SetXY(52, 52); 
    $pdf->MultiCell(96, 4, $prod, 0, 1);

    $pdf->SetXY(52, 57); 
    $pdf->MultiCell(96, 4, $term.$term_d, 0, 1);
    $pdf->SetXY(52, 57); 
    $pdf->MultiCell(96, 4, $term, 0, 1);
    $pdf->SetXY(52, 57); 
    $pdf->MultiCell(96, 4, $term, 0, 1);

    //warunki przechowywania
    $pdf->SetXY(3, 63); 
    $pdf->MultiCell(96, 4, $war_p.$war, 0, 1);
    $pdf->SetXY(3, 63); 
    $pdf->MultiCell(96, 4, $war_p, 0, 1);
    $pdf->SetXY(3, 63); 
    $pdf->MultiCell(96, 4, $war_p, 0, 1);

    //producent
    $pdf->SetXY(20, 76); 
    $pdf->MultiCell(96, 4, $producent, 0, 1);
    $pdf->SetXY(20, 76); 
    $pdf->MultiCell(96, 4, $producent, 0, 1);
    $pdf->SetXY(20, 76); 
    $pdf->MultiCell(96, 4, $producent, 0, 1);

    $pdf->SetXY(15, 80); 
    $pdf->MultiCell(96, 4, $producent_adr1, 0, 1);
    $pdf->SetXY(15, 84); 
    $pdf->MultiCell(96, 4, $producent_adr2, 0, 1);
    $pdf->SetXY(15, 88); 
    $pdf->MultiCell(96, 4, $producent_adr3, 0, 1);

    //QR
    $pdf->SetXY(50, 76); 
    $pdf->Image($qrFileName, 70, 72, $imageWidth, $imageHeight); 

    $pdf->Output(); 
    unlink($qrFileName);