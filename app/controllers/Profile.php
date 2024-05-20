<?php

/**
 * GetCargo class
 */
class Profile
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('profile', $data);
    }

    public function camera()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $u_id = $_SESSION["USER"]->id;
        $cam = $_SESSION["USER"]->camera;
        $data["cam"] = $cam;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = new User();
            $user->update($u_id, ["camera" => $_POST["camera"]]);
            $_SESSION["USER"]->camera = $_POST["camera"];
        }

        $this->view('profile.camera', $data);
    }

}
