<?php
//require('fpdf/makefont/makefont.php');
//MakeFont('fpdf/makefont/Arialpl.ttf','ISO-8859-2');

require(ROOT_PLUGINS . 'fpdf/fpdf.php');//require('fpdf/fpdf.php');
include(ROOT_PLUGINS . 'phpqrcode/qrlib.php');//include('phpqrcode/qrlib.php');

//show($data["alergen"]);

if ($data["show_prod_date"] > 0) {
    $date_show_to = $data["show_prod_date"]; // ile dni terminu przydatku
} else {
    $date_show_to = 0;
}

$sku = $data["sku"];
$prod_name = $data["prod_name"];
$prod_name_type = substr($prod_name, 0, 7);
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
$txt = "Lista alergenów: " . $link;
$txt = $data["alergen"]; // TU USUNĄĆ JAKBY CO
$ntxt = "Może zawierać: ";
$prod = "Data produkcji: ";
$producent = "Prod.: Radluks Sp. z o.o. NIP: 7963011952";
if ($data["kcal"] > 0) {
    $kcal = "Kalorie: " . $data["kcal"] . "kcal";
} else {
    $kcal = "";
}
$date = $data["date"];

$prod_name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $prod_name);
$txt = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $txt);
$ntxt = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $ntxt);
$term = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $term);
$producent = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $producent);

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

$pdf->AddFont('Arialpl', '', 'Arialpl.php', 'font');
$pdf->SetFont('Arialpl', '', 8);

$imageWidth = 16;
$imageHeight = 16;

$prod_type = substr($sku, 0, 4);
if ($date_show_to > 0) {
    if (strlen($prod_name) > 51) {
        $prod_name = substr($prod_name, 0, 51) . '...';
    }
    $dateTime = DateTime::createFromFormat('d.m.Y', $date);
    $dateTime->modify('+' . $date_show_to . ' day');
    $newDate = $dateTime->format('d.m.Y');
    $pdf->SetXY(15, 9);
    $pdf->Cell(0, 10, $term . $newDate, 0, 1);
    $pdf->SetXY(15, 6);
    $pdf->Cell(0, 10, $prod . $date, 0, 1);
} else {
    $pdf->SetXY(15, 10);
    $pdf->Cell(0, 10, $prod . $date, 0, 1);
}

$pdf->Image($qrFileName, 0, 1, $imageWidth, $imageHeight);
$pdf->SetXY(16, 3);
$pdf->MultiCell(46, 2.5, $prod_name, 0, 1);
$new = true; //bez linka do strony
if ($new) {
    $new2 = true; //bez kcal z nazwa firmy
    if ($new2) {
        $pdf->SetXY(1, 16);
        $pdf->MultiCell(60, 3, $ntxt . $txt, 0, 'L');
        $pdf->SetXY(1, 23);
        $pdf->MultiCell(60, 3, $producent, 0, 'L');
    } else {
        $pdf->SetXY(1, 14);
        $pdf->MultiCell(62, 6, $kcal, 0, 'L');
        $pdf->SetXY(1, 19);
        $pdf->MultiCell(60, 3, $ntxt . $txt, 0, 'L');
    }
} else {
    $pdf->SetXY(1, 15);
    $pdf->MultiCell(62, 6, $al . $alergens, 0, 'L');
    $pdf->SetXY(1, 19);
    $pdf->MultiCell(62, 5, $kcal, 0, 'L');
    $pdf->SetXY(1, 22);
    $pdf->MultiCell(62, 5, $txt, 0, 'L');
}

$pdf->Output();
unlink($qrFileName);