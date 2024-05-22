<?php

/**
 * Scanner class
 */
class QRScanner
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $_SESSION["selected_company"] = 0;
        $_SESSION["selected_company_id"] = 0;
        $_SESSION["selected_company_fullname"] = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["text"]) && !empty($_POST["text"])) {
                if (!isset($_POST['token_post']) || $_POST['token_post'] !== $_SESSION['token_post']) {
                    $data['error'] = "Odświeżenie strony, nie dodano skanu";
                } else {
                    $u_id = $_SESSION["USER"]->id;
                    $c_id = $_POST["c_fullname_id"];
                    $p_id = $_POST["prod_p_id"];
                    $sales = new Sales;
                    $toUpdate = ["u_id" => $u_id, "c_id" => $c_id, "sale_description" => "scan", "p_id" => $p_id, "s_amount" => 1];
                    $sales->insert($toUpdate);
    
                    $now = date("Y-m-d H:i:s");
                    $data['success'] = "Pomyślnie zeskanowano produkt: <b>" . $_POST["prod_name"] . "</b> o godzinie: <b>" . $now . "</b>";
                    $check_sold = 1;
                    $placeVisited = new PlacesModel;
                    $city_id = $_POST["c_id"];
                    $v = $placeVisited->checkVisit($city_id);
                    if($check_sold == 1) {
                        if(empty($v)) {
                            $placeVisited->insert(["u_id" => $u_id, "sold" => 1, "c_id" => $city_id]);
                        }
                    }
                }
            }

            unset($_SESSION['token_post']);


            $_SESSION["selected_company"] = $_POST["c_fullname_id"]; // ustawia aktualnie wybraną firmę
            $_SESSION["selected_company_id"] = $_POST["c_id"]; // ustawia aktualnie wybraną firmę
            $_SESSION["selected_company_fullname"] = $_POST["c_fullname"]; // ustawia aktualnie wybraną firmę
        }
        
        $token = bin2hex(random_bytes(32));
        $_SESSION['token_post'] = $token;

        $products = new ProductsModel;
        $temp = $products->getAllFullProducts();
        foreach ($temp as $key => $value) {
            $data["products"][$value->id] = $value;
        }
        $companies = new Companies();
        $temp = $companies->getMyCompanies($_SESSION["USER"]->id);
        if(!empty($temp)) {
            foreach ($temp as $key => $value) {
                $data["companies"][$value->id] = $value;
            }
        }

        $sal = new Sales();
        $temp = $sal->getLastScans($_SESSION["USER"]->id);
        if(!empty($temp)) {
            foreach ($temp as $key => $value) {
                $data["scans"][$value->id] = $value;
            }
        }

        $this->view('qrscanner', $data);
    }

    public function delete()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id_scan = $URL[2];

        $pq = new Sales;
        $pq->delete($id_scan, "id");

        $com = "Pomyślnie usunięto scan ID: $id_scan";

        return $com;
    }
}
