<?php

/**
 * Returns class
 */
class Returns
{
    use Controller;
    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $u_id = $_SESSION["USER"]->id;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $returns = new ReturnsModel;

            if(isset($_POST["p_id"])) {
                foreach ($_POST["p_id"] as $key => $value) {
                    if ($value > 0) {
                        $toUpdate = ["w_id" => $_POST["w_id"], "u_id" => $u_id, "p_id" => $key, "amount" => $value];
                        $returns->insert($toUpdate);
                    }
                }
                $data['success'] = "Produkty zostały zwrócone do magazynu";
                unset($_POST);
            } else {
                $data['errors'] = "Brak produktów do zwrotu";
            }
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city AND w_active = 1 AND wh_name = 'MAIN'"; //wh_name tylko zwroty na główny
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $products_list = new ProductsModel();
        $prod_list = [];
        $prod_list_sold = [];
        $prod_list_returned = [];
        $prod_availability_exchange_from = [];
        $prod_availability_exchange_to = [];
        $prod_availability_exchange_pending = [];
        $prod_availability_gratis = [];
        $prod_availability_destroy = [];

        foreach($products_list->getAllFullProducts() as $key => $value) {
            $data["products"][$value->id] = $value;
        }

        foreach ($data["products"] as $prod) {
            $prod_list[$prod->id] = 0;
            $prod_list_sold[$prod->id] = 0;
            $prod_list_returned[$prod->id] = 0;
            $prod_availability_exchange_from[$prod->id] = 0;
            $prod_availability_exchange_to[$prod->id] = 0;
            $prod_availability_exchange_pending[$prod->id] = 0;
            $prod_availability_gratis[$prod->id] = 0;
            $prod_availability_destroy[$prod->id] = 0;
        }
        
        $today = date("Y-m-d");
        $date_from = $today . " 00:00:00";
        $date_to = $today . " 23:59:59";
        $products_list = new Cargo();
        $data["cargo"] = $products_list->getAllFullProductsDate($u_id, $date_from, $date_to);

        if (!is_bool($data["cargo"])) {
            foreach ($data["cargo"] as $carg) {
                $prod_list[$carg->p_id] += $carg->amount;
            }
        }
        $data["prod_availability"] = $prod_list;

        $products_list = new Sales();
        $data["sold"] = $products_list->getSoldProducts($u_id);

        if (!is_bool($data["sold"])) {
            foreach ($data["sold"] as $sold) {
                $prod_list_sold[$sold->p_id] += $sold->s_amount;
            }
        }
        $data["prod_availability"] = $prod_list;
        $data["prod_availability_sold"] = $prod_list_sold;

        $products_list = new ReturnsModel();
        $data["return"] = $products_list->getAllFullProducts($u_id);

        if (!is_bool($data["return"])) {
            foreach ($data["return"] as $return) {
                $prod_list_returned[$return->p_id] += $return->amount;
            }
        }

        $products_list = new CargoExchange();
        $data["exchange_from"] = $products_list->getExchangeTodayOffersToMeSelected($u_id, 1);

        if (!is_bool($data["exchange_from"])) {
            foreach ($data["exchange_from"] as $return) {
                $prod_availability_exchange_from[$return->p_id] += $return->amount;
            }
        }

        $products_list = new CargoExchange();
        $data["prod_availability_exchange_to"] = $products_list->getExchangeTodayMyOffersSelected($u_id, 1);

        if (!is_bool($data["prod_availability_exchange_to"])) {
            foreach ($data["prod_availability_exchange_to"] as $return) {
                $prod_availability_exchange_to[$return->p_id] += $return->amount;
            }
        }

        $products_list = new CargoExchange();
        $data["prod_availability_exchange_pending"] = $products_list->getExchangeTodayMyOffersSelected($u_id, 0);

        if (!is_bool($data["prod_availability_exchange_pending"])) {
            foreach ($data["prod_availability_exchange_pending"] as $return) {
                $prod_availability_exchange_pending[$return->p_id] += $return->amount;
            }
        }

        $products_list = new Sales();
        $data["prod_availability_gratis"] = $products_list->getStatusProductsLeft($u_id, "gratis");

        if (!is_bool($data["prod_availability_gratis"])) {
            foreach ($data["prod_availability_gratis"] as $return) {
                $prod_availability_gratis[$return->p_id] += $return->s_amount;
            }
        }

        $products_list = new Sales();
        $data["prod_availability_destroy"] = $products_list->getStatusProductsLeft($u_id, "destroy");

        if (!is_bool($data["prod_availability_destroy"])) {
            foreach ($data["prod_availability_destroy"] as $return) {
                $prod_availability_destroy[$return->p_id] += $return->s_amount;
            }
        }

        //show($prod_availability_exchange_from);
        //die;

        $data["prod_availability"] = $prod_list;
        $data["prod_availability_sold"] = $prod_list_sold;
        $data["prod_availability_returned"] = $prod_list_returned;
        $data["prod_availability_exchange_from"] = $prod_availability_exchange_from;
        $data["prod_availability_exchange_to"] = $prod_availability_exchange_to;
        $data["prod_availability_exchange_pending"] = $prod_availability_exchange_pending;
        $data["prod_availability_gratis"] = $prod_availability_gratis;
        $data["prod_availability_destroy"] = $prod_availability_destroy;
        $this->view('returns.new', $data);
    }

    public function split()
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
        //przy zapisywaniu ustawić na sztywno magazyn na którym to robimy, później ewentualnie będzie wybór
        $w_id = 1;
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $plan = new ReturnsModel();
            $plan->deleteByDate($date);
            if(isset($_POST["ordered_products"])) {
                $prod = $_POST["ordered_products"];
                $u_id = $_SESSION["USER"]->id;
    
                foreach($prod as $usr => $pid) {
                    foreach($pid as $p_id => $amount) {
                        $que = ["date" => "$date 15:00:00", "p_id" => $p_id, "amount" => $amount, "u_id" => $usr, "u_set_id" => $u_id, "w_id" => $w_id];
                        $plan->insert($que);
                    }
                }
            }

        }

        $plan = new ReturnsModel();
        if(!empty($plan->getAll($date))) {
            foreach ($plan->getAll($date) as $key => $value) {
                $data["returns"][$value->u_id][$value->p_id] = (array) $value;
            }
        }

        $users = new User();
        foreach ($users->getTraders() as $key => $value) {
            $data["traders"][$value->id] = $value;
        }

        $planned = new Plannerproduction();
        if(!empty($planned->getPlanned($date, $w_id))) {
            foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                $data["planned"][$value->id] = (array) $value;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = (array) $value;
        }

        $data["date_plan"] = $date;




        $this->view('returns.split', $data);
    }
}
