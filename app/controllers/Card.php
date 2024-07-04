<?php

/**
 * Cities class
 */
class Card
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $cards = new Cards();
        $data["cards"]= $cards->getAll();

        $card_user = new Carduser();
        $data["card_user"]= $card_user->getAll();

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $this->view('cards', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if(!isset($_POST["status"])) {
                $_POST["status"] = 0;
            }
            $card = new Cards;
            $temp = $card->getCard($_POST["card_id"]);
            if(isset($temp)) {
                $card->insert($_POST);
                $data['success'] = "Karta została dodana";
            } else {
                $data['error'] = "Karta nie została dodana";
            }

            unset($_POST);
            redirect('card');
        }
        $data["edit"] = False;

        $carderr = new Cardlogger();
        $data["last_errors"] = $carderr->getLast(5);

        $city = new Shared();
        foreach($city->getCitiesAndWarehouse() as $city) {
            $data["city"][$city->id] = $city;
        }

        $this->view('cards.new', $data);
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

            if(!isset($_POST["status"])) {
                $_POST["status"] = 0;
            }
            $card = new Cards;
            $temp = $card->getCard($_POST["card_id"]);
            if(isset($temp)) {
                $card->update($id, $_POST);
                $data['success'] = "Edycja karty pomyślna";
            } else {
                $data['error'] = "Błąd przy edycji karty";
            }

            unset($_POST);
            redirect('card');
        }
        $data["edit"] = True;

        $cards = new Cards;
        if(!empty($cards->getCardId($id))) {
            $data["card"] = $cards->getCardId($id);
        } else {
            $data["card"] = (object) ["card_id" => "", "status" => 0];
        }

        $this->view('cards.new', $data);
    }
}

