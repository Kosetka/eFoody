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

        $processedValues = [];
        $data["supplier"] = [];
        $data["supplier_prod"] = [];
        $comp_id = 447;
        $supp = new Suppliercategory();
        if(!empty($supp->getSupplier($comp_id))) {
            foreach($supp->getSupplier($comp_id) as $s) {
                $data["supplier"][$s->id] = $s;
            }
        }
        $supppro = new Supplierproducts();
        if(!empty($supppro->getSupplier($comp_id))) {
            foreach($supppro->getSupplier($comp_id) as $s) {
                $data["supplier_prod"][$s->id] = $s;
            }
        }
        //show($data["supplier"]);die;

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
                    $cleanedString = str_replace("EAT ME", "", $cleanedString);
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
                    $amount_temp = "";
                    $string = trim($cleanedString);
                    
                    $words = explode(' ', $string);

                    $last_word = end($words);

                    if (preg_match('/^(\d+)\/(\d+)$/', $last_word, $matches)) {
                        $amount = $matches[2];
                        //$amount_temp = $last_word;

                        array_pop($words);
                    } elseif (is_numeric($last_word)) {
                        if (substr($last_word, 0, 1) === '0' && strlen($last_word) > 1) {
                            $amount = '0' . substr($last_word, 1);
                        } else {
                            $amount_temp = $last_word;
                            $amount = 1;//$last_word;
                        }
                        array_pop($words);
                    } else {
                        
                        $amount = 1; 
                    }
                    $cleanedString = implode(' ', $words);

                    if (substr($cleanedString, -2) === "OP") {
                        $cleanedString = substr($cleanedString, 0, -2);
                        if($amount_temp <> "") {
                            $amount_temp = "";
                            //$amount = $amount_temp;
                        }
                    }
                    


                    $string = trim($cleanedString);

                    $words = explode(' ', $string);
                    $last_word = end($words);

                    $valid_units = ['G', 'ML', 'L', 'KG', 'SZT', 'ml', 'SZTUKI'];

                    if (in_array($last_word, $valid_units)) {
                        $unit = $last_word;
                        array_pop($words);
                    }
                    $cleanedString = implode(' ', $words);
                    $string = trim($cleanedString);
                    
                    $words = explode(' ', $string);

                    $last_word = end($words);

                    if (preg_match('/^(\d+)\/(\d+)$/', $last_word, $matches)) {
                        $amount = $matches[2];
                        array_pop($words);
                    } elseif (is_numeric($last_word)) {
                        if (substr($last_word, 0, 1) === '0' && strlen($last_word) > 1) {
                            $amount = '0' . substr($last_word, 1);
                        } else {
                            $amount = 1;//$last_word;
                            if($unit == "G" || $unit == "ML") {
                                $amount = $last_word;
                            }
                        }
                        array_pop($words);
                    } else {
                        if($amount_temp == "") {
                            $amount = 1; 
                        }
                    }
                    $cleanedString = implode(' ', $words);
                    $cleanedString = str_replace("KARTON", "", $cleanedString);
                    $cleanedString = str_replace("DONICZKA", "", $cleanedString);
                    $cleanedString = str_replace("OP PRÓŻNIOWE", "", $cleanedString);
                    $cleanedString = str_replace("OPPRÓŻNIOWE", "", $cleanedString);

                    


                    
                    //echo $cleanedString."</br>";
                    $fullname = trim($cleanedString);
                    
                    $fn_temp = trim(preg_replace('/\s*["\'][^"\']*["\']\s*/', ' ', $row[2]));
                    $fn_temp = trim(preg_replace('/\s+/', ' ', $fn_temp));
                    $fullname = trim(preg_replace('/\s+/', ' ', $fullname));
                    //echo $fullname."</br>";
                    $id_supplier_category = 0;
                    

                    $unit = strtolower($unit);
                    if($unit == "sztuki") {
                        $unit = "szt";
                    }
                    if($unit == "g") {
                        $unit = "kg";
                        $amount = $amount / 1000;
                    }
                    if($unit == "ml") {
                        $unit = "l";
                        $amount = $amount / 1000;
                    }

                    $sup[$in]["supplier_products"]["id_supplier_category"] = $id_supplier_category; 
                    $sup[$in]["supplier_products"]["id_company"] = $comp_id; // 447 - Seliga 
                    $sup[$in]["supplier_products"]["full_name"] = $row[2]; 
                    $sup[$in]["supplier_products"]["producent"] = ""; 
                    $sup[$in]["supplier_products"]["producent_id"] = ""; 
                    $sup[$in]["supplier_products"]["name"] = $fullname;
                    $sup[$in]["supplier_products"]["amount"] = $amount; 
                    $sup[$in]["supplier_products"]["unit"] = $unit; 
                    $sup[$in]["supplier_products"]["unit_order"] = strtolower(str_replace([' ', '.'], '', $row[4])); 

                    

                    if($sup[$in]["supplier_products"]["unit_order"] == "szt" && $sup[$in]["supplier_products"]["unit"] == "szt") {
                        if($amount_temp == "") {
                            $sup[$in]["supplier_products"]["amount"] = 1;
                        } else {
                            $sup[$in]["supplier_products"]["amount"] = $amount_temp;
                        }
                    }
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
                    $sup[$in]["supplier_cost"]["netto_per_unit"] = 0;
                    
