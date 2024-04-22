<?php

/**
 * users class
 */
class Users
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $users = new UsersModel();
        $users->getAllUsers();
        $data["users"] = $users->users;

        $role = new RolesNameModel;
        $data["roles"] = $role->getRoles();

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $this->view('users', $data);
    }

    public function setDepartment()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_warehouse = $URL[2];
            $id_user = $_SESSION["USER"]->id;
            $query = "UPDATE users SET u_warehouse = $id_warehouse WHERE id = $id_user LIMIT 1;";
            $user = new UsersModel();
            $result = $user->query($query);
            $_SESSION["USER"]->u_warehouse = $id_warehouse;


            $this->view('users.setDepartment', $result);

        }
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $user_id = $URL[2];
            $user = new User();
            $warehouse_access = new WarehouseAccessModel();
            if (isset($_POST["userEdit"])) {
                $user->update($user_id, $_POST);
                $u_warehouse = $_POST["u_warehouse"];
                $update_data = ["u_id" => $user_id, "w_id" => $u_warehouse];
                $relationExist = $warehouse_access->first($update_data);
                if (!$relationExist) {
                    $warehouse_access->insert($update_data);
                }
                $data['success'] = "Edycja konta pomyślna!";
            } elseif (isset($_POST["warehouseEdit"])) {
                $query = "delete from warehouse_access where u_id = $user_id";
                $warehouse_access->query($query);
                foreach ($_POST["check"] as $k => $v) {
                    $update_data = ["u_id" => $user_id, "w_id" => $v];
                    $warehouse_access->insert($update_data);
                }
                $data['success_warehouse'] = "Edycja magazynów pomyślna!";
                //edycja dolengo formularza
            }
        }

        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $user_id = $URL[2];
            $user = new User();
            $data["user"] = $user->getOne("users", $user_id)[0];
            $roles_name = new RolesNameModel();
            $roles_name->getRoles();
            $data["roles"] = $roles_name->roles;
            $cities = new Shared();
            $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
            $temp["cities"] = $cities->query($query);
            foreach ($temp["cities"] as $city) {
                $data["cities"][$city->id] = (array) $city;
            }
            $cities2 = new Shared();
            $query2 = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city INNER JOIN warehouse_access as a ON a.w_id = w.id WHERE u_id = $user_id ORDER BY a.w_id ASC";
            $temp2["cities"] = $cities2->query($query2);
            $data["cityList"] = [];
            foreach ($temp2["cities"] as $city2) {
                $data["cityList"][$city2->id] = $city2;
            }

            $this->view('users.edit', $data);
        }
    }

}
