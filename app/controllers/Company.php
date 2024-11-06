<?php

/**
 * Company class
 */
class Company
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $companies = new Companies();
        $data["companies"] = $companies->getAll("companies");

        $users_list = new User();
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        $cities = new Shared();
        $query = "SELECT * FROM `cities`";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $companies = new Companiesphone;
        foreach ($companies->getAllNumbers() as $company) {
            $data["phone_numbers"][$company->c_id][$company->c_phone] = $company->c_phone;
        }

        $this->view('company', $data);
    }

    public function setDepartment()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $id_warehouse = $URL[2];
            $id_user = $_SESSION["USER"]->id;
            $query = "UPDATE users SET u_warehouse = $id_warehouse WHERE id = $id_user LIMIT 1;";
            $user = new UsersModel();
            $result = $user->query($query);
            $_SESSION["USER"]->u_warehouse = $id_warehouse;


            $this->view('company.setDepartment', $result);

        }
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $users_list = new User();
        $data["users"] = $users_list->getAllTraders("users", "3");

        $cities = new Shared();
        $query = "SELECT * FROM `cities`";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //show($_POST);die;
            $company = new Companies;
            $_POST["date"] = date("Y-m-d H:i:s");
            $_POST["phone_number"] = $_POST["phone_numbers"][0];
            $_POST["address"] = $_POST["street"] . " " . $_POST["street_number"] . ", " . $_POST["city"] . " " . $_POST["postal_code"];
            if ($company->validate($_POST)) {
                $company->insert($_POST);
                $data['success'] = "Konto firmy zostało pomyślnie utworzone";

                $last_id = ""; // pobrać ID
                $last_id = $company->getLast();
                $last_id = $last_id[0]->id;
                $companies = new Companiesphone;
                foreach ($_POST["phone_numbers"] as $phone) {
                    if ($phone != "") {
                        $que_phone = ["c_id" => $last_id, "c_phone" => $phone]; // sprawdzić
                        $companies->insert($que_phone);
                    }
                }


                $this->view('company.new', $data);
                die;
            }
            $data['errors'] = $company->errors;
        }
        $this->view('company.new', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $company_id = $URL[2];
            $_POST["phone_number"] = $_POST["phone_numbers"][0];
            $company = new Companies();
            if (!isset($_POST["active"])) {
                $_POST["active"] = 0;
            }
            if (isset($_POST["companyEdit"])) {
                $_POST["address"] = $_POST["street"] . " " . $_POST["street_number"] . ", " . $_POST["city"] . " " . $_POST["postal_code"];
                $company->update($company_id, $_POST);
                $data['success'] = "Edycja firmy pomyślna!";
                $companies = new Companiesphone;
                $companies->delete($company_id, "c_id");
                foreach ($_POST["phone_numbers"] as $phone) {
                    if ($phone != "") {
                        $que_phone = ["c_id" => $company_id, "c_phone" => $phone]; // sprawdzić
                        $companies->insert($que_phone);
                    }
                }
            }
        }

        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $company_id = $URL[2];
            $company = new Companies();
            $data["companies"] = $company->getOne("companies", $company_id)[0];
            $cities = new Shared();
            $query = "SELECT * FROM `cities`";
            $temp["cities"] = $cities->query($query);
            foreach ($temp["cities"] as $city) {
                $data["cities"][$city->id] = (array) $city;
            }

            $companies = new Companiesphone;
            $data["phone_numbers"] = $companies->getAllById($company_id);

            $users_list = new User();
            $data["users"] = $users_list->getAllTraders("users", "3");

            $this->view('company.edit', $data);
        }
    }

    public function shops()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $companies = new Companies();
        $data["companies"] = $companies->getAllShopsActive();
        $cargo = new Cargo();
        if (!empty($cargo->getLatestCargoDates())) {
            foreach ($cargo->getLatestCargoDates() as $cg) {
                $data["cargo"][$cg->c_id] = $cg;
            }
        }

        $users_list = new User();
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        $apikey = new Apitokens;
        $data["token"] = $apikey->getToken("google_maps");

        $wh = new WarehouseModel;
        $data["warehouse"] = $wh->getWarehouses();

        $companies = new Companiesphone;
        foreach ($companies->getAllNumbers() as $company) {
            $data["phone_numbers"][$company->c_id][$company->c_phone] = $company->c_phone;
        }

        $this->view('companyshops', $data);
    }

}
