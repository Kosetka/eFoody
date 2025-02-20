<?php

/**
 * GetCargo class
 */
class Upselprices
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $products = new ProductsModel();
        foreach ($products->getAllFullProductsUpsel() as $product) {
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
    

}
