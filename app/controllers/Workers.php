<?php

/**
 * Cities class
 */
class Workers
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('home', $data);
    }

    public function live()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $int = [];
        $work = [];
        $break = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $date = $URL[2];
            $data["date"] = $date;
        } else {
            $data["date"] = date("d-m-Y");
            $date = date("Y-m-d");
        }



        $users = new User();
        foreach($users->getAllActiveUsers() as $user) {
            $data["users"][$user->id] = $user;
            $int[$user->id] = 0;
            $work[$user->id] = 0;
            $break[$user->id] = 0;
        }

        $cardscan = new Cardscan();
        $data["scans"] = $cardscan->getScanDate($date);

        $data["scans_ok"] = [];
        foreach($data["scans"] as $scan) {
            if($scan->user_id <> 0) {
                if($scan->status == "in") {
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["in"] = $scan->date;
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["out"] = "";
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["w_id_in"] = $scan->w_id;
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["w_id_out"] = "";
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["card_in"] = $scan->card_name;
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["card_out"] = "";
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["user"] = $scan->user_id;
    
                    if($int[$scan->user_id] > 0) {
                        $datetime1 = new DateTime($data["scans_ok"][$scan->user_id][$int[$scan->user_id]-1]["out"]);
                        $datetime2 = new DateTime($data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["in"]);
                        $interval = $datetime2->getTimestamp() - $datetime1->getTimestamp();
                        $break[$scan->user_id] += $interval;
                    }
    
                } else {
                    //out
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["out"] = $scan->date;
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["card_out"] = $scan->card_name;
                    $data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["w_id_out"] = $scan->w_id;
    
                    $datetime1 = new DateTime($data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["in"]);
                    $datetime2 = new DateTime($data["scans_ok"][$scan->user_id][$int[$scan->user_id]]["out"]);
                    $interval = $datetime2->getTimestamp() - $datetime1->getTimestamp();
                    $work[$scan->user_id] += $interval;
    
                    $int[$scan->user_id]++;
                }
            }
        }
        $data["work"] = $work;
        $data["break"] = $break;

        //show($data["break"]);
        //show($data["work"]);

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $roles = new RolesNameModel();
        foreach($roles->getAllRoles() as $role) {
            $data["roles"][$role->id] = $role;
        }

        $this->view('workers.live', $data);
    }

    public function day()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('workers.day', $data);
    }

    public function month()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));

        $month = date("m");
        $year = date("Y");

        if (isset($URL[2])) {
            $month = $URL[2];
            $year = $URL[3];
        }

        if (isset($_GET["search"])) {
            if (isset($_GET["month"])) {
                $month = $_GET["month"];
            }
            if (isset($_GET["year"])) {
                $year = $_GET["year"];
            }
        }


        $users = new User();
        foreach($users->getAllActiveUsers() as $user) {
            $data["users"][$user->id] = $user;
            $int[$user->id] = 0;
            $work[$user->id] = 0;
            $break[$user->id] = 0;
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $roles = new RolesNameModel();
        foreach($roles->getAllRoles() as $role) {
            $data["roles"][$role->id] = $role;
        }

        $holidays = new Holidaysmodel();
        foreach($holidays->getMonth($month,$year) as $holiday) {
            $data["holidays"][$holiday->date] = $holiday;
        }

        $data["month"] = $month;
        $data["year"] = $year;

                    
        //show($data);die;

        $this->view('workers.month', $data);
    }

}