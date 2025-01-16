<?php

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function esc($str)
{
    return htmlspecialchars($str);
}

function redirect($path)
{
    header("Location: " . ROOT . "/" . $path);
    die;
}

function getYourData(string $param)
{
    $arr = (array) $_SESSION["USER"];
    return $arr[$param];
}

function getMargin($p, $c)
{
    if ($c == 0) {
        return 0;
    }
    if ($p == 0) {
        return 0;
    }
    if ($c < 0) {
        return round(-($p - $c) / $p * 100, 2);
    }
    return round(($p - $c) / $p * 100, 2);
}
function showPrice($p, $c)
{
    if ($c == 0) {
        return 0;
    }
    return round($p / $c, 2);
}
function roundPrice($p, $c)
{
    if ($c == 0) {
        return 0;
    }
    return round($p * $c, 2);
}
function getPercent($p, $c, $cel = 2)
{
    $ret = 0;
    if ($c > 0) {
        $ret = round($p / $c * 100, $cel);
    }
    return $ret;
}

function roundUp($number)
{
    // Mnożenie przez 100, zaokrąglanie w górę, a następnie dzielenie przez 100
    $rounded = ceil($number * 100) / 100;

    // Formatowanie liczby do dwóch miejsc po przecinku
    return number_format($rounded, 2, '.', '');
}
function roundCost($number)
{
    // Zaokrąglanie liczby do dwóch miejsc po przecinku
    if (is_string($number)) {
        return 0;
    }
    $rounded = round($number, 2);

    // Formatowanie liczby do dwóch miejsc po przecinku
    return number_format($rounded, 2, '.', '');
}

function buildHierarchy($data)
{
    $tree = [];
    $indexed = [];

    // Index all elements by their ID
    foreach ($data as $element) {
        $indexed[$element['id']] = $element;
        $indexed[$element['id']]['children'] = [];
    }

    // Build the hierarchy
    foreach ($indexed as $id => $element) {
        if ($element['id_parent'] === null) {
            $tree[] = &$indexed[$id];
        } else {
            $indexed[$element['id_parent']]['children'][] = &$indexed[$id];
        }
    }

    return $tree;
}

