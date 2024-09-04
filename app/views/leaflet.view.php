<?php
$max_chars = 20; // Maksymalna liczba znaków na linię, uwzględniając "asd"

$days = [
    0 => "NIEDZIELA",
    1 => "PONIEDZIAŁEK",
    2 => "WTOREK",
    3 => "ŚRODA",
    4 => "CZWARTEK",
    5 => "PIĄTEK",
    6 => "SOBOTA"
];
$offs = [
    0 => 40,
    1 => 0,
    2 => 60,
    3 => 70,
    4 => 40,
    5 => 65,
    6 => 65
];

$day = 3;

function podziel_tekst_na_linie($tekst, $max_chars) {
    $wynik = '';
    $prefix = "   ";
    $prefix_len = strlen($prefix);
    $is_first_line = true; // Flaga do sprawdzenia, czy to pierwsza linia

    while (strlen($tekst) > ($max_chars - ($is_first_line ? 0 : $prefix_len))) {
        // Jeśli to pierwsza linia, używamy pełnego limitu znaków
        $current_limit = $is_first_line ? $max_chars : $max_chars - $prefix_len;
        
        // Znajdź ostatnią spację w pierwszych $current_limit znakach
        $breakpoint = strrpos(substr($tekst, 0, $current_limit), ' ');

        // Jeśli nie ma spacji, łam tekst na $current_limit znaków
        if ($breakpoint === false) {
            $breakpoint = $current_limit;
        }

        // Dodaj podzieloną część tekstu do wyniku
        if ($is_first_line) {
            $wynik .= substr($tekst, 0, $breakpoint) . "\n";
        } else {
            $wynik .= $prefix . substr($tekst, 0, $breakpoint) . "\n";
        }

        // Usuń już przetworzony fragment tekstu
        $tekst = ltrim(substr($tekst, $breakpoint));
        
        // Po pierwszej iteracji ustawiamy flagę na false
        $is_first_line = false;
    }

    // Dodaj pozostały tekst, dodając prefix jeśli to nie pierwsza linia
    if ($is_first_line) {
        $wynik .= $tekst;
    } else {
        $wynik .= $prefix . $tekst;
    }

    return $wynik;
}

function roundCorners($source, $radius) {
    $ws = imagesx($source);
    $hs = imagesy($source);

    $corner = $radius + 2;
    $s = $corner*2;

    $src = imagecreatetruecolor($s, $s);
    imagecopy($src, $source, 0, 0, 0, 0, $corner, $corner);
    imagecopy($src, $source, $corner, 0, $ws - $corner, 0, $corner, $corner);
    imagecopy($src, $source, $corner, $corner, $ws - $corner, $hs - $corner, $corner, $corner);
    imagecopy($src, $source, 0, $corner, 0, $hs - $corner, $corner, $corner);

    $q = 8; # change this if you want
    $radius *= $q;

    # find unique color
    do {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
    } while (imagecolorexact($src, $r, $g, $b) < 0);

    $ns = $s * $q;

    $img = imagecreatetruecolor($ns, $ns);
    $alphacolor = imagecolorallocatealpha($img, $r, $g, $b, 127);
    imagealphablending($img, false);
    imagefilledrectangle($img, 0, 0, $ns, $ns, $alphacolor);

    imagefill($img, 0, 0, $alphacolor);
    imagecopyresampled($img, $src, 0, 0, 0, 0, $ns, $ns, $s, $s);
    imagedestroy($src);

    imagearc($img, $radius - 1, $radius - 1, $radius * 2, $radius * 2, 180, 270, $alphacolor);
    imagefilltoborder($img, 0, 0, $alphacolor, $alphacolor);
    imagearc($img, $ns - $radius, $radius - 1, $radius * 2, $radius * 2, 270, 0, $alphacolor);
    imagefilltoborder($img, $ns - 1, 0, $alphacolor, $alphacolor);
    imagearc($img, $radius - 1, $ns - $radius, $radius * 2, $radius * 2, 90, 180, $alphacolor);
    imagefilltoborder($img, 0, $ns - 1, $alphacolor, $alphacolor);
    imagearc($img, $ns - $radius, $ns - $radius, $radius * 2, $radius * 2, 0, 90, $alphacolor);
    imagefilltoborder($img, $ns - 1, $ns - 1, $alphacolor, $alphacolor);
    imagealphablending($img, true);
    imagecolortransparent($img, $alphacolor);

    # resize image down
    $dest = imagecreatetruecolor($s, $s);
    imagealphablending($dest, false);
    imagefilledrectangle($dest, 0, 0, $s, $s, $alphacolor);
    imagecopyresampled($dest, $img, 0, 0, 0, 0, $s, $s, $ns, $ns);
    imagedestroy($img);

    # output image
    imagealphablending($source, false);
    imagecopy($source, $dest, 0, 0, 0, 0, $corner, $corner);
    imagecopy($source, $dest, $ws - $corner, 0, $corner, 0, $corner, $corner);
    imagecopy($source, $dest, $ws - $corner, $hs - $corner, $corner, $corner, $corner, $corner);
    imagecopy($source, $dest, 0, $hs - $corner, 0, $corner, $corner, $corner);
    imagealphablending($source, true);
    imagedestroy($dest);

    return $source;
}



