<?php

/**
 * Company class
 */
class Leaflet
{
    use Controller;

    public function day()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $date = $URL[2];
        } else {
            if(isset($_GET["date"])) {
                $date = $_GET["date"];
            } else {
                $date = date('Y-m-d');
            }
        }
        $w_id = 1;
        $data["list"]["1-03"] = [];
        $data["list"]["1-04"] = [];
        $data["list"]["1-01"] = [];
        $data["list"]["1-02"] = [];
        $data["list"]["1"] = [];
        $data["list"]["2"] = [];
        $data["list"]["3"] = [];
        $data["list"]["4"] = [];
        $data["list"]["5"] = [];
        $data["list"]["6"] = [];
        $data["list"]["1-05"] = [];

        $skus = new Skumodel();
        foreach($skus->getByParent(1) as $sku) {
            $data["sku"][$sku->full_type] = $sku;
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }
        $planned = new Plannerproduction();
        $int = 1;
        $gr = 0;
        if(!empty($planned->getPlanned($date, $w_id))) {
            foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                $data["planned"][$value->p_id] = $value;
                if (substr($data["fullproducts"][$value->p_id]->p_name,0,6) == "Grzank") { //grzanka łososiowa |\ grzanka z serem ziołowym
                    $data["list"][1][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if ($value->p_id == 14) { //Naleśniki
                    $data["list"][2][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if ($value->p_id == 40 || $value->p_id == 41) { //Granola mus owocowy || Granola Toffi
                    $data["list"][3][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if ($value->p_id == 199 || $value->p_id == 200) { //Wrap kurczak || Wrap wołowina
                    $data["list"][6][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if (substr($data["fullproducts"][$value->p_id]->p_name, 0, 5) == "Deser") {
                    $data["list"][4][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if (substr($data["fullproducts"][$value->p_id]->p_name, 0, 8) == "Smoothie") {
                    $data["list"][5][] = $data["fullproducts"][$value->p_id];
                    $int++;
                }  else {
                    $data["list"][substr($data["fullproducts"][$value->p_id]->sku,0,4)][] = $data["fullproducts"][$value->p_id];
                    //show($value);
                }

                //$data["list"]
            }
        }
        
        $prices = new PriceModel();
        foreach($prices->getCurrentPrice() as $price) {
            $data["prices"][$price->p_id] = $price;
        }

        
        $data["day_num"] = date('N', strtotime($date));

        //show($data);
        //die;
        $this->view('leaflet', $data);
    }

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $show = false;
        if(isset($URL[2])) {
            $date = $URL[2];
            $show = true;
        } else {
            if(isset($_GET["date"])) {
                $date = $_GET["date"];
                $show = true;
            } else {
                $date = date('Y-m-d');
            }
        }
        if($show) {
            redirect('leaflet/day/'.$date);
        }

        $data["date"] = date("Y-m-d");
        $this->view('leaflet.index', $data);
    }
    public function add()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $target_dir = IMG_ROOT_UPLOAD;
            $uploadOk = 1;
            $file_name = "";
            
            $date = $_POST["selectedDate"];
        
            // Pobierz rozszerzenie pliku
            $imageFileType = strtolower(pathinfo($_FILES["fileInput"]["name"], PATHINFO_EXTENSION));
            
            if (!empty($_FILES["fileInput"]["name"])) {
                // Nowa nazwa pliku w formacie data_menu.xxx
                $file_name = $date . "_menu." . $imageFileType;
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
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $data['errors'] = "Sorry, only JPG, JPEG, PNG files are allowed.";
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

            $ll = new Leafletmodel();
            $ll->delete($date, "date");
            if ($uploadOk == 1) {
                $ll->insert([
                    "img_name" => $file_name,
                    "date" => $date,
                    "u_id" => $_SESSION["USER"]->id
                ]);
            }
        }


        $data["leaflet"] = [];
        $leaflets = new Leafletmodel();
        if(!empty($leaflets->getLeafletsWeekly())) {
            foreach($leaflets->getLeafletsWeekly() as $leaflet) {
                $data["leaflet"][$leaflet->date] = $leaflet;
            }
        }

        $this->view('leaflet.add', $data);
    }

}
