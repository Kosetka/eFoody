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
        $ord = new Order;

        if (!empty($ord->getFullOrdersbyDate($date_from, $date_to))) {
            foreach ($ord->getFullOrdersbyDate($date_from, $date_to) as $o) {
                $data["ordered"][$o->order_id][$o->o_date][$o->p_id]["p_id"] = $o->p_id;
                $data["ordered"][$o->order_id][$o->o_date][$o->p_id]["amount"] = $o->amount;
                $data["ordered"][$o->order_id][$o->o_date][$o->p_id]["cost"] = $o->cost;
                $data["ordered"][$o->order_id]["data"]["description"] = $o->o_description;
                $data["ordered"][$o->order_id]["data"]["fv"] = $o->fv;
                $data["ordered"][$o->order_id]["data"]["fv_id"] = $o->fv_id;
                $data["ordered"][$o->order_id]["data"]["not_return_status"] = $o->o_status;
                $data["ordered"][$o->order_id]["data"]["order_date"] = $o->date;
                $data["ordered"][$o->order_id]["data"]["u_id"] = $o->u_id;
                $data["ordered"][$o->order_id]["data"]["order_status"] = $o->status;
                $data["ordered"][$o->order_id]["data"]["o_phone"] = $o->o_phone;
                $data["ordered"][$o->order_id]["data"]["o_email"] = $o->o_email;
                $data["ordered"][$o->order_id]["data"]["discount"] = $o->discount;
                $data["ordered"][$o->order_id]["data"]["id_discount_code"] = $o->id_discount_code;
                $data["ordered"][$o->order_id]["data"]["discount_amount"] = $o->discount_amount;
            }
        }
        //show($data["ordered"]);
        //die;


        //show($data["sms"]);
        $this->view('orders.show', $data);
    }
}
