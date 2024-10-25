<?php

/**
 * GetCargo class
 */
class Bonussystem
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $u_u_id = $_SESSION["USER"]->id;
            $bonus = new Bonuses;
            $date = $_POST["date"];
            $bonus->insert(["u_id" => $_POST["u_id"], "b_description" => $_POST["b_description"], "date" => "$date", "amount" => $_POST["amount"],"type" => $_POST["type"], "u_u_id" => $u_u_id]);
            $data['success'] = "Pomyślnie dodano premię lub karę.";
        }


        $users = new User;
        foreach ($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }
        $roles = new RolesNameModel();
        foreach ($roles->getAllRoles() as $role) {
            $data["roles"][$role->id] = $role;
        }

        $bonuses = new Bonuses();
        if(!empty($bonuses->getBonuses())) {
            foreach ($bonuses->getBonuses() as $bonus) {
                $data["bonuses"][$bonus->id] = $bonus;
            }
        }


        $this->view('bonussystem', $data);
    }

    public function add()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));

        $month = date("m");
        $year = date("Y");
        
        $data["show_table"] = false;
        if (isset($URL[2])) {
            $data["show_table"] = true;
            $month = $URL[2];
            $year = $URL[3];
        }

        if (isset($_GET["search"])) {
            $data["show_table"] = true;
            if (isset($_GET["month"])) {
                $month = $_GET["month"];
            }
            if (isset($_GET["year"])) {
                $year = $_GET["year"];
            }
        }
        $data["year"] = $year;
        $data["month"] = $month;

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $roles = new RolesNameModel();
        foreach ($roles->getAllRoles() as $role) {
            $data["roles"][$role->id] = $role;
        }

        $users = new User;
        foreach ($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
        }

        $rates = new Payrate();
        if(!empty($rates->getRates($month, $year))) {
            foreach ($rates->getRates($month, $year) as $rate) {
                $data["rates"][$rate->u_id][] = $rate;
            }
        }


        $workhour = new Workhours();
        if (!empty($workhour->getMonth($month, $year))) {
            foreach ($workhour->getMonth($month, $year) as $wh) {
                $data["accepted"][$wh->date][$wh->u_id] = $wh;
                if (!isset($data["hours"][$wh->u_id])) {
                    $data["hours"][$wh->u_id] = 0;
                }
                $data["hours"][$wh->u_id] += $wh->accept_time;

                if (isset($data["rates"][$wh->u_id])) {
                    foreach ($data["rates"][$wh->u_id] as $rt) {
                        if ($rt->date_from <= $wh->date) {
                            if ($rt->date_to == NULL || $rt->date_to >= $wh->date) {
                                if ($rt->type == 2) {
                                    if (!isset($data["pay"][$wh->u_id])) {
                                        $data["pay"][$wh->u_id] = 0;
                                    }
                                    $data["pay"][$wh->u_id] += getPayment($wh->accept_time, $rt->rate);
                                }
                            }
                        }
                    }
                }
            }
        }


        $this->view('bonussystem', $data);
    }

}
