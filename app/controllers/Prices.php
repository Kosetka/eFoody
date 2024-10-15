<?php

/**
 * GetCargo class
 */
class Prices
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }

        $products = new PriceModel();
        if(!empty($products->getCurrentPrice())) {
            foreach ($products->getCurrentPrice() as $product) {
                $data["prices"][$product->p_id] = (object) $product;
            }
        }
        $foodcost = new Foodcost();
        $data["foodcost"] = $foodcost->getPriceDetailedWithSauce(date("Y-m-d"));

        $this->view('prices', $data);
    }
    

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $data["state"] = "show";

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $p_id = $URL[2];

            $u_id = $_SESSION["USER"]->id;
            $date_from = $_POST["date_from"];
            $date_to = NULL;
            $production_cost = $_POST["production_cost"];
            $pr = $_POST["price"];
            $prs = 0;
            if(isset($_POST["priceshops"])) {
                $prs = $_POST["priceshops"];
            } else {
                $prs = 0;
            }
            $active = 1;

            $price = new PriceModel;
            if(!isset($URL[3])) {
                if(!empty($price->getLastPrice($p_id))) {
                    $last = $price->getLastPrice($p_id)[0]->date_to;
                    if(!isset($last)) {
                        $ndate = new DateTime($date_from);
                        $ndate->modify('-1 day');
                        $new_date_to = $ndate->format('Y-m-d')." 23:59:59";
                        $price->update($price->getLastPrice($p_id)[0]->id,["date_to" => $new_date_to]);
                    }
                }
            }
            $toUpdate = ["u_id" => $u_id, "p_id" => $p_id, "date_from" => "$date_from", "date_to" => $date_to, "active" => $active, "production_cost" => $production_cost, "price" => $pr, "priceshops" => $prs];
            if (isset($URL[3])) {
                $price_id = $URL[3];
                $toUpdate = ["production_cost" => $production_cost, "price" => $pr, "priceshops" => $prs];
                show($toUpdate);die;
                $price->update($price_id, $toUpdate, "id");
                $data["success"] = "Aktualizacja danych pomyślna";
            } else {
                $price->insert($toUpdate);
                $data["success"] = "Pomyślnie dodano nową cenę";
            }



        }

        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $p_id = $URL[2];
            $data["state"] = "add";
            if (isset($URL[3])) {
                // edit
                $data["state"] = "edit";
                $price_id = $URL[3];
            }
            $products = new PriceModel();
            if(!empty($products->getAllPrices($p_id))) {
                foreach ($products->getAllPrices($p_id) as $product) {
                    $data["prices"][$product->id] = (object) $product;
                    if (!empty($price_id) && $product->id == $price_id) {
                        $data["price"] = (object) $product;
                    }
                }
            }


        }

        $this->view('prices.edit', $data);
    }
}