// Ustawienia obrazu
$szerokosc = 707; // Szerokość obrazu
$wysokosc = 1000; // Wysokość obrazu
$wysokoscTlo = 140; // Wysokość obrazka tła
$menu_szer = 400;
$po_logo_wys = 60;
$word_menu_wys = 30;
$word_menu_szer = 100;
$day_from_left = 0;
$day_wys = 40;
$food_wys = 171; //256
$food_szer = 228; //192
$radius = 20;
$border = 3;

$menu_txt = "1. Zupa szczawiowa z jajkiem - 10zł\n"
          . "2. Makaron w sosie serowo-brokułowym z kurczakiem - 20zł\n"
          . "3. Wieprzowina BBQ, ryż, surówka - 20zł\n"
          . "4. VEGE Leniwe z bułką tartą i śmietanką na słodko - 18zł\n"
          . "5. Sałatki:\n"
          . "   a. Cezar - 16zł\n"
          . "   b. Grecka - 16zł\n"
          . "   c. Z nuggetsami i opiekanymi ziemniakami - 16zł\n"
          . "6. Kanapki:\n"
          . "   BBQ z wieprzowiną - 10zł\n"
          . "   z kurczakiem - 10zł\n"
          . "   z pastą jajeczną - 10zł\n"
          . "   wiosenna z salami - 10zł\n"
          . "7. Grzanki z łososiem i awokado - 15zł\n"
          . "8. Naleśniki z serem i musem owocowym - 16zł";

$menu_txt = "";
$int = 1;
$photo_ids = [];
foreach($data["list"] as $row_key => $row_val) {
    if($row_key == "1-03" || $row_key == "1-04") {
        foreach($row_val as $dan) {
            if($row_key == "1-03") {
                if($dan->p_photo != NULL) {
                    $photo_ids[1][] = $dan;
                }
            }
            if($row_key == "1-04") {
                if($dan->p_photo != NULL) {
                    $photo_ids[2][] = $dan;
                }
            }
            $prod_name = $dan->p_name;
            $vege = "";
            if(isset($dan->friendly_name)) {
                $prod_name = $dan->friendly_name;
            }
            if(isset($dan->vege)) {
                if($dan->vege == true) {
                    $prod_name = $dan->friendly_name;
                    $vege = " VEGE";
                }
            }
            $price = $data["prices"][$dan->id]->price;
            $menu_txt .= $int.".".$vege." ".$prod_name." - ".$price."zł\n";
            $int++;
        }
    } else if($row_key == "1-01"){
        $menu_txt .= $int.". Sałatki:\n";
        foreach($row_val as $dan) {
            if($dan->p_photo != NULL) {
                $photo_ids[3][] = $dan;
            }
            $prod_name = $dan->p_name;
            //show($dan);
            if(isset($dan->friendly_name)) {
                $prod_name = $dan->friendly_name;
            }
            $price = $data["prices"][$dan->id]->price;
            $menu_txt .= "   ".$prod_name." - ".$price."zł\n";
        }
        $int++;
    } else if($row_key == "1-02"){
        $menu_txt .= $int.". Kanapki:\n";
        foreach($row_val as $dan) {
            if($dan->p_photo != NULL) {
                $photo_ids[4][] = $dan;
            }
            $prod_name = $dan->p_name;
            if(isset($dan->friendly_name)) {
                $prod_name = $dan->friendly_name;
            }
            $price = $data["prices"][$dan->id]->price;
            $menu_txt .= "   ".$prod_name." - ".$price."zł\n";
        }
        $int++;
    } else if($row_key == "3"){
        $menu_txt .= $int.". Granola:\n";
        foreach($row_val as $dan) {
            if($dan->p_photo != NULL) {
                $photo_ids[4][] = $dan;
            }
            $prod_name = $dan->p_name;
            if(isset($dan->friendly_name)) {
                $prod_name = $dan->friendly_name;
            }
            $price = $data["prices"][$dan->id]->price;
            $menu_txt .= "   ".$prod_name." - ".$price."zł\n";
        }
        $int++;
    } else {
        foreach($row_val as $dan) {
            if($dan->p_photo != NULL) {
                $photo_ids[4][] = $dan;
            }
            $prod_name = $dan->p_name;
            if(isset($dan->friendly_name)) {
                $prod_name = $dan->friendly_name;
            }
            $price = $data["prices"][$dan->id]->price;
            $menu_txt .= $int.". ".$dan->p_name." - ".$price."zł\n";
            $int++;
        }
    
    }
}
//die;
$food_img = [];
$los = 1;
$count = 1;
if(isset($photo_ids[1])) {
    $losowa_liczba = rand(0, count($photo_ids[1]) - 1);
    $food_img[$count] = $photo_ids[1][$losowa_liczba]->p_photo; 
    $count++;
    $los++;
} else {
    $los += 1;
}
//show($los);
if(isset($photo_ids[2])) {
    for($i = $count; $i<=$los; $i++) {
        $losowa_liczba = rand(0, count($photo_ids[2]) - 1);
        $food_img[$count] = $photo_ids[2][$losowa_liczba]->p_photo; 
        $count++;
    }
    $los++;
} else {
    $los += 1;
}
if(isset($photo_ids[3])) {
    for($i = $count; $i<=$los; $i++) {
        $losowa_liczba = rand(0, count($photo_ids[3]) - 1);
        $food_img[$count] = $photo_ids[3][$losowa_liczba]->p_photo; 
        $count++;
    }
    $los++;
} else {
    $los += 1;
}
if(isset($photo_ids[4])) {
    for($i = $count; $i<=$los; $i++) {
        $losowa_liczba = rand(0, count($photo_ids[4]) - 1);
        $food_img[$count] = $photo_ids[4][$losowa_liczba]->p_photo; 
        $count++;
    }
} else {
    $los += 1;
}
//show($los);
//show($food_img);
//show($photo_ids);die;

