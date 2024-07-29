<?php

/**
 * GetCargo class
 */
class Cars
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $data["cars"] = [];

        $car_driver = new Cardriver();
        $data["car_user"]= $car_driver->getAll();

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $cars = new Carsmodel();
        if(!empty($cars->getAll())) {
            foreach ($cars->getAll() as $car) {
                $data["cars"][$car->id] = $car;
            }
        }

        $this->view('cars', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //show($_POST);die;
            if(!isset($_POST["active"])) {
                $_POST["active"] = 0;
            }
            $car = new Carsmodel;
            $temp = $car->getCar($_POST["objectno"]);
            if(isset($temp)) {
                $car->insert($_POST);
                $data['success'] = "Samochód został dodany";
            } else {
                $data['error'] = "Samochód nie został dodany";
            }

            unset($_POST);
            redirect('cars');
        }
        $data["edit"] = False;

        $this->view('cars.new', $data);
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

            if(isset($_POST["newadd"])) {
                if(!isset($_POST["active"])) {
                    $_POST["active"] = 0;
                }
                $card = new Carsmodel;
                $card->update($id, $_POST);
                $data['success'] = "Edycja samochodu pomyślna";
    
                unset($_POST);
                redirect('cars');
            } else if(isset($_POST["caruser"])){
                $car_u = new Cardriver;
                $date_from = $_POST["date_from"];
                if(!empty($_POST["date_to"])) {
                    $date_to = $_POST["date_to"];
                } else {
                    $date_to = NULL;
                }
                if(!empty($car_u->getLastOwner($id))) {
                    $last = $car_u->getLastOwner($id)[0]->date_to;
                    if(!isset($last)) {
                        $ndate = new DateTime($date_from);
                        $ndate->modify('-1 day');
                        $new_date_to = $ndate->format('Y-m-d');
                        $car_u->update($car_u->getLastOwner($id)[0]->id,["date_to" => $new_date_to]);
                    }
                }

                $car_u->insert(["u_id" => $_POST["u_id"], "car_id" => $id, "date_from" => "$date_from", "date_to" => $date_to]);
                $data['success'] = "Pomyślnie przypisano samochód";

            } else if(isset($_POST["input_edit"])) {
                /*$date_from = $_POST["date_from"];
                if(!empty($_POST["date_to"])) {
                    $date_to = $_POST["date_to"];
                } else {
                    $date_to = NULL;
                }
                $card_u = new Carduser;
                $card_u->update($card_id,["date_from" => $date_from, "date_to" => $date_to]);

                $data['success'] = "Edycja pomyślna";*/
            }
        }
        $data["edit"] = True;

        $cars = new Carsmodel;
        $data["car"] = $cars->getCar($id)[0];

        $car = new Cardriver;
        $data["car_users"] = $car->getCarUsers($id);

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }
        

        $this->view('cars.new', $data);
    }

}
