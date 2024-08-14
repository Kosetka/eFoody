<?php

/**
 * Returns class
 */
class Fleetreport
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];


        $this->view('reports.all', $data);
    }

    public function day()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));

        //show($URL);
        $day = date("Y-m-d");
        $data = [];

        $type = "show";
        $send = 0;
        $data["hide"] = false;

        if(isset($URL[2])) {
            $type = $URL[2];
            $data["hide"] = true;
            $day = date("Y-m-d", strtotime("-1 day"));
        }

        if ($type == "send") {
            $send = 1;
            if (isset($URL[3])) {
                $day = $URL[3];
            }
            //show($URL);
            $raport_id = 113; 
            $l_access = new Linksaccess;
            $ids = [];
            if (!empty($l_access->getEmailsByLinks($raport_id))) {
                foreach ($l_access->getEmailsByLinks($raport_id) as $l_a) {
                    $ids[] = $l_a->r_id;
                }
            }
            $ids = implode(",", $ids);
            $get_users = new User;
            $temp_emails = $get_users->getEmailsByRole($ids);

            $t_em = [];
            foreach ($temp_emails as $email) {
                $t_em[] = $email->email;
            }
            $data["emails"] = implode(",", $t_em);
        } else if ($type == "show") {
            $send = 2;
            if(isset($URL[3])) {
                $day = $URL[3];
            }
            if(isset($_GET["search"])) { // wysłane zapytanie GETem
                if (isset($_GET["date"])) {
                    $day = $_GET["date"];
                }
            }
        }


        $cardriver = new Cardriver();
        foreach($cardriver->getCarsWithDriversByDate($day) as $car) {
            $data["cars"][$car->objectno] = $car;
        }
        $data["logbook"] = [];
        $carlogbook = new Carlogbook();
        if(!empty($carlogbook->getAllByDate($day))) {
            foreach($carlogbook->getAllByDate($day) as $log) {
                $data["logbook"][$log->objectno][] = $log;
            }
        }
        if(!empty($carlogbook->getLastRecord($day))) {
            foreach($carlogbook->getLastRecord($day) as $log) {
                $data["logbook_visit"][$log->objectno][] = $log;
            }
        }
        //show($data["logbook_visit"]);


        $data["get"]["send"] = $send;
        $data["get"]["type"] = $type;
        $data["get"]["day"] = $day;

        $this->view('fleet.report', $data);
    }

}
