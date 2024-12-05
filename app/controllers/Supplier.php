<?php

/**
 * GetCargo class
 */
class Supplier
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $plikCSV = ROOT.'/assets/tmp/oferta.csv';

        // Sprawdź, czy plik istnieje

        $sup = []; // Tablica na dane z CSV

//                                                                                              SELIGA
        // Otwórz plik CSV w trybie odczytu

        $comp_id = 447;
        $supp = new Supplierproducts();
        if(!empty($supp->getSupplier($comp_id))) {
            foreach($supp->getSupplier($comp_id) as $s) {
                $data["supplier"][$s->id] = $s;
            }
        }

        if (($handle = fopen($plikCSV, 'r')) !== FALSE) {
            // Czytaj plik linia po linii
            $in = 1;
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) { // Separator: przecinek (,)
                if($row[0] <> "" && $row[2] <> "" && $row[0] <> "LP") {
                    $cleanedString = trim(preg_replace('/\s*["\'][^"\']*["\']\s*/', ' ', $row[2]));
                    $cleanedString = str_replace("SMAK TRADYCJI", "", $cleanedString);
                    $cleanedString = str_replace("KOSZ NATURY", "", $cleanedString);
                    $cleanedString = str_replace("KLIMEK", "", $cleanedString);
                    $cleanedString = str_replace("GUTIMEX", "", $cleanedString);
                    $cleanedString = str_replace("do wyczerpania", "", $cleanedString);
                    $cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString));
                    $cleanedString = str_replace("'", "", $cleanedString);
                    $cleanedString = str_replace([';', '.', '-', '_', ':'], '', $cleanedString);
                    $cleanedString = preg_replace('/\s+/', ' ', $cleanedString);
                    $cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString));
                    $cleanedString = str_replace("G SZT", "G", $cleanedString);
                    $cleanedString = str_replace("I KG", "I", $cleanedString);
                    $cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString));
                    $cleanedString = trim(preg_replace('/\s+\w{2,3}$/', '', $cleanedString));
                    $cleanedString = str_replace(",",".",$cleanedString);
                    
                    if (substr($cleanedString, -6) === "SŁOIK") {
                        // Usuwamy ostatnie słowo "SŁOIK"
                        $cleanedString = substr($cleanedString, 0, -6);
                    }
                    
                    $cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString));

                    // Dopasowanie ostatniego słowa, które zawiera liczbę i jednostkę
                    $pattern = '/(\d+)([A-Za-z]+)$/'; // Dopasowanie liczby na końcu z literami

                    if (preg_match($pattern, $cleanedString, $matches)) {
                        // Jeśli dopasowano, dodajemy spację między liczbą a jednostką
                        $cleanedString = preg_replace($pattern, $matches[1] . ' ' . $matches[2], $cleanedString);
                    }

                    $string = trim($cleanedString);

                    $words = explode(' ', $string);
                    $last_word = end($words);

                    $valid_units = ['G', 'ML', 'L', 'KG', 'SZT', 'ml'];

                    if (in_array($last_word, $valid_units)) {
                        $unit = $last_word;
                        array_pop($words);
                    } else {
                        $unit = "Brak";
                    }
                    $cleanedString = implode(' ', $words);
                    
                    $amount = 0;
                    $string = trim($cleanedString);
                    
                    $words = explode(' ', $string);

                    $last_word = end($words);

                    if (preg_match('/^(\d+)\/(\d+)$/', $last_word, $matches)) {
                        $amount = $matches[2];
                        array_pop($words);
                    } elseif (is_numeric($last_word)) {
                        if (substr($last_word, 0, 1) === '0' && strlen($last_word) > 1) {
                            $amount = '0,' . substr($last_word, 1);
                        } else {
                            $amount = $last_word;
                        }
                        array_pop($words);
                    } else {
                        $amount = 1; 
                    }
                    $cleanedString = implode(' ', $words);

                    if (substr($cleanedString, -2) === "OP") {
                        // Usuwamy ostatnie słowo "SŁOIK"
                        $cleanedString = substr($cleanedString, 0, -2);
                    }

                    $fullname = trim($cleanedString);
                    $id_supplier_category = 0;
                    $isindb = false;
                    if(isset($data["supplier"])) {
                        foreach($data["supplier"] as $s) {
                            if($s->full_name == $row[2]) {
                                $isindb = true;
                                $id_supplier_category = $s->id;
                            }
                        }
                    }
                    if(!$isindb) {
                        //TUTAJ DODAĆ DO BAZY NOWY PRODUKT I USTAWIĆ ZMIENNĄ
                        
                        //dodać
                    }
                    $unit = strtolower($unit);

                    $sup[$in]["supplier_products"]["id_supplier_category"] = $id_supplier_category; 
                    $sup[$in]["supplier_products"]["id_company"] = $comp_id; // 447 - Seliga 
                    $sup[$in]["supplier_products"]["full_name"] = $row[2]; 
                    $sup[$in]["supplier_products"]["producent"] = ""; 
                    $sup[$in]["supplier_products"]["producent_id"] = ""; 
                    $sup[$in]["supplier_products"]["name"] = $fullname;
                    $sup[$in]["supplier_products"]["amount"] = $amount; 
                    $sup[$in]["supplier_products"]["unit"] = $unit; 
                    $sup[$in]["supplier_products"]["unit_order"] = strtolower(str_replace([' ', '.'], '', $row[4])); 

                    $data[] = $fullname;

                    $date = date("Y-m-d");
                    $vat = "";
                    $netto_price = "";
                    $brutto_price = "";
                    if(isset($row[6])) {
                        $vat = str_replace("%","",$row[6]);
                    }
                    if(isset($row[7])) {
                        $netto_price = $row[7];
                    }
                    if(isset($row[8])) {
                        $brutto_price = $row[8];
                    }
                    $sup[$in]["supplier_cost"]["id_supplier_products"] = $id_supplier_category;
                    $sup[$in]["supplier_cost"]["netto_price"] = $netto_price;
                    $sup[$in]["supplier_cost"]["vat"] = $vat;
                    $sup[$in]["supplier_cost"]["brutto_price"] = $brutto_price;
                    
                    if($unit == "szt" || $unit == "brak") {
                        $sup[$in]["supplier_cost"]["netto_price_100g"] = 0;
                        $sup[$in]["supplier_cost"]["netto_price_1kg"] = 0;
                    } else {
                        if(isset($netto_price) && isset($amount) && $unit <> "brak") {
                            if($amount == 0) {
                                $price_per_gram = $netto_price / $amount;
                                $price_for_100g = $price_per_gram * 100;
                                $price_for_1000g = $price_per_gram * 1000;
                            } else {
                                show($sup[$in]);
                            }
                        } else {
                            $price_for_100g = 0;
                            $price_for_1000g = 0;
                        }
                        $sup[$in]["supplier_cost"]["netto_price_100g"] = number_format($price_for_100g, 2);
                        $sup[$in]["supplier_cost"]["netto_price_1kg"] = number_format($price_for_1000g, 2);


                    }
                    
                    $sup[$in]["supplier_cost"]["date"] = $date;





                    $in++;
                }
            }
            fclose($handle); // Zamknij plik
        } else {
            die("Nie udało się otworzyć pliku $plikCSV!");
        }

        // Wyświetl dane w formacie tablicy (przydatne do debugowania)
        echo "<pre>";
        //print_r($data);
        print_r($sup);
        echo "</pre>";

        die;

        $this->view('supplier', $data);
    }

}
