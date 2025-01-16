<?php

require(ROOT_PLUGINS . 'fpdf/fpdf.php');
$pdf = new FPDF('L', 'mm', 'A4');

$date = $data["date"];

//show($data["cargo_before"]);

//die;


foreach ($data["cargo_before"] as $company) {
    if (empty($company["street"]) || empty($company["street_number"])) {
        $address = $company["full_name"];
    } else {
        $address = $company["street"] . " " . $company["street_number"];
    }
    //show($company["return"]["sku"]);die;
    if (isset($company["return"]["sku"])) {
        $to_send = $company["return"]["sku"];
    } else {
        $to_send = [];
    }
    //show($company);die;
    generatePage($company["get"]["sku"], $to_send, $date, $pdf, $address);
}
//show($data["cargo_before"]);
//die;

$pdf->Output();



function generatePage($prod, $prod2, $date, $pdf, $address)
{

    $pdf->AddPage();

    $pdf->AddFont('Arialpl', '', 'Arialpl.php', 'font');
    $pdf->SetFont('Arialpl', '', 8);
    $text_rect = "(pieczęć dostawcy)";
    $text_pod1 = "(pieczęć i podpis odbiorcy)";
    $text_pod2 = "(pieczęć i podpis dostawcy)";
    $text_dd = "DOWÓD DOSTAWY";
    $text_po = "Odbiorca:";
    $text_data = "Data:";
    $text_odbiorca = $address;
    $text_returns = "ZWROTY";
    $text_val = "zł";
    $text[1] = "Nazwa towaru";
    $text[2] = "Ilość";
    $text[3] = "Cena za jedn.";
    $text[4] = "Wartość";
    $text_topay = "DO ZAPŁATY";
    $text_fl = "";
    $offsetX = 6;
    $total_sum = 0;

    

    $p_1 = count($prod);
    if ($p_1 <= 5) {
        $p_1++;
    }

    $p_2 = count($prod2);
    if ($p_2 <= 5) {
        $p_2++;
    }
    $total_products = $p_1 + $p_2;
    //show($total_products);
    $pdf->SetFillColor(212, 217, 219);

    $text_rect = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_rect);
    $text_val = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_val);
    $text_pod1 = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_pod1);
    $text_pod2 = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_pod2);
    $text_dd = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_dd);
    $text_po = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_po);
    $text_data = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_data);
    $text_odbiorca = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_odbiorca);
    $text_returns = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_returns);
    $text_topay = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text_topay);
    $text[1] = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text[1]);
    $text[2] = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text[2]);
    $text[3] = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text[3]);
    $text[4] = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $text[4]);


    $pageWidth = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();

    $middleX = $pageWidth / 2;

    $pdf->SetLineWidth(0.5);
    for ($y = 0; $y < $pageWidth; $y += 12) {
        $pdf->Line($middleX, $y, $middleX, $y + 4);
    }

    // Dodanie prostokąta w lewym górnym rogu
    $rectWidth = 52;
    $rectHeight = 30;
    $pdf->Rect($offsetX, $offsetX, $rectWidth, $rectHeight);
    $pdf->Rect($middleX + $offsetX, $offsetX, $rectWidth, $rectHeight);
    $pdf->Text($offsetX + ($rectWidth / 2) - ($pdf->GetStringWidth($text_rect) / 2), $rectHeight + ($offsetX - 1), $text_rect);
    $pdf->Text($middleX + $offsetX + ($rectWidth / 2) - ($pdf->GetStringWidth($text_rect) / 2), $rectHeight + ($offsetX - 1), $text_rect);

    // Dodanie pola daty w lewym górnym
    $pdf->SetFont('Arialpl', '', 12);
    $dataWidth = 52;
    $dataHeight = 8;
    $pdf->Rect($offsetX, $offsetX + 2 + $rectHeight, $dataWidth, $dataHeight);
    $pdf->Rect($middleX + $offsetX, $offsetX + 2 + $rectHeight, $dataWidth, $dataHeight);
    $pdf->Text($offsetX + 2, $dataHeight + ($offsetX) + $rectHeight, $text_data);
    $pdf->Text($offsetX + 2, $dataHeight + ($offsetX) + $rectHeight, $text_data);
    $pdf->Text($middleX + $offsetX + 2, $dataHeight + ($offsetX) + $rectHeight, $text_data);
    $pdf->Text($middleX + $offsetX + 2, $dataHeight + ($offsetX) + $rectHeight, $text_data);

    $pdf->Text($offsetX + 2 + 12, $dataHeight + ($offsetX) + $rectHeight, $date);
    $pdf->Text($middleX + $offsetX + 2 + 12, $dataHeight + ($offsetX) + $rectHeight, $date);

    // Dodanie napisu Dowód dostawy
    $pdf->SetFont('Arialpl', '', 20);
    $ddWidth = 82;
    $ddHeight = 10;
    $pdf->Rect($offsetX + 2 + $rectWidth, $offsetX, $ddWidth, $ddHeight, 'DF');
    $pdf->Rect($middleX + $offsetX + 2 + $rectWidth, $offsetX, $ddWidth, $ddHeight, 'DF');
    $pdf->Text($offsetX + ($ddWidth / 2) - ($pdf->GetStringWidth($text_dd) / 2) + $rectWidth, $ddHeight + ($offsetX - 2), $text_dd);
    $pdf->Text($offsetX + ($ddWidth / 2) - ($pdf->GetStringWidth($text_dd) / 2) + $rectWidth, $ddHeight + ($offsetX - 2), $text_dd);
    $pdf->Text($middleX + $offsetX + ($ddWidth / 2) - ($pdf->GetStringWidth($text_dd) / 2) + $rectWidth, $ddHeight + ($offsetX - 2), $text_dd);
    $pdf->Text($middleX + $offsetX + ($ddWidth / 2) - ($pdf->GetStringWidth($text_dd) / 2) + $rectWidth, $ddHeight + ($offsetX - 2), $text_dd);

    // Dodanie pola odbiorcy
    $pdf->SetFont('Arialpl', '', 12);
    $poWidth = 82;
    $poHeight = 28;
    $pdf->Rect($offsetX + 2 + $rectWidth, $offsetX + 2 + $ddHeight, $poWidth, $poHeight);
    $pdf->Rect($middleX + $offsetX + 2 + $rectWidth, $offsetX + 2 + $ddHeight, $poWidth, $poHeight);
    $pdf->Text($offsetX + 4 + $rectWidth, $ddHeight + ($offsetX - 2) + $ddHeight, $text_po);
    $pdf->Text($offsetX + 4 + $rectWidth, $ddHeight + ($offsetX - 2) + $ddHeight, $text_po);
    $pdf->Text($middleX + $offsetX + 4 + $rectWidth, $ddHeight + ($offsetX - 2) + $ddHeight, $text_po);
    $pdf->Text($middleX + $offsetX + 4 + $rectWidth, $ddHeight + ($offsetX - 2) + $ddHeight, $text_po);
    drawCenteredText(
        $pdf,
        $offsetX + 2 + $rectWidth,          // X
        $offsetX + 4 + 2 + $ddHeight,           // Y
        $poWidth,                           // Szerokość pola
        $poHeight,                          // Wysokość pola
        $text_odbiorca                            // Tekst
    );
    drawCenteredText(
        $pdf,
        $middleX + $offsetX + 2 + $rectWidth, // X
        $offsetX + 4 + 2 + $ddHeight,             // Y
        $poWidth,                             // Szerokość pola
        $poHeight,                            // Wysokość pola
        $text_odbiorca                              // Tekst
    );


    // pola z towarem
    //136
    $ttWidth[1] = 50;
    $ttWidth[2] = 26;
    $ttWidth[3] = 30;
    $ttWidth[4] = 30;
    $ttHeight3 = 20;
    $rectWidth3 = 67;
    $rectHeight3 = 16;
    $offtext = 0;
    $offtext2 = 0;
    $offsplit = 0;
    $offsplit2 = 0;
    $offcos = 0;
    $offcos2 = 0;
    $offcos3 = 0;
    $offcos4 = 0;
    $fontSize = 12;
    $spacing = 4;
    $tosmall = 13;
    $offtextnag = 0;
    $offtext2name = 0;
    if ($total_products <= 10) {
        $ttHeight = 9;
        $ttHeight2 = 7;
        $ttHeight3 = 20;
        $offtext = 2;
        $offtext2 = 2;
        $offsplit = 4;
        $offsplit2 = 4;
        $offcos = 3;
        $offcos2 = -2;
        $offcos3 = -1;
        $offcos4 = -2;
    } else if ($total_products <= 14) {
        $ttHeight = 6;
        $ttHeight2 = 6;
        $ttHeight3 = 14;
        $rectHeight3 = 16;

        $fontSize = 8;
        $spacing = 2;
        $tosmall = 9;
        $offtext = 3;
        $offtext2 = 1;
        $offsplit = 2;
        $offsplit2 = 0;
        $offcos = 1;
        $offcos2 = -1;
        $offcos3 = 0;
        $offcos4 = 0;
    } else {
        $ttHeight = 5;
        $ttHeight2 = 5;
        $ttHeight3 = 14;
        $rectHeight3 = 16;

        $fontSize = 8;

        $spacing = 2;
        $tosmall = 9;

        $offtext = 3;
        $offtextnag = 1;
        $offtext2 = 1;
        $offtext2name = 1;
        $offsplit = 2;
        $offsplit2 = 0;
        $offcos = 1;
        $offcos2 = -1;
        $offcos3 = 0;
        $offcos4 = 0;
    }

    for ($i = 1; $i < 4; $i++) {
        $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[1], $ttHeight, 'DF');
        $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[1], $ttHeight, 'DF');
        $pdf->Text($offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($text[1]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[1]);
        $pdf->Text($middleX + $offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($text[1]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[1]);

        $pdf->Rect($offsetX + $ttWidth[1], $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[2], $ttHeight, 'DF');
        $pdf->Rect($middleX + $ttWidth[1] + $offsetX, $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[2], $ttHeight, 'DF');
        $pdf->Text($offsetX + $ttWidth[1] + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($text[2]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[2]);
        $pdf->Text($middleX + $ttWidth[1] + $offsetX + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($text[2]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[2]);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[3], $ttHeight, 'DF');
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[3], $ttHeight, 'DF');
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($text[3]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[3]);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($text[3]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[3]);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[4], $ttHeight, 'DF');
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + 4, $ttWidth[4], $ttHeight, 'DF');
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($text[4]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[4]);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($text[4]) / 2), $ttHeight + ($offsetX - 1) + $offtextnag + $rectHeight + $dataHeight + $offtext, $text[4]);
    }
    //kolejne wiersze

    $height_offset = 0;
    $i = 1;
    $j = 1;
    foreach ($prod as $pr) {
        $name = "";
        $cost = "";
        $amount = "";
        $value = "";
        if (isset($pr["name"])) {
            $name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr["name"]);
        }
        if (isset($pr["cost"])) {
            $cost = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr["cost"]);
        }
        if (isset($pr["amount"])) {
            $amount = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr["amount"]);
        }
        if (isset($pr["value"])) {
            $value = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr["value"]);
        }

        $total_sum += (float) $value;

        if ($value <> "") {
            $value = $value . " " . $text_val;
        }


        $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[1], $ttHeight2);
        $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[1], $ttHeight2);
        $pdf->Text($offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $name);
        $pdf->Text($middleX + $offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $name);

        $pdf->Rect($offsetX + $ttWidth[1], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[2], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[2], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $amount);
        $pdf->Text($middleX + $ttWidth[1] + $offsetX + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $amount);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[3], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[3], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $cost);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offcos + $offtext + ($ttHeight2 * $i), $cost);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[4], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[4], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $value);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offcos + $offtext + ($ttHeight2 * $i), $value);

        $height_offset = ($ttHeight2 * ($i + 1) + 2);
        $i++;
        $j++;
    }
    if ($total_sum <> "") {
        $total_sum = $total_sum . " " . $text_val;
    }
    $need_empty = 0;
    if ($i >= 5) {
        $need_empty = 1;
        $j = $i + 1;
    }

    while ($i <= (5 + $need_empty)) {
        $name = "";
        $cost = "";
        $amount = "";
        $value = "";

        $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[1], $ttHeight2);
        $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[1], $ttHeight2);
        $pdf->Text($offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $name);
        $pdf->Text($middleX + $offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $name);

        $pdf->Rect($offsetX + $ttWidth[1], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[2], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[2], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $amount);
        $pdf->Text($middleX + $ttWidth[1] + $offsetX + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $amount);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[3], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[3], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $cost);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offcos + $offtext + ($ttHeight2 * $i), $cost);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[4], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[4], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offcos + ($ttHeight2 * $i), $value);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offcos + ($ttHeight2 * $i), $value);
        $height_offset = ($ttHeight2 * ($i + 1) + 2);
        $i++;
    }

    $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + $height_offset, $ttWidth[1] + $ttWidth[2], $ttHeight2);
    $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + $height_offset, $ttWidth[1] + $ttWidth[2], $ttHeight2);

    $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[3], $ttHeight2, 'DF');
    $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[3], $ttHeight2, 'DF');
    $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth("RAZEM:") / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), "RAZEM:");
    $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth("RAZEM:") / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), "RAZEM:");

    $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($total_sum) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $total_sum);
    $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($total_sum) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + $offcos + ($ttHeight2 * $i), $total_sum);


    $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[4], $ttHeight2);
    $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + 2, $ttWidth[4], $ttHeight2);
    $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth("") / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + ($ttHeight2 * $i), "");
    $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth("") / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext + ($ttHeight2 * $i), "");


    $height_offset += $ttHeight2;

    // ZWROTY
    $total_width = 136;
    for ($i = 1; $i < 4; $i++) {
        $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + $height_offset, $total_width, $ttHeight2, 'DF');
        $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + $height_offset, $total_width, $ttHeight2, 'DF');
        $pdf->Text($offsetX + ($total_width / 2) - ($pdf->GetStringWidth($text_returns) / 2), $ttHeight + ($offsetX - 1) + $offtext2name + $rectHeight + $dataHeight + $offsplit - $offcos + $height_offset, $text_returns);
        $pdf->Text($middleX + $offsetX + ($total_width / 2) - ($pdf->GetStringWidth($text_returns) / 2), $ttHeight + ($offsetX - 1) + $offtext2name + $rectHeight + $dataHeight + $offsplit - $offcos + $height_offset, $text_returns);
    }
    //$height_offset += $ttHeight;
    $height_offset_new = 0;
    $i = 1;
    foreach ($prod2 as $pr2) {
        $text_fl = "";
        if(isset($pr2["names"]["name"])) {
            if($pr2["names"]["name"] <> "") {
                if (substr($pr2["names"]["name"], -3) === " | ") {
                    $pr2["names"]["name"] = substr($pr2["names"]["name"], 0, -3);
                }
                $text_fl = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr2["names"]["name"]);
            }
        }
        //show($pr2);die;
        $name = "";
        $cost = "";
        $amount = "";
        $value = "";
        if (isset($pr2["name"])) {
            $name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr2["name"]);
            if($text_fl <> "") {
                $name = $name . ": ". $text_fl;
            }
        }
        if (isset($pr2["cost"])) {
            $cost = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr2["cost"]);
        }
        if (isset($pr2["amount"])) {
            $amount = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr2["amount"]);
        }
        if (isset($pr2["value"])) {
            $value = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $pr2["value"]);
        }

        $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[1], $ttHeight2);
        $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[1], $ttHeight2);
        $pdf->Text($offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight + ($offsetX + $offcos2) + $offtext2name + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $name);
        $pdf->Text($middleX + $offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight + ($offsetX + $offcos2) + $offtext2name + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $name);

        $pdf->Rect($offsetX + $ttWidth[1], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[2], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[2], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $amount);
        $pdf->Text($middleX + $ttWidth[1] + $offsetX + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $amount);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[3], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[3], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - $offcos3) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $cost);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - $offcos3) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $cost);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[4], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[4], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $value);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $value);
        $height_offset_new = ($ttHeight2 * ($i + 1) + 2);
        $i++;
    }
    $need_empty = 0;
    if ($i >= 5) {
        $need_empty = 1;
    }
    while ($i <= (5 + $need_empty)) {
        $name = "";
        $cost = "";
        $amount = "";
        $value = "";

        $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[1], $ttHeight2);
        $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[1], $ttHeight2);
        $pdf->Text($offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight + ($offsetX + $offcos2) + $offtext2name + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $name);
        $pdf->Text($middleX + $offsetX + ($ttWidth[1] / 2) - ($pdf->GetStringWidth($name) / 2), $ttHeight + ($offsetX + $offcos2) + $offtext2name + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $name);

        $pdf->Rect($offsetX + $ttWidth[1], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[2], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[2], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $amount);
        $pdf->Text($middleX + $ttWidth[1] + $offsetX + ($ttWidth[2] / 2) - ($pdf->GetStringWidth($amount) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $amount);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[3], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[3], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - $offcos3) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $cost);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth($cost) / 2), $ttHeight2 + ($offsetX - $offcos3) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $cost);

        $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[4], $ttHeight2);
        $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit + ($ttHeight2 * $i) + $height_offset, $ttWidth[4], $ttHeight2);
        $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $value);
        $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth($value) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + $offtext2 + ($ttHeight2 * $i) + $height_offset, $value);
        $height_offset_new = ($ttHeight2 * ($i + 1) + 2);
        $i++;
    }
    $height_offset += $height_offset_new;

    $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit2 + $height_offset + $offcos4, $ttWidth[1] + $ttWidth[2], $ttHeight2);
    $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit2 + $height_offset + $offcos4, $ttWidth[1] + $ttWidth[2], $ttHeight2);

    $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2], $offsetX + $rectHeight + $dataHeight + $offsplit2 + $height_offset + $offcos4, $ttWidth[3], $ttHeight2, 'DF');
    $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offsplit2 + $height_offset + $offcos4, $ttWidth[3], $ttHeight2, 'DF');
    $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + ($ttWidth[3] / 2) - ($pdf->GetStringWidth("RAZEM:") / 2), $ttHeight2 + ($offsetX + $offcos4) + $offcos2 + $rectHeight + $dataHeight + $offsplit2 + $height_offset, "RAZEM:");
    $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + ($ttWidth[3] / 2) - ($pdf->GetStringWidth("RAZEM:") / 2), $ttHeight2 + ($offsetX + $offcos4 + $offcos2) + $rectHeight + $dataHeight + $offsplit2 + $height_offset, "RAZEM:");

    $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3], $offsetX + $rectHeight + $dataHeight + $offcos4 + $offsplit2 + $height_offset, $ttWidth[4], $ttHeight2);
    $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX, $offsetX + $rectHeight + $dataHeight + $offcos4 + $offsplit2 + $height_offset, $ttWidth[4], $ttHeight2);
    $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + ($ttWidth[4] / 2) - ($pdf->GetStringWidth("") / 2), $ttHeight2 + $offcos4 + ($offsetX - 1) + $rectHeight + $dataHeight + 3 + $height_offset, "");
    $pdf->Text($middleX + $ttWidth[1] + $ttWidth[2] + $ttWidth[3] + $offsetX + ($ttWidth[4] / 2) - ($pdf->GetStringWidth("") / 2), $ttHeight2 + $offcos4 + ($offsetX - 1) + $rectHeight + $dataHeight + 3 + $height_offset, "");

    $height_offset += $ttHeight2;



    // pola zapłacono, niezapłacono
    $pdf->Rect($offsetX, $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2, $ttWidth[1] + $ttWidth[2] - 1, $ttHeight3);
    $pdf->Rect($middleX + $offsetX, $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2, $ttWidth[1] + $ttWidth[2] - 1, $ttHeight3);

    drawSquaresWithText(
        $pdf,
        $offsetX + 20,
        $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2,
        $ttWidth[1] + $ttWidth[2] - 1,
        $ttHeight3,
        [iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Zapłacone"), iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Niezapłacone")],
        $fontSize,
        $spacing
    );

    // Prawy prostokąt: test 1 i test 2
    drawSquaresWithText(
        $pdf,
        $middleX + $offsetX + 20,
        $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2,
        $ttWidth[1] + $ttWidth[2] - 1,
        $ttHeight3,
        [iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Zapłacone"), iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Niezapłacone")],
        $fontSize,
        $spacing

    );



    // łącznie do zapłaty
    $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + 1, $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2, $ttWidth[3] + $ttWidth[4] - 1, $ttHeight3 - $tosmall, 'DF');
    $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + 1, $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2, $ttWidth[3] + $ttWidth[4] - 1, $ttHeight3 - $tosmall, 'DF');
    $pdf->Text($offsetX + $ttWidth[1] + $ttWidth[2] + 2 + ($pdf->GetStringWidth($text_topay) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + 5 + $height_offset, $text_topay);
    $pdf->Text($middleX + $offsetX + $ttWidth[1] + $ttWidth[2] + 2 + ($pdf->GetStringWidth($text_topay) / 2), $ttHeight2 + ($offsetX - 1) + $rectHeight + $dataHeight + 5 + $height_offset, $text_topay);
    $pdf->Rect($offsetX + $ttWidth[1] + $ttWidth[2] + 1, $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2, $ttWidth[3] + $ttWidth[4] - 1, $ttHeight3);
    $pdf->Rect($middleX + $ttWidth[1] + $ttWidth[2] + $offsetX + 1, $offsetX + $rectHeight + $dataHeight + 4 + $height_offset + 2, $ttWidth[3] + $ttWidth[4] - 1, $ttHeight3);


    // Dodanie prostokąta w lewym dolnym rogu
    $pdf->SetFont('Arialpl', '', 8);

    $pdf->Rect($offsetX, $offsetX + 184, $rectWidth3, $rectHeight3 - 2);
    $pdf->Rect($middleX + $offsetX, $offsetX + 184, $rectWidth3, $rectHeight3 - 2);
    $pdf->Text($offsetX + ($rectWidth3 / 2) - ($pdf->GetStringWidth($text_pod1) / 2), $rectHeight3 - 2 + ($offsetX - 1) + 184, $text_pod1);
    $pdf->Text($middleX + $offsetX + ($rectWidth3 / 2) - ($pdf->GetStringWidth($text_pod1) / 2), $rectHeight3 - 2 + ($offsetX - 1) + 184, $text_pod1);

    // Dodanie prostokąta w prawym dolnym rogu
    $pdf->SetFont('Arialpl', '', 8);

    $pdf->Rect($offsetX + 69, $offsetX + 184, $rectWidth3, $rectHeight3 - 2);
    $pdf->Rect($middleX + 69 + $offsetX, $offsetX + 184, $rectWidth3, $rectHeight3 - 2);
    $pdf->Text($offsetX + 69 + ($rectWidth3 / 2) - ($pdf->GetStringWidth($text_pod2) / 2), $rectHeight3 - 2 + ($offsetX - 1) + 184, $text_pod2);
    $pdf->Text($middleX + 69 + $offsetX + ($rectWidth3 / 2) - ($pdf->GetStringWidth($text_pod2) / 2), $rectHeight3 - 2 + ($offsetX - 1) + 184, $text_pod2);
}




















