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
        if(!empty($products_list->getAll($_SESSION["date_planner"]))) {
            foreach ($products_list->getAll($_SESSION["date_planner"]) as $key => $value) {
                $data["planned"][$value->w_id][$value->p_id] = $value;
            }
        }

        // Tutaj ogarnąć sumowanie i wyświetlanie dobrze
        $products_list = new ProductsModel();
        foreach ($products_list->getAllSubProducts() as $key => $value) {
            $data["subproducts"][$value->id] = $value;
        }
        foreach ($data["p"] as $k => $v) {
            foreach ($data["subproducts"] as $k1 => $v1) {
                $data["sets"][$k][$k1] = [];
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

        //show($data);//die;
        //pobranie info o ostatnim ustawieniu stanów
        foreach ($data["subproducts"] as $product) {

            /*$amount = 0;
            if (isset($data["sets"][$product["id"]][0]->amount))
                $amount = $data["sets"][$product["id"]][0]->amount;


            $data["product_quantity"][$product["id"]]["set"] = $amount;*/
            /*$data["product_quantity"][$product["id"]]["scan"] = 0;
            $data["product_quantity"][$product["id"]]["add"] = 0;
            $data["product_quantity"][$product["id"]]["sub"] = 0;
            $data["product_quantity"][$product["id"]]["cargo"] = 0;
            $data["product_quantity"][$product["id"]]["return"] = 0;*/
        }
        //show($data);
        $this->view('planner.possibility', $data);
    }
}
