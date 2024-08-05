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
        $products = new Productsmodel();
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
        $products = new Productsmodel();
        foreach ($products->getAllSubProductsSorted() as $product) {
            $data["products"][$product->id] = $product;
        }

        $prod_quant = new ProductsQuantity();
        foreach($prod_quant->getLastTransactionsByProduct($id_city) as $res) {
            $data["sets"][$res->p_id] = $res;
        }

        $this->view('stocks.history', $data);
    }
}