// Tworzenie pustego obrazu
$obraz = imagecreatetruecolor($szerokosc, $wysokosc);

$black = imagecreatetruecolor($food_szer + ($border * 2), $food_wys + ($border*2));
$czarny = imagecolorallocate($black, 0, 0, 0);
imagefill($black, 0, 0, $czarny);

// Definiowanie kolorów (R, G, B)
$kolorTla = imagecolorallocate($obraz, 240, 240, 240); // Biały kolor tła
$kolorTekstu = imagecolorallocate($obraz, 0, 0, 0); // Czarny kolor tekstu

// Wypełnienie tła obrazu
imagefilledrectangle($obraz, 0, 0, $szerokosc, $wysokosc, $kolorTla);

// Ładowanie obrazu tła (tlo.png)
$header_logo = imagecreatefrompng(IMG_ROOT_UPLOAD.'tlo.png');
$po_name = imagecreatefrompng(IMG_ROOT_UPLOAD.'panobiadek-name.png');
$word_menu = imagecreatefrompng(IMG_ROOT_UPLOAD.'word-menu.png');
$day_ss = imagecreatefrompng(IMG_ROOT_UPLOAD.'d-1.png'); //numer dniazmieniać
if (file_exists(IMG_ROOT_UPLOAD.$food_img[1])) {
    $food_1 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.$food_img[1]); 
} else {
    $food_1 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'blank.jpg'); 
}
if (file_exists(IMG_ROOT_UPLOAD.$food_img[2])) {
    $food_2 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.$food_img[2]); 
} else {
    $food_2 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'blank.jpg'); 
}
if (file_exists(IMG_ROOT_UPLOAD.$food_img[3])) {
    $food_3 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.$food_img[3]); 
} else {
    $food_3 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'blank.jpg'); 
}
if (file_exists(IMG_ROOT_UPLOAD.$food_img[4])) {
    $food_4 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.$food_img[4]); 
} else {
    $food_4 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'blank.jpg'); 
}

