<?php

/**
 * Availability class
 */
class Availability
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data["cities"] = $_SESSION["CITIES"];

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $users = new UsersModel();
        $user_list = $users->getAllUsers();
        foreach ($user_list as $user) {
            $data["users"][$user->id] = $user;

        }

        /*$cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }*/


        $this->view('availability.show', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        //$w_id = $_SESSION["USER"]->u_warehouse;
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $w_id = $URL[2];

        $u_id = $_SESSION["USER"]->id;

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $data["user_warehouse"] = $w_id;

        $products_list = new ProductsModel();
        $temp["products"] = $products_list->getAllProducts();
        $product_number = 0;
        foreach ($temp["products"] as $product) {
            $data["products"][$product->id] = (array) $product;
            $product_number++;
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            foreach ($_POST["p_id"] as $key => $value) {
                $p = new ProductsQuantity;
                $old = $_POST["p_id_old"][$key];
                if ($value != $old) {
                    $que = ["w_id" => $w_id, "u_id" => $u_id, "p_id" => $key, "amount" => $value, "old_amount" => $old, "transaction_type" => "set"];
                    $p->insert($que);
                }
            }
        }

        //pobranie info o ostatnim ustawieniu stanów
        foreach ($data["products"] as $product) {
            $prod = new ProductsQuantity();
            //echo $w_id . " " . $product->id . "</br>";
            $data["sets"][$product["id"]] = $prod->getAllSet($w_id, $product["id"]);
            $amount = 0;
            if (isset($data["sets"][$product["id"]][0]->amount))
                $amount = $data["sets"][$product["id"]][0]->amount;
            $data["product_quantity"][$product["id"]]["set"] = $amount;
            $data["product_quantity"][$product["id"]]["scan"] = 0;
            $data["product_quantity"][$product["id"]]["add"] = 0;
            $data["product_quantity"][$product["id"]]["sub"] = 0;
            $data["product_quantity"][$product["id"]]["cargo"] = 0;
            $data["product_quantity"][$product["id"]]["return"] = 0;
        }



        //pobranie zeskanowych ilości od ostatniaego SET
        foreach ($data["sets"] as $key => $value) {
            if (isset($value[0]))
                $date = $value[0]->date;
            else
                $date = '2000-01-01 00:00:00';

            //echo $key . " -> " . $date . "</br>";

            //skany i wyliczone stany zeskanowane
            $scan = new ScanModel();
            $data["scans"][$key] = $scan->getScans($key, $w_id, $date);

            if (!is_bool($data["scans"][$key])) {
                foreach ($data["scans"][$key] as $scan) {
                    $data["product_quantity"][$key]["scan"] += 1;
                }
            }

            //add i wyliczone stany ADD
            $prod_add = new ProductsQuantity();
            $data["set_add"][$key] = $prod_add->getAllAdd($w_id, $key, $date);

            if (!is_bool($data["set_add"][$key])) {
                foreach ($data["set_add"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["add"] += $set_ad->amount;
                }
            }

            //sub i wyliczone stany SUB
            $prod_sub = new ProductsQuantity();
            $data["set_sub"][$key] = $prod_sub->getAllSub($w_id, $key, $date);

            if (!is_bool($data["set_sub"][$key])) {
                foreach ($data["set_sub"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["sub"] += $set_ad->amount;
                }
            }

            //cargo
            $prod_cargo = new Cargo();
            $data["set_cargo"][$key] = $prod_cargo->getCargo($w_id, $key, $date);

            if (!is_bool($data["set_cargo"][$key])) {
                foreach ($data["set_cargo"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["cargo"] += $set_ad->amount;
                }
            }

            //return
            $prod_returns = new ReturnsModel();
            $data["set_return"][$key] = $prod_returns->getReturns($w_id, $key, $date);

            if (!is_bool($data["set_return"][$key])) {
                foreach ($data["set_return"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["return"] += $set_ad->amount;
                }
            }
            //po dodaniu tych dwóch mam aktualne ilości każdego produktu w danym magazynie
        }

        $this->view('availability', $data);
    }

    public function add()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $w_id = $_SESSION["USER"]->u_warehouse;
        $u_id = $_SESSION["USER"]->id;
        $data["user_warehouse"] = $w_id;

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $p = new ProductsQuantity;
                    $old = $_POST["p_id_old"][$key];
                    $que = ["w_id" => $w_id, "u_id" => $u_id, "p_id" => $key, "amount" => $value, "old_amount" => $old, "transaction_type" => "add"];
                    $p->insert($que);
                }
            }
        }

        $products_list = new ProductsModel();
        $temp["products"] = $products_list->getAllProducts();
        $product_number = 0;
        foreach ($temp["products"] as $product) {
            $data["products"][$product->id] = (array) $product;
            $product_number++;
        }



        //pobranie info o ostatnim ustawieniu stanów
        foreach ($data["products"] as $product) {
            $prod = new ProductsQuantity();
            //echo $w_id . " " . $product->id . "</br>";
            $data["sets"][$product["id"]] = $prod->getAllSet($w_id, $product["id"]);
            $amount = 0;
            if (isset($data["sets"][$product["id"]][0]->amount))
                $amount = $data["sets"][$product["id"]][0]->amount;
            $data["product_quantity"][$product["id"]]["set"] = $amount;
            $data["product_quantity"][$product["id"]]["scan"] = 0;
            $data["product_quantity"][$product["id"]]["add"] = 0;
            $data["product_quantity"][$product["id"]]["sub"] = 0;
            $data["product_quantity"][$product["id"]]["cargo"] = 0;
            $data["product_quantity"][$product["id"]]["return"] = 0;
        }



        //pobranie zeskanowych ilości od ostatniaego SET
        foreach ($data["sets"] as $key => $value) {
            if (isset($value[0]))
                $date = $value[0]->date;
            else
                $date = '2000-01-01 00:00:00';

            //echo $key . " -> " . $date . "</br>";

            //skany i wyliczone stany zeskanowane
            $scan = new ScanModel();
            $data["scans"][$key] = $scan->getScans($key, $w_id, $date);

            if (!is_bool($data["scans"][$key])) {
                foreach ($data["scans"][$key] as $scan) {
                    $data["product_quantity"][$key]["scan"] += 1;
                }
            }

            //add i wyliczone stany ADD
            $prod_add = new ProductsQuantity();
            $data["set_add"][$key] = $prod_add->getAllAdd($w_id, $key, $date);

            if (!is_bool($data["set_add"][$key])) {
                foreach ($data["set_add"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["add"] += $set_ad->amount;
                }
            }

            //sub i wyliczone stany SUB
            $prod_sub = new ProductsQuantity();
            $data["set_sub"][$key] = $prod_sub->getAllSub($w_id, $key, $date);

            if (!is_bool($data["set_sub"][$key])) {
                foreach ($data["set_sub"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["sub"] += $set_ad->amount;
                }
            }

            //cargo
            $prod_cargo = new Cargo();
            $data["set_cargo"][$key] = $prod_cargo->getCargo($w_id, $key, $date);

            if (!is_bool($data["set_cargo"][$key])) {
                foreach ($data["set_cargo"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["cargo"] += $set_ad->amount;
                }
            }

            //return
            $prod_returns = new ReturnsModel();
            $data["set_return"][$key] = $prod_returns->getReturns($w_id, $key, $date);

            if (!is_bool($data["set_return"][$key])) {
                foreach ($data["set_return"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["return"] += $set_ad->amount;
                }
            }
            //po dodaniu tych dwóch mam aktualne ilości każdego produktu w danym magazynie
        }


        $this->view('availability.add', $data);
    }

    public function sub()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $w_id = $_SESSION["USER"]->u_warehouse;
        $u_id = $_SESSION["USER"]->id;
        $data["user_warehouse"] = $w_id;

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $p = new ProductsQuantity;
                    $old = $_POST["p_id_old"][$key];
                    $que = ["w_id" => $w_id, "u_id" => $u_id, "p_id" => $key, "amount" => $value, "old_amount" => $old, "transaction_type" => "sub"];
                    $p->insert($que);
                }
            }
        }

        $products_list = new ProductsModel();
        $temp["products"] = $products_list->getAllProducts();
        $product_number = 0;
        foreach ($temp["products"] as $product) {
            $data["products"][$product->id] = (array) $product;
            $product_number++;
        }



        //pobranie info o ostatnim ustawieniu stanów
        foreach ($data["products"] as $product) {
            $prod = new ProductsQuantity();
            //echo $w_id . " " . $product->id . "</br>";
            $data["sets"][$product["id"]] = $prod->getAllSet($w_id, $product["id"]);
            $amount = 0;
            if (isset($data["sets"][$product["id"]][0]->amount))
                $amount = $data["sets"][$product["id"]][0]->amount;
            $data["product_quantity"][$product["id"]]["set"] = $amount;
            $data["product_quantity"][$product["id"]]["scan"] = 0;
            $data["product_quantity"][$product["id"]]["add"] = 0;
            $data["product_quantity"][$product["id"]]["sub"] = 0;
            $data["product_quantity"][$product["id"]]["cargo"] = 0;
            $data["product_quantity"][$product["id"]]["return"] = 0;
        }



        //pobranie zeskanowych ilości od ostatniaego SET
        foreach ($data["sets"] as $key => $value) {
            if (isset($value[0]))
                $date = $value[0]->date;
            else
                $date = '2000-01-01 00:00:00';

            //echo $key . " -> " . $date . "</br>";

            //skany i wyliczone stany zeskanowane
            $scan = new ScanModel();
            $data["scans"][$key] = $scan->getScans($key, $w_id, $date);

            if (!is_bool($data["scans"][$key])) {
                foreach ($data["scans"][$key] as $scan) {
                    $data["product_quantity"][$key]["scan"] += 1;
                }
            }

            //add i wyliczone stany ADD
            $prod_add = new ProductsQuantity();
            $data["set_add"][$key] = $prod_add->getAllAdd($w_id, $key, $date);

            if (!is_bool($data["set_add"][$key])) {
                foreach ($data["set_add"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["add"] += $set_ad->amount;
                }
            }

            //sub i wyliczone stany SUB
            $prod_sub = new ProductsQuantity();
            $data["set_sub"][$key] = $prod_sub->getAllSub($w_id, $key, $date);

            if (!is_bool($data["set_sub"][$key])) {
                foreach ($data["set_sub"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["sub"] += $set_ad->amount;
                }
            }

            //cargo
            $prod_cargo = new Cargo();
            $data["set_cargo"][$key] = $prod_cargo->getCargo($w_id, $key, $date);

            if (!is_bool($data["set_cargo"][$key])) {
                foreach ($data["set_cargo"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["cargo"] += $set_ad->amount;
                }
            }

            //return
            $prod_returns = new ReturnsModel();
            $data["set_return"][$key] = $prod_returns->getReturns($w_id, $key, $date);

            if (!is_bool($data["set_return"][$key])) {
                foreach ($data["set_return"][$key] as $set_ad) {
                    $data["product_quantity"][$key]["return"] += $set_ad->amount;
                }
            }
            //po dodaniu tych dwóch mam aktualne ilości każdego produktu w danym magazynie
        }


        $this->view('availability.sub', $data);
    }

    public function history()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $this->view('availability');
    }

}
