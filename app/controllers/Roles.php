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
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["role"])) {
            if(!isset($_POST["r_active"])) {
                $_POST["r_active"] = 0;
            }
            $roles = new RolesNameModel;
            $roles->update($id, $_POST);
            $data['success'] = "Edycja roli pomyślna";
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["prepared_items"])) {

            $l_access = new Linksaccess;
            $l_access->delete($id,"r_id");

            foreach($_POST["prepared_items"] as $lid) {
                $que = ["l_id" =>$lid, "r_id" => $id];
                $l_access->insert($que);
            }

        }

        $l_access = new Linksaccess;
        if(!empty($l_access->getAccessByRole($id))) {
            foreach($l_access->getAccessByRole($id) as $l_a) {
                $data["access"][$l_a->l_id] = $l_a->l_id;
            }
        }

        $links = new Linksmodel();
        foreach ($links->getLinks() as $link) {
            $temp[$link->id] = (array) $link;
        }
        $hierarchy = buildHierarchy($temp);
        $data["links"] = $hierarchy;

        $roles = new RolesNameModel();
        $data["roles"] = $roles->getRoleById($id)[0];

        $this->view('roles.edit', $data);
    }
}
