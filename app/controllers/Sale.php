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
        if (isset($_GET["search"]) && $_GET["search"] == 1)
            $show_data = True;

        if ($_SERVER['REQUEST_METHOD'] == "GET" && $show_data) {
            $date_from = $_GET["date_from"] . " 00:00:00";
            $date_to = $_GET["date_to"] . " 23:59:59";
            $u_id = $_SESSION["USER"]->id;

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
        // do zrobienia
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $u_id = $_SESSION["USER"]->id;
            $c_id = $_POST["c_id"];
            $sale_description = $_POST["sale_description"];
            $sales = new Sales;
            foreach ($_POST["p_id"] as $key => $value) {
                if ($value > 0) {
                    $toUpdate = ["u_id" => $u_id, "c_id" => $c_id, "sale_description" => $sale_description, "p_id" => $key, "s_amount" => $value];
                    $sales->insert($toUpdate);
                }
            }
            $data['success'] = "Produkty zraportowane pomyślnie";
            unset($_POST);
            $data['errors'] = $sales->errors;
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
        $data["companies"] = $companies_list->getAllCompanies("companies");

        $products_list = new ProductsModel();
        $data["products"] = $products_list->getAllFullProducts();

        $cargo_list = new Cargo();
        $data["cargo"] = $cargo_list->getAllFullProducts($u_id);

        $sold_list = new Sales();
        $data["sold"] = $sold_list->getSoldProducts($u_id);

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
}
