<?php

/**
 * Company class
 */
class Test
{
    use Controller;

    public function index()
    {
        //if (empty($_SESSION['USER']))
        //    redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $date = $URL[2];
        } else {
            if(isset($_GET["date"])) {
                $date = $_GET["date"];
            } else {
                $date = date('Y-m-d');
            }
        }
        $w_id = 1;
        $data["list"]["1-03"] = [];
        $data["list"]["1-04"] = [];
        $data["list"]["1-01"] = [];
        $data["list"]["1-02"] = [];
        $data["list"]["1"] = [];
        $data["list"]["2"] = [];
        $data["list"]["3"] = [];
        $data["list"]["4"] = [];
        $data["list"]["5"] = [];
        $data["list"]["6"] = [];
        $data["list"]["1-05"] = [];

        $skus = new Skumodel();
        foreach($skus->getByParent(1) as $sku) {
            $data["sku"][$sku->full_type] = $sku;
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }
        $planned = new Plannerproduction();
        $int = 1;
        $gr = 0;
        if(!empty($planned->getPlanned($date, $w_id))) {
            foreach ($planned->getPlanned($date, $w_id) as $key => $value) {
                $data["planned"][$value->p_id] = $value;
                if ($value->p_id == 11 || $value->p_id == 622) { //grzanka łososiowa |\ grzanka z serem ziołowym
                    $data["list"][1][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if ($value->p_id == 14) { //Naleśniki
                    $data["list"][2][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if ($value->p_id == 40 || $value->p_id == 41) { //Granola mus owocowy || Granola Toffi
                    $data["list"][3][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if ($value->p_id == 199 || $value->p_id == 200) { //Wrap kurczak || Wrap wołowina
                    $data["list"][6][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if (substr($data["fullproducts"][$value->p_id]->p_name, 0, 5) == "Deser") {
                    $data["list"][4][] = $data["fullproducts"][$value->p_id];
                    $int++;
                } else if (substr($data["fullproducts"][$value->p_id]->p_name, 0, 8) == "Smoothie") {
                    $data["list"][5][] = $data["fullproducts"][$value->p_id];
                    $int++;
                }  else {
                    $data["list"][substr($data["fullproducts"][$value->p_id]->sku,0,4)][] = $data["fullproducts"][$value->p_id];
                    //show($value);
                }

                //$data["list"]
            }
        }
        
        $prices = new PriceModel();
        foreach($prices->getCurrentPrice() as $price) {
            $data["prices"][$price->p_id] = $price;
        }

        
        $data["day_num"] = 1;

        //show($data);
        //die;
        $this->view('test', $data);
    }
    public function wa()
    {
        //if (empty($_SESSION['USER']))
        //    redirect('login');

        $data = [];

        $this->view('test.wa', $data);
    }

    public function me()
    {
        //if (empty($_SESSION['USER']))
        //    redirect('login');

        $data = [];

        $this->view('test.me', $data);
    }
    public function summaryreport()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        
        $data = [];
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2]) && isset($URL[3])) {
            $date_from = $URL[2];
            $date_to = $URL[3];
        } else {
            if (isset($_GET["date_from"])) {
                $date_from = $_GET["date_from"] . " 00:00:00";
                $data["date_from"] = $_GET["date_from"];
            } else {
                $date_from = date('Y-m-d 00:00:00');
            }
            if (isset($_GET["date_to"])) {
                $date_to = $_GET["date_to"] . " 23:59:59";
                $data["date_to"] = $_GET["date_to"];
            } else {
                $date_to = date('Y-m-d 23:59:59');
            }
        }

        if (!isset($_GET["date_from"])) {
            $date_from = '2024-10-10 00:00:00';
            $date_to = '2025-01-05 23:59:59';
            $data["date_from"] = '2024-10-10';
            $data["date_to"] = '2025-01-05';
        }
        $cargo = new Cargo;
        if (!empty($cargo->getAllFullProductsByDate( $date_from, $date_to))) {
            foreach ($cargo->getAllFullProductsByDate( $date_from, $date_to) as $key => $value) {
                if($value->amount > 0 && $value->exclude <> 1) {
                    $date = substr($value->date,0,10);

                    if(!isset($data["cargo"][$value->c_id][$date]["delivery_early"])) {
                        $data["cargo"][$value->c_id][$date]["delivery_early"] = 0;
                    }
                    if(!isset($data["cargo"][$value->c_id][$date]["delivery_late"])) {
                        $data["cargo"][$value->c_id][$date]["delivery_late"] = 0;
                    }
                    if($value->delivery_hour < 2) {
                        $data["cargo"][$value->c_id][$date]["delivery_early"] += $value->amount;
                    } else {
                        $data["cargo"][$value->c_id][$date]["delivery_late"] += $value->amount;
                    }
                    //show($value);
                }
            }
        }

        $return = new ReturnsModel;
        if (!empty($return->getShopsReturn( $date_from, $date_to))) {
            foreach ($return->getShopsReturn( $date_from, $date_to) as $key => $value) {
                    $date = substr($value->date,0,10);
                    if(!isset($data["cargo"][$value->c_id][$date]["return"])) {
                        $data["cargo"][$value->c_id][$date]["return"] = 0;
                    }
                    $data["cargo"][$value->c_id][$date]["return"] += $value->amount;
                    
                    //show($value);
            }
        }
        $companies = new Companies();
        $data["shops"] = [];
        if(!empty($companies->getAllShops())) {
            foreach ($companies->getAllShops() as $key => $value) {
                $data["shops"][$value->id] = $value;
            }
        }


        $this->view('returns.summary', $data);
    }

}
