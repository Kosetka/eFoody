<?php


/**
 * Cargo class
 */
class Sendemail
{

    use Model;

    protected $table = 'email_sended';

    protected $allowedColumns = [
        'id',
        'email',
        'date',
        'order_id',
        'mtype'
    ];

    public function sendEMAILconfirmation($email,$order_id)
    {
        $prod = new ProductsModel();
        foreach($prod->getAllFullProducts() as $pr) {
            $data["prod"][$pr->id] = $pr;
        }
        $order = new Order();
        $ordet = $order->getFullOrderById($order_id);

        //show($ordet);
        $deliveryDetails = [];
        $uu_id = 0;
        $totalPrice = 0;
        foreach($ordet as $od) {
            $uu_id = $od->u_id;
            $deliveryDetails[$od->o_date]["date"] = $od->o_date; 
            $deliveryDetails[$od->o_date]["items"][$od->p_id]["image"] = $data["prod"][$od->p_id]->p_photo; 
            $deliveryDetails[$od->o_date]["items"][$od->p_id]["name"] = $data["prod"][$od->p_id]->p_name; 
            $deliveryDetails[$od->o_date]["items"][$od->p_id]["quantity"] = $od->amount; 
            $deliveryDetails[$od->o_date]["items"][$od->p_id]["price"] = $od->cost; 
            $totalPrice += $od->cost;
        }
        //show($ordet);
        //die;
        if(isset($_SESSION["PANOBIADEK"])) {
            $uu_id = $_SESSION["PANOBIADEK"]->id;
        }
        $cl = new Client();
        $us = $cl->getUser($uu_id);
        if($us->house_number <> "") {
            $full_address = $us->street." ".$us->street_number." m. ".$us->house_number.", ".$us->postal_code." ".$us->city;
        } else {
            $full_address = $us->street." ".$us->street_number.", ".$us->postal_code." ".$us->city;
        }
        $email = $us->email;

        //$payment = "";
        $payment = CART_STATUS[$ordet[0]->status];
        

        $templateVars = [
            'name' => $us->first_name,
            'surname' => $us->last_name,
            'order_number' => $order_id,
            'delivery_details' => $deliveryDetails, // Tablica z datami, adresami i produktami na dany dzień
            'total_price' => $totalPrice,
            'order_link' => "",
            'address' => $full_address,
            'payment' => $payment,
        ];
        
        $message = Mailer::loadTemplate(TEMPLATE["order_confirm"], $templateVars);
        
        $mailer = new Mailer($email, "Pan Obiadek - potwierdzenie zamówienia #$order_id", $message);
        
        if ($mailer->send()) {
            //echo "E-mail został wysłany!";
            $date_now = date("Y-m-d H:i:s");
            $order->update($order_id,[
                "send_email" => 1,
                "send_email_date" => $date_now,
            ]);
            $query = "INSERT INTO $this->table (`email`, `order_id`, `mtype`) VALUES (:email, :order_id, :mtype)";
            $this->query($query, ['email' => $email, 'order_id' => $order_id, 'mtype' => "order_payed"]);
        } else {
            //error_log($mailer->getLastError());
        }
        

        


        //tu dodać zapis o wysyłce email do bazy

        //return true;
    }

    public function sendEMAILconfirmationfailed($email,$order_id)
    {
        $order = new Order();
        $ordet = $order->getFullOrderById($order_id);
        $uu_id = 0;
        foreach($ordet as $od) {
            $uu_id = $od->u_id;
        }
        $cl = new Client();
        $us = $cl->getUser($uu_id);
        $email = $us->email;

        $templateVars = [
            'name' => $us->first_name,
            'surname' => $us->last_name,
            'order_number' => $order_id
        ];
        
        $message = Mailer::loadTemplate(TEMPLATE["order_failed"], $templateVars);
        
        $mailer = new Mailer($email, "Pan Obiadek - anulowanie zamówienia #$order_id", $message);
        
        if ($mailer->send()) {
            //echo "E-mail został wysłany!";
            $date_now = date("Y-m-d H:i:s");
            $order->update($order_id,[
                "send_email" => 1,
                "send_email_date" => $date_now,
            ]);
            $query = "INSERT INTO $this->table (`email`, `order_id`, `mtype`) VALUES (:email, :order_id, :mtype)";
            $this->query($query, ['email' => $email, 'order_id' => $order_id, 'mtype' => "order_failed"]);
        } else {
            //error_log($mailer->getLastError());
        }
        

        //tu dodać zapis o wysyłce email do bazy

        //return true;
    }

    public function sendEMAILregister($u_id)
    {
        $cl = new Client();
        $us = $cl->getUser($u_id);
        if($us->house_number <> "") {
            $full_address = $us->street." ".$us->street_number." m. ".$us->house_number.", ".$us->postal_code." ".$us->city;
        } else {
            $full_address = $us->street." ".$us->street_number.", ".$us->postal_code." ".$us->city;
        }
        $email = $us->email;

        $templateVars = [
            'name' => $us->first_name,
            'surname' => $us->last_name,
            'link' => CLIENT_PANEL
        ];
        
        $message = Mailer::loadTemplate(TEMPLATE["register_confirm"], $templateVars);
        
        $mailer = new Mailer($email, "Pan Obiadek - potwierdzenie założenia konta", $message);
        
        if ($mailer->send()) {
            //echo "E-mail został wysłany!";
            $query = "INSERT INTO $this->table (`email`, `order_id`, `mtype`) VALUES (:email, :order_id, :mtype)";
            $this->query($query, ['email' => $email, 'order_id' => 0, 'mtype' => "register"]);
        } else {
            //error_log($mailer->getLastError());
        }
        
        //return true;
    }

    public function sendEMAILpassreset($session_id)
    {
        $cl = new Client();
        $us = $cl->getUserBySession($session_id);
        $email = $us->email;

        $templateVars = [
            'name' => $us->first_name,
            'surname' => $us->last_name,
            'reset_link' => CLIENT_PANEL . "/logowanie/" . $session_id
        ];
        
        $message = Mailer::loadTemplate(TEMPLATE["lost_password"], $templateVars);
        
        $mailer = new Mailer($email, "Pan Obiadek - potwierdź zmianę hasła", $message);
        
        if ($mailer->send()) {
            //echo "E-mail został wysłany!";
            $query = "INSERT INTO $this->table (`email`, `order_id`, `mtype`) VALUES (:email, :order_id, :mtype)";
            $this->query($query, ['email' => $email, 'order_id' => 0, 'mtype' => "password_reset"]);
        } else {
            //error_log($mailer->getLastError());
        }
        
        //return true;
    }
}