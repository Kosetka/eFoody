<?php

/**
 * GetCargo class
 */
class GetCargo
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        // do zrobienia
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $cargo = new Cargo;
            $u_id = $_SESSION["USER"]->id;

            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $toUpdate = ["w_id" => $_POST["w_id"], "u_id" => $u_id, "p_id" => $key, "amount" => $value];
                    $cargo->insert($toUpdate);
                }
            }
            $data['success'] = "Produkty zostały pobrane";
            unset($_POST);

            $data['errors'] = $cargo->errors;
        }


        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city AND w_active = 1";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $products_list = new ProductsModel();
        $data["products"] = $products_list->getAllFullProducts();

        $this->view('getcargo', $data);
    }

    public function split()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $date = $URL[2];
        } else {
            if (isset($_GET["date"])) {
                $date = $_GET["date"];
            } else {
                $date = date('Y-m-d');
            }
        }

        $u_set_id = $_SESSION["USER"]->id;

        //w przyszłości zmienić gdyby było więcej magazynów
        $w_id = 1;

        if (isset($_GET["u_id"])) {
            $u_id = $_GET["u_id"];

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $cargo = new Cargo;
                $prod = $_POST["prepared_products"];
                //show($_POST);
                //die();
                $date_now = $date . ' 06:00:00';
                $cargo->deleteByDateId($date_now, $u_id);
                foreach ($prod as $key => $value) {
                    $am = $value["amount"];
                    $toUpdate = ["w_id" => $w_id, "u_id" => $u_id, "p_id" => $key, "amount" => $am, "date" => $date_now, "u_set_id" => $u_set_id];
                    $cargo->insert($toUpdate);
                }
                $data['success'] = "Zapisano pomyślnie";
                unset($_POST);

                $data['errors'] = $cargo->errors;
            }

            $cargo = new Cargo;
            $date_from = $date . ' 00:00:00';
            $date_to = $date . ' 23:59:59';
            if (!empty($cargo->getAllFullProductsDate($u_id, $date_from, $date_to))) {
                foreach ($cargo->getAllFullProductsDate($u_id, $date_from, $date_to) as $key => $value) {
                    $data["cargo"][$value->p_id] = (array) $value;
                }
            }
            if (!empty($cargo->getFullProductsDate($date_from, $date_to))) {
                foreach ($cargo->getFullProductsDate($date_from, $date_to) as $key => $value) {
                    $data["cargo_total"][$value->p_id] = (array) $value;
                }
            }

            $data["warehouse"] = $w_id;

            $warehouse = new WarehouseModel();
            $data["warehouse"] = $warehouse->getWarehouse($w_id);

            $planned = new Plannerproduction();
            if (!empty($planned->getPlannedUser($date, $w_id, $u_id))) {
                foreach ($planned->getPlannedUser($date, $w_id, $u_id) as $key => $value) {
                    $data["planned"][$value->p_id] = (array) $value;
                }
            }
            if (!empty($planned->getPlanned($date, $w_id))) {
                foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                    $data["planned_total"][$value->p_id] = (array) $value;
                }
            }

            $plan = new Plannersplit();
            if (!empty($plan->getPlannedUser($date, $u_id))) {
                foreach ($plan->getPlannedUser($date, $u_id) as $key => $value) {
                    $data["split"][$value->u_id][$value->p_id] = (array) $value;
                }
            }
            if (!empty($plan->getPlanned($date))) {
                foreach ($plan->getPlanned($date) as $key => $value) {
                    $data["split_total"][$value->u_id][$value->p_id] = (array) $value;
                }
            }

            $products_list = new ProductsModel();
            foreach ($products_list->getAllFullProducts() as $key => $value) {
                $data["fullproducts"][$value->id] = (array) $value;
            }
        }

        $users = new User();
        foreach ($users->getTraders() as $key => $value) {
            $data["traders"][$value->id] = $value;
        }

        $data["date_plan"] = $date;


        $this->view('splitpermerchant', $data);
    }
}
