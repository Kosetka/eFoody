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
        $sku = new Skumodel;
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

        $sku = new Skumodel;
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

    public function edit() {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id = $URL[2];

        $sku = new Skumodel;

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_GET)) {

            $s_type = $_POST["type"];
            $s_name = $_POST["name"];
            $s_parent = $_POST["parent"];
            $s_full_type = $_POST["parent"] . "_" . $_POST["type"];
            $s_priceshops = $_POST["priceshops"];
            $s_pricefixed = $_POST["pricefixed"];
            $toUpdate = [
                "type" => $s_type, 
                "name" => $s_name, 
                "parent" => $s_parent, 
                "full_type" => $s_full_type,
                "priceshops" => $s_priceshops,
                "pricefixed" => $s_pricefixed
            ];
            $sku->update($id, $toUpdate, "id");
            $data["success"] = "Aktualizacja danych pomyślna";
            redirect(path: 'sku');
        }

        if (!empty($_GET)) {
            $data["sku"] = $sku->getFullType($id)[0];
        }

        
        $data["sku_full"] = $sku->getSku();
        



        $this->view('sku.edit', $data);
    }
}
