<?php

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.1.101') {
	/** database config **/
	define('DBNAME', 'efoody');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'http://localhost/efoody/public'); //http://localhost/efoody/public
	define('ROOT_DIR', '/efoody/public/');
	define('ROOT_PLUGINS', '../public/plugins/');
	define('IMG_ROOT', '/efoody/public/assets/img/');
	define('IMG_ALERGENS_ROOT', '/efoody/public/assets/img/alergens/');
	define('IMG_ROOT_UPLOAD', '../public/assets/img/');
	define('IMG_LABELS_UPLOAD', '../public/assets/labels/');
	define('IMG_ALERGENS_ROOT_UPLOAD', '../public/assets/img/alergens/');
	define('SEND_ON', false);


} else {
	/** database config **/
	define('DBNAME', 'efoody');
	define('DBHOST', 'localhost');
	define('DBUSER', 'efoody_admin');
	define('DBPASS', '#Verona123');
	define('DBDRIVER', '');

	define('ROOT', ''); //https://51.254.47.60
	define('ROOT_DIR', '/');
	define('ROOT_PLUGINS', '../public/plugins/');
	define('IMG_ROOT', '/assets/img/'); ///efoody/public/assets/img/
	define('IMG_ALERGENS_ROOT', '/assets/img/alergens/'); ///efoody/public/assets/img/
	define('IMG_ROOT_UPLOAD', '../public/assets/img/'); //../public/assets/img/
	define('IMG_LABELS_UPLOAD', '../public/assets/labels/');
	define('IMG_ALERGENS_ROOT_UPLOAD', '../public/assets/img/alergens/');
	define('SEND_ON', true);
}

define('APP_NAME', "My Webiste");
define('APP_DESC', "Best website on the planet");

define('PRODUCTTYPENAMES', [0 => "Półprodukt", 1 => "Gotowy produkt", 2 => "Sos własny"]);
define('COMPANIESTYPE', [0 => "Sprzedażowa (Handlowcy)", 1 => "Zakupowa", 2 => "Dostawa (zmienna cena)", 3 => "Dostawa (stała cena)"]);
define('STATUSNAME', [0 => "Nieaktywne", 1 => "Aktywne"]);
define('VISITSTATUSES', [0 => "Brak sprzedaży", 1 => "Sprzedaż", 2 => "Gratisy rozdane"]);
define('COMPANYSIZE', ["building" => "Biurowiec", "house" => "Dom", "shop" => "Sklep", "warehouse" => "Magazyn", "exclamation" => "Duży biurowiec", "school" => "Liceum"]);
define('TRADERS', '3'); //define('TRADERS', '1, 3');
define('ALLTRADERS', '3, 10'); //define('TRADERS', '1, 3');
define('EXCHANGESTATUS', [0 => "Oczekuje", 1 => "Zaakceptowany", 2 => "Odrzucony", 3 => "Odrzucony automatycznie", 4 => "Anulowany"]);
define('REPORTTYPES', ['hour' => "godzinny", 'day' => "dzienny", 'week' => "tygodniowy", 'month' => "miesięczny"]);
define('COSTTYPES', [1 => "Dzienny", 2 => "Tygodniowy", 3 => "Miesięczny", 4 => "Roczny", 5 => "Jednorazowy"]);
define('COSTCATEGORIES', [1 => "Administracja", 2 => "Flota", 3 => "Kuchnia", 4 => "IT", 5 => "Media"]);
define('COSTMETHODS', [0 => "-", 1 => "Gotówka", 2 => "Karta *1111", 3 => "Przelew"]);
define('ATTENDANCEERRORS', ["OK,atcErr01" => "Brak karty w systemie", "OK,atcErr02" => "Karta zablokowana"]);
define('POLISHMONTHS',[
	"January" => "Styczeń",
    "February" => "Luty",
    "March" => "Marzec",
    "April" => "Kwiecień",
    "May" => "Maj",
    "June" => "Czerwiec",
    "July" => "Lipiec",
    "August" => "Sierpień",
    "September" => "Wrzesień",
    "October" => "Październik",
    "November" => "Listopad",
    "December" => "Grudzień",
    "01" => "Styczeń",
    "1" => "Styczeń",
    "02" => "Luty",
    "2" => "Luty",
    "03" => "Marzec",
    "3" => "Marzec",
    "04" => "Kwiecień",
    "4" => "Kwiecień",
    "05" => "Maj",
    "5" => "Maj",
    "06" => "Czerwiec",
    "6" => "Czerwiec",
    "07" => "Lipiec",
    "7" => "Lipiec",
    "08" => "Sierpień",
    "8" => "Sierpień",
    "09" => "Wrzesień",
    "9" => "Wrzesień",
    "10" => "Październik",
    "11" => "Listopad",
    "12" => "Grudzień"
]);
define('LABELCOST',["cost" => 16.50, "labels" => 1034]);
define('FUELTYPE',[0 => "Diesel", 1 => "Benzyna"]);
define('BONUSTYPE',[0 => "Premia", 1 => "Kara"]);
define('PAGETYPE',[1 => "Fingerfood", 2 => "Catering"]);
define('DELIVERYHOUR',[0 => "Brak", 1 => "Rano", 2 => "Południe", 3 => "Popołudnie", 4 => "Wieczór"]);
                                        

/** true means show errors **/
define( 'DEBUG', true);

