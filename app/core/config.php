<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	/** database config **/
	define('DBNAME', 'efoody');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'http://localhost/efoody/public');
	define('IMG_ROOT', '/efoody/public/assets/img/');
	define('IMG_ROOT_UPLOAD', '../public/assets/img/');


} else {
	/** database config **/
	define('DBNAME', 'efoody');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');
	define('IMG_ROOT', '/efoody/public/assets/img/');
	define('IMG_ROOT_UPLOAD', '../public/assets/img/');

}

define('APP_NAME', "My Webiste");
define('APP_DESC', "Best website on the planet");

define('PRODUCTTYPENAMES', [0 => "Półprodukt", 1 => "Gotowy produkt"]);
define('COMPANIESTYPE', [0 => "Sprzedażowa", 1 => "Zakupowa"]);
define('STATUSNAME', [0 => "Nieaktywne", 1 => "Aktywne"]);
define('TRADERS', '1, 3');

/** true means show errors **/
define('DEBUG', true);
