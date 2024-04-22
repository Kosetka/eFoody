<?php

/**
 * Sale class
 */
class Exchange
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $data["products"] = False;

            $u_id = $_SESSION["USER"]->id;

            $products_list = new ProductsModel();
            $data["products"] = $products_list->getAllFullProducts();

            $users_list = new User();
            foreach($users_list->getAllTraders("users", TRADERS) as $key => $value) {
                $data["users"][$value->id] = $value; 
            }


            $data["user_id"] = $u_id;

            $ex = new CargoExchange();
            $data["exchange_my"] = $ex->getExchangeTodayMyOffers($u_id);
            $data["exchange_to_me"] = $ex->getExchangeTodayOffersToMe($u_id);
            
        $this->view('exchange', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $u_id = $_SESSION["USER"]->id;
        // do zrobienia
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $u_id_init = $_SESSION["USER"]->id;
            $u_id_target = $_POST["u_id_target"];

            $sales = new CargoExchange;
            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $toUpdate = ["u_id_init" => $u_id_init, "u_id_target"=>$u_id_target, "result" => 0, "date_result" => "", "p_id" => $key, "amount" => $value];
                    $sales->insert($toUpdate);
                }
            }
            $data['success'] = "Oferta wymiany została dodana";
            unset($_POST);
            $data['errors'] = $sales->errors;
        }

        $users_list = new User();
        $data["users"] = $users_list->getAllTraders("users", TRADERS);

        $products_list = new ProductsModel();
        $data["products"] = $products_list->getAllFullProducts();

        $cargo_list = new Cargo();
        $data["cargo"] = $cargo_list->getAllFullProducts($u_id);

        $sold_list = new Sales();
        $data["sold"] = $sold_list->getSoldProducts($u_id);

        $products_list = new ReturnsModel();
        $data["return"] = $products_list->getAllFullProducts($u_id);

        $products_list = new CargoExchange();
        $data["exchange_my"] = $products_list->getExchangeTodayMyOffers($u_id);

        $products_list = new CargoExchange();
        $data["exchange_to_me"] = $products_list->getExchangeTodayOffersToMeSelected($u_id, 1);

        $this->view('exchange.new', $data);
    }
    public function accept()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id_scan = $URL[2];
        $user = $URL[3];

        if ($_SESSION["ROLE"]->id != 1)
            if ($_SESSION["USER"]->id != $user)
                redirect('login');
        $scan = new ScanModel;
        //$scan->update($id_scan, ['ps_active' => 0]);
        $com = "Pomyślnie usunięto scan ID: $id_scan";

        return $com;
    }
    public function reject()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id_scan = $URL[2];
        $user = $URL[3];

        if ($_SESSION["ROLE"]->id != 1)
            if ($_SESSION["USER"]->id != $user)
                redirect('login');
        $scan = new ScanModel;
        //$scan->update($id_scan, ['ps_active' => 0]);
        $com = "Pomyślnie usunięto scan ID: $id_scan";

        return $com;
    }
    public function cancel()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id_scan = $URL[2];
        $user = $URL[3];

        if ($_SESSION["ROLE"]->id != 1)
            if ($_SESSION["USER"]->id != $user)
                redirect('login');
        $scan = new ScanModel;
        //$scan->update($id_scan, ['ps_active' => 0]);
        $com = "Pomyślnie usunięto scan ID: $id_scan";

        return $com;
    }
}
