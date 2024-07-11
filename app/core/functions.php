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
    if($c == 0) {
        return 0;
    }
	return round(($p - $c) / $p * 100, 2);
}
function showPrice($p, $c)
{
    if($c == 0) {
        return 0;
    }
	return round($p / $c, 2);
}
function getPercent($p, $c, $cel = 2)
{
	$ret = 0;
	if($c > 0) {
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

function buildHierarchy($data) {
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

function generateTree($items) {
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

function generateTreeEditing($items) {
    $html = '<ul class="tree">';
    foreach ($items as $item) {
        $html .= '<li class="tree">';
        //$html .= '<input type="checkbox" id="checkbox-' . $item['id'] . '" class="checkbox tree" data-id="' . $item['id'] . '" />';
        $color = "";
        if($item["l_active"] == 0) {
            $color = ' style="color: red; text-decoration: line-through;" ';
        }
        $html .= '<label class="tree" '.$color.'>' . $item['l_name'] . ' [<a style="color: green;" href="'.ROOT.'/tabs/add/'.$item["id"].'">Dodaj</a>] [<a href="'.ROOT.'/tabs/edit/'.$item["id"].'">Edytuj</a>]</label>';
        if (!empty($item['children'])) {
            $html .= generateTreeEditing($item['children']);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

function isDateInRange($date) { //do SMS
    $inputDate = new DateTime($date);
    $now = new DateTime();

    // Dni tygodnia: 0 (niedziela) - 6 (sobota)
    $today = (int)$now->format('w');

    if ($today >= 2 && $today <= 5) { // od wtorku do piątku
        $start = (clone $now)->setTime(15, 0, 0)->modify('-1 day');
        $end = (clone $now)->setTime(15, 0, 0);
    } else { // sobota, niedziela, poniedziałek
        $start = (clone $now)->setTime(15, 0, 0)->modify('last Friday');
        $end = (clone $now)->setTime(15, 0, 0);
    }

    return $inputDate >= $start && $inputDate <= $end;
}

function getWeekends($year) {
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

function changePolishChars($tekst) {
    $polskieZnaki = array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż', 
                          'Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż');
    $zwykleZnaki = array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z',
                         'A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z');
    return strtr($tekst, array_combine($polskieZnaki, $zwykleZnaki));
}

function subYear($date) {
    return substr($date, 11);
}
function subDay($date) {
    return substr($date, 0, 10);
}

function showInHours($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    // Formatowanie do hh:mm:ss
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function timeDiffInSeconds($time1, $time2) {
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

function printDaysOfMonth($month, $year) {
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