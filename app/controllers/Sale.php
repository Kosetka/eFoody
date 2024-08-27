<?php

/**
 * Sale class
 */
class Sale
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        $data["dates"] = False;
        $data["products"] = False;
        $show_data = False;

        $u_id = $_SESSION["USER"]->id;

        // ODWRÓCONIE ID PRZY POMOCNIKU
        $h_id = 0;
        if(isset($_SESSION["USER"]->helper_for)) {
            $u_id = $_SESSION["USER"]->helper_for;
            $h_id = $_SESSION["USER"]->id;
        }

        if (isset($_GET["search"]) && $_GET["search"] == 1)
            $show_data = True;

        if ($_SERVER['REQUEST_METHOD'] == "GET" && $show_data) {
            $date_from = $_GET["date_from"] . " 00:00:00";
            $date_to = $_GET["date_to"] . " 23:59:59";

            $companies_list = new Companies();
            $data["companies"] = $companies_list->getAllCompanies("companies");

            $products_list = new ProductsModel();
            $data["products"] = $products_list->getAllFullProducts();

            $cargo_list = new Cargo();
            $data["cargo"] = $cargo_list->getAllFullProductsDate($u_id, $date_from, $date_to);

            $sold_list = new Sales();
            $data["sold"] = $sold_list->getSoldProductsDate($u_id, $date_from, $date_to);

            $data["user_id"] = $u_id;

            $date_to_temp = new DateTime($_GET["date_to"]);
            $date_to_temp->modify('+1 day');
            $period = new DatePeriod(
                new DateTime($_GET["date_from"]),
                new DateInterval('P1D'),
                $date_to_temp
            );

            foreach ($period as $key => $value) {
                $data["dates"][$key] = $value->format('Y-m-d');
            }
            $data["date_from"] = $_GET["date_from"];
            $data["date_to"] = $_GET["date_to"];
        }

        $this->view('sale', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $u_id = $_SESSION["USER"]->id;

        // ODWRÓCONIE ID PRZY POMOCNIKU
        $h_id = 0;
        if(isset($_SESSION["USER"]->helper_for)) {
            $u_id = $_SESSION["USER"]->helper_for;
            $h_id = $_SESSION["USER"]->id;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $c_id = $_POST["c_id"];
            $sale_description = $_POST["raport_type"];
            if($sale_description == "sell") {
                $sale_description = "";
            }
            $v_sold = isset($_POST["sale_description"]) ? 2 : 1;
            $sales = new Sales;
            $check_sold = 0;
            if(isset($_POST["p_id"])) {
                foreach ($_POST["p_id"] as $key => $value) {
                    if ($value > 0) {
                        $check_sold = 1;
                        if($h_id == 0) {
                            $toUpdate = ["u_id" => $u_id, "c_id" => $c_id, "sale_description" => $sale_description, "p_id" => $key, "s_amount" => $value];
                        } else {
                            $toUpdate = ["u_id" => $u_id, "c_id" => $c_id, "sale_description" => $sale_description, "p_id" => $key, "s_amount" => $value, "h_id" => $h_id];
                        }
                        $sales->insert($toUpdate);
                    }
                }
                $placeVisited = new PlacesModel;
                $v = $placeVisited->checkVisit($c_id);
                if($check_sold == 1) {
                    if(empty($v)) {
                        if($h_id == 0) {
                            $placeVisited->insert(["u_id" => $u_id, "sold" => $v_sold, "c_id" => $c_id]);
                        } else {
                            $placeVisited->insert(["u_id" => $h_id, "sold" => $v_sold, "c_id" => $c_id, "h_id" => $u_id]);
                        }
                    }
                }
                $data['success'] = "Produkty zraportowane pomyślnie";
                unset($_POST);
            } else {
                $data['errors'] = "Brak produktów do zraportowania";

            }
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $users_list = new User();
        $data["users"] = $users_list->getAllTraders("users", TRADERS);

        $companies_list = new Companies();
        $data["companies"] = $companies_list->getMyCompanies($u_id);

        $products_list = new ProductsModel();
        $data["products"] = $products_list->getAllFullProducts();

        $cargo_list = new Cargo();
        $data["cargo"] = $cargo_list->getAllFullProducts($u_id);

        $sold_list = new Sales();
        $data["sold"] = $sold_list->getSoldProductsLeft($u_id);
        
        $products_list = new ReturnsModel();
        $data["return"] = $products_list->getAllFullProducts($u_id);

        $products_list = new CargoExchange();
        $data["exchange_from"] = $products_list->getExchangeTodayOffersToMeSelected($u_id, 1);

        $products_list = new CargoExchange();
        $data["exchange_to"] = $products_list->getExchangeTodayMyOffersSelected($u_id, 1);

        $products_list = new CargoExchange();
        $data["exchange_pending"] = $products_list->getExchangeTodayMyOffersSelected($u_id, 0);



        $this->view('sale.new', $data);
    }

    public function report()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
       
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $date_from = $URL[2];
        } else {
            if(isset($_GET["date_from"])) {
                $date_from = $_GET["date_from"];
            } else {
                $date_from = date('Y-m-d');
            }
        }
        if(isset($URL[3])) {
            $date_to = $URL[3];
        } else {
            if(isset($_GET["date_from"])) {
                $date_to = $_GET["date_to"];
            } else {
                $date_to = date('Y-m-d');
            }
        }
        if(isset($URL[4])) {
            $guardian = $URL[4];
        } else {
            if(isset($_GET["guardian"])) {
                $guardian = $_GET["guardian"];
            } else {
                $guardian = 0;
            }
        }

        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;
        $data["guardian"] = $guardian;

        $users = new User();
        foreach ($users->getAllTraders("users", ALLTRADERS) as $key => $value) {
            $data["users"][$value->id] = $value;
        }
        $places = new PlacesModel();
        if(!empty($places->getAllPlaces($date_from, $date_to))) {
            foreach($places->getAllPlaces($date_from, $date_to) as $key => $value) {
                $data["places"][$value->c_id] = $value;
            }
        }
        $companies = new Companies();
        if(!empty($companies->getAllCompanies("companies"))) {
            foreach($companies->getAllCompanies("companies") as $key => $value) {
                $data["companies"][$value->id] = $value;
            }
        }
        $sales = new Sales;
        if (!empty($sales->getAllData($date_from, $date_to))) {
            foreach ($sales->getAllData($date_from, $date_to) as $sale) {
                if ($sale->sale_description == "") {
                    $sale->sale_description = "scan";
                }
                $data["sales"][$sale->sale_description][$sale->c_id]["u_id"] = $sale->u_id;
                $data["sales"][$sale->sale_description][$sale->c_id]["h_id"] = $sale->h_id;
                $data["sales"][$sale->sale_description][$sale->c_id][$sale->p_id]["p_id"] = $sale->p_id;
                $data["sales"][$sale->sale_description][$sale->c_id]["date"] = $sale->date;
                if(!isset($data["sales"][$sale->sale_description][$sale->c_id][$sale->p_id]["s_amount"])) {
                    $data["sales"][$sale->sale_description][$sale->c_id][$sale->p_id]["s_amount"] = 0;
                }
                $data["sales"][$sale->sale_description][$sale->c_id][$sale->p_id]["s_amount"] += $sale->s_amount;
            }
        }

        $products = new ProductsModel;
        $temp = $products->getAllFullProducts();
        foreach ($temp as $key => $value) {
            $data["products"][$value->id] = $value;
        }

        $prices = new PriceModel();
        foreach ($prices->getGroupedPrices($date_from, $date_to) as $price) {
            $data["prices"][$price->p_id][] = $price;
        }


    

        $this->view('sale.report', $data);
    }


    public function dailyprofit()
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
        } elseif(isset($_GET["show"])) {
            $date = date("Y-m-d");
            $data["show_list"] = true;
        } else {
            $date = date("Y-m-d");
            $data["show_list"] = false;
        }

        $gain = new Gainsmodel();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            show($gain->checkExists($date, $_POST["u_id"]));
            if(!empty($gain->checkExists($date, $_POST["u_id"]))) {
                $t_id = $gain->checkExists($date, $_POST["u_id"])[0]->id;
                $gain->delete($t_id);
            }

            //show($_POST);
            $to_insert = [
                "u_id" => $_POST["u_id"],
                "date" => $date,
                "profit" => $_POST["cash"] + $_POST["card"],
                "insert_u_id" => $_SESSION["USER"]->id,
                "main_u_id" => $_POST["u_id"],
                "card" => $_POST["card"],
                "cash" => $_POST["cash"]
            ];
            
            $gain->insert($to_insert);
        }

        $data["gains"] = [];
        if(!empty($gain->getByDate($date))) {
            foreach($gain->getByDate($date) as $g) {
                $data["gains"][$g->u_id] = $g;
            }
        }
        //show($data);


        $users = new User();
        foreach($users->getAllDrivers() as $user) {
            $data["users"][$user->id] = $user;
        }


        $data["date"] = $date;
        $this->view('sale.dailyprofit', $data);
    }
}
