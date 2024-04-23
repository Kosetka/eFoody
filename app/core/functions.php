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