//show($sup[$in]);

                    if($amount_temp <> "") {
                        $sup[$in]["supplier_cost"]["netto_per_unit"] = number_format($netto_price / $amount_temp, 2);
                    }

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
                            } if($amount > 0 && $amount < 1) {
                                $price_per_gram = ($netto_price / $amount) / 1000;
                                $price_for_100g = $price_per_gram * 100;
                                $price_for_1000g = $price_per_gram * 1000;
                            } else if ($amount >= 1) {
                                $price_per_gram = $netto_price / $amount / 1000;
                                $price_for_100g = $price_per_gram * 100;
                                $price_for_1000g = $price_per_gram * 1000;
                            } else {
                                $price_for_100g = 0;
                                $price_for_1000g = 0;
                                //show($sup[$in]);
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
            
            foreach($sup as $sk => $s) {
                $isindb = false;
                $id_supplier_category = 0;
                $sname = $s["supplier_products"]["name"];
                foreach($data["supplier"] as $kssup => $ssup) {
                    $tsname = $ssup->name;
                    if($sname == $tsname) {
                        $isindb = true;
                        $id_supplier_category = $ssup->id;
                        break;
                    }
                }
                if(!$isindb) {
                    $supcat = new Suppliercategory();
                    $supcat->insert(["name" => $sname, "supplier_id" => $comp_id]);
                    $id_supplier_category = $supcat->getLast();

                    if (!isset($data["supplier"][$id_supplier_category])) {
                        $data["supplier"][$id_supplier_category] = new stdClass();
                    }

                    $data["supplier"][$id_supplier_category]->id = $id_supplier_category;
                    $data["supplier"][$id_supplier_category]->sub_prod_id = "";
                    $data["supplier"][$id_supplier_category]->name = $sname;
                    $data["supplier"][$id_supplier_category]->supplier_id = $comp_id;
                }
                $sup[$sk]["supplier_products"]["id_supplier_category"] = $id_supplier_category;
                //TUTAJ WSTAWIAĆ CENY I PRODUKTY PRZY CZYM SPRAWDZAĆ JESZCZE CZY TAKI PRODUKT JEST


                /*$isindb = false;
                $id_supplier_category = 0;
                $sname = $s["supplier_products"]["name"];
                foreach($data["supplier_prod"] as $kssup => $ssup) {
                    $tsname = $ssup->name;
                    if($sname == $tsname) {
                        $isindb = true;
                        $id_supplier_category = $ssup->id;
                        break;
                    }
                }
                if(!$isindb) {
                    $supcat = new Supplierproducts();
                    //$supcat->insert(["name" => $sname, "supplier_id" => $comp_id]);
                    //$id_supplier_product = $supcat->getLast();

                    if (!isset($data["supplier_prod"][$id_supplier_category])) {
                        $data["supplier_prod"][$id_supplier_category] = new stdClass();
                    }
                }*/



            }
            show($sup);



            fclose($handle); // Zamknij plik
        } else {
            die("Nie udało się otworzyć pliku $plikCSV!");
        }

        // Wyświetl dane w formacie tablicy (przydatne do debugowania)
        echo "<pre>";
        //print_r($data);
        //print_r($sup);
        echo "</pre>";

        die;

        $this->view('supplier', $data);
    }

}
