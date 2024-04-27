<?php

/**
 * Scanner class
 */
class Scanner
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $this->view('scanner.index');
    }
    public function history()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $cities = new Shared();
        $query = "SELECT * FROM `cities` as c INNER JOIN `warehouses` as w ON c.id = w.id_city";
        $temp["cities"] = $cities->query($query);
        foreach ($temp["cities"] as $city) {
            $data["cities"][$city->id] = (array) $city;
        }

        $users = new Shared();
        $query = "SELECT * FROM `users`";
        $temp["users"] = $users->query($query);
        foreach ($temp["users"] as $user) {
            $data["users"][$user->id] = (array) $user;
        }



        if (isset($_GET["search"]) && $_GET["search"] == 1) {
            $data["get"] = $_GET;
            $s = new Shared;
            $date_from = $_GET["date_from"];
            $date_to = $_GET["date_to"];

            $que = " AND ps.date >= '$date_from 00:00:00' AND ps.date <= '$date_to 23:59:59'";

            if (isset($_GET["sku"]) && $_GET["sku"] != "") {
                $sku = $_GET["sku"];
                $que .= " AND ps.sku = '$sku'";
            }
            if (isset($_GET["ean"]) && $_GET["ean"] != "") {
                $ean = $_GET["ean"];
                $que .= " AND ps.ean = '$ean'";
            }
            if (isset($_GET["user"]) && $_GET["user"] != "") {
                $user = $_GET["user"];
                $que .= " AND u_id = $user";
            }
            if (isset($_GET["warehouse"]) && $_GET["warehouse"] != "") {
                $warehouse = $_GET["warehouse"];
                $que .= " AND s_warehouse = $warehouse";
            }

            //show($s->getAllScans($que));
            //die;
            $data["scans"] = $s->getAllScans($que);
        }


        $this->view('scanner.history', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        // do zrobienia
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $scan = new ScanModel;
            if ($scan->validate($_POST) && isset($_POST["scan"])) {
                $u_id = $_SESSION["USER"]->id;
                $s_warehouse = $_SESSION["USER"]->u_warehouse;
                $sku = $_POST["sku"];
                $product = new ProductsModel;
                $p = $product->first(["sku" => $sku]);
                $ean = $p->ean;
                $p_id = $p->id;
                $toUpdate = ["ean" => "$ean", "u_id" => $u_id, "s_warehouse" => $s_warehouse, "p_id" => $p_id, "sku" => "$sku", "ps_active" => 1];
                $scan->insert($toUpdate);
                $scan_id = $scan->firstNewAdded($toUpdate);
                $scan_id = $scan_id->id;
                //echo $scan_id;


                if($p->prod_type == 1) {
                    $recipes = new RecipesModel();
                    foreach ($recipes->getOneRecipt($p_id) as $key => $value) {
                        $qu = ["w_id" => $s_warehouse, "p_id" => $value->sub_prod, "u_id" => $u_id, "amount" => $value->amount, "old_amount" => 0, "transaction_type" => "sub", "scan_id" => $scan_id];
                        $pq = new ProductsQuantity();
                        $pq->insert($qu);
                    }

                }


                $data['success'] = "Produkt zeskanowany";
                unset($_POST);

                //redirect('signup');
            }

            $data['errors'] = $scan->errors;
        }
        $s = new Shared;
        $data["scans"] = $s->getFullData();

        $this->view('scanner.new', $data);
    }

    public function delete()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id_scan = $URL[2];
        $user = $URL[3];

        if ($_SESSION["ROLE"]->id != 1)
            if ($_SESSION["USER"]->id != $user)
                redirect('login');
        $scan = new ScanModel;
        $scan->update($id_scan, ['ps_active' => 0]);

        $pq = new ProductsQuantity;
        $pq->delete($id_scan, "scan_id");

        $com = "Pomyślnie usunięto scan ID: $id_scan";

        return $com;
    }

}
