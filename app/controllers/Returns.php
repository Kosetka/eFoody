<?php

/**
 * Returns class
 */
class Returns
{
    use Controller;
    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $u_id = $_SESSION["USER"]->id;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $returns = new ReturnsModel;

            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $toUpdate = ["w_id" => $_POST["w_id"], "u_id" => $u_id, "p_id" => $key, "amount" => $value];
                    $returns->insert($toUpdate);
                }
            }
            $data['success'] = "Produkty zostały zwrócone do magazynu";
            unset($_POST);
            $data['errors'] = $returns->errors;
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $products_list = new ProductsModel();
        $prod_list = [];
        $prod_list_sold = [];
        $prod_list_returned = [];
        $data["products"] = $products_list->getAllFullProducts();
        foreach ($data["products"] as $prod) {
            $prod_list[$prod->id] = 0;
            $prod_list_sold[$prod->id] = 0;
            $prod_list_returned[$prod->id] = 0;
        }

        $today = date("Y-m-d");
        $date_from = $today . " 00:00:00";
        $date_to = $today . " 23:59:59";
        $products_list = new Cargo();
        $data["cargo"] = $products_list->getAllFullProductsDate($u_id, $date_from, $date_to);

        if (!is_bool($data["cargo"])) {
            foreach ($data["cargo"] as $carg) {
                $prod_list[$carg->p_id] += $carg->amount;
            }
        }
        $data["prod_availability"] = $prod_list;

        $products_list = new Sales();
        $data["sold"] = $products_list->getSoldProducts($u_id);

        if (!is_bool($data["sold"])) {
            foreach ($data["sold"] as $sold) {
                $prod_list_sold[$sold->p_id] += $sold->s_amount;
            }
        }
        $data["prod_availability"] = $prod_list;
        $data["prod_availability_sold"] = $prod_list_sold;

        $products_list = new ReturnsModel();
        $data["return"] = $products_list->getAllFullProducts($u_id);

        if (!is_bool($data["return"])) {
            foreach ($data["return"] as $return) {
                $prod_list_returned[$return->p_id] += $return->amount;
            }
        }
        $data["prod_availability"] = $prod_list;
        $data["prod_availability_sold"] = $prod_list_sold;
        $data["prod_availability_returned"] = $prod_list_returned;

        $this->view('returns.new', $data);
    }
}
