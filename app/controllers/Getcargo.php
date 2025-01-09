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
    public function splitshops()
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

        if (isset($_GET["s_id"])) {
            $s_id = $_GET["s_id"];

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $cargo = new Cargo;
                $prod = $_POST["prepared_products"];
                //show($_POST);
                //die();
                $date_now = $date . ' 06:00:00';
                $cargo->deleteByDateId($date_now, $s_id);
                foreach ($prod as $key => $value) {
                    $am = $value["amount"];
                    $toUpdate = ["w_id" => $w_id, "u_id" => 0, "p_id" => $key, "amount" => $am, "date" => $date_now, "u_set_id" => $u_set_id, "c_id" => $s_id];
                    $cargo->insert($toUpdate);
                }
                $data['success'] = "Zapisano pomyślnie";
                unset($_POST);

                $data['errors'] = $cargo->errors;
            }

            $cargo = new Cargo;
            $date_from = $date . ' 00:00:00';
            $date_to = $date . ' 23:59:59';
            if (!empty($cargo->getAllFullProductsDateAndShop($s_id, $date_from, $date_to))) {
                foreach ($cargo->getAllFullProductsDateAndShop($s_id, $date_from, $date_to) as $key => $value) {
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

            $planned = new Plannerproduction();// ??
            if (!empty($planned->getPlanned($date, $w_id))) {
                foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                    $data["planned"][$value->p_id] = (array) $value;
                }
            }
            
            if (!empty($planned->getPlanned($date, $w_id))) {
                foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                    $data["planned_total"][$value->p_id] = (array) $value;
                }
            }
        

            $products_list = new ProductsModel();
            foreach ($products_list->getAllFullProducts() as $key => $value) {
                $data["fullproducts"][$value->id] = (array) $value;
            }
        }

        $companies = new Companies();
        $data["shops"] = [];
        if(!empty($companies->getAllShops())) {
            foreach ($companies->getAllShops() as $key => $value) {
                $data["shops"][$value->id] = $value;
            }
        }

        $data["date_plan"] = $date;


        $this->view('splitpershop', $data);
    }

    public function shops()
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

        if (isset($_GET["date"])) {
            $cargo = new Cargo;
            $date_from = $date . ' 00:00:00';
            $date_to = $date . ' 23:59:59';
            if (!empty($cargo->getAllFullProductsByDate( $date_from, $date_to))) {
                foreach ($cargo->getAllFullProductsByDate( $date_from, $date_to) as $key => $value) {
                    if($value->amount > 0 && $value->exclude !=1) {
                        $data["cargo"][$value->c_id][$value->p_id] = (array) $value;
                        if($value->delivery_hour <= 2) {
                            if(!isset($data["cargo_total_morning"][$value->c_id][$value->p_id])) {
                                $data["cargo_total_morning"][$value->c_id][$value->p_id] = 0;
                            }
                            $data["cargo_total_morning"][$value->c_id][$value->p_id] += $value->amount;
                            if(!isset($data["c_total_morning"][$value->p_id])) {
                                $data["c_total_morning"][$value->p_id] = 0;
                            }
                            $data["c_total_morning"][$value->p_id] += $value->amount;
                        } else {
                            if(!isset($data["cargo_total_evening"][$value->c_id][$value->p_id])) {
                                $data["cargo_total_evening"][$value->c_id][$value->p_id] = 0;
                            }
                            $data["cargo_total_evening"][$value->c_id][$value->p_id] += $value->amount;
                            if(!isset($data["c_total_evening"][$value->p_id])) {
                                $data["c_total_evening"][$value->p_id] = 0;
                            }
                            $data["c_total_evening"][$value->p_id] += $value->amount;
                        }
                    }
                }
            }
            //show($data);die;

            $data["warehouse"] = $w_id;

            $warehouse = new WarehouseModel();
            $data["warehouse"] = $warehouse->getWarehouse($w_id);

            $planned = new Plannerproduction();// ??
            if (!empty($planned->getPlanned($date, $w_id))) {
                foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                    $data["planned"][$value->p_id] = (array) $value;
                }
            }
            
            if (!empty($planned->getPlanned($date, $w_id))) {
                foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                    $data["planned_total"][$value->p_id] = (array) $value;
                }
            }
        

            $products_list = new ProductsModel();
            foreach ($products_list->getAllFullProducts() as $key => $value) {
                $data["fullproducts"][$value->id] = (array) $value;
            }
        }
        $driverlist = new User();
        foreach ($driverlist->getAllDriverShopsActive() as $key => $value) {
            $data["drivers"][$value->id] = $value;
        }

        $companies = new Companies();
        $data["shops"] = [];
        if(!empty($companies->getAllShops())) {
            foreach ($companies->getAllShops() as $key => $value) {
                $data["shops"][$value->id] = $value;
                if(isset($data["drivers"][$value->guardian])) {
                    //show($value);
                    if (!property_exists($data["drivers"][$value->guardian], "shops") || !is_array($data["drivers"][$value->guardian]->shops)) {
                        $data["drivers"][$value->guardian]->shops = [];
                    }
                    $data["drivers"][$value->guardian]->shops[$value->id] = $value->id;
                }
            }
        }
        $data["cargo_per_driver"] = [];
        if(isset($data["cargo"])) {
            foreach($data["cargo"] as $c_key => $c_val) {
                $c_id = $c_key;
                foreach($c_val as $c_val1) {
                    if($c_val1["delivery_hour"] < 2 && $c_val1["exclude"] <> 1) {
        
                        foreach($data["drivers"] as $d_val => $d_key) {
                            $d_id = $d_key->id;
                            foreach($d_key->shops as $cc_id) {
                                if($c_id == $cc_id) {
                                    if(!isset($data["cargo_per_driver"][$d_id][$c_id][$c_val1["p_id"]])) {
                                        $data["cargo_per_driver"][$d_id][$c_id][$c_val1["p_id"]] = 0;
                                    }
                                    $data["cargo_per_driver"][$d_id][$c_id][$c_val1["p_id"]] += $c_val1["amount"];
                                    if(!isset($data["cargo_per_driver"][$d_id]["total"][$c_val1["p_id"]])) {
                                        $data["cargo_per_driver"][$d_id]["total"][$c_val1["p_id"]] = 0;
                                    }
                                    $data["cargo_per_driver"][$d_id]["total"][$c_val1["p_id"]] += $c_val1["amount"];
                                    if(!isset($data["cargo_per_driver"][$d_id]["total"]["sum"])) {
                                        $data["cargo_per_driver"][$d_id]["total"]["sum"] = 0;
                                    }
                                    $data["cargo_per_driver"][$d_id]["total"]["sum"] += $c_val1["amount"];
                                }
                            }
                        }
                    }
                    if($c_val1["delivery_hour"] >= 2 && $c_val1["exclude"] <> 1) {     
                        if(!isset($data["cargo_night"][$c_id][$c_val1["p_id"]])) {
                            $data["cargo_night"][$c_id][$c_val1["p_id"]] = 0;
                        }
                        $data["cargo_night"][$c_id][$c_val1["p_id"]] += $c_val1["amount"];
                        if(!isset($data["cargo_night"]["total"][$c_val1["p_id"]])) {
                            $data["cargo_night"]["total"][$c_val1["p_id"]] = 0;
                        }
                        $data["cargo_night"]["total"][$c_val1["p_id"]] += $c_val1["amount"];
                        if(!isset($data["cargo_night"]["total"]["sum"])) {
                            $data["cargo_night"]["total"]["sum"] = 0;
                        }
                        $data["cargo_night"]["total"]["sum"] += $c_val1["amount"];
                                
                         
                    }
                }
            }
        }

        

        

        $data["date_plan"] = $date;

        

        $this->view('splitpershopsummary', $data);
    }

    public function summaryreport()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        
        $data = [];
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2]) && isset($URL[3])) {
            $date_from = $URL[2];
            $date_to = $URL[3];
        } else {
            if (isset($_GET["date_from"])) {
                $date_from = $_GET["date_from"] . " 00:00:00";
                $data["date_from"] = $_GET["date_from"];
            } else {
                $date_from = date('Y-m-d 00:00:00');
            }
            if (isset($_GET["date_to"])) {
                $date_to = $_GET["date_to"] . " 23:59:59";
                $data["date_to"] = $_GET["date_to"];
            } else {
                $date_to = date('Y-m-d 23:59:59');
            }
        }

        if (!isset($_GET["date_from"])) {
            $date_from = '2024-10-10 00:00:00';
            $date_to = '2025-01-05 23:59:59';
            $data["date_from"] = '2024-10-10';
            $data["date_to"] = '2025-01-05';
        }
        $cargo = new Cargo;
        if (!empty($cargo->getAllFullProductsByDate( $date_from, $date_to))) {
            foreach ($cargo->getAllFullProductsByDate( $date_from, $date_to) as $key => $value) {
                if($value->amount > 0 && $value->exclude <> 1) {
                    $date = substr($value->date,0,10);

                    if(!isset($data["cargo"][$value->c_id][$date]["delivery_early"])) {
                        $data["cargo"][$value->c_id][$date]["delivery_early"] = 0;
                    }
                    if(!isset($data["cargo"][$value->c_id][$date]["delivery_late"])) {
                        $data["cargo"][$value->c_id][$date]["delivery_late"] = 0;
                    }
                    if($value->delivery_hour < 2) {
                        $data["cargo"][$value->c_id][$date]["delivery_early"] += $value->amount;
                    } else {
                        $data["cargo"][$value->c_id][$date]["delivery_late"] += $value->amount;
                    }
                    //show($value);
                }
            }
        }

        $return = new ReturnsModel;
        if (!empty($return->getShopsReturn( $date_from, $date_to))) {
            foreach ($return->getShopsReturn( $date_from, $date_to) as $key => $value) {
                    $date = substr($value->date,0,10);
                    if(!isset($data["cargo"][$value->c_id][$date]["return"])) {
                        $data["cargo"][$value->c_id][$date]["return"] = 0;
                    }
                    $data["cargo"][$value->c_id][$date]["return"] += $value->amount;
                    
                    //show($value);
            }
        }
        $companies = new Companies();
        $data["shops"] = [];
        if(!empty($companies->getAllShops())) {
            foreach ($companies->getAllShops() as $key => $value) {
                $data["shops"][$value->id] = $value;
            }
        }


        $this->view('returns.summary', $data);
    }
}
