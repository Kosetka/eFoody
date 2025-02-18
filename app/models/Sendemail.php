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
        'order_id'
    ];

    public function sendEMAILconfirmation($email,$order_id)
    {
        $prod = new ProductsModel();
        foreach($prod->getAllFullProducts() as $pr) {
            $data["prod"][$pr->id] = $pr;
        }
        $order = new Order();
        $ordet = $order->getFullOrderById($order_id);

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
        $cl = new Client();
        $us = $cl->getUser($uu_id);
        if($us->house_number <> "") {
            $full_address = $us->street." ".$us->street_number." m. ".$us->house_number.", ".$us->postal_code." ".$us->city;
        } else {
            $full_address = $us->street." ".$us->street_number.", ".$us->postal_code." ".$us->city;
        }
        $email = $us->email;

        $templateVars = [
            'name' => $us->first_name,
            'surname' => $us->last_name,
            'order_number' => $order_id,
            'delivery_details' => $deliveryDetails, // Tablica z datami, adresami i produktami na dany dzień
            'total_price' => $totalPrice,
            'order_link' => "",
            'address' => $full_address,
        ];
        
        $message = Mailer::loadTemplate(TEMPLATE["order_confirm"], $templateVars);
        
        $mailer = new Mailer($email, "Pan Obiadek - potwierdzenie zamówienia #$order_id", $message);
        
        if ($mailer->send()) {
            //echo "E-mail został wysłany!";
            $date_now = date("Y-m-d H:i:s");
            $order->update($order_id,[
                "send_sms" => 1,
                "send_sms_date" => $date_now,
                "send_email" => 1,
                "send_email_date" => $date_now,
            ]);
        } else {
            //error_log($mailer->getLastError());
        }
        

        $query = "INSERT INTO $this->table (`email`, `order_id`) VALUES (:email, :order_id)";
        $this->query($query, ['email' => $email, 'order_id' => $order_id]);


        //tu dodać zapis o wysyłce email do bazy

        //return true;
    }
}