<?php

/**
 * GetCargo class
 */
class Orders
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];


        redirect('home');
        $this->view('index', $data);
    }

    public function show()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $date_from = $URL[2];
            if (isset($URL[3])) {
                $date_to = $URL[3];
            } else {
                $date_to = $date_from;
            }
        } else {
            if (isset($_GET["date_from"])) {
                $date_from = $_GET["date_from"];
                if (isset($_GET["date_to"])) {
                    $date_to = $_GET["date_to"];
                } else {
                    $date_to = $date_from;
                }
            } else {
                $date_from = date('Y-m-d');
                $date_to = date('Y-m-d');
            }
        }

        $data["date_from"] = $date_from;
        $data["date_to"] = $date_to;
        $data["ordered"] = [];
        $clients = new Client();
        if(!empty($clients->getAllUsers())) {
            foreach($clients->getAllUsers() as $cl) {
                $data["clients"][$cl->id] = $cl;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }
        $ord = new Order;
        if (!empty($ord->getFullOrdersbyDate($date_from, $date_to))) {
            foreach ($ord->getFullOrdersbyDate($date_from, $date_to) as $o) {
                $data["ordered"][$o->order_id][$o->o_date][$o->p_id]["p_id"] = $data["fullproducts"][$o->p_id]->p_name;
                $data["ordered"][$o->order_id][$o->o_date][$o->p_id]["amount"] = $o->amount;
                $data["ordered"][$o->order_id][$o->o_date][$o->p_id]["cost"] = $o->cost;
                $data["ordered"][$o->order_id]["data"]["description"] = $o->o_description;
                $data["ordered"][$o->order_id]["data"]["fv"] = $o->fv;
                $data["ordered"][$o->order_id]["data"]["fv_id"] = $o->fv_id;
                $data["ordered"][$o->order_id]["data"]["not_return_status"] = $o->o_status;
                $data["ordered"][$o->order_id]["data"]["order_date"] = $o->date;
                $fname = "";
                if(isset($data["clients"][$o->u_id])) {
                    $fname = $data["clients"][$o->u_id]->full_name;
                }
                $address = "";
                if(isset($data["clients"][$o->u_id])) {
                    $address = $data["clients"][$o->u_id]->street." ".$data["clients"][$o->u_id]->street_number;
                    if($data["clients"][$o->u_id]->house_number <> "") {
                        $address .= "/".$data["clients"][$o->u_id]->house_number;
                    }
                    $address .= ", ".$data["clients"][$o->u_id]->city." ".$data["clients"][$o->u_id]->postal_code;
                }
                $data["ordered"][$o->order_id]["data"]["address"] = $address;
                $data["ordered"][$o->order_id]["data"]["u_id"] = $o->u_id;
                $data["ordered"][$o->order_id]["data"]["full_name"] = $fname. "<br>(tel. ".$o->o_phone.")";
                $data["ordered"][$o->order_id]["data"]["order_status"] = CART_STATUS[$o->status];
                $data["ordered"][$o->order_id]["data"]["o_phone"] = $o->o_phone;
                $data["ordered"][$o->order_id]["data"]["o_email"] = $o->o_email;
                $data["ordered"][$o->order_id]["data"]["discount"] = $o->discount;
                $data["ordered"][$o->order_id]["data"]["id_discount_code"] = $o->id_discount_code;
                $data["ordered"][$o->order_id]["data"]["discount_amount"] = $o->discount_amount;
            }
        }
        
        
        $this->view('orders.show', $data);
    }

    public function kitchenplan() 
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $date_from = $URL[2];
        } else {
            if (isset($_GET["date_from"])) {
                $date_from = $_GET["date_from"];
            } else {
                $date_from = date('Y-m-d');
            }
        }

        $data["date_from"] = $date_from;
        $data["ordered"] = [];
        $clients = new Client();
        if(!empty($clients->getAllUsers())) {
            foreach($clients->getAllUsers() as $cl) {
                $data["clients"][$cl->id] = $cl;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }
        $data["total"] = [];
        $ord = new Order;
        if (!empty($ord->getFullOrdersSingleDay($date_from, ))) {
            foreach ($ord->getFullOrdersSingleDay($date_from, ) as $o) {
                $data["ordered"][$o->order_id][$o->p_id]["p_id"] = $data["fullproducts"][$o->p_id]->p_name;
                $data["ordered"][$o->order_id][$o->p_id]["amount"] = $o->amount;
                $data["ordered"][$o->order_id][$o->p_id]["cost"] = $o->cost;
                $data["ordered"][$o->order_id]["data"]["description"] = $o->o_description;
                $data["ordered"][$o->order_id]["data"]["fv"] = $o->fv;
                $data["ordered"][$o->order_id]["data"]["fv_id"] = $o->fv_id;
                $data["ordered"][$o->order_id]["data"]["not_return_status"] = $o->o_status;
                $data["ordered"][$o->order_id]["data"]["order_date"] = $o->date;
                $fname = "";
                if(isset($data["clients"][$o->u_id])) {
                    $fname = $data["clients"][$o->u_id]->full_name;
                }
                $address = "";
                if(isset($data["clients"][$o->u_id])) {
                    $address = $data["clients"][$o->u_id]->street." ".$data["clients"][$o->u_id]->street_number;
                    if($data["clients"][$o->u_id]->house_number <> "") {
                        $address .= "/".$data["clients"][$o->u_id]->house_number;
                    }
                    $address .= ", ".$data["clients"][$o->u_id]->city." ".$data["clients"][$o->u_id]->postal_code;
                }
                $data["ordered"][$o->order_id]["data"]["address"] = $address;
                $data["ordered"][$o->order_id]["data"]["u_id"] = $o->u_id;
                $data["ordered"][$o->order_id]["data"]["full_name"] = $fname;
                $data["ordered"][$o->order_id]["data"]["order_status"] = CART_STATUS[$o->status];
                $data["ordered"][$o->order_id]["data"]["o_phone"] = $o->o_phone;
                $data["ordered"][$o->order_id]["data"]["o_email"] = $o->o_email;
                $data["ordered"][$o->order_id]["data"]["discount"] = $o->discount;
                $data["ordered"][$o->order_id]["data"]["id_discount_code"] = $o->id_discount_code;
                $data["ordered"][$o->order_id]["data"]["discount_amount"] = $o->discount_amount;
                $data["ordered"][$o->order_id]["data"]["order_id"] = $o->order_id;

                if(!isset($data["total"][$o->p_id])) {
                    $data["total"][$o->p_id] = 0;
                }
                $data["total"][$o->p_id] += $o->amount;
            }
        }
        usort($data["ordered"], function ($a, $b) {
            return strcmp($a['data']['address'], $b['data']['address']);
        });
        //show($data["total"]);
        //die;
        
        $this->view('orders.kitchenplan', $data);
    }
    public function driverplan() 
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if (isset($URL[2])) {
            $date_from = $URL[2];
        } else {
            if (isset($_GET["date_from"])) {
                $date_from = $_GET["date_from"];
            } else {
                $date_from = date('Y-m-d');
            }
        }

        $data["date_from"] = $date_from;
        $data["ordered"] = [];
        $clients = new Client();
        if(!empty($clients->getAllUsers())) {
            foreach($clients->getAllUsers() as $cl) {
                $data["clients"][$cl->id] = $cl;
            }
        }
        $products_list = new ProductsModel();
        foreach ($products_list->getAllFullProducts() as $key => $value) {
            $data["fullproducts"][$value->id] = $value;
        }
        $data["total"] = [];
        $ord = new Order;
        if (!empty($ord->getFullOrdersSingleDay($date_from, ))) {
            foreach ($ord->getFullOrdersSingleDay($date_from, ) as $o) {
                $data["ordered"][$o->order_id][$o->p_id]["p_id"] = $data["fullproducts"][$o->p_id]->p_name;
                $data["ordered"][$o->order_id][$o->p_id]["amount"] = $o->amount;
                $data["ordered"][$o->order_id][$o->p_id]["cost"] = $o->cost;
                $data["ordered"][$o->order_id]["data"]["description"] = $o->o_description;
                $data["ordered"][$o->order_id]["data"]["fv"] = $o->fv;
                $data["ordered"][$o->order_id]["data"]["fv_id"] = $o->fv_id;
                $data["ordered"][$o->order_id]["data"]["not_return_status"] = $o->o_status;
                $data["ordered"][$o->order_id]["data"]["order_date"] = $o->date;
                $fname = "";
                if(isset($data["clients"][$o->u_id])) {
                    $fname = $data["clients"][$o->u_id]->full_name;
                }
                $address = "";
                if(isset($data["clients"][$o->u_id])) {
                    $address = $data["clients"][$o->u_id]->street." ".$data["clients"][$o->u_id]->street_number;
                    if($data["clients"][$o->u_id]->house_number <> "") {
                        $address .= "/".$data["clients"][$o->u_id]->house_number;
                    }
                    $address .= ", ".$data["clients"][$o->u_id]->city." ".$data["clients"][$o->u_id]->postal_code;
                }
                $data["ordered"][$o->order_id]["data"]["address"] = $address;
                $data["ordered"][$o->order_id]["data"]["u_id"] = $o->u_id;
                $data["ordered"][$o->order_id]["data"]["full_name"] = $fname . "</br>(tel. ".$o->o_phone.")";
                $data["ordered"][$o->order_id]["data"]["order_status"] = CART_STATUS[$o->status];
                $data["ordered"][$o->order_id]["data"]["o_phone"] = $o->o_phone;
                $data["ordered"][$o->order_id]["data"]["o_email"] = $o->o_email;
                $data["ordered"][$o->order_id]["data"]["discount"] = $o->discount;
                $data["ordered"][$o->order_id]["data"]["id_discount_code"] = $o->id_discount_code;
                $data["ordered"][$o->order_id]["data"]["discount_amount"] = $o->discount_amount;
                $data["ordered"][$o->order_id]["data"]["order_id"] = $o->order_id;

                if(!isset($data["total"][$o->p_id])) {
                    $data["total"][$o->p_id] = 0;
                }
                $data["total"][$o->p_id] += $o->amount;
            }
        }
        //show($data["ordered"]);
        usort($data["ordered"], function ($a, $b) {
            return strcmp($a['data']['address'], $b['data']['address']);
        });
        
        //show($data["ordered"]);die;
        //show($data["total"]);
        //die;
        
        $this->view('orders.driverplan', $data);
    }

    public function checker()
    {

        //CRON - sprawdza czy zamówienie zostało opłacone kartą i wysyła powiadomienia

        $data = [];
        $data["errors"] = [];
        $data["page"]["title"] = "Sprawdzanie statusów zamówień - Pan Obiadek | Pyszne Obiady i Catering w Radomiu";
        $data["page"]["link"] = "https://www.pan-obiadek.pl/zamowienie/checker";
        $data["page"]["sublink"] = "checker";

        $date = date("Y-m-d");
        $orders = new Order();
        $payu_status = new Payu();
        if(!empty($orders->getOrdersAwaiting($date))) {
            foreach($orders->getOrdersAwaiting($date) as $order) {
                $order_id = $order->id;
                if(!empty($payu_status->getPayuStatus($order_id))) {
                    $status = $payu_status->getPayuStatus($order_id)[0]->status;
                    $email = $order->o_email;
                    $phone = $order->o_phone;
                    if($status == "COMPLETED") {
                        $orders->update($order_id,[
                            "status" => 3
                        ]);
                        $send_sms = new Sendsms();
                        $send_sms->sendSMSconfirm($phone, $order_id);

                        $send_email = new Sendemail();
                        $send_email->sendEMAILconfirmation($email,$order_id);
                    }
                    if($status == "CANCELED") {
                        $orders->update($order_id,[
                            "status" => 8
                        ]);

                        $send_email = new Sendemail();
                        $send_email->sendEMAILconfirmationfailed($email,$order_id);
                    }
                }
                //show($order);
                //biore info z payu_statuses czy jest wpis z moim order_id, jak nie ma to pomijam, jak jest to sprawdzam który i aktualizuje status w zamówieniu + ewentualnie wyysłam info
                //COMPLETED
                //CANCELED
            }
        }
        

        //$this->view('status', $data);
    }
}
