<?php

/**
 * GetCargo class
 */
class GetCargo
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        // do zrobienia
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $cargo = new Cargo;
            $u_id = $_SESSION["USER"]->id;

            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $toUpdate = ["w_id" => $_POST["w_id"], "u_id" => $u_id, "p_id" => $key, "amount" => $value];
                    $cargo->insert($toUpdate);
                }
            }
            $data['success'] = "Produkty zostały pobrane";
            unset($_POST);

            $data['errors'] = $cargo->errors;
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $products_list = new ProductsModel();
        $data["products"] = $products_list->getAllFullProducts();

        $this->view('getcargo', $data);
    }
}
