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
            if(isset($_POST["text"]) && !empty($_POST["text"])) {
                $u_id = $_SESSION["USER"]->id;
                $c_id = $_POST["c_fullname_id"];
                $p_id = $_POST["prod_p_id"]; 
                $sales = new Sales;
                $toUpdate = ["u_id" => $u_id, "c_id" => $c_id, "sale_description" => "scan", "p_id" => $p_id, "s_amount" => 1];
                $sales->insert($toUpdate);

                $now = date("Y-m-d H:m:s");
                $data['success'] = "Pomyślnie zeskanowano produkt: <b>".$_POST["prod_name"]."</b> o godzinie: <b>".$now."</b>";
            } 
            $_SESSION["selected_company"] = $_POST["c_fullname_id"]; // ustawia aktualnie wybraną firmę
            $_SESSION["selected_company_id"] = $_POST["c_id"]; // ustawia aktualnie wybraną firmę
            $_SESSION["selected_company_fullname"] = $_POST["c_fullname"]; // ustawia aktualnie wybraną firmę


        }

        $products = new ProductsModel;
        $temp = $products->getAll("products");
        foreach ($temp as $key => $value) {
            $data["products"][$value->id] = $value;
        }
        $companies = new Companies();
        $temp = $companies->getAll("companies");
        foreach ($temp as $key => $value) {
            $data["companies"][$value->id] = $value;
        }

        $this->view('qrscanner',$data);
    }
}
