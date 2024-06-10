<?php

/**
 * GetCargo class
 */
class Smsapi
{
    use Controller;
    public function index()
    {
        //if (empty($_SESSION['USER']))
        //    redirect('login');

        $data = [];

        if(!empty($_POST)) {
            $received   = $_POST;
            $content = print_r($received, true);
            $sms_from   = $received['sms_from'];
            $sms_to     = $received['sms_to'];
            $sms_date   = $received['sms_date'];
            $sms_text   = $received['sms_text'];
            $username   = $received['username'];

            $sms = new Smsapimodel;
            $sms->insert(["sms_from" => "$sms_from", "sms_to" => "$sms_to", "sms_date" => "$sms_date", "sms_text" => "$sms_text", "username"=>"$username"]);

            echo "OK"; //wymagane przez API
        } else {
            redirect('login');
        }
        

        $this->view('smsapi.result', $data);
    }
}
