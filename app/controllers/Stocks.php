<?php

/**
 * GetCargo class
 */
class Stocks
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $data["cities"] = $_SESSION["CITIES"];

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $users = new UsersModel();
        $user_list = $users->getAllUsers();
        foreach ($user_list as $user) {
            $data["users"][$user->id] = $user;

        }

        $this->view('stocks', $data);
    }

    public function show()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $data["user_warehouse"] = 0;
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_city = $URL[2];
            $data["user_warehouse"] = $id_city;
        }

        $data["cities"] = $_SESSION["CITIES"];

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $users = new UsersModel();
        $user_list = $users->getAllUsers();
        foreach ($user_list as $user) {
            $data["users"][$user->id] = $user;
        }
        $products = new ProductsModel();
        foreach ($products->getAllSubProductsSorted() as $product) {
            $data["products"][$product->id] = $product;
        }

        $prod_quant = new ProductsQuantity();
        foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
            $data["sets"][$res->p_id] = $res;
        }

        $this->view('stocks.show', $data);
    }

    public function history()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $data["user_warehouse"] = 0;
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_city = $URL[2];
            $data["user_warehouse"] = $id_city;
        }
        if(isset($URL[3])) {
            $date = $URL[3];
        } else {
            if(isset($_GET["date"])) {
                $date = $_GET["date"];
            } else {
                $date = date('Y-m-d');
            }
        }
        $data["date_plan"] = $date;

        $data["cities"] = $_SESSION["CITIES"];

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $users = new UsersModel();
        $user_list = $users->getAllUsers();
        foreach ($user_list as $user) {
            $data["users"][$user->id] = $user;
        }
        $products = new ProductsModel();
        foreach ($products->getAllSubProductsSorted() as $product) {
            $data["products"][$product->id] = $product;
        }

        $prod_quant = new ProductsQuantity();
        foreach($prod_quant->getLastTransactionsByProductAndMaxDate($id_city, $date) as $res) {
            $data["sets"][$res->p_id] = $res;
        }

        $this->view('stocks.history', $data);
    }

    public function add()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $data["cities"] = $_SESSION["CITIES"];
        $data["user_warehouse"] = 0;
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_city = $URL[2];
            $data["user_warehouse"] = $id_city;
        }
        $date = date("Y-m-d H:i:s");
        $u_id = $_SESSION["USER"]->id;


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //show($_POST);
            $prodqua = new ProductsQuantity();
            foreach($_POST["p_id"] as $p_key => $p_val) {
                $prodqua->insert([
                    "w_id" => $id_city,
                    "p_id" => $p_key,
                    "u_id" => $u_id,
                    "amount" => $p_val,
                    "date" => $date,
                    "old_amount" => $_POST["p_id_old"][$p_key],
                    "transaction_type" => "set"
                ]);
            }
            //die;
        }

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $users = new UsersModel();
        $user_list = $users->getAllUsers();
        foreach ($user_list as $user) {
            $data["users"][$user->id] = $user;
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProductsSorted() as $product) {
            $data["products"][$product->id] = $product;
        }

        $prod_quant = new ProductsQuantity();
        foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
            $data["sets"][$res->p_id] = $res;
        }

        //show($data);
        $data["cities"] = $_SESSION["CITIES"];

        $this->view('stocks.add', $data);
    }
}
