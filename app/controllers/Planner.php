<?php

/**
 * Availability class
 */
class Planner
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data["cities"] = $_SESSION["CITIES"];
        $data["prod_num"] = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["dateSend"])) {
                $_SESSION["date_planner"] = $_POST["date"];
            } else if (isset($_POST["planSend"])) {

                $plan = new PlannerModel();
                $date_plan = $_SESSION["date_planner"];
                $u_id = $_SESSION["USER"]->id;
                $w_id = $_POST["city"];
                $p_id = $_POST["prod"];
                $amount = $_POST["amount"];

                $que = ["date_plan" => "$date_plan", "w_id" => $w_id, "p_id" => $p_id, "amount" => $amount, "u_id" => $u_id];
                $que_check = ["date_plan" => "$date_plan", "w_id" => $w_id, "p_id" => $p_id];

                $che = $plan->where($que_check);
                if (!empty($che[0]->id)) {
                    $plan->update($che[0]->id, $que);
                } else {
                    $plan->insert($que);
                }
            }
        }


        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["p"][$id] = [];
        }

        $products_list = new PlannerModel();
        if (isset($_SESSION["date_planner"])) {
            if (!empty($products_list->getAll($_SESSION["date_planner"]))) {
                foreach ($products_list->getAll($_SESSION["date_planner"]) as $key => $value) {
                    $data["planned"][$value->w_id][$value->p_id] = $value;
                }
            }
        }

        // Tutaj ogarnąć sumowanie i wyświetlanie dobrze
        $products_list = new ProductsModel();
        foreach ($products_list->getAllSubProducts() as $key => $value) {
            $data["subproducts"][$value->id] = $value;
        }
        foreach ($data["p"] as $k => $v) {
            foreach ($data["subproducts"] as $k1 => $v1) {
                $data["sets"][$k][$k1] = (object)[];
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }

        $recipes = new RecipesModel();
        foreach ($recipes->getFullRecipes() as $key => $value) {
            $data["recipes"][$value->p_id][$value->sub_prod] = $value;
        }

        $prod = new ProductsQuantity();
        $temp = $prod->getAllSetAllwarehouse();
        //show($temp);
        foreach ($temp as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $data["sets"][$v->w_id][$v->p_id] = $v;
            }
        }
        $temp = $prod->getAllAddSub();
        foreach ($temp as $key => $value) {
            if ($data["sets"][$value->w_id][$value->p_id]->date < $value->date) {
                if ($value->transaction_type == "add") {
                    $data["sets"][$value->w_id][$value->p_id]->amount += $value->amount;
                }
                if ($value->transaction_type == "sub") {
                    $data["sets"][$value->w_id][$value->p_id]->amount -= $value->amount;
                }
            }
        }

        $this->view('planner.possibility', $data);
    }

    public function show()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data["cities"] = $_SESSION["CITIES"];
        $data["prod_num"] = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["dateSend"])) {
                $_SESSION["date_plan"] = $_POST["date"];
            }
        }
        if (isset($_SESSION["date_plan"])) {
            /*foreach ($_SESSION["CITIES"] as $key => $value) {
                $prod = new ProductsQuantity();
                $id = $value["id"];
                $data["p"][$id] = [];
            }*/

            $products_list = new PlannerModel();
            if (!empty($products_list->getAll($_SESSION["date_plan"]))) {
                foreach ($products_list->getAll($_SESSION["date_plan"]) as $key => $value) {
                    $data["planned"][$value->w_id][$value->p_id] = $value;
                }
            }
            if (!empty($data["planned"])) {
                foreach ($data["planned"] as $key => $value) {
                    foreach ($value as $k => $v) {
                        $data["prod_planned"][$k][$key] = $v->amount;
                        if (!isset($data["prod_planned"][$k]["total"])) {
                            $data["prod_planned"][$k]["total"] = 0;
                        }
                        $data["prod_planned"][$k]["total"] += $v->amount;
                    }
                }
            }


            //die;

            /*$products_list = new PlannerModel();
            if(!empty($products_list->getAll($_SESSION["date_planner"]))) {
                foreach ($products_list->getAll($_SESSION["date_planner"]) as $key => $value) {
                    $data["planned"][$value->w_id][$value->p_id] = $value;
                }
            }*/

            // Tutaj ogarnąć sumowanie i wyświetlanie dobrze
            /*$products_list = new ProductsModel();
            foreach ($products_list->getAllSubProducts() as $key => $value) {
                $data["subproducts"][$value->id] = $value;
            }*/

            $products_list = new ProductsModel();
            foreach ($products_list->getAllFullProducts() as $key => $value) {
                $data["fullproducts"][$value->id] = $value;
            }

            $products_list = new ScanModel();
            $temp = $products_list->getAllProducts($_SESSION["date_plan"]);

            if (!empty($temp)) {
                foreach ($temp as $key => $value) {
                    $data["scans"][$value->p_id][$value->s_warehouse] = 0;
                    $data["scans"][$value->p_id]["total"] = 0;
                }
            }
            if (!empty($temp)) {
                foreach ($temp as $key => $value) {
                    if (isset($data["scans"][$value->p_id][$value->s_warehouse])) {
                        $data["scans"][$value->p_id][$value->s_warehouse] += 1;
                        $data["scans"][$value->p_id]["total"] += 1;
                    }
                }
            }

            /*$recipes = new RecipesModel();
            foreach ($recipes->getFullRecipes() as $key => $value) {
                $data["recipes"][$value->p_id][$value->sub_prod] = $value;
            }*/

            /*$prod = new ProductsQuantity();
            $temp = $prod->getAllSetAllwarehouse();
            //show($temp);
            foreach ($temp as $k => $v) {
                foreach ($v as $k1 => $v1) {
                    $data["sets"][$v->w_id][$v->p_id] = $v;
                }
            }
            $temp = $prod->getAllAddSub();
            foreach ($temp as $key => $value) {
                if ($data["sets"][$value->w_id][$value->p_id]->date < $value->date) {
                    if ($value->transaction_type == "add") {
                        $data["sets"][$value->w_id][$value->p_id]->amount += $value->amount;
                    }
                    if ($value->transaction_type == "sub") {
                        $data["sets"][$value->w_id][$value->p_id]->amount -= $value->amount;
                    }
                }
            }*/
        }

        $this->view('planner.plan', $data);
    }

    public function new() {
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

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["product_id"])) {
            $prod = [];
            foreach($_POST["product_id"] as $k => $v) {
                $prod[$v] = $_POST["product_quantity"][$k];
            }
            $u_id = $_SESSION["USER"]->id;
            //echo $u_id;
            //show($prod);
            //echo $date;
            $w_id = 1;

            $plan = new Plannerproduction();

            //tu usunąć cały plan z tego dnia przed wstawieniem aktualizacji/nowego
            foreach($prod as $pid => $amount) {
                $que = ["date_plan" => "$date", "w_id" => $w_id, "p_id" => $pid, "amount" => $amount, "u_id" => $u_id];
                $plan->insert($que);
            }
        }


        $planned = new Plannerproduction();
        if(!empty($planned->getPlanned($date, 1))) {
            foreach ($planned->getPlanned($date, 1) as $key => $value) {
                $data["planned"][$value->id] = (array) $value;
            }
        }



        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = (array) $value;
        }

        $data["date_plan"] = $date;

        $this->view('planner.new', $data);
    }
}
