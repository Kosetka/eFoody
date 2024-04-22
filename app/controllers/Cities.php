<?php

/**
 * Cities class
 */
class Cities
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $cities = new CityModel;
        $data = $cities->getAll("cities");

        $this->view('cities', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $city = new CityModel;
            if ($city->validate($_POST)) {
                $city->insert($_POST);
                $data['success'] = "Miasto zostało pomyślnie dodane";
                //redirect('signup');
            }

            $data['errors'] = $city->errors;
        }

        $this->view('cities.new', $data);
    }
    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_city = $URL[2];
            $city = new CityModel;
            $data["city"] = $city->first(["id" => $id_city]);

            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                if (!isset($_POST["c_active"]))
                    $_POST["c_active"] = 0;
                $city->update($id_city, $_POST);
                $data['success'] = "Edycja miasta pomyślna";
                //redirect('signup');
                $city = new CityModel;
                $data["city"] = $city->first(["id" => $id_city]);

                $data['errors'] = $city->errors;

            }
        }

        $this->view('cities.edit', $data);
    }
}