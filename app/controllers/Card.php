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

    public function errors()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $carderr = new Cardlogger();
        $data["last_errors"] = $carderr->getAll(50);

        $city = new Shared();
        foreach($city->getCitiesAndWarehouse() as $city) {
            $data["city"][$city->id] = $city;
        }

        $this->view('card.errors', $data);
    }

    public function users()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $user_id = $URL[2];
        }
        if (isset($URL[3])) {
            $card_id = $URL[3];
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if(isset($_POST["input_edit"])) {
                $date_from = $_POST["date_from"];
                if(!empty($_POST["date_to"])) {
                    $date_to = $_POST["date_to"];
                } else {
                    $date_to = NULL;
                }
                $card_u = new Carduser;
                $card_u->update($card_id,["date_from" => $date_from, "date_to" => $date_to]);

                $data['success'] = "Edycja pomyślna";
            } else {
                if(!isset($_POST["status"])) {
                    $_POST["status"] = 0;
                }
                $card_u = new Carduser;
                $date_from = $_POST["date_from"];
                if(!empty($_POST["date_to"])) {
                    $date_to = $_POST["date_to"];
                } else {
                    $date_to = NULL;
                }
                $card_u->insert(["u_id" => $user_id, "card_id" => $_POST["card_id"], "date_from" => "$date_from", "date_to" => $date_to]);
                $data['success'] = "Pomyślnie przypisano kartę";
            }

        }

        $card = new Cards;
        foreach($card->getAll() as $c) {
            $data["cards"][$c->card_id] = $c;
        }
        $card_users = new Carduser;
        foreach($card_users->getFreeCards() as $cus) {
            $data["free_cards"][$cus->card_id] = $cus;
        }

        if (isset($card_id)) {
            $data["card_data"] = $card_users->getCardInfo($card_id);
        }

        $data["user_id"] = $user_id;
        $data["user_cards"] = $card_users->getUserCards($user_id);

        $this->view('card.users', $data);
    }
}

