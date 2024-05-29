<?php

/**
 * Company class
 */
class Roles
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $roles = new RolesNameModel();
        $data["roles"] = $roles->getAllRoles();

        $this->view('roles', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $roles = new RolesNameModel;
            $roles->insert($_POST);
            $data['success'] = "Rola została pomyślnie utworzona";
        }

        $roles = new RolesNameModel();
        $data["roles"] = $roles->getAllRoles();

        $this->view('roles.new', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $id = $URL[2];
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if(!isset($_POST["r_active"])) {
                $_POST["r_active"] = 0;
            }
            $roles = new RolesNameModel;
            $roles->update($id, $_POST);
            $data['success'] = "Edycja roli pomyślna";
        }

        $roles = new RolesNameModel();
        $data["roles"] = $roles->getRoleById($id)[0];

        $this->view('roles.edit', $data);
    }
}
