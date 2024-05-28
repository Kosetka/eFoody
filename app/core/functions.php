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
	return round(($p - $c) / $p * 100, 2);
}
function getPercent($p, $c)
{
	$ret = 0;
	if($c > 0) {
		$ret = round($p / $c * 100, 2);
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