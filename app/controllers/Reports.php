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

        if (isset($URL[2])) {
            $type = $URL[2];
        }

        if ($type == "send") {
            $send = 1;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($URL[4])) {
                $param1 = $URL[4];
            }
            if (isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if ($type == "show") {
            $send = 2;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($_GET["search"])) { // wysłane zapytanie GETem
                if (isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if (isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if (isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if (isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if (isset($URL[3])) {
                $param1 = $URL[3];
            }
            if (isset($URL[4])) {
                $param2 = $URL[4];
            }
        }

        if ($type == "hour")
            $raport_id = 15;
        elseif ($type == "day")
            $raport_id = 32;
        else if ($type == "week")
            $raport_id = 33;
        else if ($type == "month")
            $raport_id = 34;

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

        $today = date("Y-m-d");

        if ($type == "hour") {
            if ($param1 == 0) {
                $param1 = date("H", strtotime("-1 hour"));
            }
            $date_from_hour = $today . " " . $param1 . ":00:00";
            $date_to_hour = $today . " " . $param1 . ":59:59";
            $date_from = $today . " 00:00:00";
            $date_to = $today . " 23:59:59";

        } else if ($type == "day") {
            if ($param1 <> 0) {
                $today = $param1;
            }
            $date_from = $today . " 00:00:00";
            $date_to = $today . " 23:59:59";
        } else if ($type == "week") {
            if ($param1 <> 0) {
                $date_from = $param1 . " 00:00:00";
            }
            if ($param2 <> 0) {
                $date_to = $param2 . " 23:59:59";
            }
            if ($param1 == 0) {
                $last_monday = date("Y-m-d", strtotime("-7 days", strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+6 days", strtotime($last_monday)));
                $date_from = $last_monday . " 00:00:00";
                $date_to = $last_sunday . " 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if ($param1 <> 0) {
                if ($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $date_from = $firstday . " 00:00:00";
                    $date_to = $lastday . " 23:59:59";
                }
            }
            if ($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));

                $date_from = $first_day_previous_month . " 00:00:00";
                $date_to = $last_day_previous_month . " 23:59:59";
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
        $data["users"] = $users->getAllTraders("users", TRADERS);

        $sales = new Sales;
        $data["sales"] = $sales->reportData($date_from, $date_to);

        if ($type == "hour") {
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
        foreach ($companies->getCompaniesNumber() as $comp) {
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

        if (isset($URL[2])) {
            $type = $URL[2];
        }

        if ($type == "send") {
            $send = 1;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($URL[4])) {
                $param1 = $URL[4];
            }
            if (isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if ($type == "show") {
            $send = 2;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($_GET["search"])) { // wysłane zapytanie GETem
                if (isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if (isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if (isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if (isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if (isset($URL[3])) {
                $param1 = $URL[3];
            }
            if (isset($URL[4])) {
                $param2 = $URL[4];
            }
        }
        //tu sięzaczyna - 

        if ($type == "day")
            $raport_id = 82;
        else if ($type == "week")
            $raport_id = 83;
        else if ($type == "month")
            $raport_id = 84;

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

        $today = date("Y-m-d");

        if ($type == "day") {
            if ($param1 <> 0) {
                $today = $param1;
            }
            $date_from = $today . " 00:00:00";
            $date_to = $today . " 23:59:59";
        } else if ($type == "week") {
            if ($param1 <> 0) {
                $date_from = $param1 . " 00:00:00";
            }
            if ($param2 <> 0) {
                $date_to = $param2 . " 23:59:59";
            }
            if ($param1 == 0) {
                $last_monday = date("Y-m-d", strtotime("-7 days", strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+6 days", strtotime($last_monday)));
                $date_from = $last_monday . " 00:00:00";
                $date_to = $last_sunday . " 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if ($param1 <> 0) {
                if ($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $date_from = $firstday . " 00:00:00";
                    $date_to = $lastday . " 23:59:59";
                }
            }
            if ($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));

                $date_from = $first_day_previous_month . " 00:00:00";
                $date_to = $last_day_previous_month . " 23:59:59";
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
        $data["users"] = $users->getAllTraders("users", TRADERS);

        $w_id = 1;
        $planned = new Plannerproduction();
        if (!empty($planned->getPlannedDates($date_from, $date_to, $w_id))) {
            foreach ($planned->getPlannedDates($date_from, $date_to, $w_id) as $key => $value) {
                $data["planned"][$value->id] = (array) $value;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = (array) $value;
        }
        $plan = new Plannerproducted();
        if (!empty($plan->getAllDates($date_from, $date_to))) {
            foreach ($plan->getAllDates($date_from, $date_to) as $key => $value) {
                $data["producted"][$value->id] = (array) $value;
            }
        }
        $cargo = new Cargo;
        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';
        if (!empty($cargo->getFullProductsDate($date_from, $date_to))) {
            foreach ($cargo->getFullProductsDate($date_from, $date_to) as $key => $value) {
                $data["cargo"][$value->id] = (array) $value;
            }
        }

        $plan = new Plannersplit();
        if (!empty($plan->getPlannedByDates($date_from, $date_to))) {
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

        if (isset($URL[2])) {
            $type = $URL[2];
        }

        if ($type == "send") {
            $send = 1;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($URL[4])) {
                $param1 = $URL[4];
            }
            if (isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if ($type == "show") {
            $send = 2;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($_GET["search"])) { // wysłane zapytanie GETem
                if (isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if (isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if (isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if (isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if (isset($URL[3])) {
                $param1 = $URL[3];
            }
            if (isset($URL[4])) {
                $param2 = $URL[4];
            }
        }

        //tu sięzaczyna - 

        if ($type == "day")
            $raport_id = 82;
        else if ($type == "week")
            $raport_id = 83;
        else if ($type == "month")
            $raport_id = 84;

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

        $today = date("Y-m-d");

        if ($type == "day") {
            if ($param1 <> 0) {
                $today = $param1;
            }
            $f_date_from = $today;
            $f_date_to = $today;
            $date_from = $today . " 00:00:00";
            $date_to = $today . " 23:59:59";
        } else if ($type == "week") {
            if ($param1 <> 0) {
                $f_date_from = $param1;
                $date_from = $param1 . " 00:00:00";
            }
            if ($param2 <> 0) {
                $f_date_to = $param2;
                $date_to = $param2 . " 23:59:59";
            }
            if ($param1 == 0) {
                $last_monday = date("Y-m-d", strtotime("-7 days", strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+6 days", strtotime($last_monday)));
                $f_date_from = $last_monday;
                $f_date_to = $last_sunday;
                $date_from = $last_monday . " 00:00:00";
                $date_to = $last_sunday . " 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if ($param1 <> 0) {
                if ($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $f_date_from = sprintf("%d-%02d-%d", ...explode('-', $firstday));
                    $f_date_to = sprintf("%d-%02d-%d", ...explode('-', $lastday));
                    $date_from = $firstday . " 00:00:00";
                    $date_to = $lastday . " 23:59:59";
                }
            }
            if ($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));
                $f_date_from = sprintf("%d-%02d-%d", ...explode('-', $first_day_previous_month));
                $f_date_to = sprintf("%d-%02d-%d", ...explode('-', $last_day_previous_month));
                $date_from = $first_day_previous_month . " 00:00:00";
                $date_to = $last_day_previous_month . " 23:59:59";
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
        $data["users"] = $users->getAllTraders("users", TRADERS);

        $w_id = 1;
        $planned = new Plannerproduction();
        if (!empty($planned->getPlannedDates($date_from, $date_to, $w_id))) {
            foreach ($planned->getPlannedDates($date_from, $date_to, $w_id) as $key => $value) {
                $data["planned"][$value->id] = (array) $value;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = (array) $value;
        }
        $plan = new Plannerproducted();
        if (!empty($plan->getAllDates($date_from, $date_to))) {
            foreach ($plan->getAllDates($date_from, $date_to) as $key => $value) {
                $data["producted"][$value->id] = (array) $value;
            }
        }
        $cargo = new Cargo;
        $date_from = $date_from . ' 00:00:00';
        $date_to = $date_to . ' 23:59:59';
        if (!empty($cargo->getFullProductsDate($date_from, $date_to))) {
            foreach ($cargo->getFullProductsDate($date_from, $date_to) as $key => $value) {
                $data["cargo"][$value->id] = (array) $value;
            }
        }

        $plan = new Plannersplit();
        if (!empty($plan->getPlannedByDates($date_from, $date_to))) {
            foreach ($plan->getPlannedByDates($date_from, $date_to) as $key => $value) {
                $data["split"][$value->id] = (array) $value;
            }
        }

        $prices = new PriceModel();
        foreach ($prices->getGroupedPrices($date_from, $date_to) as $price) {
            $data["prices"][$price->p_id][] = $price;
        }

        //echo "<br><br><br>".$f_date_from." ".$f_date_to;
        $foodcost = new Foodcost();
        $data["foodcost"] = $foodcost->getPriceDetailedWithSauce($f_date_from, $f_date_to);

        //show($data["prices"]);//die;
        //show($data["foodcost"]);//die;

        $returns = new ReturnsModel;
        foreach ($returns->returnsByDate($date_from, $date_to) as $ret) {
            $data["returns"][$ret->p_id][$ret->u_id][] = $ret;
        }

        //show($data["returns"]);

        //$date_from = '2024-05-01';
        $sales = new Sales;
        //$data["sales"] = $sales->getAllData($date_from, $date_to);
        if (!empty($sales->getAllData($date_from, $date_to))) {
            foreach ($sales->getAllData($date_from, $date_to) as $sale) {
                if ($sale->sale_description == "") {
                    $sale->sale_description = "scan";
                }
                $data["sales"][$sale->sale_description][$sale->p_id][$sale->u_id][] = $sale;
            }
        }

        //show($data["sales"]);

        $this->view('profitability.total', $data);
    }

    public function salescompanies()
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

        if (isset($URL[2])) {
            $type = $URL[2];
        }

        if ($type == "send") {
            $send = 1;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($URL[4])) {
                $param1 = $URL[4];
            }
            if (isset($URL[5])) {
                $param2 = $URL[5];
            }
        } else if ($type == "show") {
            $send = 2;
            if (isset($URL[3])) {
                $type = $URL[3];
            }
            if (isset($_GET["search"])) { // wysłane zapytanie GETem
                if (isset($_GET["date_from"])) {
                    $param1 = $_GET["date_from"];
                    $data["date_from"] = $param1;
                }
                if (isset($_GET["date_to"])) {
                    $param2 = $_GET["date_to"];
                    $data["date_to"] = $param2;
                }
            } else {
                if (isset($URL[4])) {
                    $param1 = $URL[4];
                }
                if (isset($URL[5])) {
                    $param2 = $URL[5];
                }
            }
        } else {
            if (isset($URL[3])) {
                $param1 = $URL[3];
            }
            if (isset($URL[4])) {
                $param2 = $URL[4];
            }
        }

        if ($type == "hour")
            $raport_id = 15; // do zmiany 133
        elseif ($type == "day")
            $raport_id = 15; // do zmiany
        else if ($type == "week")
            $raport_id = 15; // do zmiany
        else if ($type == "month")
            $raport_id = 15; // do zmiany

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

        $today = date("Y-m-d");

        if ($type == "hour") {
            if ($param1 == 0) {
                $param1 = date("H", strtotime("-1 hour"));
            }
            $date_from_hour = $today . " " . $param1 . ":00:00";
            $date_to_hour = $today . " " . $param1 . ":59:59";
            $date_from = $today . " 00:00:00";
            $date_to = $today . " 23:59:59";

        } else if ($type == "day") {
            if ($param1 <> 0) {
                $today = $param1;
            }
            $date_from = $today . " 00:00:00";
            $date_to = $today . " 23:59:59";
        } else if ($type == "week") {
            if ($param1 <> 0) {
                $date_from = $param1 . " 00:00:00";
            }
            if ($param2 <> 0) {
                $date_to = $param2 . " 23:59:59";
            }
            if ($param1 == 0) {
                $last_monday = date("Y-m-d", strtotime("-7 days", strtotime("last monday")));
                $last_sunday = date("Y-m-d", strtotime("+6 days", strtotime($last_monday)));
                $date_from = $last_monday . " 00:00:00";
                $date_to = $last_sunday . " 23:59:59";
                $param1 = $last_monday; // tu sprawdzić
                $param2 = $last_sunday;
            }
        } else if ($type == "month") {
            if ($param1 <> 0) {
                if ($param2 <> 0) {
                    $firstday = date("$param2-$param1-01");
                    $ld = cal_days_in_month(CAL_GREGORIAN, $param1, $param2);
                    $lastday = date("$param2-$param1-$ld");
                    $date_from = $firstday . " 00:00:00";
                    $date_to = $lastday . " 23:59:59";
                }
            }
            if ($param1 == 0) {
                $first_day_current_month = date("Y-m-01");
                $last_day_current_month = date("Y-m-t", strtotime($first_day_current_month));
                $last_day_previous_month = date("Y-m-t", strtotime("-1 month", strtotime($first_day_current_month)));
                $first_day_previous_month = date("Y-m-01", strtotime("-1 month", strtotime($first_day_current_month)));

                $date_from = $first_day_previous_month . " 00:00:00";
                $date_to = $last_day_previous_month . " 23:59:59";
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

        $prices = new PriceModel();
        if(!empty($prices->getGroupedPrice($date_from, $date_to))) {
            foreach($prices->getGroupedPrice($date_from, $date_to) as $key => $value) {
                $data["prices"][$value->p_id][] = $value; 
            }
        }
        //show($data["prices"]);

        $cargo = new Cargo;
        if (!empty($cargo->getAllFullProductsDateAndShops($date_from, $date_to))) {
            foreach ($cargo->getAllFullProductsDateAndShops($date_from, $date_to) as $key => $value) {
                $day = substr($value->date,0,10);
                $data["cargo_temp"][$value->c_id][$value->p_id][$day]["amount"] = $value->amount;
                $data["cargo_temp2"][$value->c_id][$day][$value->p_id]["amount"] = $value->amount;
                if(isset($data["prices"][$value->p_id])) {
                    $is_price = false;
                    foreach($data["prices"][$value->p_id] as $k => $v) {
                        if(substr($v->date_from,0,10) <= $day) {
                            if(($v->date_to == null) || $v->date_to >= $day) {
                                if(isset($v->priceshops)) {
                                    $data["cargo_temp"][$value->c_id][$value->p_id][$day]["cost"] = $v->priceshops;
                                    $data["cargo_temp2"][$value->c_id][$day][$value->p_id]["cost"] = $v->priceshops;
                                    $is_price = true;
                                } else {
                                    $data["cargo_temp"][$value->c_id][$value->p_id][$day]["cost"] = $v->price;
                                    $data["cargo_temp2"][$value->c_id][$day][$value->p_id]["cost"] = $v->price;
                                    $is_price = true;
                                }
                            }
                        }
                    } 
                    if($is_price == false) {
                        $data["cargo_temp"][$value->c_id][$value->p_id][$day]["cost"] = 0;
                        $data["cargo_temp2"][$value->c_id][$day][$value->p_id]["cost"] = 0;
                    }
                }
            }
        }

        $companies = new Companies();
        $data["shops"] = [];
        if(!empty($companies->getAllShops())) {
            foreach ($companies->getAllShops() as $key => $value) {
                $data["shops"][$value->id] = $value;
            }
        }

        $products_list = new ProductsModel();
            foreach ($products_list->getAllFullProducts() as $key => $value) {
                $data["fullproducts"][$value->id] = (array) $value;
            }

        $this->view('salescompanies.total', $data);
    }



}
