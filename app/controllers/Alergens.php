<?php

/**
 * GetCargo class
 */
class Alergens
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $alergens = new Alergen();
        foreach ($alergens->getAlergens() as $alergen) {
            $data["alergens"][$alergen->id] = (object) $alergen;
        }

        $this->view('alergens', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $p_id = $URL[2];

            $alergen = new Alergen;
            //$toUpdate = ["a_name" => $u_id, "a_photo" => $p_id, "a_description" => "$date_from"];
            
            $target_dir = IMG_ALERGENS_ROOT_UPLOAD;
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
                    //$data['errors'] = "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $data['errors'] = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                        $_POST["a_photo"] = $file_name;
                    } else {
                        $data['errors'] = "Sorry, there was an error uploading your file.";
                    }
                }
            }

            $alergen->update($p_id, $_POST);
            $data["success"] = "Aktualizacja danych pomyślna";
            
        }

        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $p_id = $URL[2];
            $alergen = new Alergen();
            $data["alergen"] = $alergen->first(["id" => $p_id]);
        }

        $this->view('alergens.edit', $data);
    }

    public function show() {
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $p_id = $URL[2];
            $alergen = new Alergen();
            $data["alergen"] = $alergen->first(["id" => $p_id]);
            foreach($alergen->getAlergens() as $ale) {
                $data["alergens"][$ale->id] = $ale;
            }


            $alergens = new Productalergens();
            foreach($alergens->getGrouped() as $ale) {
                $data["prod_alergens"][$ale->p_id] = $ale;
            }
            //$data["prod_alergens"] = $alergens->getAll();
            if(!empty($alergens->getByAlergen($p_id))) {
                foreach($alergens->getByAlergen($p_id) as $ale) {
                    $data["p_alergen"][$ale->p_id] = $ale;
                }
            }
            $product = new ProductsModel;
            foreach($product->getAllFullProducts() as $prod) {
                $data["product"][$prod->id] = $prod;
                
            }
        }

        $this->view('alergens.show', $data);
    }
}
