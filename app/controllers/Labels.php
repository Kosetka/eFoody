<?php

/**
 * GetCargo class
 */
class Labels
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $target_dir = IMG_LABELS_UPLOAD;
            $uploadOk = 1;
            $allowed_file_types = ['lbx'];
            $max_file_size = 500000; // Maksymalny rozmiar pliku w bajtach (500 KB)
            $data['errors'] = [];

            foreach ($_FILES["fileToUpload"]["name"] as $key => $name) {
                $target_file = $target_dir . basename($name);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $file_name = basename($name);
                $file_tmp_name = $_FILES["fileToUpload"]["tmp_name"][$key];
                $file_size = $_FILES["fileToUpload"]["size"][$key];
                $uploadOk = 1;

                if (!empty($name)) {
                    // Check file size
                    if ($file_size > $max_file_size) {
                        $data['errors'][] = "Sorry, your file $file_name is too large.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if (!in_array($imageFileType, $allowed_file_types)) {
                        $data['errors'][] = "Sorry, only LBX files are allowed for file $file_name.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $data['errors'][] = "Sorry, your file $file_name was not uploaded.";
                    } else {
                        if (move_uploaded_file($file_tmp_name, $target_file)) {
                            $data['success'][] = "Plik " . htmlspecialchars($file_name) . " został pomyślnie przesłany.";
                            $_POST["p_photo"][] = $file_name;
                        } else {
                            $data['errors'][] = "Sorry, there was an error uploading your file $file_name.";
                        }
                    }
                }
            }
        }



        $this->view('labels', $data);
    }

    public function add()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["recipeEdit"])) {
                $_POST["u_id"] = $_SESSION["USER"]->id;
                $recipes = new RecipesModel();
                $recipes->insert($_POST);
            }
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["sub_products"][$product->id] = (object) $product;
        }
        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }
        $this->view('recipes.new', $data);

    }

    public function generate()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $data["alergens"] = "";

        $tomorrow = date("d.m.Y", strtotime("+1 day"));
        $today = date("N");
        if ($today >= 5) {
            $nextMonday = date("d.m.Y", strtotime("next Monday"));
            $date = $nextMonday;
        } else {
            $date = $tomorrow;
        }

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $id = $URL[2];
            if (isset($URL[3])) {
                $date = $URL[3];
            }
            if (isset($_GET["date"])) {
                $date = $_GET["date"];
            }
        } else {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                if (isset($_GET["date"])) {
                    $date = $_GET["date"];
                }
            } else {
                $id = NULL;
                $date = NULL;
                redirect('home');
            }
        }
        $data["aa"] = "";
        if ($id != NULL) {
            $products = new ProductsModel();
            foreach ($products->getAllById($id) as $product) {
                $temp["product"] = (object) $product;
            }
            $data["prod_name"] = $temp["product"]->p_name;
            $data["kcal"] = $temp["product"]->kcal;
            $data["sku"] = $temp["product"]->sku;
            $data["id"] = $temp["product"]->id;
            $data["show_prod_date"] = $temp["product"]->show_prod_date;
            $pid = $temp["product"]->id;
            $alergens = new Productalergens();
            if (!empty($alergens->getByProduct($pid))) {
                foreach ($alergens->getByProduct($pid) as $ale) {
                    $data["alergens"] = $data["alergens"] . $ale->a_id . ', ';
                }
            }
            $data["alergens"] = substr($data["alergens"], 0, -2);
            $data["date"] = $date;

            $alergens = new Productalergens();
            if (!empty($alergens->getByProduct($pid))) {
                foreach ($alergens->getByProduct($pid) as $ale) {
                    $data["aa"] = $data["aa"] . $ale->a_id . ', ';
                }
            }
            $data["aa"] = substr($data["aa"], 0, -2);
            $aler = new Alergen();
            foreach ($aler->getAlergens() as $al) {
                $temp["aler"][$al->id] = $al;
            }
            if (!empty($alergens->getByProduct($pid))) {
                $data["alergen"] = "";
                foreach ($alergens->getByProduct($pid) as $ale) {
                    $data["alergen"] .= $temp["aler"][$ale->a_id]->a_name . ", ";
                }
                if ($data["alergen"] <> "") {
                    $data["alergen"] = substr($data["alergen"], 0, -2);
                }
            }

        }
        $this->view('labels.generate', $data);
    }

    public function generatebig()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $data["alergens"] = "";

        $tomorrow = date("d.m.Y", strtotime("+1 day"));
        $today = date("N");
        if ($today >= 5) {
            $nextMonday = date("d.m.Y", strtotime("next Monday"));
            $date = $nextMonday;
        } else {
            $date = $tomorrow;
        }

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $id = $URL[2];
            if (isset($URL[3])) {
                $date = $URL[3];
            }
            if (isset($_GET["date"])) {
                $date = $_GET["date"];
            }
        } else {
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                if (isset($_GET["date"])) {
                    $date = $_GET["date"];
                }
            } else {
                $id = NULL;
                $date = NULL;
                redirect('home');
            }
        }
        if ($id != NULL) {
            $products = new ProductsModel();
            foreach ($products->getAllById($id) as $product) {
                $temp["product"] = (object) $product;
            }
            foreach ($products->getAllSubProducts() as $product) {
                $temp["subprod"][$product->id] = $product;
            }
            $aler = new Alergen();
            foreach ($aler->getAlergens() as $al) {
                $temp["aler"][$al->id] = $al;
            }
            $data["prod_name"] = $temp["product"]->p_name;
            $data["kcal"] = $temp["product"]->kcal;
            $data["sku"] = $temp["product"]->sku;
            $data["id"] = $temp["product"]->id;
            $data["show_prod_date"] = $temp["product"]->show_prod_date;
            $pid = $temp["product"]->id;
            $alergens = new Productalergens();
            if (!empty($alergens->getByProduct($pid))) {
                foreach ($alergens->getByProduct($pid) as $ale) {
                    $data["alergens"] = $data["alergens"] . $ale->a_id . ', ';
                }
            }
            $data["alergens"] = substr($data["alergens"], 0, -2);
            $data["date"] = $date;
        }


        /*
            minimalna wielkość czcionki na etykiecie to 1,2 mm, a na bardzo małych opakowaniach – 0,9 mm

            obowiązkowe jest umieszczenie na etykiecie informacji, takich jak: nazwa (nie nadana przez przedsiębiorcę, tylko wskazująca na rodzaj produktu), 
            wykaz wszystkich składników (wraz z alergenami i dodatkami do żywności), zawartość netto, data minimalnej trwałości (albo termin przydatności do spożycia), 
            warunki przechowywania lub przygotowania, dane producenta
            
            etykiety muszą informować o rodzaju składnika powodującego alergię, który musi być wyróżniony, na przykład napisany inną czcionką, kolorem, na innym tle. 

            na pierwszym miejscu na etykiecie musi znajdować się składnik, którego w produkcie jest najwięcej.
        */


        $x = $temp["product"]->show_prod_date;
        $datetime = DateTime::createFromFormat('d.m.Y', $date);
        $datetime->modify("+$x days");
        $datetime = $datetime->format('d.m.Y');

        $data["prod"]["name"] = $temp["product"]->p_name;
        $data["prod"]["kcal"] = $temp["product"]->kcal;
        $data["prod"]["sku"] = $temp["product"]->sku;
        $data["prod"]["id"] = $temp["product"]->id;
        //show($alergens->getByProduct(id: $pid));die;
        if (!empty($alergens->getByProduct($pid))) {
            $data["prod"]["alergen"] = "";
            foreach ($alergens->getByProduct($pid) as $ale) {
                $data["prod"]["alergens"][$ale->a_id]["name"] = $temp["aler"][$ale->a_id]->a_name;
                $data["prod"]["alergens"][$ale->a_id]["id"] = $ale->a_id;
                $data["prod"]["alergen"] .= $temp["aler"][$ale->a_id]->a_name . ", ";
            }
            if ($data["prod"]["alergen"] <> "") {
                $data["prod"]["alergen"] = substr($data["prod"]["alergen"], 0, -2);
            }
        }
        $ids = [];
        $recipes = new RecipesModel();

        if (!empty($recipes->getFullRecipe($pid))) {
            $rec = $recipes->getFullRecipe($pid);
            foreach ($rec as $key => $value) {
                if (!isset($ids[$value->sub_prod])) {
                    $ids[$value->sub_prod] = 0;
                }
                $ids[$value->sub_prod] += $value->amount;
            }
            $sauce = new Sauce();
            if (!empty($sauce->getSauce($pid))) {
                $rec = $recipes->getFullRecipe($sauce->getSauce($pid)[0]->r_id);
                foreach ($rec as $key => $value) {
                    if (!isset($ids[$value->sub_prod])) {
                        $ids[$value->sub_prod] = 0;
                    }
                    $ids[$value->sub_prod] += $value->amount;
                }
            }
        }

        $data["prod"]["netto"] = 0;
        $data["prod"]["full_products"] = "";
        $data["prod"]["full_products_big"] = "";
        arsort($ids);
        foreach ($ids as $idd => $idv) {
            $data["prod"]["ing"][$idd]["name"] = $temp["subprod"][$idd]->p_name;
            $data["prod"]["ing"][$idd]["ratio"] = $temp["subprod"][$idd]->ratio;
            $data["prod"]["ing"][$idd]["wage"] = $idv;
            $data["prod"]["ing"][$idd]["unit"] = $temp["subprod"][$idd]->p_unit;
            $data["prod"]["ing"][$idd]["alergen"] = "false";
            if (!empty($alergens->getByProduct($temp["subprod"][$idd]->id))) {
                $data["prod"]["ing"][$idd]["alergen"] = "true";
            }

            if ($temp["subprod"][$idd]->p_unit == "kg" || $temp["subprod"][$idd]->p_unit == "l") {
                $pu = "";
                if ($temp["subprod"][$idd]->p_unit == "kg") {
                    $pu = "g";
                }
                if ($temp["subprod"][$idd]->p_unit == "l") {
                    $pu = "ml";
                }
                $num = $idv * 1000;
                if ($num < 1) {
                    $num = 1;
                }
                $data["prod"]["ing"][$idd]["show"] = $num . $pu;
                $data["prod"]["ing"][$idd]["show_only"] = $num;
            } else {
                $num = ($data["prod"]["ing"][$idd]["wage"] * $data["prod"]["ing"][$idd]["ratio"]) * 1000;
                if ($num < 1) {
                    $num = 1;
                }
                $data["prod"]["ing"][$idd]["show"] = $num . "g";
                $data["prod"]["ing"][$idd]["show_only"] = $num;
            }
            $data["prod"]["netto"] += $num;
        }
        if (isset($data["prod"]["ing"])) {
            usort($data["prod"]["ing"], function ($a, $b) {
                return $b['show_only'] <=> $a['show_only'];
            });
            foreach ($data["prod"]["ing"] as $prod) {
                if ($prod["alergen"] == "true") {
                    $data["prod"]["full_products"] .= $prod["name"] . "*, ";
                } else {
                    $data["prod"]["full_products"] .= $prod["name"] . ", ";
                }
            }
        }
        $data["prod"]["full_products"] = substr($data["prod"]["full_products"], 0, -2);
        $data["prod"]["full_products_big"] = substr($data["prod"]["full_products_big"], 0, -2);
        //show($ids);
        //die;

        $data["prod"]["date_prod"] = $date;
        $data["prod"]["date_term"] = $datetime;
        $data["prod"]["store"] = "Przechowywać w ...";
        $data["comp"]["name"] = "Radluks Sp. z o.o.";
        $data["comp"]["nip"] = "7963011952";
        $data["comp"]["address"] = "ul. Kozienicka 211F";
        $data["comp"]["address2"] = "26-610 Radom";

        //show($data);
        //die;

        $this->view('labels.generatebig', $data);
    }

    public function shopswz()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $sku_list = [
            "1-01" => "Sałatki",
            "1-02" => "Kanapki",
            "1-03" => "Zupy",
            "1-04" => "Dania główne",
            "1-05" => "Desery",
            "1-06" => "Dodatki",
            "1-07" => "Napoje",
            "1-08" => "Burgery",
            "1-09" => "Granole",
            "1-10" => "Smoothie",
            "1-11" => "Grzanki",
            "1-12" => "Bajgle",
            "1-13" => "Wrapy",
            "1-14" => "Racuchy",
            "1-15" => "Owsianki",
            "1-16" => "Naleśniki"
        ];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $date = $URL[2];
            if (isset($_GET["date"])) {
                $date = $_GET["date"];
            }
        } else {
            $date = date("Y-m-d");
        }

        $date_from = $date . " 00:00:00";
        $date_to = $date . " 23:59:59";



        $sku = new Skumodel();
        foreach ($sku->getSku() as $sk) {
            $s = $sk->parent . "-" . $sk->type;
            if ($sk->priceshops <> "") {
                $data["sku"][$s] = $sk->priceshops . " zł";
                $data["sku_price"][$s] = $sk->priceshops;
            } else {
                $data["sku"][$s] = "";
                $data["sku_price"][$s] = "";
            }
        }

        $cargo = new Cargo();

        if (!empty($cargo->getLatestTwoRecordsPerPair())) {
            foreach ($cargo->getLatestTwoRecordsPerPair() as $cg) {
                $date_here = substr($cg->date, 0, 10);
                //show($cg);
                if ($date == $date_here) {
                    $data["cargo_before"][$cg->c_id]["date"] = $date;
                    $data["cargo_before"][$cg->c_id]["set"] = "0";
                    $data["cargo_before"][$cg->c_id]["get"]["products"][$cg->p_id] = $cg->amount;
                    $sku = substr($cg->sku, 0, 4);
                    $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["name"] = $sku_list[$sku];
                    $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["cost"] = $data["sku"][$sku];
                    $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["empty"] = "";
                    if (!isset($data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["amount"])) {
                        $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["amount"] = 0;
                    }
                    $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["amount"] += $cg->amount;
                    $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["value"] = $data["cargo_before"][$cg->c_id]["get"]["sku"][$sku]["amount"] * (float) $data["sku_price"][$sku];

                } else {
                    if (isset($data["cargo_before"][$cg->c_id]["set"])) {
                        if ($data["cargo_before"][$cg->c_id]["set"] == 0) {
                            $data["cargo_before"][$cg->c_id]["set"] = 1;
                            $data["cargo_before"][$cg->c_id]["return"]["date"] = $date_here;
                        }
                        if ($data["cargo_before"][$cg->c_id]["return"]["date"] == $date_here) {
                            $data["cargo_before"][$cg->c_id]["return"]["products"][$cg->p_id] = $cg->amount;
                            $sku = substr($cg->sku, 0, 4);
                            $data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["name"] = $sku_list[$sku];
                            $data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["cost"] = $data["sku"][$sku];
                            $data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["empty"] = "";

                            if (!isset($data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["names"]["name"])) {
                                $data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["names"]["name"] = "";
                            }
                            $data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["names"][$cg->p_id] = $cg->first_letter;
                            if ($cg->first_letter <> "") {
                                $data["cargo_before"][$cg->c_id]["return"]["sku"][$sku]["names"]["name"] .= $cg->first_letter . " | ";
                            }
                        }
                    }

                }
            }
        }
        //show($sku_list);
        //show($data["cargo_before"][$cg->c_id]["return"]);
        //show($data["sku"]);die;



        $company = new Companies();
        if (!empty($company->getAllShopsActive())) {
            foreach ($company->getAllShopsActive() as $cg) {

                if (isset($data["cargo"][$cg->id])) {
                    $data["cargo"][$cg->id]["full_name"] = $cg->full_name;
                    $data["cargo"][$cg->id]["street"] = $cg->street;
                    $data["cargo"][$cg->id]["street_number"] = $cg->street_number;
                }
                if (isset($data["cargo_before"][$cg->id])) {
                    $data["cargo_before"][$cg->id]["full_name"] = $cg->full_name;
                    $data["cargo_before"][$cg->id]["street"] = $cg->street;
                    $data["cargo_before"][$cg->id]["street_number"] = $cg->street_number;
                }

            }
        }

        if (!isset($data["cargo_before"])) {
            redirect('labels/shops');
            //redirect('labels.shops');
        }
        $data["date"] = $date;

        $this->view('labels.shopswz', $data);
    }
    public function shops()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $date = date("Y-m-d");
        $data["date"] = $date;

        $this->view('labels.shops', $data);
    }
}
