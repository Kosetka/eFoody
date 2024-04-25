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

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["p"][$id] = [];
        }

        $products_list = new ProductsModel();
        foreach($products_list->getAllSubProducts() as $key => $value) {
            $data["subproducts"][$value->id] = $value;
        }
        foreach($data["p"] as $k => $v) {
            foreach($data["subproducts"] as $k1 => $v1) {
                $data["sets"][$k][$k1] = [];
            }
        }
        $products_list = new ProductsModel();
        foreach($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }

        $recipes = new RecipesModel();
        foreach($recipes->getFullRecipes() as $key => $value) {
            $data["recipes"][$value->p_id][$value->sub_prod] = $value;
        }

        $prod = new ProductsQuantity();
        $temp = $prod->getAllSetAllwarehouse();
        //show($temp);
        foreach($temp as $k => $v) {
            foreach($v as $k1 => $v1) {
                $data["sets"][$v->w_id][$v->p_id] = $v;
            }
        }
        $temp = $prod->getAllAddSub();
        foreach($temp as $key => $value) {
            if($data["sets"][$value->w_id][$value->p_id]->date < $value->date) {
                if($value->transaction_type == "add") {
                    $data["sets"][$value->w_id][$value->p_id]->amount += $value->amount;
                }
                if($value->transaction_type == "sub") {
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
        show($data);
        $this->view('planner.possibility', $data);
    }
}
