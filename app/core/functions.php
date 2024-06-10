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
function getPercent($p, $c, $cel = 2)
{
	$ret = 0;
	if($c > 0) {
		$ret = round($p / $c * 100, $cel);
	}
	return $ret;
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