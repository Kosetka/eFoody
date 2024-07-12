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

        $data["show_details"] = false;

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
        if (isset($_GET["show_details"])) { //SZCZEGÓŁY
            $data["show_details"] = true;
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
        $data["costs"] = $costs->getByMonth($month, $year);

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

        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }

       
        // vv Ustalenie kosztów produkcji, wyprodukowanej ilości, zagrafikowanej ilości i cen w poszczególnych dniach
        $planned = new Plannerproduction();
        if(!empty($planned->getPlannedMonth($month, $year))) {
            foreach ($planned->getPlannedMonth($month, $year) as $key => $value) {
                $data2["planned"][$value->date_plan][$value->p_id] = (array) $value;
            }
        }
        $producted = new Plannerproducted();
        if(!empty($producted->getProductedMonth($month, $year))) {
            foreach ($producted->getProductedMonth($month, $year) as $key => $value) {
                $data2["producted"][$value->date_producted][$value->p_id] = (array) $value;
            }
        }
        $plan_prod = [];
        if(!empty($data2["planned"])) {
            foreach($data2["planned"] as $plan_date => $plan) {
                foreach($plan as $prod_plan) {
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["p_id"] = $prod_plan["p_id"];
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["date_plan"] = $prod_plan["date_plan"];
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["amount_plan"] = $prod_plan["amount"];
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["production_cost"] = "";
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["price"] = "";
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["returns"] = "";
                    $plan_prod[$plan_date][$prod_plan["p_id"]]["amount_prod"] = "";
                }
            }
            foreach($data2["producted"] as $prod_date => $prod) {
                foreach($prod as $prod_plan_prod) {
                    $plan_prod[$prod_date][$prod_plan_prod["p_id"]]["amount_prod"] = $prod_plan_prod["amount"];
                }
            }
            //wcisnąć info o koszcie produkcji i sprzedaży
            $prices = new PriceModel();
            if(!empty($prices->getPriceMonth($month, $year))) {
                foreach ($prices->getPriceMonth($month, $year) as $price) {
                    $data2["prices"][$price->p_id][] = (object) $price;
                }
            }
            $data["price_log_error"] = [];
            $data["price_log"] = [];
            $data["return_log"] = [];
            foreach($data2["prices"] as $price_prod) {
                foreach($price_prod as $price) {
                    foreach($data2["planned"] as $plan_date => $plan) {
                        $add_log_price = true;
                        if($price->date_from <= $plan_date && $price->date_to >= $plan_date) {
                            if(isset($plan_prod[$plan_date][$price->p_id]["p_id"])) {
                                $plan_prod[$plan_date][$price->p_id]["production_cost"] = $price->production_cost;
                                $plan_prod[$plan_date][$price->p_id]["price"] = $price->price;
                                $data["price_log"][] = ["p_id" => $price->p_id, "day" => $plan_date, "price" => $price->price, "production_cost" => $price->production_cost];
                                //"Produkt ID: ".$price->p_id."; Data: ".$plan_date."; Cena sprzedaży: ".$price->price."; Koszt produkcji: ".$price->production_cost;
                            }
                            $add_log_price = false;
                        } 
                        if($add_log_price) {
                            $data["price_log_error"][] = ["p_id" => $price->p_id, "day" => $plan_date, "text" => "Brak kosztu produkcji i ceny sprzedaży"];
                            //"Produkt ID: ".$price->p_id."; Data: ".$plan_date."; Brak kosztu produkcji i ceny sprzedaży.";
                        }
                    }
                }
            }

            //wcisnąć info o zwrotach ilości zameldowanej
            $products_list = new ReturnsModel();
            foreach($products_list->getReturnsMonth($month, $year) as $return) {
                $return_date = subDay($return->date);
                $data2["return"][$return_date][$return->p_id] = $return; 
                $plan_prod[$return_date][$return->p_id]["returns"] = $return->amount;
                $data["return_log"][] = ["p_id" => $return->p_id, "day" => $return_date, "returns" => $return->amount];
                //"Produkt ID: ".$return->p_id."; Data: ".$return_date."; Zwrócono: ".$return->amount;
            }
        }


        $data["full_prod"] = $plan_prod;

    
        $this->view('fixedcosts.show', $data);
    }
}