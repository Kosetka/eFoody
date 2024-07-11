<?php

/**
 * Sale class
 */
class Fixedcosts
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $costs = new Fixedcostsmodel;
        $data["costs"] = $costs->getAll();
    
        $this->view('fixedcosts', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $cost = new Fixedcostsmodel;

            $date_from = $_POST["date_from"];
            $type = $_POST["type"];
            $date_to = $_POST["date_to"];
            $date = $_POST["single_date"];
            $cost_name = $_POST["cost_name"];
            $price = $_POST["price"];
            $category = $_POST["category"];
            $method = $_POST["method"];
            if(!isset($_POST["active"])) {
                $active = 0;
            } else {
                $active = $_POST["active"];
            }
            if(empty($_POST["single_date"])) {
                $date = NULL;
            }
            if(empty($_POST["date_from"])) {
                $date_from = NULL;
            }
            if(empty($_POST["date_to"])) {
                $date_to = NULL;
            }
            $description = $_POST["description"];
            $toUpdate = ["date_from" => $date_from, "date_to" => $date_to, "date" => $date, "name" => "$cost_name", 
                            "price" => $price, "category" => $category, 'method' => $method, 'active' => $active, 'description' => "$description", 'type' => $type];
            $cost->insert($toUpdate);

            $data['success'] = "Koszt został dodany";
            unset($_POST);
            redirect('fixedcosts');
        }
        $data["edit"] = False;

        $this->view('fixedcosts.new', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $id = $URL[2];
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //show($_POST);
            //die;
            $cost = new Fixedcostsmodel;

            $date_from = $_POST["date_from"];
            $type = $_POST["type"];
            $date_to = $_POST["date_to"];
            $date = $_POST["single_date"];
            $cost_name = $_POST["cost_name"];
            $price = $_POST["price"];
            $category = $_POST["category"];
            $method = $_POST["method"];
            if(!isset($_POST["active"])) {
                $active = 0;
            } else {
                $active = $_POST["active"];
            }
            if(empty($_POST["single_date"])) {
                $date = NULL;
            }
            if(empty($_POST["date_from"])) {
                $date_from = NULL;
            }
            if(empty($_POST["date_to"])) {
                $date_to = NULL;
            }
            $description = $_POST["description"];
            $toUpdate = ["date_from" => $date_from, "date_to" => $date_to, "date" => $date, "name" => "$cost_name", 
                            "price" => $price, "category" => $category, 'method' => $method, 'active' => $active, 'description' => "$description", 'type' => $type];
            $cost->update($id, $toUpdate);

            $data['success'] = "Koszt został dodany";
            unset($_POST);
            redirect('fixedcosts');

        }

        $costs = new Fixedcostsmodel;
        $data["cost"] = $costs->getByID($id);
        $data["edit"] = True;

        $this->view('fixedcosts.new', $data);
    }

    public function show()
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
        $month = removeLeadingZero($month);
        $data["month"] = $month;
        $data["year"] = $year;





        $holidays = new Holidaysmodel();
        foreach($holidays->getMonth($month,$year) as $holiday) {
            $data["holidays"][$holiday->date] = $holiday;
        }
        $data["working_days"] = cal_days_in_month(CAL_GREGORIAN, $month, $year) - $holidays->getWorkingDays($month,$year)[$year][$month];

        $costs = new Fixedcostsmodel;
        $data["costs"] = $costs->getAll();

        $users = new User();
        foreach($users->getAllActiveUsers() as $user) {
            $data["users"][$user->id] = $user;
        }
        $workhour = new Workhours();
        if(!empty($workhour->getMonth($month, $year))) {
            foreach($workhour->getMonth($month, $year) as $wh) {
                $data["accepted"][$wh->date][$wh->u_id] = $wh;
            }
        }

        $payrates = new Payrate();
        if(!empty($payrates->getRates($month, $year))) {
            foreach($payrates->getRates($month, $year) as $pr) {
                $data["rates"][$pr->u_id][] = $pr;
            }
        }
    
        $this->view('fixedcosts.show', $data);
    }
}