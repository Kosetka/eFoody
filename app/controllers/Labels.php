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
        }
        $this->view('labels.generate', $data);
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
                        }
                    }

                }
            }
        }




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
