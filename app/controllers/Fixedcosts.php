<?php

/**
 * Sale class
 */
class Fixedcosts
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $costs = new Fixedcostsmodel;
        $data["costs"] = $costs->getAll();
    
        $this->view('fixedcosts', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $cost = new Fixedcostsmodel;

            $date_from = $_POST["date_from"];
            $type = $_POST["type"];
            $date_to = $_POST["date_to"];
            $date = $_POST["single_date"];
            $cost_name = $_POST["cost_name"];
            $price = $_POST["price"];
            $category = $_POST["category"];
            $method = $_POST["method"];
            if(!isset($_POST["active"])) {
                $active = 0;
            } else {
                $active = $_POST["active"];
            }
            if(empty($_POST["single_date"])) {
                $date = NULL;
            }
            if(empty($_POST["date_from"])) {
                $date_from = NULL;
            }
            if(empty($_POST["date_to"])) {
                $date_to = NULL;
            }
            $description = $_POST["description"];
            $toUpdate = ["date_from" => $date_from, "date_to" => $date_to, "date" => $date, "name" => "$cost_name", 
                            "price" => $price, "category" => $category, 'method' => $method, 'active' => $active, 'description' => "$description", 'type' => $type];
            $cost->insert($toUpdate);

            $data['success'] = "Koszt został dodany";
            unset($_POST);
            redirect('fixedcosts');
        }
        $data["edit"] = False;

        $this->view('fixedcosts.new', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $id = $URL[2];
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //show($_POST);
            //die;
            $cost = new Fixedcostsmodel;

            $date_from = $_POST["date_from"];
            $type = $_POST["type"];
            $date_to = $_POST["date_to"];
            $date = $_POST["single_date"];
            $cost_name = $_POST["cost_name"];
            $price = $_POST["price"];
            $category = $_POST["category"];
            $method = $_POST["method"];
            if(!isset($_POST["active"])) {
                $active = 0;
            } else {
                $active = $_POST["active"];
            }
            if(empty($_POST["single_date"])) {
                $date = NULL;
            }
            if(empty($_POST["date_from"])) {
                $date_from = NULL;
            }
            if(empty($_POST["date_to"])) {
                $date_to = NULL;
            }
            $description = $_POST["description"];
            $toUpdate = ["date_from" => $date_from, "date_to" => $date_to, "date" => $date, "name" => "$cost_name", 
                            "price" => $price, "category" => $category, 'method' => $method, 'active' => $active, 'description' => "$description", 'type' => $type];
            $cost->update($id, $toUpdate);

            $data['success'] = "Koszt został dodany";
            unset($_POST);
            redirect('fixedcosts');

        }

        $costs = new Fixedcostsmodel;
        $data["cost"] = $costs->getByID($id);
        $data["edit"] = True;

        $this->view('fixedcosts.new', $data);
    }
}