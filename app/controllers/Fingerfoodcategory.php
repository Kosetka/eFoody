<?php

/**
 * GetCargo class
 */
class Fingerfoodcategory
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $fc = new Fingerfoodscategory();
        $data["fingerfoodscategory"]= $fc->getAll();

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $this->view('fingerfoodcategory', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $target_dir = IMG_ROOT_UPLOAD;
            $uploadOk = 1;
            $file_name[1] = "";
            $file_name[2] = "";
            $file_name[3] = "";

            
            $timestamp = date("Ymd_His");
        
            // Pobierz rozszerzenie pliku
            $i = 0;
            foreach($_FILES as $file) {
                $i++;
                $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    
                if (!empty($file["name"])) {
                    // Nowa nazwa pliku w formacie data_menu.xxx
                    $file_name[$i] = $timestamp . "_" . $i . "_ffc_." . $imageFileType;
                    $target_file = $target_dir . $file_name[$i];
                    
                    // Sprawdzenie, czy plik jest rzeczywiście obrazem
                    $check = getimagesize($file["tmp_name"]);
                    if ($check !== false) {
                        $data['errors'] = "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        $data['errors'] = "File is not an image.";
                        $uploadOk = 0;
                    }
            
                    // Check file size
                    if ($file["size"] > 5000000) {
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
                        if (move_uploaded_file($file["tmp_name"], $target_file)) {
                            $data['errors'] = "The file " . htmlspecialchars($file_name[$i]) . " has been uploaded.";
                        } else {
                            $data['errors'] = "Sorry, there was an error uploading your file.";
                        }
                    }
                }
            }
            if ($uploadOk == 1) {
                if($file_name[1] != "") {
                    $_POST["fc_photo_1"] = $file_name[1];
                }
                if($file_name[2] != "") {
                    $_POST["fc_photo_2"] = $file_name[2];
                }
                if($file_name[3] != "") {
                    $_POST["fc_photo_3"] = $file_name[3];
                }
                $u_id = $_SESSION["USER"]->id;

                if(!isset($_POST["f_active"])) {
                    $_POST["f_active"] = 0;
                }
                if(!isset($_POST["fc_photo_1"])) {
                    $_POST["fc_photo_1"] = NULL;
                }
                if(!isset($_POST["fc_photo_2"])) {
                    $_POST["fc_photo_2"] = NULL;
                }
                if(!isset($_POST["fc_photo_3"])) {
                    $_POST["fc_photo_3"] = NULL;
                }
                $fc = new Fingerfoodscategory;

                $fc->insert([
                    "fc_name" => $_POST["fc_name"],
                    "fc_description" => $_POST["fc_description"],
                    "f_active" => $_POST["f_active"],
                    "fc_photo_1" => $_POST["fc_photo_1"],
                    "fc_photo_2" => $_POST["fc_photo_2"],
                    "fc_photo_3" => $_POST["fc_photo_3"],
                    "u_id" => $u_id,
                    "f_order" => NULL,
                ]);
            }




            

            redirect('fingerfoodcategory');
        }
        $data["edit"] = False;

        $this->view('fingerfoodcategory.new', $data);
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
                $file_name[1] = "";
                $file_name[2] = "";
                $file_name[3] = "";
    
                
                $timestamp = date("Ymd_His");
            
                // Pobierz rozszerzenie pliku
                $i = 0;
                foreach($_FILES as $file) {
                    $i++;
                    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
                    if (!empty($file["name"]) && $file["name"] != "") {
                        // Nowa nazwa pliku w formacie data_menu.xxx
                        $file_name[$i] = $timestamp . "_" . $i . "_ffc_." . $imageFileType;
                        $target_file = $target_dir . $file_name[$i];
                        
                        // Sprawdzenie, czy plik jest rzeczywiście obrazem
                        $check = getimagesize($file["tmp_name"]);
                        if ($check !== false) {
                            $data['errors'] = "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            $data['errors'] = "File is not an image.";
                            $uploadOk = 0;
                        }
                
                        // Check file size
                        if ($file["size"] > 5000000) {
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
                            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                                $data['errors'] = "The file " . htmlspecialchars($file_name[$i]) . " has been uploaded.";
                            } else {
                                $data['errors'] = "Sorry, there was an error uploading your file.";
                            }
                        }
                    }
                }
                if ($uploadOk == 1) {
                    
                    if($file_name[1] != "") {
                        $_POST["fc_photo_1"] = $file_name[1];
                    }
                    if($file_name[2] != "") {
                        $_POST["fc_photo_2"] = $file_name[2];
                    }
                    if($file_name[3] != "") {
                        $_POST["fc_photo_3"] = $file_name[3];
                    }
                    $u_id = $_SESSION["USER"]->id;
                    $_POST["u_id"] = $u_id;
    
                    if(!isset($_POST["f_active"])) {
                        $_POST["f_active"] = 0;
                    }


                    $fc = new Fingerfoodscategory;
                    $fc->update($id, $_POST);
                    $data['success'] = "Edycja kategorii pomyślna";
                }



                
                redirect('fingerfoodcategory');
            } 
        }
        $data["edit"] = True;

        $fc = new Fingerfoodscategory;
        $data["fingerfoodcategory"] = $fc->getCategory($id)[0];

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }
        

        $this->view('fingerfoodcategory.new', $data);
    }

}
