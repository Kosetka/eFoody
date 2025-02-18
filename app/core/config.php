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
define('COMPANYTYPE', ["grocery_or_supermarket" => "Sklep spożywczy", "school" => "Szkoła", "secondary_school" => "Szkoła Wieczorowa"]);
define('VISITSTATUSES', [0 => "Brak sprzedaży", 1 => "Sprzedaż", 2 => "Gratisy rozdane"]);
define('COMPANYVISIT', [0 => "-", 1 => "Zamknięte na stałe", 2 => "Chętny", 3 => "Nie chcą", 5 => "Inny powód", 6 => "To nie sklep", 7 => "Stary punkt", 8 => "Supermarket", 9 => "Ponowny kontakt"]);
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
define('WEEKDAYNAMES',[
	"0" => "Niedziela",
    "1" => "Poniedziałek",
    "2" => "Wtorek",
    "3" => "Środa",
    "4" => "Czwartek",
    "5" => "Piątek",
    "6" => "Sobota"

]);
define("SUPPLIERCOUNTY",[
    "KOSTARYKA" => "CR",
    "BRAZYLIA" => "BR",
    "PERU" => "PE",
    "IZRAEL" => "IL",
    "HISZPANIA" => "ES",
    "EKWADOR" => "EC",
    "POLSKA" => "PL",
    "WŁOCHY" => "IT",
    "HOLANDIA" => "NL",
    "AMERYKA" => "SA",
    "TURCJA" => "TR",
    "CHINY" => "CN",
    "MAROKO" => "MA",
    "KOLUMBIA" => "CO",
    "WIETNAM" => "WN",
    "FRANCJA" => "FR",
    "MACEDONIA" => "MK",
    "MALEZJA" => "MY",
    "GRECJA" => "GR",
    "NOWA ZELANDIA" => "NZ",
    "FILIPINY" => "PH",
    "HONDURAS" => "HN",
    "ROSJA" => "RU",
    "MOŁDAWIA" => "MD",
    "EGIPT" => "EG",
    "USA" => "SA",
    "IRAN" => "IR",
    "CHILE" => "CL"
]);
define('LABELCOST',["cost" => 16.50, "labels" => 1034]);
define('FUELTYPE',[0 => "Diesel", 1 => "Benzyna"]);
define('BONUSTYPE',[0 => "Premia", 1 => "Kara"]);
define('PAGETYPE',[1 => "Fingerfood", 2 => "Catering"]);
define('DELIVERYHOUR',[
    0 => "Brak", 
    1 => "Rano", 
    //2 => "Południe", 
    3 => "Popołudnie", 
    //4 => "Wieczór"
]);

define('HOLIDAYS',
[
    '2024-11-01', // Wszystkich Świętych
    '2024-11-11', // Narodowe Święto Niepodległości
    '2024-12-20', // wolne
    '2024-12-21', // wolne
    '2024-12-22', // wolne
    '2024-12-23', // wolne
    '2024-12-24', // wolne
    '2024-12-25', // Boże Narodzenie (pierwszy dzień)
    '2024-12-26', // Boże Narodzenie (drugi dzień)
    '2024-12-27', // wolne
    '2024-12-28', // wolne
    '2024-12-30', // wolne
    '2024-12-31', // wolne
    '2025-01-01', // Nowy Rok
    '2025-01-02', // wolne
    '2025-01-03', // wolne
    '2025-01-04', // wolne
    '2025-01-06', // Trzech Króli
    '2025-01-07', // wolne
    '2025-04-20', // Wielkanoc (pierwszy dzień)
    '2025-04-21', // Wielkanoc (drugi dzień)
    '2025-05-01', // Święto Pracy
    '2025-05-03', // Święto Konstytucji 3 Maja
    '2025-06-08', // Zielone Świątki
    '2025-06-19', // Boże Ciało
    '2025-08-15', // Wniebowzięcie NMP
]);

define("CART_STATUS", [
	0 => "Koszyk",
	1 => "Płatność na miejscu",
	2 => "Oczekuje na płatność",
	3 => "Opłacone online",
	4 => "Dostarczone (na miejscu)",
	5 => "Dostarczone (online)",
	6 => "Zamówienie anulowane",
	7 => "Zamówienie anulowane (na miejscu)",
	8 => "Płatność anulowana",
	9 => "Zwrot online"
]);

define("ORDER_PAYED", "1, 3, 4, 5");
            
define("TEMPLATE", [
	"lost_password" => "../app/views/template/lostpassword.view.php",
	"order_confirm" => "../app/views/template/orderconfirm.view.php",
	"register_confirm" => "../app/views/template/registerconfirm.view.php",
]);

/** true means show errors **/
define( 'DEBUG', true);

