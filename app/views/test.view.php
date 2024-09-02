<?php
$max_chars = 20; // Maksymalna liczba znaków na linię, uwzględniając "asd"

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
$food_wys = 256;
$food_szer = 192;

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

// Tworzenie pustego obrazu
$obraz = imagecreatetruecolor($szerokosc, $wysokosc);

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
$food_1 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'granola.jpg'); 
$food_2 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'dorsz.jpg'); 
$food_3 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'cezar.jpg'); 
$food_4 = imagecreatefromjpeg(IMG_ROOT_UPLOAD.'kartacze.jpg'); 

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

$day_from_left = ($menu_szer - imagesx($day_ss) / 2 )/2 ;
// Kopiowanie przeskalowanego tła na główny obraz
imagecopy($obraz, $header_logo_new, 0, 0, 0, 0, $szerokosc, $wysokoscTlo);
imagecopy($obraz, $po_name_new, 50, $wysokoscTlo, 0, 0, $menu_szer - 100, $po_logo_wys);
imagecopy($obraz, $word_menu_new, ($menu_szer - 100) / 2, $wysokoscTlo + $po_logo_wys, 0, 0, $word_menu_szer, $word_menu_wys);
imagecopy($obraz, $day_ss_new, $day_from_left, $wysokoscTlo + $po_logo_wys + $word_menu_wys, 0, 0, 300, $day_wys);

for($i = 0; $i<=2; $i++) {
    imagecopy($obraz, $food_new[$i+1], $szerokosc - $food_szer - 30, $wysokoscTlo + 20 + (($food_wys+20) * $i), 0, 0, $food_szer, $food_wys);
}


$font = IMG_ROOT_UPLOAD . '/FiraCode-VariableFont_wght.ttf';//HelveticaWorld-Regular.ttf
// Dodanie tekstu do obrazu (pod tłem)
$tekst = "Smak domu na Twoim talerzu";
$fontSize = 14; // Rozmiar czcionki
$x = 20; // Pozycja X tekstu
$y = 70; // Pozycja Y tekstu (pod tłem)
for ($i = -1; $i <= 1; $i++) {
    for ($j = -1; $j <= 1; $j++) {
        imagettftext($obraz, $fontSize, 0, $x + $i, $y + $j, $kolorTekstu, $font, $tekst);
    }
}

$fontSize = 14; // Rozmiar czcionki
$x = 20; // Pozycja X tekstu
$y = $wysokoscTlo + $po_logo_wys + $word_menu_wys + $day_wys; // Pozycja Y tekstu (pod tłem)
// Łamanie tekstu menu na linie
$lines = explode("\n", $menu_txt);
$lineHeight = 15; // Wysokość jednej linii
$y += 20; // Odstęp od górnej krawędzi obrazu


$max_chars = 38;
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
        $y += $lineHeight + 5;
    }
    $y += $lineHeight;
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