function generateTree($items)
{
    $html = '<ul class="tree">';
    foreach ($items as $item) {
        $html .= '<li class="tree">';
        $html .= '<input type="checkbox" id="checkbox-' . $item['id'] . '" class="checkbox tree" data-id="' . $item['id'] . '" />';
        $html .= '<label class="tree" for="checkbox-' . $item['id'] . '">' . $item['l_name'] . '</label>';
        if (!empty($item['children'])) {
            $html .= generateTree($item['children']);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

function generateTreeEditing($items)
{
    $html = '<ul class="tree">';
    foreach ($items as $item) {
        $html .= '<li class="tree">';
        //$html .= '<input type="checkbox" id="checkbox-' . $item['id'] . '" class="checkbox tree" data-id="' . $item['id'] . '" />';
        $color = "";
        if ($item["l_active"] == 0) {
            $color = ' style="color: red; text-decoration: line-through;" ';
        }
        $html .= '<label class="tree" ' . $color . '>' . $item['l_name'] . ' [<a style="color: green;" href="' . ROOT . '/tabs/add/' . $item["id"] . '">Dodaj</a>] [<a href="' . ROOT . '/tabs/edit/' . $item["id"] . '">Edytuj</a>]</label>';
        if (!empty($item['children'])) {
            $html .= generateTreeEditing($item['children']);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

function isDateInRange($date)
{ //do SMS
    $inputDate = new DateTime($date);
    $now = new DateTime();

    // Dni tygodnia: 0 (niedziela) - 6 (sobota)
    $today = (int) $now->format('w');

    if ($today >= 2 && $today <= 5) { // od wtorku do piątku
        $start = (clone $now)->setTime(15, 0, 0)->modify('-1 day');
        $end = (clone $now)->setTime(15, 0, 0);
    } else { // sobota, niedziela, poniedziałek
        $start = (clone $now)->setTime(15, 0, 0)->modify('last Friday');
        $end = (clone $now)->setTime(15, 0, 0);
    }

    return $inputDate >= $start && $inputDate <= $end;
}

function getWeekends($year)
{
    $weekends = [];
    $date = new DateTime("$year-01-01");

    // Iterujemy przez cały rok
    while ($date->format('Y') == $year) {
        if ($date->format('N') == 6) { // Sobota
            $weekends[] = ['date' => $date->format('Y-m-d'), 'reason' => 'Sobota'];
        } elseif ($date->format('N') == 7) { // Niedziela
            $weekends[] = ['date' => $date->format('Y-m-d'), 'reason' => 'Niedziela'];
        }
        $date->modify('+1 day');
    }
    return $weekends;
}

function changePolishChars($tekst)
{
    $polskieZnaki = array(
        'ą',
        'ć',
        'ę',
        'ł',
        'ń',
        'ó',
        'ś',
        'ź',
        'ż',
        'Ą',
        'Ć',
        'Ę',
        'Ł',
        'Ń',
        'Ó',
        'Ś',
        'Ź',
        'Ż'
    );
    $zwykleZnaki = array(
        'a',
        'c',
        'e',
        'l',
        'n',
        'o',
        's',
        'z',
        'z',
        'A',
        'C',
        'E',
        'L',
        'N',
        'O',
        'S',
        'Z',
        'Z'
    );
    return strtr($tekst, array_combine($polskieZnaki, $zwykleZnaki));
}

function getPayment($czasWSekundach, $stawkaGodzinowa)
{
    if ($czasWSekundach == 0 || $stawkaGodzinowa == 0) {
        return '0.00';
    }

    $czasWGodzinach = $czasWSekundach / 3600;
    $zarobki = $czasWGodzinach * $stawkaGodzinowa;

    return number_format($zarobki, 2, '.', '');
}

function subYear($date)
{
    return substr($date, 11);
}
function subDay($date)
{
    return substr($date, 0, 10);
}

function showInHours($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    // Formatowanie do hh:mm:ss
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function timeDiffInSeconds($time1, $time2)
{
    $datetime1 = strtotime($time1);
    $datetime2 = strtotime($time2);

    if ($datetime1 === false || $datetime2 === false) {
        // W przypadku nieprawidłowego formatu czasu, zwróć 0 lub rzuć wyjątek, zależnie od wymagań
        return 0;
    }

    // Oblicz różnicę czasu w sekundach
    $diffInSeconds = abs($datetime2 - $datetime1);

    return $diffInSeconds;
}

function printDaysOfMonth($month, $year)
{
    // Utwórz obiekt DateTime dla pierwszego dnia podanego miesiąca
    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-01");

    // Znajdź liczbę dni w podanym miesiącu
    $daysInMonth = $date->format('t');

    // Pętla od 1 do liczby dni w miesiącu
    for ($day = 1; $day <= $daysInMonth; $day++) {
        // Ustaw datę na odpowiedni dzień miesiąca
        $date->setDate($year, $month, $day);

        // Wypisz datę w formacie Y-m-d
        echo $date->format('Y-m-d') . "<br>";
    }
}
function removeLeadingZero($str)
{
    // Sprawdzenie, czy pierwszy znak to "0"
    if (isset($str[0]) && $str[0] === '0') {
        // Usunięcie pierwszego znaku
        $str = substr($str, 1);
    }
    return $str;
}

function removeElement(&$array, $id, $color)
{
    foreach ($array as $key => $item) {
        if ($item['id'] === $id && $item['color'] === $color) {
            unset($array[$key]);
        }
    }
}

function timeDiff($datetime1, $datetime2)
{
    // Tworzenie obiektów DateTime z przekazanych parametrów
    $date1 = new DateTime($datetime1);
    $date2 = new DateTime($datetime2);

    // Obliczenie różnicy między datami
    $interval = $date1->diff($date2);

    // Zwrócenie różnicy w formacie H:i:s
    return $interval->format('%H:%I:%S');
}

function checkWords($text1, $text2)
{
    $wordsToCheck = ['Wernera', 'Barlickiego', 'Rapackiego'];

    foreach ($wordsToCheck as $word) {
        if (strpos($text1, $word) !== false && strpos($text2, $word) !== false) {
            return true;
        }
    }

    return false;
}
function checkWord($text1)
{
    $wordsToCheck = ['Wernera', 'Barlickiego', 'Rapackiego'];

    foreach ($wordsToCheck as $word) {
        if (strpos($text1, $word) !== false) {
            return true;
        }
    }
    if ($text1 == 0) {
        return true;
    }

    return false;
}

function timeToSeconds($time)
{
    list($hours, $minutes, $seconds) = explode(':', $time);

    $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

    return $totalSeconds;
}
function secondsToTime($seconds)
{
    $hours = floor($seconds / 3600);

    $minutes = floor(($seconds % 3600) / 60);

    $remainingSeconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
}

function averageStopTime($seconds, $stops)
{
    if ($stops <= 0) {
        return false;
    }

    $averageSeconds = $seconds / $stops;

    $hours = floor($averageSeconds / 3600);
    $minutes = floor(($averageSeconds % 3600) / 60);
    $remainingSeconds = $averageSeconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
}
function avgDistance($distance, $stops)
{
    if ($stops <= 0) {
        return false;
    }
    return round(($distance / $stops) / 1000, 1);
}

function amountPerPoint($amount, $points)
{
    if ($points <= 0) {
        return 0;
    }

    $amountPerPoint = $amount / $points;

    return floor($amountPerPoint * 100) / 100;
}

function roundToNearest5($number)
{
    $rounded = round($number);

    $lastDigit = $rounded % 10;

    if ($lastDigit < 3) {
        $rounded -= $lastDigit;
    } elseif ($lastDigit < 8) {
        $rounded += (5 - $lastDigit);
    } else {
        $rounded += (10 - $lastDigit);
    }

    return $rounded;
}

function getPolishMonthName($monthNumber)
{
    // Tablica z polskimi nazwami miesięcy
    $polishMonths = [
        1 => "Styczeń",
        2 => "Luty",
        3 => "Marzec",
        4 => "Kwiecień",
        5 => "Maj",
        6 => "Czerwiec",
        7 => "Lipiec",
        8 => "Sierpień",
        9 => "Wrzesień",
        10 => "Październik",
        11 => "Listopad",
        12 => "Grudzień"
    ];

    // Zwraca polską nazwę miesiąca na podstawie numeru miesiąca
    return $polishMonths[$monthNumber] ?? "Nieznany miesiąc";
}

function getPolishDayName($dayNumber)
{
    // Tablica z polskimi nazwami miesięcy
    $polishDays = [
        1 => "poniedziałek",
        2 => "wtorek",
        3 => "środa",
        4 => "czwartek",
        5 => "piątek",
        6 => "sobota",
        7 => "niedziela"
    ];

    // Zwraca polską nazwę miesiąca na podstawie numeru miesiąca
    return $polishDays[$dayNumber] ?? "Nieznany dzień";
}

function countDaysExcludingSundays($dateFrom, $dateTo, $holidays = []) {
    $start = new DateTime($dateFrom);
    $end = new DateTime($dateTo);
    $end->modify('+1 day'); // Uwzględnij dzień końcowy w iteracji

    $interval = new DateInterval('P1D'); // 1-dniowy krok
    $dateRange = new DatePeriod($start, $interval, $end);

    $nonSundayAndHolidayCount = 0;

    foreach ($dateRange as $date) {
        $formattedDate = $date->format('Y-m-d');

        // Sprawdź, czy dzień nie jest niedzielą i nie jest w tablicy świąt
        if ($date->format('w') != 0 && $date->format('w') != 6 && !in_array($formattedDate, $holidays)) {
            $nonSundayAndHolidayCount++;
        }
    }

    return $nonSundayAndHolidayCount;
}