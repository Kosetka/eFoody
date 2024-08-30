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
        if(!empty($prod_quant->getLastTransactionsByProduct($id_city))) {
            foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
                $data["sets"][$res->p_id] = $res;
            }
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
                $old = $_POST["p_id_old"][$p_key];
                if($_POST["p_id_old"][$p_key] == "") {
                    $old = 0;
                }
                $prodqua->insert([
                    "w_id" => $id_city,
                    "p_id" => $p_key,
                    "u_id" => $u_id,
                    "amount" => $p_val,
                    "date" => $date,
                    "old_amount" => $old,
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
        if(!empty($prod_quant->getLastTransactionsByProduct($id_city))) {
            foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
                $data["sets"][$res->p_id] = $res;
            }
        }
        if(!empty($prod_quant->getLastTransactionsWithAddAndSub($id_city))) {
            foreach($prod_quant->getLastTransactionsWithAddAndSub($id_city) as $res) {
                if($res->transaction_type == "add") {
                    if(!isset($data["sets_all"][$res->p_id]["add"])) {
                        $data["sets_all"][$res->p_id]["add"] = 0;
                    }
                    $data["sets_all"][$res->p_id]["add"] += $res->amount;
                }
                if($res->transaction_type == "sub") {
                    if(!isset($data["sets_all"][$res->p_id]["sub"])) {
                        $data["sets_all"][$res->p_id]["sub"] = 0;
                    }
                    $data["sets_all"][$res->p_id]["sub"] += $res->amount;
                }
            }
        }
        //show($data["sets_all"]);
        //die;

        //show($data);
        $data["cities"] = $_SESSION["CITIES"];

        $this->view('stocks.add', $data);
    }

    public function storageadd()
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
            $prbo = new Productsbought();
            foreach($_POST["ordered_products"] as $p_key => $p_val) {
                $old_am = 0;
                if(!empty($prodqua->getLast($id_city, $p_key))) {
                    if($prodqua->getLast($id_city, $p_key)[0]->transaction_type == "set") {
                        $old_am = $prodqua->getLast($id_city, $p_key)[0]->amount;
                    } else if($prodqua->getLast($id_city, $p_key)[0]->transaction_type == "add") {
                        $old_am = $prodqua->getLast($id_city, $p_key)[0]->amount + $prodqua->getLast($id_city, $p_key)[0]->old_amount;
                    } else if($prodqua->getLast($id_city, $p_key)[0]->transaction_type == "sub") {
                        $old_am = $prodqua->getLast($id_city, $p_key)[0]->old_amount - $prodqua->getLast($id_city, $p_key)[0]->amount;
                    }
                }
                $prodqua->insert([
                    "w_id" => $id_city,
                    "p_id" => $p_key,
                    "u_id" => $u_id,
                    "amount" => $p_val["amount"],
                    "date" => $date,
                    "old_amount" => $old_am,
                    "transaction_type" => "add"
                ]);

                $prbo->insert([
                    "date" => $_POST["z_date"],
                    "p_id" => $p_key,
                    "amount" => $p_val["amount"],
                    "cost" => $p_val["cost"],
                    "u_id" => $u_id,
                    "company_id" => $_POST["w_id"]
                ]);
            }
            

            //die;
        }

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $data["companies"] = [];
        $companies = new Companies();
        if(!empty($companies->getAllCompaniesBuy())) {
            foreach ($companies->getAllCompaniesBuy() as $company) {
                $data["companies"][$company->id] = $company;
            }
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["halfproducts"][$product->id] = (array) $product;
        }

        $prod_quant = new ProductsQuantity();
        foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
            $data["sets"][$res->p_id] = $res;
        }

        //show($data);
        $data["cities"] = $_SESSION["CITIES"];

        $this->view('stocks.storageadd', $data);
    }

    public function storagesub()
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
            foreach($_POST["ordered_products"] as $p_key => $p_val) {
                $old_am = 0;
                if($prodqua->getLast($id_city, $p_key)[0]->transaction_type == "set") {
                    $old_am = $prodqua->getLast($id_city, $p_key)[0]->amount;
                } else if($prodqua->getLast($id_city, $p_key)[0]->transaction_type == "add") {
                    $old_am = $prodqua->getLast($id_city, $p_key)[0]->amount + $prodqua->getLast($id_city, $p_key)[0]->old_amount;
                } else if($prodqua->getLast($id_city, $p_key)[0]->transaction_type == "sub") {
                    $old_am = $prodqua->getLast($id_city, $p_key)[0]->old_amount - $prodqua->getLast($id_city, $p_key)[0]->amount;
                }

                $prodqua->insert([
                    "w_id" => $id_city,
                    "p_id" => $p_key,
                    "u_id" => $u_id,
                    "amount" => $p_val["amount"],
                    "date" => $date,
                    "old_amount" => $old_am,
                    "transaction_type" => "sub"
                ]);

            }
            

            //die;
        }

        foreach ($_SESSION["CITIES"] as $key => $value) {
            $prod = new ProductsQuantity();
            $id = $value["id"];
            $data["sets"][$id] = $prod->getAllSetByWarehouse($key);
        }

        $data["companies"] = [];
        $companies = new Companies();
        if(!empty($companies->getAllCompaniesBuy())) {
            foreach ($companies->getAllCompaniesBuy() as $company) {
                $data["companies"][$company->id] = $company;
            }
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["halfproducts"][$product->id] = (array) $product;
        }

        $prod_quant = new ProductsQuantity();
        foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
            $data["sets"][$res->p_id] = $res;
        }

        //show($data);
        $data["cities"] = $_SESSION["CITIES"];

        $this->view('stocks.storagesub', $data);
    }

    public function storage()
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

        $this->view('stocks.storage', $data);
    }
}
