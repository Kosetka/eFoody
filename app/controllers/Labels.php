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
}