function drawCenteredText($pdf, $x, $y, $width, $height, $text)
{
    // Ustawienie czcionki
    $pdf->SetFont('Arialpl', '', 12);

    // Wysokość pojedynczej linii tekstu
    $lineHeight = 5;

    // Obliczanie szerokości tekstu w jednej linii
    $textWidth = $pdf->GetStringWidth($text);

    // Dzielimy tekst na linie, jeśli jest za szeroki
    $lines = [];
    $currentLine = "";
    foreach (explode(" ", $text) as $word) {
        if ($pdf->GetStringWidth($currentLine . " " . $word) < $width) {
            $currentLine .= (empty($currentLine) ? "" : " ") . $word;
        } else {
            $lines[] = $currentLine;
            $currentLine = $word;
        }
    }
    $lines[] = $currentLine;

    // Obliczanie początkowej pozycji Y, aby tekst był wyśrodkowany pionowo
    $textHeight = count($lines) * $lineHeight;
    $startY = $y + ($height - $textHeight) / 2;

    // Wyświetlanie każdej linii
    foreach ($lines as $i => $line) {
        $lineWidth = $pdf->GetStringWidth($line);
        $lineX = $x + ($width - $lineWidth) / 2; // Wyśrodkowanie poziome
        $pdf->Text($lineX, $startY + $i * $lineHeight, $line);
    }
}

function drawSquaresWithText($pdf, $x, $y, $width, $height, $texts, $fontSize, $spacing)
{
    $squareSize = 5;  // Rozmiar kwadratów

    // Ustawienie czcionki
    $pdf->SetFont('Arialpl', '', $fontSize);

    // Wyliczenie pozycji Y dla pierwszego elementu
    $currentY = $y + ($height - (count($texts) * ($squareSize + $spacing) - $spacing)) / 2;

    foreach ($texts as $text) {
        // Rysowanie kwadratu
        $pdf->Rect($x + 2, $currentY, $squareSize, $squareSize);

        // Rysowanie tekstu obok kwadratu
        $pdf->Text($x + 2 + $squareSize + 2, $currentY + $squareSize - 1, $text);

        // Przejście do następnego elementu w pionie
        $currentY += $squareSize + $spacing;
    }
}