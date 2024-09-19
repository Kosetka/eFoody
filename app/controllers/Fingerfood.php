<?php

/**
 * GetCargo class
 */
class Fingerfood
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $f = new Fingerfoods();
        $data["fingerfoods"]= $f->getAll();

        $fc = new Fingerfoodscategory();
        $data["fingerfoodscategory"]= $fc->getAll();

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $this->view('fingerfood', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $target_dir = IMG_ROOT_UPLOAD;
            $uploadOk = 1;
            $file_name = "";
            
            $timestamp = date("Ymd_His");
        
            // Pobierz rozszerzenie pliku
            $imageFileType = strtolower(pathinfo($_FILES["fileInput"]["name"], PATHINFO_EXTENSION));

            if (!empty($_FILES["fileInput"]["name"])) {
                // Nowa nazwa pliku w formacie data_menu.xxx
                $file_name = $timestamp . "_fingerfood." . $imageFileType;
                $target_file = $target_dir . $file_name;
                
                // Sprawdzenie, czy plik jest rzeczywiście obrazem
                $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
                if ($check !== false) {
                    $data['errors'] = "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $data['errors'] = "File is not an image.";
                    $uploadOk = 0;
                }
        
                // Check file size
                if ($_FILES["fileInput"]["size"] > 5000000) {
                    $data['errors'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
        
                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
                    $data['errors'] = "Sorry, only JPG, JPEG, PNG, WebP files are allowed.";
                    $uploadOk = 0;
                }
        
                // Sprawdzenie, czy wszystko jest OK
                if ($uploadOk == 0) {
                    $data['errors'] = "Sorry, your file was not uploaded.";
                } else {
                    // Próba przesłania pliku
                    if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
                        $data['errors'] = "The file " . htmlspecialchars($file_name) . " has been uploaded.";
                        $_POST["p_photo"] = $file_name;
                    } else {
                        $data['errors'] = "Sorry, there was an error uploading your file.";
                    }
                }
            }
            if ($uploadOk == 1) {
                if(!isset($_POST["f_active"])) {
                    $_POST["f_active"] = 0;
                }
                if($file_name != "") {
                    $_POST["f_photo"] = $file_name;
                }
                $f = new Fingerfoods;
                $f->insert($_POST);
            }



            redirect('fingerfood');
        }
        $data["edit"] = False;

        $fc = new Fingerfoodscategory();
        foreach($fc->getAll() as $ffc) {
            $data["fingerfoodscategory"][$ffc->id] = $ffc;
        }
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $id = $URL[2];
            $data["id"] = $id;
        }

        $this->view('fingerfood.new', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $id = $URL[2];
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if(isset($_POST["newadd"])) {

                $target_dir = IMG_ROOT_UPLOAD;
                $uploadOk = 1;
                $file_name = "";
                
                $timestamp = date("Ymd_His");
            
                // Pobierz rozszerzenie pliku
                $imageFileType = strtolower(pathinfo($_FILES["fileInput"]["name"], PATHINFO_EXTENSION));
    
                if (!empty($_FILES["fileInput"]["name"])) {
                    // Nowa nazwa pliku w formacie data_menu.xxx
                    $file_name = $timestamp . "_fingerfood." . $imageFileType;
                    $target_file = $target_dir . $file_name;
                    
                    // Sprawdzenie, czy plik jest rzeczywiście obrazem
                    $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
                    if ($check !== false) {
                        $data['errors'] = "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        $data['errors'] = "File is not an image.";
                        $uploadOk = 0;
                    }
            
                    // Check file size
                    if ($_FILES["fileInput"]["size"] > 5000000) {
                        $data['errors'] = "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
            
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp") {
                        $data['errors'] = "Sorry, only JPG, JPEG, PNG, WebP files are allowed.";
                        $uploadOk = 0;
                    }
            
                    // Sprawdzenie, czy wszystko jest OK
                    if ($uploadOk == 0) {
                        $data['errors'] = "Sorry, your file was not uploaded.";
                    } else {
                        // Próba przesłania pliku
                        if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
                            $data['errors'] = "The file " . htmlspecialchars($file_name) . " has been uploaded.";
                            $_POST["p_photo"] = $file_name;
                        } else {
                            $data['errors'] = "Sorry, there was an error uploading your file.";
                        }
                    }
                }
                if ($uploadOk == 1) {
                    if($file_name != "") {
                        $_POST["f_photo"] = $file_name;
                    }
                    if(!isset($_POST["f_active"])) {
                        $_POST["f_active"] = 0;
                    }
                    $f = new Fingerfoods;
                    $f->update($id, $_POST);
                    $data['success'] = "Edycja fingerfood pomyślna";
                }


                redirect('fingerfood');
            }
        }
        $data["edit"] = True;

        $f = new Fingerfoods;
        $data["fingerfoods"] = $f->getFingerfood($id)[0];

        $fc = new Fingerfoodscategory();
        foreach($fc->getAll() as $ffc) {
            $data["fingerfoodscategory"][$ffc->id] = $ffc;
        }

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }
        

        $this->view('fingerfood.new', $data);
    }

}
