<?php

/**
 * home class
 */
class TestView
{
    use Controller;

    public function index()
    {

        $products = new ProductsModel;
        $temp = $products->getAll("products");
        foreach ($temp as $key => $value) {
            $data["products"][$value->id] = $value;
        }

        show($temp);
        die;

        $date_from = "2024-05-16 00:00:00";
        $date_to = "2024-05-16 23:59:59";
        $u_id = 3;

        $companies_list = new Companies();
        $temp = $companies_list->getAllCompanies("companies");
        foreach ($temp as $key => $value) {
            $data["companies"][$value->id] = $value;
        }

        $cargo_list = new Cargo();
        $data["cargo"] = $cargo_list->getAllFullProductsDate($u_id, $date_from, $date_to);

        $sold_list = new Sales();
        $data["sold"] = $sold_list->getSoldProductsDate($u_id, $date_from, $date_to);

        $this->view('test', $data);
    }
}
