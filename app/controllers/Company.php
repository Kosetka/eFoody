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
        $data["users"] = $users_list->getAllTraders("users", "3, 5, 11");

        $cities = new Shared();
        $query = "SELECT * FROM `cities`";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //show($_POST);die;
            $company = new Companies;
            if ($_POST["company_type"] == 2 || $_POST["company_type"] == 3) {
                //
            } else {
                unset($_POST["delivery_hour"]);
            }
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
                if ($_POST["company_type"] == 2 || $_POST["company_type"] == 3) {
                    //
                } else {
                    unset($_POST["delivery_hour"]);
                }
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
            $data["users"] = $users_list->getAllTraders("users", "3, 5, 11");

            $this->view('company.edit', $data);
        }
    }

    public function shops()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $companies = new Companies();
        $data["companies"] = $companies->getAllShopsActiveSorted();
        foreach ($companies->getAllShopsActiveSorted() as $co) {
            $data["companies_sorted"][$co->id] = $co;
        }
        $cargo = new Cargo();
        if (!empty($cargo->getLatestCargoDates())) {
            foreach ($cargo->getLatestCargoDates() as $cg) {
                $data["cargo"][$cg->c_id] = $cg;
            }
        }
        if (!empty($cargo->getLastCargo())) {
            foreach ($cargo->getLastCargo() as $ro) {
                $data["cargo_comp"][$ro->c_id][] = $ro;
            }
        }

        $users_list = new User();
        $int = 0;
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
            if($int>0) {
                $data["users"][$user->id]["int"] = 0;
            }
            if($data["users"][$user->id]["u_role"] == 5 || $data["users"][$user->id]["u_role"] == 11) {
                $int++;
                $data["users"][$user->id]["int"] = $int;
            }
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

    public function points()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //show($_POST);die;
            $date = date("Y-m-d H:i:s");
            $u_id = $_SESSION["USER"]->id;
            $toUpdate = ["description" => $_POST["description"], "status" => $_POST["status"], "visit_date" => $date, "u_id" => $u_id];
            //show($_POST);
            $id = $_POST["id"];
            $card = new Companiestocheck;
            $card->update($id, $toUpdate);
            $data['success'] = "Edycja firmy pomyślna";
        }

        $companies = new Companiestocheck();
        $data["companies"] = $companies->getCompaniesToVisit();
        foreach ($companies->getCompaniesToVisit() as $co) {
            $data["companies_sorted"][$co->id] = $co;
        }
        if (!empty($companies->getCompaniesVisited())) {
            foreach ($companies->getCompaniesVisited() as $co) {
                $data["companies_visited"][$co->id] = $co;
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

        $this->view('companypoints', $data);
    }

    public function pointslist()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $companies = new Companiestocheck();
        $data["companies"] = $companies->getCompaniesActive();
        foreach ($companies->getCompaniesActive() as $co) {
            $data["companies_sorted"][$co->id] = $co;
        }

        $users_list = new User();
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        $this->view('companypointslist', $data);
    }

    public function pointstatus()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $data["status"] = "";

        if(!empty($_GET["send"])) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            if(isset($URL[2])) {
                $status = $URL[2];
            }
            if(isset($_GET["send"])) {
                if (isset($_GET["status"])) {
                    $status = $_GET["status"];
                }
            }

            $companies = new Companiestocheck();
            if($status == 99) {
                if(!empty($companies->getCompaniesActive())) {
                    foreach($companies->getCompaniesActive() as $com) {
                        $data["companies"][$com->id] = $com;
                    }
                }
            } else {
                if(!empty($companies->getCompaniesActiveByStatus($status))) {
                    foreach($companies->getCompaniesActiveByStatus($status) as $com) {
                        $data["companies"][$com->id] = $com;
                    }
                }
            }
            $data["status"] = $status;
        }

        $this->view('companypointstatus', $data);
    }

    public function pointadd()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];


        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //show($_POST);die;
            $u_id = $_SESSION["USER"]->id;
            $date = date("Y-m-d H:i:s");
            $address = $_POST["street"] . " " . $_POST["street_number"] . ", " . $_POST["city"] . " " . $_POST["postal_code"];
            $toInsert = [
                "address" => $address,
                "street" => $_POST["street"],
                "street_number" => $_POST["street_number"],
                "postal_code" => $_POST["postal_code"],
                "city" => $_POST["city"],
                "phone_number" => $_POST["phone_number"],
                "latitude" => $_POST["latitude"],
                "longitude" => $_POST["longitude"],
                "type" => $_POST["type"],
                "u_id" => $u_id,
                "status" => $_POST["status"],
                "name" => $_POST["name"],
                "visit_date" => $date,
                "description" => $_POST["description"],
                "inserted" => 1
            ];

            $comp = new Companiestocheck;
            $comp->insert($toInsert);
            $data['success'] = "Punkt został dodany";

            unset($_POST);
            redirect('company/pointslist');
        }
        $data["edit"] = False;

        $companies = new Companiestocheck();
        $data["companies"] = $companies->getCompanies();
        foreach ($companies->getCompanies() as $co) {
            $data["companies_sorted"][$co->id] = $co;
        }

        $users_list = new User();
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        foreach($users_list->getAllDriverShopsActive() as $us) {
            $data["drivers"][$us->id] = $us;
        }

        $this->view('companypointadd', $data);
    }

    public function pointedit()
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
            //show($_POST);die;
            if(isset($_POST["is_added"])){
                $toInsert = [
                    "latitude" => $_POST["latitude"],
                    "longitude" => $_POST["longitude"]
                ];

                $comp = new Companiestocheck;
                $comp->update($id, $toInsert);
                unset($_POST);
                redirect('company/pointslist');

            } else if (isset($_POST["newadd"])) {
                $u_id = $_SESSION["USER"]->id;
                $address = $_POST["street"] . " " . $_POST["street_number"] . ", " . $_POST["city"] . " " . $_POST["postal_code"];
                $toInsert = [
                    "address" => $address,
                    "street" => $_POST["street"],
                    "street_number" => $_POST["street_number"],
                    "postal_code" => $_POST["postal_code"],
                    "city" => $_POST["city"],
                    "phone_number" => $_POST["phone_number"],
                    "latitude" => $_POST["latitude"],
                    "longitude" => $_POST["longitude"],
                    "type" => $_POST["type"],
                    "u_id" => $u_id,
                    "status" => $_POST["status"],
                    "name" => $_POST["name"],
                    "description" => $_POST["description"]
                ];

                $comp = new Companiestocheck;
                $comp->update($id, $toInsert);
                $data['success'] = "Punkt został edytowany";
                if ($_POST["status"] == 2) {
                    if (isset($_POST["moved"])) {
                        //tutaj do dodania jako sklep
                        $comp->update($id, ["moved" => 1]);
                        $date = date("Y-m-d H:i:s");

                        $company = new Companies;

                        $toInsert = [
                            "phone_number" => $_POST["phone_number"],
                            "full_name" => $_POST["name"],
                            "active" => 1,
                            "address" => $address,
                            "postal_code" => $_POST["postal_code"],
                            "city" => $_POST["city"],
                            "street" => $_POST["street"],
                            "street_number" => $_POST["street_number"],
                            "company_type" => 3,
                            "description" => "",
                            "latitude" => $_POST["latitude"],
                            "longitude" => $_POST["longitude"],
                            "c_type" => "shop",
                            "delivery_hour" => $_POST["hours"],
                            "contact_first_name" => "",
                            "contact_last_name" => "",
                            "city_id" => 1,
                            "guardian" => $_POST["driver"],
                            "nip" => "",
                            "date" => $date,
                            "workers" => "",
                            "friendly_name" => "",
                        ];

                        $company->insert($toInsert);

                        $data['success'] = "Sklep został dodany pomyślnie";



                        if (isset($_POST["phone_number"])) {
                            if ($_POST["phone_number"] != "") {
                                $last_id = ""; // pobrać ID
                                $last_id = $company->getLast();
                                $last_id = $last_id[0]->id;
                                $companies = new Companiesphone;
                                $que_phone = ["c_id" => $last_id, "c_phone" => $_POST["phone_number"]]; // sprawdzić
                                $companies->insert($que_phone);
                            }
                        }
                    }
                } else {
                    if ($_POST["status"] != 0) {
                        if (isset($_POST["to_delete"])) {
                            $comp->update($id, ["to_delete" => 1]);
                        } else {
                            $comp->update($id, ["to_delete" => 0]);
                        }
                    }
                }

                unset($_POST);
                redirect('company/pointslist');
            }
        }
        $data["edit"] = True;

        $companies = new Companiestocheck;
        $data["comp"] = $companies->getCompany($id)[0];
        //show($data);die;

        $companies = new Companiestocheck();
        $data["companies"] = $companies->getCompanies();
        foreach ($companies->getCompanies() as $co) {
            $data["companies_sorted"][$co->id] = $co;
        }

        $users_list = new User();
        $temp["users"] = $users_list->getAll("users");
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        foreach($users_list->getAllDriverShopsActive() as $us) {
            $data["drivers"][$us->id] = $us;
        }

        $this->view('companypointadd', $data);
    }

}