// Tworzenie nowego obrazu dla przeskalowanego tła
$header_logo_new = imagecreatetruecolor($szerokosc, $wysokoscTlo);
$po_name_new = imagecreatetruecolor($menu_szer - 100, $po_logo_wys);
$word_menu_new = imagecreatetruecolor($word_menu_szer, $word_menu_wys);
$day_ss_new = imagecreatetruecolor($menu_szer, $day_wys);
$food_new[1] = imagecreatetruecolor($food_szer, $food_wys);
$food_new[2] = imagecreatetruecolor($food_szer, $food_wys);
$food_new[3] = imagecreatetruecolor($food_szer, $food_wys);
$food_new[4] = imagecreatetruecolor($food_szer, $food_wys);

// Wypełnienie nowego obrazu białym tłem (dla przezroczystości)
$kolorPrzezroczysty = imagecolorallocatealpha($header_logo_new, 255, 255, 255, 127);
imagefill($header_logo_new, 0, 0, $kolorPrzezroczysty);
imagesavealpha($header_logo_new, true);
imagefill($po_name_new, 0, 0, $kolorPrzezroczysty);
imagesavealpha($po_name_new, true);
imagefill($word_menu_new, 0, 0, $kolorPrzezroczysty);
imagesavealpha($word_menu_new, true);
imagefill($day_ss_new, 0, 0, $kolorPrzezroczysty);
imagesavealpha($day_ss_new, true);

imagefill($food_new[1], 0, 0, $kolorPrzezroczysty);
imagesavealpha($food_new[1], true);
imagefill($food_new[2], 0, 0, $kolorPrzezroczysty);
imagesavealpha($food_new[2], true);
imagefill($food_new[3], 0, 0, $kolorPrzezroczysty);
imagesavealpha($food_new[3], true);
imagefill($food_new[4], 0, 0, $kolorPrzezroczysty);
imagesavealpha($food_new[4], true);

// Skopiowanie i przeskalowanie obrazu tła
imagecopyresampled($header_logo_new, $header_logo, 0, 0, 0, 0, $szerokosc, $wysokoscTlo, imagesx($header_logo), imagesy($header_logo));
imagecopyresampled($po_name_new, $po_name, 0, 0, 0, 0, $menu_szer-100, $po_logo_wys, imagesx($po_name), imagesy($po_name));
imagecopyresampled($word_menu_new, $word_menu, 0, 0, 0, 0, $word_menu_szer, $word_menu_wys, imagesx($word_menu), imagesy($word_menu));
imagecopyresampled($day_ss_new, $day_ss, 0, 0, 0, 0, $menu_szer - 200, $day_wys, imagesx($day_ss), imagesy($day_ss));
imagecopyresampled($food_new[1], $food_1, 0, 0, 0, 0, $food_szer, $food_wys, imagesx($food_1), imagesy($food_1));
imagecopyresampled($food_new[2], $food_2, 0, 0, 0, 0, $food_szer, $food_wys, imagesx($food_2), imagesy($food_2));
imagecopyresampled($food_new[3], $food_3, 0, 0, 0, 0, $food_szer, $food_wys, imagesx($food_3), imagesy($food_3));
imagecopyresampled($food_new[4], $food_4, 0, 0, 0, 0, $food_szer, $food_wys, imagesx($food_4), imagesy($food_4));

$food_new[1] = roundCorners($food_new[1],  $radius);
$food_new[2] = roundCorners($food_new[2],  $radius);
$food_new[3] = roundCorners($food_new[3],  $radius);
$food_new[4] = roundCorners($food_new[4],  $radius);
$black = roundCorners($black,  $radius+3);

$day_from_left = 84 + $offs[$day]; //12 //7 //84 // 60
// Kopiowanie przeskalowanego tła na główny obraz

$font = IMG_ROOT_UPLOAD . '/FreckleFace-Regular.ttf';
$fontSize = 40; // Rozmiar czcionki
$kolorTekstu = imagecolorallocate($obraz, 0, 200, 0);

imagecopy($obraz, $header_logo_new, 0, 0, 0, 0, $szerokosc, $wysokoscTlo);
imagecopy($obraz, $po_name_new, 50, $wysokoscTlo, 0, 0, $menu_szer - 100, $po_logo_wys);
//imagecopy($obraz, $word_menu_new, ($menu_szer - 100) / 2, $wysokoscTlo + $po_logo_wys, 0, 0, $word_menu_szer, $word_menu_wys);
imagettftext($obraz, $fontSize, 0, ($menu_szer - 100) / 2, $wysokoscTlo + $po_logo_wys + $fontSize - 7, $kolorTekstu, $font, "MENU");

