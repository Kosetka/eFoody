<?php

/**
 * users class
 */
class Users
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $users = new UsersModel();
        foreach($users->getAllUsers() as $user) {
            $data["users"][$user->id] = (array) $user;
        }

        $role = new RolesNameModel;
        $data["roles"] = $role->getRoles();

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $this->view('users', $data);
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


            $this->view('users.setDepartment', $result);

        }
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $access = [1, 2, 4];
        if(!in_array($_SESSION['USER']->u_role,$access))
            redirect('login');

        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_GET)) {
            //show($_POST);die;

            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $user_id = $URL[2];
            
            $user = new User();
            $warehouse_access = new WarehouseAccessModel();
            if (isset($_POST["userEdit"])) {
                if($_POST["u_role"] <> 10) {
                    $_POST["helper_for"] = NULL;
                    //unset($_POST["helper_for"]);
                }
                if(!isset($_POST["active"])) {
                    $_POST["active"] = 0;
                }
                $user->update($user_id, $_POST);
                $u_warehouse = $_POST["u_warehouse"];
                $update_data = ["u_id" => $user_id, "w_id" => $u_warehouse];
                $relationExist = $warehouse_access->first($update_data);
                if (!$relationExist) {
                    $warehouse_access->insert($update_data);
                }

                if($_POST["u_role"] == 10) {
                    $helper_history = new Helperhistory();
                    $d_last = "";
                    $date = date("Y-m-d");
                    if(!empty($helper_history->getLast($user_id)[0])) {
                        if($helper_history->getLast($user_id)[0]->helper_for != $_POST["helper_for"]) {
                            $d_last = $helper_history->getLast($user_id)[0];
                            $helper_history->update($d_last->id,["date_to" => date("Y-m-d", strtotime($date . " -1 day"))]);
                            $helper_history->insert([
                                'u_id' => $user_id,
                                'date_from' => $date,
                                'date_to' => NULL,
                                'helper_for' => $_POST["helper_for"]
                            ]);
                        } else {
                             if($helper_history->getLast($user_id)[0]->date_to != NULL) {
                                $helper_history->insert([
                                    'u_id' => $user_id,
                                    'date_from' => $date,
                                    'date_to' => NULL,
                                    'helper_for' => $_POST["helper_for"]
                                ]);
                            }
                        }
                    } else {
                        $helper_history->insert([
                            'u_id' => $user_id,
                            'date_from' => $date,
                            'date_to' => NULL,
                            'helper_for' => $_POST["helper_for"]
                        ]);
                    }
                } else {
                    $helper_history = new Helperhistory();
                    $d_last = "";
                    $date = date("Y-m-d");
                    //show($helper_history->getLast($user_id)[0]);die;
                    if(!empty($helper_history->getLast($user_id)[0])) {
                        $d_last = $helper_history->getLast($user_id)[0];
                        $helper_history->update($d_last->id,["date_to" => date("Y-m-d", strtotime($date . " -1 day"))]);
                    }
                }

                if($_POST["active"] == 0) {
                    //zwolniony
                    $user_history = new Userhistory();
                    $d_last = "";
                    $date = date("Y-m-d");
                    if(!empty($user_history->getLast($user_id)[0])) {
                        $d_last = $user_history->getLast($user_id)[0];
                        $user_history->update($d_last->id,["date_to" => date("Y-m-d", strtotime($date . " -1 day"))]);
                    }
                } else {
                    //zatrudniony ponownie
                    $user_history = new Userhistory();
                    $d_last = "";
                    $date = date("Y-m-d");
                    //show($user_history->getLast($user_id)[0]);die;
                    if(!empty($user_history->getLast($user_id)[0])) {
                        $d_last = $user_history->getLast($user_id)[0];
                        if($d_last->date_to != NULL){
                            $user_history->insert([
                                "date_from" => $date, 
                                "date_to" => NULL, 
                                "role" => $_POST["u_role"],
                                "u_id" => $user_id,
                                "helper_for" => $_POST["helper_for"],
                            ]);
                        } else {
                            if($d_last->role != $_POST["u_role"]) {
                                $user_history->update($d_last->id,["date_to" => date("Y-m-d", strtotime($date . " -1 day"))]);
                                $user_history->insert([
                                    "date_from" => $date, 
                                    "date_to" => NULL, 
                                    "role" => $_POST["u_role"],
                                    "u_id" => $user_id,
                                    "helper_for" => $_POST["helper_for"],
                                ]);
                            }
                        }

                    }
                    
                    
                }



                $data['success'] = "Edycja konta pomyślna!";
            } elseif (isset($_POST["warehouseEdit"])) {
                $query = "delete from warehouse_access where u_id = $user_id";
                $warehouse_access->query($query);
                foreach ($_POST["check"] as $k => $v) {
                    $update_data = ["u_id" => $user_id, "w_id" => $v];
                    $warehouse_access->insert($update_data);
                }
                $data['success_warehouse'] = "Edycja magazynów pomyślna!";
                //edycja dolengo formularza
            } elseif (isset($_POST["payrate"])) {
                $set_u_id = $_SESSION["USER"]->id;
                $type = $_POST["type"];
                $rate = $_POST["rate"];
                $date_from = $_POST["date_from"];
                $date_to = $_POST["date_to"];
                if(empty($_POST["date_to"])) {
                    $date_to = NULL;
                }
                if(isset($_POST["edit_id"])) {
                    $que = [
                        "type"=> $type,
                        "rate"=> $rate,
                        "date_from"=> $date_from,
                        "date_to"=> $date_to,
                        "set_u_id"=> $set_u_id
                    ];
                    $payrate = new Payrate();
                    $payrate->update($_POST["edit_id"], $que);
                    $data['success_payrate'] = "Stawka pomyślnie edytowana!";

                } else {
                    $que = [
                        "u_id" => $user_id,
                        "type"=> $type,
                        "rate"=> $rate,
                        "date_from"=> $date_from,
                        "date_to"=> $date_to,
                        "set_u_id"=> $set_u_id
                    ];
    
                    $payrate = new Payrate();
    
                    $upd = $payrate->getActiveByUser($user_id);
                    if(!empty($upd)) {
                        $new_date = date('Y-m-d', strtotime($date_from . ' -1 day'));
                        $payrate->update($upd[0]->id, ["date_to" => $new_date]);
                    }
    
                    $payrate->insert($que);
    
                    $data['success_payrate'] = "Stawka pomyślnie dodana!";
                }
            }
        }

        if (!empty($_GET)) {
            $URL = $_GET['url'] ?? 'home';
            $URL = explode("/", trim($URL, "/"));
            $user_id = $URL[2];

            if(isset($URL[3])) {
                $payrate_id = $URL[3];
                $data["payrate_id"] = $payrate_id;
                $pr = new Payrate();
                $data["payrate"] = $pr->getPayrate($payrate_id);
            } else {
                $payrate_id = 0;
                $data["payrate_id"] = $payrate_id;
            }

            $user = new User();
            $data["user"] = $user->getOne("users", $user_id)[0];

            $userhistory = new Userhistory();
            $data["user_history"] = $userhistory->getUser($user_id);

            foreach($user->getAllTraders("users", TRADERS) as $trader) {
                $data["users"][$trader->id] = $trader; 
            }

            $roles_name = new RolesNameModel();
            $roles_name->getRoles();
            $data["roles"] = $roles_name->roles;
            foreach($roles_name->getRoles() as $role) {
                $data["roles_history"][$role["id"]] = $role;
            }
            $cities = new Shared();
            $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
            $temp["cities"] = $cities->query($query);
            foreach ($temp["cities"] as $city) {
                $data["cities"][$city->id] = (array) $city;
            }
            $cities2 = new Shared();
            $query2 = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city INNER JOIN warehouse_access as a ON a.w_id = w.id WHERE u_id = $user_id ORDER BY a.w_id ASC";
            $temp2["cities"] = $cities2->query($query2);
            $data["cityList"] = [];
            foreach ($temp2["cities"] as $city2) {
                $data["cityList"][$city2->id] = $city2;
            }

            $payrate = new Payrate();
            $data["payrates"] = $payrate->getUserPayrate($user_id);

            $this->view('users.edit', $data);
        }
    }

}
