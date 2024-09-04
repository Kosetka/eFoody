<?php

/**
 * Products class
 */
class Products
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $products = new ProductsModel;
        $data["products"] = $products->getAll("products");
        $alergen = new Alergen();
        foreach($alergen->getAlergens() as $ale) {
            $data["alergens"][$ale->id] = $ale;
        }
        $alergens = new Productalergens();
        foreach($alergens->getGrouped() as $ale) {
            $data["prod_alergens"][$ale->p_id] = $ale;
        }
        $this->view('products', $data);
    }
    public function fullproducts()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $products = new ProductsModel;
        $data["products"] = $products->getAllFullProducts("products");
        $alergen = new Alergen();
        foreach($alergen->getAlergens() as $ale) {
            $data["alergens"][$ale->id] = $ale;
        }
        $alergens = new Productalergens();
        foreach($alergens->getGrouped() as $ale) {
            $data["prod_alergens"][$ale->p_id] = $ale;
        }
        $this->view('products', $data);
    }
    public function subproducts()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $products = new ProductsModel;
        $data["products"] = $products->getAllSubProducts("products");
        $alergen = new Alergen();
        foreach($alergen->getAlergens() as $ale) {
            $data["alergens"][$ale->id] = $ale;
        }
        $p_alergens = new Productalergens();
        foreach($p_alergens->getGrouped() as $ale) {
            $data["prod_alergens"][$ale->p_id] = $ale;
        }
        $this->view('products', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $products = new ProductsModel;
        $temp = $products->getAll("products");
        foreach ($temp as $key => $value) {
            $data["products"][$value->id] = $value;
        }

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $data["target_sku"] = $URL[2];
            $data["target_type"] = substr($URL[2],0,1);
        }
        $alergen = new Alergen();
        foreach($alergen->getAlergens() as $ale) {
            $data["alergens"][$ale->id] = $ale;
        }
        

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $target_dir = IMG_ROOT_UPLOAD;
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $file_name = "";
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (!empty($_FILES["fileToUpload"]["name"])) {
                $file_name = basename($_FILES["fileToUpload"]["name"]);
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $data['errors'] = "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $data['errors'] = "File is not an image.";
                    $uploadOk = 0;
                }
                if (file_exists($target_file)) {
                    $data['errors'] = "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $data['errors'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                ) {
                    $data['errors'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $data['errors'] = "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $data['errors'] = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                        $_POST["p_photo"] = $file_name;
                    } else {
                        $data['errors'] = "Sorry, there was an error uploading your file.";
                    }
                }
            }

            $product = new ProductsModel;
            if ($product->validate($_POST)) {
                if(!isset($_POST["kcal"])) {
                    $_POST["kcal"] = 0;
                }
                if(isset($_POST["vege"])) {
                    $_POST["vege"] = TRUE;
                } else {
                    $_POST["vege"] = FALSE;
                }
                if(!isset($_POST["friendly_name"]) && $_POST["friendly_name"] == "") {
                    $_POST["friendly_name"] = NULL;
                    //unset($_POST["friendly_name"]);
                }
                $product->insert($_POST);
                $data['success'] = "Produkt/SKU został pomyślnie dodany";
                //redirect('signup');
                $id_product = $product->getLast();

                $p_alergens = new Productalergens;
                if(isset($_POST["alergens"])) {
                    foreach($_POST["alergens"] as $key => $value) {
                        $p_alergens->insert(["p_id" => $id_product, "a_id" => $key]);
                    }
                }
            }

            // tu ogarnąć alergeny

            $data['errors'] = $product->errors;
        }
        $this->view('products.new', $data);
    }
    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        if (!empty($_GET)) {
            /*$product = new ProductsModel;
            $temp_product = $product->getAll("products");
            foreach ($temp_product as $t => $v) {
                $data["product"][$v->id] = $v;
            }*/
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_product = $URL[2];
            $product = new ProductsModel;
            $data["product"] = $product->first(["id" => $id_product]);
            $alergens = new Alergen;
            $data["alergens"] = $alergens->getAlergens();
            $p_alergens = new Productalergens;
            $data["p_alergen"] = $p_alergens->getByProduct($id_product);

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $target_dir = IMG_ROOT_UPLOAD;
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $file_name = "";
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (!empty($_FILES["fileToUpload"]["name"])) {
                    $file_name = basename($_FILES["fileToUpload"]["name"]);
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        $data['errors'] = "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        $data['errors'] = "File is not an image.";
                        $uploadOk = 0;
                    }
                    if (file_exists($target_file)) {
                        $data['errors'] = "Sorry, file already exists.";
                        $uploadOk = 0;
                    }

                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
                        $data['errors'] = "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if (
                        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    ) {
                        $data['errors'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $data['errors'] = "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            $data['errors'] = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                            $_POST["p_photo"] = $file_name;
                        } else {
                            $data['errors'] = "Sorry, there was an error uploading your file.";
                        }
                    }
                }

                //show($_POST);die;
                if($_POST["kcal"] == "") {
                    $_POST["kcal"] = NULL;
                }
                if(isset($_POST["vege"])) {
                    $_POST["vege"] = TRUE;
                } else {
                    $_POST["vege"] = FALSE;
                }
                if(!isset($_POST["friendly_name"]) && $_POST["friendly_name"] == "") {
                    $_POST["friendly_name"] = NULL;
                    //unset($_POST["friendly_name"]);
                }
                $product->update($id_product, $_POST);
                
                $p_alergens->delete($id_product,"p_id");
                if(isset($_POST["alergens"])) {
                    foreach($_POST["alergens"] as $key => $value) {
                        $p_alergens->insert(["p_id" => $id_product, "a_id" => $key]);
                    }
                }

                $data['success'] = "Edycja produktu/SKU pomyślna";
                $product = new ProductsModel;
                $data["product"] = $product->first(["id" => $id_product]);
                $alergens = new Alergen;
                $data["alergens"] = $alergens->getAlergens();
                $p_alergens = new Productalergens;
                $data["p_alergen"] = $p_alergens->getByProduct($id_product);

                $data['errors'] = $product->errors;

            }
        }

        $this->view('products.edit', $data);
    }
}
