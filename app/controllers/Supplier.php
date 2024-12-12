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

        $plikCSV = ROOT.'/assets/tmp/gobarto2.csv';

        // Sprawdź, czy plik istnieje

        $sup = []; // Tablica na dane z CSV

//                                                                                              SELIGA
        // Otwórz plik CSV w trybie odczytu

        $processedValues = [];
        $data["supplier"] = [];
        $data["supplier_prod"] = [];
        $comp_id = 448; //447 - oferta 2 3
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
        $today = date("Y-m-d");
        //$today = date("2024-12-11");
        $suppco = new Suppliercost();
        if(!empty($suppco->getCosts($today))) {
            foreach($suppco->getCosts($today) as $s) {
                $data["supplier_cost"][$s->id_supplier_products] = $s;
            }
        }
        //show($data["supplier"]);die;

        if($comp_id == 447) {
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
                                if($unit == "G" || $unit == "ML"|| $unit == "ml" || $unit == "g") {
                                    $amount = $last_word;
                                }
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
                            
                            if($amount_temp == "" && $amount == 1) {
                                /*if($in == 288) {
                                    echo "słowo: '".$last_word ."'</br>jednostka: '" . $unit ."'</br>liczba: ". $amount;
                                    show($cleanedString);
                                }*/
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
                        if($unit == "brak") {
                            $unit = strtolower(str_replace([' ', '.'], '', $row[4]));
                        }
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
                            $netto_price = (float) $row[7];
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
                                    $price_per_gram = $netto_price / $amount / 1000;
                                    $price_for_100g = $price_per_gram * 100;
                                    $price_for_1000g = $price_per_gram * 1000;
                                } else if ($amount >= 1) {
                                    $price_per_gram = (float) $netto_price / $amount / 1000;
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
                        $sup[$sk]["supplier_products"]["id_supplier_category"] = $id_supplier_category;

                    }
                    $sup[$sk]["supplier_products"]["id_supplier_category"] = $id_supplier_category;


                    
                    
                    //TUTAJ WSTAWIAĆ CENY I PRODUKTY PRZY CZYM SPRAWDZAĆ JESZCZE CZY TAKI PRODUKT JEST

                    $to_ins = true;
                    $id_supplier_product = 0;
                    if(isset($data["supplier_prod"])){
                        foreach($data["supplier_prod"] as $sups) {
                            $tsname = $sups->full_name;
                            if($sup[$sk]["supplier_products"]["full_name"] == $tsname) {
                                $to_ins = false;
                                $id_supplier_product = $sups->id;
                                break;
                            }
                        }
                    }
                    if($to_ins) {
                        $supprod = new Supplierproducts();
                        $supprod->insert([
                            "id_supplier_category" => $sup[$sk]["supplier_products"]["id_supplier_category"], 
                            "id_company" => $comp_id,
                            "full_name" => $sup[$sk]["supplier_products"]["full_name"],
                            "producent" => "",
                            "producent_id" => "",
                            "name" => $sup[$sk]["supplier_products"]["name"],
                            "amount" => $sup[$sk]["supplier_products"]["amount"],
                            "unit" => $sup[$sk]["supplier_products"]["unit"],
                            "unit_order" => $sup[$sk]["supplier_products"]["unit_order"]
                        ]);
                        $id_supplier_product = $supprod->getLast();
                    }
                    $sup[$sk]["supplier_cost"]["id_supplier_products"] = $id_supplier_product;
                    
                    //TU CENA JEŚLI DZISIAJ NIE BYŁA TO DODAJEMY A JAK BYŁA TO AKTUALIZACJA
                    $supcost = new Suppliercost();
                    if(!isset($data["supplier_cost"][$id_supplier_product])) {
                        //dodajemy cene
                        $supcost->insert([
                            "id_supplier_products" => $sup[$sk]["supplier_cost"]["id_supplier_products"], 
                            "netto_price" => $sup[$sk]["supplier_cost"]["netto_price"],
                            "netto_per_unit" => $sup[$sk]["supplier_cost"]["netto_per_unit"],
                            "vat" => $sup[$sk]["supplier_cost"]["vat"],
                            "brutto_price" => $sup[$sk]["supplier_cost"]["brutto_price"],
                            "netto_price_100g" => $sup[$sk]["supplier_cost"]["netto_price_100g"],
                            "netto_price_1kg" => $sup[$sk]["supplier_cost"]["netto_price_1kg"],
                            "date" => $today
                        ]);
                    } else {
                        //aktualizujemy
                        $id_prod = $data["supplier_cost"][$id_supplier_product]->id;
                        $supcost->update($id_prod,[
                            "id_supplier_products" => $sup[$sk]["supplier_cost"]["id_supplier_products"], 
                            "netto_price" => $sup[$sk]["supplier_cost"]["netto_price"],
                            "netto_per_unit" => $sup[$sk]["supplier_cost"]["netto_per_unit"],
                            "vat" => $sup[$sk]["supplier_cost"]["vat"],
                            "brutto_price" => $sup[$sk]["supplier_cost"]["brutto_price"],
                            "netto_price_100g" => $sup[$sk]["supplier_cost"]["netto_price_100g"],
                            "netto_price_1kg" => $sup[$sk]["supplier_cost"]["netto_price_1kg"],
                            "date" => $today
                        ]);
                    }
                }
                show($sup);
                fclose($handle); // Zamknij plik
            } else {
                die("Nie udało się otworzyć pliku $plikCSV!");
            }
        }


        if($comp_id == 448) {
    //                                                                                          GOBARTO
            if (($handle = fopen($plikCSV, 'r')) !== FALSE) {
                // Czytaj plik linia po linii
                $in = 1;
                $id_supplier_category = 0;
                while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) { // Separator: przecinek (,)
                    if($row[0] <> "" && $row[2] <> "" && $row[3] <> "") {
                        $cleanedString = trim(preg_replace('/\s*["\'][^"\']*["\']\s*/', ' ', $row[1]));
                        $fullname = $cleanedString;
                        $cleanedString = preg_replace('/\s*kg$/i', '', $cleanedString);
                        $cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString)); //usuwa zbędne spacje
                        $cleanedString = preg_replace('/\([^)]*\)/', '', $cleanedString);
                        $cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString));
                        $cleanedString = ucfirst(strtolower($cleanedString));

                        //$cleanedString = str_replace(",",".",$cleanedString); //podmienia znaki
                        //$cleanedString = trim(preg_replace('/\s+/', ' ', $cleanedString)); //usuwa zbędne spacje
                        //$cleanedString = str_replace("SMAK TRADYCJI", "", $cleanedString); // usuwa tekst

                        //echo $cleanedString;

                        $name = $cleanedString;

                        $unit = "kg";
                        $amount = 1;
                        if (substr($row[3], -3) === "SZT") {
                            $unit = "szt";
                        }
        
                        $sup[$in]["supplier_products"]["id_supplier_category"] = $id_supplier_category; 
                        $sup[$in]["supplier_products"]["id_company"] = $comp_id;
                        $sup[$in]["supplier_products"]["full_name"] = $row[1]; 
                        $sup[$in]["supplier_products"]["producent"] = ""; 
                        $sup[$in]["supplier_products"]["producent_id"] = $row[0]; 
                        $sup[$in]["supplier_products"]["name"] = $name;
                        $sup[$in]["supplier_products"]["amount"] = $amount; 
                        $sup[$in]["supplier_products"]["unit"] = $unit; 
                        $sup[$in]["supplier_products"]["unit_order"] = $unit; 



                        $date = date("Y-m-d");
                        $vat = "";
                        $netto_price = "";
                        $brutto_price = "";
                        $vat = 5;
                        $netto_price = (float) $row[2];
                        $brutto_price = $netto_price + ($netto_price * (5 / 100));
                        
                        $sup[$in]["supplier_cost"]["id_supplier_products"] = $id_supplier_category;
                        $sup[$in]["supplier_cost"]["netto_price"] = $netto_price;
                        $sup[$in]["supplier_cost"]["netto_per_unit"] = 0;
                        $sup[$in]["supplier_cost"]["vat"] = $vat;
                        $sup[$in]["supplier_cost"]["brutto_price"] = $brutto_price;
                        
                        if($unit == "szt" || $unit == "brak") {
                            $sup[$in]["supplier_cost"]["netto_price_100g"] = 0;
                            $sup[$in]["supplier_cost"]["netto_price_1kg"] = 0;
                        } else {
                            if(isset($netto_price) && isset($amount)) {
                                if($amount == 0) {
                                    $price_per_gram = $netto_price / $amount;
                                    $price_for_100g = $price_per_gram * 100;
                                    $price_for_1000g = $price_per_gram * 1000;
                                } if($amount > 0 && $amount < 1) {
                                    $price_per_gram = $netto_price / $amount / 1000;
                                    $price_for_100g = $price_per_gram * 100;
                                    $price_for_1000g = $price_per_gram * 1000;
                                } else if ($amount >= 1) {
                                    $price_per_gram = (float) $netto_price / $amount / 1000;
                                    $price_for_100g = $price_per_gram * 100;
                                    $price_for_1000g = $price_per_gram * 1000;
                                    
                                } else {
                                    $price_for_100g = 0;
                                    $price_for_1000g = 0;
                                    
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
                        $sup[$sk]["supplier_products"]["id_supplier_category"] = $id_supplier_category;

                    }
                    $sup[$sk]["supplier_products"]["id_supplier_category"] = $id_supplier_category;


                    
                    
                    //TUTAJ WSTAWIAĆ CENY I PRODUKTY PRZY CZYM SPRAWDZAĆ JESZCZE CZY TAKI PRODUKT JEST

                    $to_ins = true;
                    $id_supplier_product = 0;
                    if(isset($data["supplier_prod"])){
                        foreach($data["supplier_prod"] as $sups) {
                            $tsname = $sups->full_name;
                            if($sup[$sk]["supplier_products"]["full_name"] == $tsname) {
                                $to_ins = false;
                                $id_supplier_product = $sups->id;
                                break;
                            }
                        }
                    }
                    if($to_ins) {
                        $supprod = new Supplierproducts();
                        $supprod->insert([
                            "id_supplier_category" => $sup[$sk]["supplier_products"]["id_supplier_category"], 
                            "id_company" => $comp_id,
                            "full_name" => $sup[$sk]["supplier_products"]["full_name"],
                            "producent" => "",
                            "producent_id" => "",
                            "name" => $sup[$sk]["supplier_products"]["name"],
                            "amount" => $sup[$sk]["supplier_products"]["amount"],
                            "unit" => $sup[$sk]["supplier_products"]["unit"],
                            "unit_order" => $sup[$sk]["supplier_products"]["unit_order"]
                        ]);
                        $id_supplier_product = $supprod->getLast();
                    }
                    $sup[$sk]["supplier_cost"]["id_supplier_products"] = $id_supplier_product;
                    
                    //TU CENA JEŚLI DZISIAJ NIE BYŁA TO DODAJEMY A JAK BYŁA TO AKTUALIZACJA
                    $supcost = new Suppliercost();
                    if(!isset($data["supplier_cost"][$id_supplier_product])) {
                        //dodajemy cene
                        $supcost->insert([
                            "id_supplier_products" => $sup[$sk]["supplier_cost"]["id_supplier_products"], 
                            "netto_price" => $sup[$sk]["supplier_cost"]["netto_price"],
                            "netto_per_unit" => $sup[$sk]["supplier_cost"]["netto_per_unit"],
                            "vat" => $sup[$sk]["supplier_cost"]["vat"],
                            "brutto_price" => $sup[$sk]["supplier_cost"]["brutto_price"],
                            "netto_price_100g" => $sup[$sk]["supplier_cost"]["netto_price_100g"],
                            "netto_price_1kg" => $sup[$sk]["supplier_cost"]["netto_price_1kg"],
                            "date" => $today
                        ]);
                    } else {
                        //aktualizujemy
                        $id_prod = $data["supplier_cost"][$id_supplier_product]->id;
                        $supcost->update($id_prod,[
                            "id_supplier_products" => $sup[$sk]["supplier_cost"]["id_supplier_products"], 
                            "netto_price" => $sup[$sk]["supplier_cost"]["netto_price"],
                            "netto_per_unit" => $sup[$sk]["supplier_cost"]["netto_per_unit"],
                            "vat" => $sup[$sk]["supplier_cost"]["vat"],
                            "brutto_price" => $sup[$sk]["supplier_cost"]["brutto_price"],
                            "netto_price_100g" => $sup[$sk]["supplier_cost"]["netto_price_100g"],
                            "netto_price_1kg" => $sup[$sk]["supplier_cost"]["netto_price_1kg"],
                            "date" => $today
                        ]);

                    }
                }
                show($sup);
                fclose($handle); // Zamknij plik
            } else {
                die("Nie udało się otworzyć pliku $plikCSV!");
            }
        }
        show($sup);





























        // Wyświetl dane w formacie tablicy (przydatne do debugowania)
        echo "<pre>";
        //print_r($data);
        //print_r($sup);
        echo "</pre>";

        die;

        $this->view('supplier', $data);
    }

}
