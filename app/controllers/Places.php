<?php

/**
 * Company class
 */
class Places
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $companies = new Companies();
        $data["companies"] = $companies->getAll("companies");

        $users_list = new User();
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities`";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }


        $this->view('places', $data);
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
            //$result = $user->query($query);
//$_SESSION["USER"]->u_warehouse = $id_warehouse;


            $this->view('company.setDepartment', $result);

        }
    }

    public function my()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $data["places"] = [];
        $u_id = $_SESSION["USER"]->id;

        $data["companies"] = [];

        $companies = new Companies();
        if(!empty($companies->getMyCompanies($u_id))) {
            foreach($companies->getMyCompanies($u_id) as $key => $value) {
                $data["companies"][$value->id] = $value;
            }
        }

        $places = new PlacesModel();
        if(!empty($places->getMyPlaces($u_id))) {
            foreach($places->getMyPlaces($u_id) as $key => $value) {
                $data["places"][$value->c_id] = $value;
            }
        }

        $sold_list = new Sales();
        if(!empty($sold_list->getSoldForMap($u_id))) { //? powodowało błąd, nie wiem czy działa po tej zmianie skanowanie
            foreach($sold_list->getSoldForMap($u_id) as $key => $value) {
                $data["soldCompany"][$value->c_id] = $value;
            }

        }
        

        $data["not_visited"] = array_diff_key($data["companies"], $data["places"]);

        $this->view('places.my', $data);
    }

    public function setvisit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $c_id = $URL[2];
        $u_id = $_SESSION["USER"]->id;

        if (empty($_SESSION['USER']))
            redirect('login');

        $scan = new PlacesModel;
        $que = ["u_id" => $u_id, "c_id" => $c_id, "sold" => 0];
        $scan->insert($que);
        $com = "Pomyślnie zaktualizowano wizytę w firmie ID: $c_id";

        return $com;
    }
}
