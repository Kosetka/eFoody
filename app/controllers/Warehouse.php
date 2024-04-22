<?php

/**
 * warehouse class
 */
class Warehouse
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $warehouses = new WarehouseModel;
        $data["warehouses"] = $warehouses->getAll("warehouses");
        $cities = new CityModel;
        $temp = $cities->getAll("cities");
        foreach ($temp as $key => $value) {
            $data["cities"][$value->id] = $value;
        }
        $this->view('warehouse', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $cities = new CityModel;
        $temp = $cities->getAll("cities");
        foreach ($temp as $key => $value) {
            $data["cities"][$value->id] = $value;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $warehouse = new WarehouseModel;
            if ($warehouse->validate($_POST)) {
                $warehouse->insert($_POST);
                $data['success'] = "Magazyn został pomyślnie dodany";
                //redirect('signup');
            }

            $data['errors'] = $warehouse->errors;
        }
        $this->view('warehouse.new', $data);
    }
    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        if (!empty($_GET)) {

            /*$cities = new Shared();
            $query = "SELECT * FROM `cities` as c RIGHT JOIN `warehouses` as w ON c.id = w.id_city";
            $temp["cities"] = $cities->query($query);
            foreach ($temp["cities"] as $city) {
                $data["cities"][$city->id] = (array) $city;
            }*/

            $city = new CityModel;
            $temp_city = $city->getAll("cities");
            foreach ($temp_city as $t => $v) {
                $data["cities"][$v->id] = $v;
            }



            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_warehouse = $URL[2];
            $warehouse = new WarehouseModel;
            $data["warehouse"] = $warehouse->first(["id" => $id_warehouse]);

            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                if (!isset($_POST["w_active"]))
                    $_POST["w_active"] = 0;
                $warehouse->update($id_warehouse, $_POST);
                $data['success'] = "Edycja magazynu pomyślna";
                //redirect('signup');
                $warehouse = new WarehouseModel;
                $data["warehouse"] = $warehouse->first(["id" => $id_warehouse]);

                $data['errors'] = $warehouse->errors;

            }
        }

        $this->view('warehouse.edit', $data);
    }
}
