<?php

/**
 * Returns class
 */
class Reports
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        

        $this->view('reports.all', $data);
    }

    public function sales() 
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        
        $type = 0;
        $send = 0;
        $param1 = 0;
        $param2 = 0;

        $date_from = "2020-01-01 00:00:00";
        $date_to = "2020-01-01 23:59:59";

        if(isset($URL[2])) {
            $type = $URL[2];
        }

        if($type == "send") {
            $send = 1;
            if(isset($URL[3])) {
                $type = $URL[3];
            }
            if(isset($URL[4])) {
                $param1 = $URL[4];
            }
            if(isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if($type == "show" ) {
            $send = 2;
            if(isset($URL[3])) {
                $type = $URL[3];
            }
            if(isset($_GET["search"])) { // wysłane zapytanie GETem
                if(isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if(isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if(isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if(isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if(isset($URL[3])) {
                $param1 = $URL[3];
            }
            if(isset($URL[4])) {
                $param2 = $URL[4];
            }
        }

        if ($type =="hour") 
            $raport_id = 15; 
        elseif ($type =="day") 
            $raport_id = 32; 
        else if ($type == "week")
            $raport_id = 33; 
        else if ($type == "month") 
            $raport_id = 34; 

        $l_access = new Linksaccess;
        $ids = [];
        if(!empty($l_access->getEmailsByLinks($raport_id))) {
            foreach($l_access->getEmailsByLinks($raport_id) as $l_a) {
                $ids[] = $l_a->r_id;
            }
        }
        $ids = implode(",", $ids);
        $get_users = new User;
        $temp_emails = $get_users->getEmailsByRole($ids);

        $t_em = [];
        foreach($temp_emails as $email) {
            $t_em[] = $email->email;
        }
        $data["emails"] = implode(",", $t_em);

        $today = date("Y-m-d");

        if($type == "hour") {
            if ($param1 == 0) {
                $param1 = date("H", strtotime("-1 hour"));
            }
            $date_from_hour = $today." ".$param1.":00:00";
            $date_to_hour = $today." ".$param1.":59:59";
            $date_from = $today." 00:00:00";
            $date_to = $today." 23:59:59";

        } else if ($type =="day") {
            if($param1 <> 0) {
                $today = $param1;
            }
            $date_from = $today." 00:00:00";
            $date_to = $today." 23:59:59";
        } else if ($type == "week") {
            if($param1 <> 0) {
                $date_from = $param1." 00:00:00";
            }
            if($param2 <> 0) {
                $date_to = $param2." 23:59:59";
            }
            if($param1 == 0) {
                $last_monday = date("Y-m-d",strtotime("-7 days",strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+7 days", strtotime($last_monday)));
                $date_from = $last_monday." 00:00:00";
                $date_to = $last_sunday." 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if($param1 <> 0) {
                if($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $date_from = $firstday." 00:00:00";
                    $date_to = $lastday." 23:59:59";
                }
            }
            if($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));

                $date_from = $first_day_previous_month." 00:00:00";
                $date_to = $last_day_previous_month." 23:59:59";
                $timestamp = strtotime($date_from);
                $param1 = date('m', $timestamp);
                $param2 = date('y', $timestamp);
            }
        } else {
            echo "Błędny parametr";
            die;
        }

        $data["get"]["send"] = $send;
        $data["get"]["type"] = $type;
        $data["get"]["date_from"] = $date_from;
        $data["get"]["date_to"] = $date_to;
        $data["get"]["param1"] = $param1;
        $data["get"]["param2"] = $param2;

        $users = new User;
        $data["users"] = $users->getAllTraders("users",TRADERS);

        $sales = new Sales;
        $data["sales"] = $sales->reportData($date_from, $date_to);
        
        if($type == "hour") {
            $sales = new Sales;
            $data["sales_hour"] = $sales->reportData($date_from_hour, $date_to_hour);
            $places = new PlacesModel;
            $data["places_hour"] = $places->reportData($date_from_hour, $date_to_hour);
        }

        $cargo = new Cargo;
        $data["cargo"] = $cargo->reportData($date_from, $date_to);

        $places = new PlacesModel;
        $data["places"] = $places->reportData($date_from, $date_to);

        $returns = new ReturnsModel;
        $data["returns"] = $returns->reportData($date_from, $date_to);

        $exchanges = new CargoExchange;
        $data["exchanges"] = $exchanges->reportData($date_from, $date_to);


        $companies = new Companies;
        foreach($companies->getCompaniesNumber() as $comp) {
            $data["companies"][$comp->guardian] = $comp->num;
        }
        
        $this->view('sales.total', $data);
    }

    public function productions() 
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        
        $type = 0;
        $send = 0;
        $param1 = 0;
        $param2 = 0;

        $date_from = "2020-01-01 00:00:00";
        $date_to = "2020-01-01 23:59:59";

        if(isset($URL[2])) {
            $type = $URL[2];
        }

        if($type == "send") {
            $send = 1;
            if(isset($URL[3])) {
                $type = $URL[3];
            }
            if(isset($URL[4])) {
                $param1 = $URL[4];
            }
            if(isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if($type == "show" ) {
            $send = 2;
            if(isset($URL[3])) {
                $type = $URL[3];
            }
            if(isset($_GET["search"])) { // wysłane zapytanie GETem
                if(isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if(isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if(isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if(isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if(isset($URL[3])) {
                $param1 = $URL[3];
            }
            if(isset($URL[4])) {
                $param2 = $URL[4];
            }
        }
//tu sięzaczyna - 

        if ($type =="day") 
            $raport_id = 82; 
        else if ($type == "week")
            $raport_id = 83; 
        else if ($type == "month") 
            $raport_id = 84; 

        $l_access = new Linksaccess;
        $ids = [];
        if(!empty($l_access->getEmailsByLinks($raport_id))) {
            foreach($l_access->getEmailsByLinks($raport_id) as $l_a) {
                $ids[] = $l_a->r_id;
            }
        }
        $ids = implode(",", $ids);
        $get_users = new User;
        $temp_emails = $get_users->getEmailsByRole($ids);

        $t_em = [];
        foreach($temp_emails as $email) {
            $t_em[] = $email->email;
        }
        $data["emails"] = implode(",", $t_em);

        $today = date("Y-m-d");

        if ($type =="day") {
            if($param1 <> 0) {
                $today = $param1;
            }
            $date_from = $today." 00:00:00";
            $date_to = $today." 23:59:59";
        } else if ($type == "week") {
            if($param1 <> 0) {
                $date_from = $param1." 00:00:00";
            }
            if($param2 <> 0) {
                $date_to = $param2." 23:59:59";
            }
            if($param1 == 0) {
                $last_monday = date("Y-m-d",strtotime("-7 days",strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+7 days", strtotime($last_monday)));
                $date_from = $last_monday." 00:00:00";
                $date_to = $last_sunday." 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if($param1 <> 0) {
                if($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $date_from = $firstday." 00:00:00";
                    $date_to = $lastday." 23:59:59";
                }
            }
            if($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));

                $date_from = $first_day_previous_month." 00:00:00";
                $date_to = $last_day_previous_month." 23:59:59";
                $timestamp = strtotime($date_from);
                $param1 = date('m', $timestamp);
                $param2 = date('y', $timestamp);
            }
        } else {
            echo "Błędny parametr";
            die;
        }

        $data["get"]["send"] = $send;
        $data["get"]["type"] = $type;
        $data["get"]["date_from"] = $date_from;
        $data["get"]["date_to"] = $date_to;
        $data["get"]["param1"] = $param1;
        $data["get"]["param2"] = $param2;

        $users = new User;
        $data["users"] = $users->getAllTraders("users",TRADERS);

        $w_id = 1;
        $planned = new Plannerproduction();
        if(!empty($planned->getPlannedDates($date_from, $date_to, $w_id))) {
            foreach ($planned->getPlannedDates($date_from, $date_to, $w_id) as $key => $value) {
                $data["planned"][$value->id] = (array) $value;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = (array) $value;
        }
        $plan = new Plannerproducted();
        if(!empty($plan->getAllDates($date_from, $date_to))) {
            foreach ($plan->getAllDates($date_from, $date_to) as $key => $value) {
                $data["producted"][$value->id] = (array) $value;
            }
        }
        $cargo = new Cargo;
        $date_from = $date_from.' 00:00:00';
        $date_to = $date_to.' 23:59:59';
        if(!empty($cargo->getFullProductsDate($date_from, $date_to))) {
            foreach ($cargo->getFullProductsDate($date_from, $date_to) as $key => $value) {
                $data["cargo"][$value->id] = (array) $value;
            }
        }

        $plan = new Plannersplit();
        if(!empty($plan->getPlannedByDates($date_from, $date_to))) {
            foreach ($plan->getPlannedByDates($date_from, $date_to) as $key => $value) {
                $data["split"][$value->id] = (array) $value;
            }
        }


        
        $this->view('productions.total', $data);
    }

    public function profitability() 
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        
        $type = 0;
        $send = 0;
        $param1 = 0;
        $param2 = 0;

        $date_from = "2020-01-01 00:00:00";
        $date_to = "2020-01-01 23:59:59";

        if(isset($URL[2])) {
            $type = $URL[2];
        }

        if($type == "send") {
            $send = 1;
            if(isset($URL[3])) {
                $type = $URL[3];
            }
            if(isset($URL[4])) {
                $param1 = $URL[4];
            }
            if(isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if($type == "show" ) {
            $send = 2;
            if(isset($URL[3])) {
                $type = $URL[3];
            }
            if(isset($_GET["search"])) { // wysłane zapytanie GETem
                if(isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if(isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if(isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if(isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if(isset($URL[3])) {
                $param1 = $URL[3];
            }
            if(isset($URL[4])) {
                $param2 = $URL[4];
            }
        }
//tu sięzaczyna - 

        if ($type =="day") 
            $raport_id = 82; 
        else if ($type == "week")
            $raport_id = 83; 
        else if ($type == "month") 
            $raport_id = 84; 

        $l_access = new Linksaccess;
        $ids = [];
        if(!empty($l_access->getEmailsByLinks($raport_id))) {
            foreach($l_access->getEmailsByLinks($raport_id) as $l_a) {
                $ids[] = $l_a->r_id;
            }
        }
        $ids = implode(",", $ids);
        $get_users = new User;
        $temp_emails = $get_users->getEmailsByRole($ids);

        $t_em = [];
        foreach($temp_emails as $email) {
            $t_em[] = $email->email;
        }
        $data["emails"] = implode(",", $t_em);

        $today = date("Y-m-d");

        if ($type =="day") {
            if($param1 <> 0) {
                $today = $param1;
            }
            $date_from = $today." 00:00:00";
            $date_to = $today." 23:59:59";
        } else if ($type == "week") {
            if($param1 <> 0) {
                $date_from = $param1." 00:00:00";
            }
            if($param2 <> 0) {
                $date_to = $param2." 23:59:59";
            }
            if($param1 == 0) {
                $last_monday = date("Y-m-d",strtotime("-7 days",strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+7 days", strtotime($last_monday)));
                $date_from = $last_monday." 00:00:00";
                $date_to = $last_sunday." 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if($param1 <> 0) {
                if($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $date_from = $firstday." 00:00:00";
                    $date_to = $lastday." 23:59:59";
                }
            }
            if($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));

                $date_from = $first_day_previous_month." 00:00:00";
                $date_to = $last_day_previous_month." 23:59:59";
                $timestamp = strtotime($date_from);
                $param1 = date('m', $timestamp);
                $param2 = date('y', $timestamp);
            }
        } else {
            echo "Błędny parametr";
            die;
        }

        $data["get"]["send"] = $send;
        $data["get"]["type"] = $type;
        $data["get"]["date_from"] = $date_from;
        $data["get"]["date_to"] = $date_to;
        $data["get"]["param1"] = $param1;
        $data["get"]["param2"] = $param2;

        $users = new User;
        $data["users"] = $users->getAllTraders("users",TRADERS);

        $w_id = 1;
        $planned = new Plannerproduction();
        if(!empty($planned->getPlannedDates($date_from, $date_to, $w_id))) {
            foreach ($planned->getPlannedDates($date_from, $date_to, $w_id) as $key => $value) {
                $data["planned"][$value->id] = (array) $value;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = (array) $value;
        }
        $plan = new Plannerproducted();
        if(!empty($plan->getAllDates($date_from, $date_to))) {
            foreach ($plan->getAllDates($date_from, $date_to) as $key => $value) {
                $data["producted"][$value->id] = (array) $value;
            }
        }
        $cargo = new Cargo;
        $date_from = $date_from.' 00:00:00';
        $date_to = $date_to.' 23:59:59';
        if(!empty($cargo->getFullProductsDate($date_from, $date_to))) {
            foreach ($cargo->getFullProductsDate($date_from, $date_to) as $key => $value) {
                $data["cargo"][$value->id] = (array) $value;
            }
        }

        $plan = new Plannersplit();
        if(!empty($plan->getPlannedByDates($date_from, $date_to))) {
            foreach ($plan->getPlannedByDates($date_from, $date_to) as $key => $value) {
                $data["split"][$value->id] = (array) $value;
            }
        }

        $prices = new PriceModel();
        foreach($prices->getGroupedPrices($date_from, $date_to) as $price) {
            $data["prices"][$price->p_id][] = $price;
        }



show($data);

        
        $this->view('profitability.total', $data);
    }
}
