<?php

/**
 * GetCargo class
 */
class Carsgps
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('carsgps', $data);
    }

    public function live()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $car_driver = new Cardriver();
        $data["car_user"]= $car_driver->getAll();

        $api_key = new Apitokens();
        $data["key"] = $api_key->getToken("google_maps");

        $users = new User;
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $this->view('carsgps.live', $data);
    }

}