$fontSize = 30; // Rozmiar czcionki
$kolorTekstu = imagecolorallocate($obraz, 200, 0, 0);
imagettftext($obraz, $fontSize, 0, $day_from_left, $wysokoscTlo + $po_logo_wys + $word_menu_wys + $fontSize, $kolorTekstu, $font, $days[$day]);
//imagecopy($obraz, $day_ss_new, $day_from_left, $wysokoscTlo + $po_logo_wys + $word_menu_wys, 0, 0, 300, $day_wys);

for($i = 0; $i<=3; $i++) {
    imagecopy($obraz, $black, $szerokosc - $food_szer - 30 - $border, $wysokoscTlo + 20 + (($food_wys+40) * $i) - $border, 0, 0, $food_szer+($border*2), $food_wys+($border*2));
    imagecopy($obraz, $food_new[$i+1], $szerokosc - $food_szer - 30, $wysokoscTlo + 20 + (($food_wys+40) * $i), 0, 0, $food_szer, $food_wys);
}




// Dodanie tekstu do obrazu (pod tłem)
$tekst = "Smak domu na Twoim talerzu";
$kolorTekstu = imagecolorallocate($obraz, 255, 0, 0); // Czarny kolor tekstu
$fontSize = 14; // Rozmiar czcionki
$x = 20; // Pozycja X tekstu
$y = 70; // Pozycja Y tekstu (pod tłem)
for ($i = 0; $i <= 1; $i++) {
    for ($j = 0; $j <= 0; $j++) {
        imagettftext($obraz, $fontSize, 0, $x + $i, $y + $j, $kolorTekstu, $font, $tekst);
    }
}
$kolorTekstu = imagecolorallocate($obraz, 0, 0, 0); // Czarny kolor tekstu

$font = IMG_ROOT_UPLOAD . '/FiraCode-VariableFont_wght.ttf';//HelveticaWorld-Regular.ttf
$fontSize = 14; // Rozmiar czcionki
$x = 20; // Pozycja X tekstu
$y = $wysokoscTlo + $po_logo_wys + $word_menu_wys + $day_wys; // Pozycja Y tekstu (pod tłem)
// Łamanie tekstu menu na linie
$lines = explode("\n", $menu_txt);
$lineHeight = 15; // Wysokość jednej linii
$y += 20; // Odstęp od górnej krawędzi obrazu


$max_chars = 40;
foreach ($lines as $line) {
    // Podziel linie, jeśli są dłuższe niż $max_chars
    $podzielone_linie = podziel_tekst_na_linie($line, $max_chars);
    
    // Rozdziel wynik na linie i wyświetl każdą z nich osobno
    $linie_do_wyswietlenia = explode("\n", $podzielone_linie);
    foreach ($linie_do_wyswietlenia as $linia) {
        if (substr($linia, 3, 4) === "VEGE") {
            for ($i = -1; $i <= 1; $i++) {
                for ($j = -1; $j <= 1; $j++) {
                    imagettftext($obraz, $fontSize, 0, $x + $i, $y + $j, imagecolorallocate($obraz, 0, 200, 0), $font, "   VEGE");
                }
            }
            $temp_txt = substr($linia,0,3) . "     ".substr($linia,8);
            imagettftext($obraz, $fontSize,0,  $x, $y,$kolorTekstu,$font, $temp_txt);
        } else {
            imagettftext($obraz, $fontSize,0,  $x, $y,$kolorTekstu,$font, $linia);
        }
        
        if (substr($linia, -3,3) === "zł") {
            $temp_txt = "";
            $str_len = mb_strlen($linia);
            for ($i == 0; $str_len > $i+2; $i++) {
                $temp_txt .= " ";
            }
            $temp_txt .= substr($linia, -5);
            for ($i = -1; $i <= 1; $i++) {
                imagettftext($obraz, $fontSize, 0, $x + $i, $y, imagecolorallocate($obraz, 20, 20, 20), $font, $temp_txt);
            }
        } 
        $y += $lineHeight + 2; // + 5
    }
    $y += $lineHeight-3;
}

// Nagłówek HTTP informujący przeglądarkę, że zwracany plik to obraz JPEG
header('Content-Type: image/jpeg');

// Zapisanie obrazu do pliku
$plik = 'obrazek.jpg';
imagejpeg($obraz, $plik, 100); // 100 to maksymalna jakość (0-100)

// Wyświetlenie obrazu
imagejpeg($obraz);

// Zniszczenie obrazów z pamięci
imagedestroy($header_logo);
imagedestroy($header_logo_new);
imagedestroy($po_name);
imagedestroy($po_name_new);
imagedestroy($word_menu);
imagedestroy($word_menu_new);
imagedestroy($obraz);
