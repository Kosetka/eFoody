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
        foreach($users->getAllActiveUsersSorted() as $user) {
            $data["users"][$user->id] = $user;
            $int[$user->id] = 0;
            $work[$user->id] = 0;
            $break[$user->id] = 0;
        }

        $cardscan = new Cardscan();
        $data["scans"] = $cardscan->getScanDate($date);

        $data["scans_ok"] = [];
        if(!empty($data["scans"])) {
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
        }

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

        $workhour = new Workhours();
        if(!empty($workhour->getMonth($month, $year))) {
            foreach($workhour->getMonth($month, $year) as $wh) {
                $data["accepted"][$wh->date][$wh->u_id] = $wh;
            }
        }
        //show($data["accepted"]);die;

        $data["month"] = $month;
        $data["year"] = $year;

                    
        //show($data);die;

        $this->view('workers.month', $data);
    }

    public function person()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $month = date("m");
        $year = date("Y");
        $u_id = 0;

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));

        if (isset($URL[2])) {
            $u_id = $URL[2];
            $month = $URL[3];
            $year = $URL[4];
        }
        $data["show_calendar"] = false;

        if (isset($_GET["search"])) {
            $data["show_calendar"] = true;
            if (isset($_GET["u_id"])) {
                $u_id = $_GET["u_id"];
            }
            if (isset($_GET["month"])) {
                $month = $_GET["month"];
            }
            if (isset($_GET["year"])) {
                $year = $_GET["year"];
            }
        }

        if(isset($_POST["save_add"])) {
            $accept_u_id = $_SESSION["USER"]->id;
            $diff_time = timeDiffInSeconds($_POST["accept_out"], $_POST["accept_in"]);
            $wh = new Workhours();
            $que = [
                "u_id" => $_POST["u_id"],
                "accept_u_id" => $accept_u_id,
                "hour_first_in" => "00:00:00",
                "hour_first_out" => "00:00:00",
                "work_seconds" => 0,
                "break_seconds" => 0,
                "accept_in" => $_POST["accept_in"],
                "accept_out" => $_POST["accept_out"],
                "accept_time" => $diff_time,
                "date" => $_POST["date_sel"],
            ];
            $wh->insert($que);
        }

        if(isset($_POST["save_edit"])) {
            $accept_u_id = $_SESSION["USER"]->id;
            $row_id = $_POST["row_id"];
            $diff_time = timeDiffInSeconds($_POST["accept_out"], $_POST["accept_in"]);
            $wh = new Workhours();
            $que = [
                "accept_u_id" => $accept_u_id,
                "accept_in" => $_POST["accept_in"],
                "accept_out" => $_POST["accept_out"],
                "accept_time" => $diff_time
            ];
            $wh->update($row_id, $que);
        }


        $users = new User();
        foreach($users->getAllActiveUsers() as $user) {
            $data["users"][$user->id] = $user;
            $int[$user->id] = 0;
        }
        $work = [];
        $break = [];

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
        $data["accepted"] = [];
        if($u_id != 0) {
            $workhour = new Workhours();
            if(!empty($workhour->getPerson($month, $year, $u_id))) {
                foreach($workhour->getPerson($month, $year, $u_id) as $wh) {
                    $data["accepted"][$wh->date] = $wh;
                }
            }
        }

        $cardscan = new Cardscan();
        $data["scans"] = $cardscan->getScanMonth($month, $year, $u_id);

        
        $data["scans_ok"] = [];
        if(!empty($data["scans"])) {
            foreach($data["scans"] as $scan) {
                $dat = subDay($scan->date);
                if(!isset($int[$dat])) {
                    $int[$dat] = 0;
                }
                if($scan->user_id <> 0) {
                    if($scan->status == "in") {
                        $data["scans_ok"][$dat][$int[$dat]]["in"] = $scan->date;
                        $data["scans_ok"][$dat][$int[$dat]]["out"] = "";
                        $data["scans_ok"][$dat][$int[$dat]]["w_id_in"] = $scan->w_id;
                        $data["scans_ok"][$dat][$int[$dat]]["w_id_out"] = "";
                        $data["scans_ok"][$dat][$int[$dat]]["card_in"] = $scan->card_name;
                        $data["scans_ok"][$dat][$int[$dat]]["card_out"] = "";
                        $data["scans_ok"][$dat][$int[$dat]]["user"] = $scan->user_id;
        
                        
                        //$datetime1 = new DateTime($data["scans_ok"][$dat][$int[$scan->user_id]-1]["out"]);
                        //$datetime2 = new DateTime($data["scans_ok"][$dat][$int[$scan->user_id]]["in"]);
                        //$interval = $datetime2->getTimestamp() - $datetime1->getTimestamp();
                        
                        if(!isset($work[$dat])) {
                            $work[$dat] = 0;
                        } 
        
                    } else {
                        //out
                        $data["scans_ok"][$dat][$int[$dat]]["out"] = $scan->date;
                        $data["scans_ok"][$dat][$int[$dat]]["card_out"] = $scan->card_name;
                        $data["scans_ok"][$dat][$int[$dat]]["w_id_out"] = $scan->w_id;
        
                        $datetime1 = new DateTime($data["scans_ok"][$dat][$int[$dat]]["in"]);
                        $datetime2 = new DateTime($data["scans_ok"][$dat][$int[$dat]]["out"]);
                        $interval = $datetime2->getTimestamp() - $datetime1->getTimestamp();
                        $work[$dat] += $interval;
                        $int[$dat]++;
                    }
                }
            }
        }
        $data["work"] = $work;
        $data["break"] = $break;
        
        //show($data["scans_ok"]);
        //show($work);

        $data["month"] = $month;
        $data["year"] = $year;
        $data["u_id"] = $u_id;

        $holidays = new Holidaysmodel();
        $data["holidays"] = $holidays->getAll();
                    
        //show($data);die;

        $this->view('workers.person', $data);
    }
    public function hours()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));

        if (isset($URL[2])) {
            $date = $URL[2];
        }

        if (isset($_GET["search"])) {
            if (isset($_GET["date"])) {
                $date = $_GET["date"];
                $data["show_list"] = true;
            }
        } else {
            $date = date("Y-m-d");
            $data["show_list"] = false;
        }
        if(isset($_POST["hours_accept"])) {
            $workhour = new Workhours();

            $u_id = $_POST["u_id"];
            $accept_u_id = $_POST["accept_id"];
            $date_sel = $_POST["date_sel"];
            $hour_first_in = $_POST["hour_first_in"];
            $hour_first_out = $_POST["hour_first_out"];
            $work_seconds = $_POST["work_seconds"];
            $break_seconds = $_POST["break_seconds"];
            $accept_in = $_POST["accept_in"];
            $accept_out = $_POST["accept_out"];
            if($accept_in == "") {
                $accept_in = $hour_first_in;
                $accept_out = $hour_first_out;
                $accept_time = $work_seconds;
            } else {
                $accept_time = timeDiffInSeconds($accept_in,$accept_out);
                
            }
            $que = [
                "u_id" => $u_id,
                "accept_u_id" => $accept_u_id,
                "date" => $date_sel,
                "hour_first_in" => $hour_first_in,
                "hour_first_out" => $hour_first_out,
                "work_seconds" => $work_seconds,
                "break_seconds" => $break_seconds,
                "accept_in" => $accept_in,
                "accept_out" => $accept_out,
                "accept_time" => $accept_time
            ];
            $workhour->insert($que);

            //show($que);
            //show($_POST);
            //die;
        }

        $users = new User();
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = $user;
            $int[$user->id] = 0;
            $work[$user->id] = 0;
            $break[$user->id] = 0;
        }

        $cardscan = new Cardscan();
        $data["scans"] = $cardscan->getScanDate($date);

        $data["scans_ok"] = [];
        if(!empty($data["scans"])) {
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
        }
        $data["work"] = $work;
        $data["break"] = $break;


        $workhour = new Workhours();
        if(!empty($workhour->getByDate($date))) {
            foreach($workhour->getByDate($date) as $wh) {
                $data["accepted"][$wh->u_id] = $wh;
            }
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

        $data["date"] = $date;
                    



        //show($data);die;

        $this->view('workers.hours', $data);
    }
}