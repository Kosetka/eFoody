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
	define('DBUSER', 'efoody_admin');
	define('DBPASS', '#Verona123');
	define('DBDRIVER', '');

	define('ROOT', 'https://51.254.47.60/eFoody/public'); //http://51.254.47.60/eFoody/public
	define('IMG_ROOT', '/assets/img/'); ///efoody/public/assets/img/
	define('IMG_ROOT_UPLOAD', '../public/assets/img/'); //../public/assets/img/

}

define('APP_NAME', "My Webiste");
define('APP_DESC', "Best website on the planet");

define('PRODUCTTYPENAMES', [0 => "Półprodukt", 1 => "Gotowy produkt"]);
define('COMPANIESTYPE', [0 => "Sprzedażowa", 1 => "Zakupowa"]);
define('STATUSNAME', [0 => "Nieaktywne", 1 => "Aktywne"]);
define('VISITSTATUSES', [0 => "Brak sprzedaży", 1 => "Sprzedaż", 2 => "Gratisy rozdane"]);
define('COMPANYSIZE', ["building" => "Biurowiec", "house" => "Dom", "shop" => "Sklep", "warehouse" => "Magazyn", "exclamation" => "Duży biurowiec"]);
define('TRADERS', '1, 3');
define('EXCHANGESTATUS', [0 => "Oczekuje", 1 => "Zaakceptowany", 2 => "Odrzucony", 3 => "Odrzucony automatycznie", 4 => "Anulowany"]);
define('REPORTTYPES', ['hour' => "godzinny", 'day'=>"dzienny", 'week' => "tygodniowy", 'month' => "miesięczny"]);

/** true means show errors **/
define('DEBUG', true);
