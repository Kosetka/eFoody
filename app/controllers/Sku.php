<?php

/**
 * GetCargo class
 */
class Sku
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $sku = new SkuModel;
        $data["sku"] = $sku->getSku();

        $this->view('sku', $data);
    }

    public function show() {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id = $URL[2];

        $sku = new SkuModel;
        $sku_show = $sku->getFullType($id);

        $products = new ProductsModel;
        $data["products"] = $products->getAllBySku($sku_show[0]->full_type);
        $alergen = new Alergen();
        foreach($alergen->getAlergens() as $ale) {
            $data["alergens"][$ale->id] = $ale;
        }
        $alergens = new Productalergens();
        foreach($alergens->getGrouped() as $ale) {
            $data["prod_alergens"][$ale->p_id] = $ale;
        }
        $this->view('sku.show', $data);
    }
}
