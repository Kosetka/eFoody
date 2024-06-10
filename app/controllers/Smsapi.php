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

    public function show() {
        if (empty($_SESSION['USER']))
            redirect('login');

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
        if(isset($URL[3])) {
            $u_id = $URL[3];
        } else {
            if(isset($_GET["guardian"])) {
                $u_id = $_GET["guardian"];
            } else {
                $u_id = 0;
            }
        }

        $data["guardian"] = $u_id;
        $data["date_plan"] = $date;
        
        $users = new User;
        $data["traders"] = $users->getAllTraders("users", TRADERS);

        $dateObject = new DateTime($date);
        $dateObject->modify('-3 days');
        $date_from = $dateObject->format('Y-m-d');

        $sms = new Smsapimodel;
        $data["sms"] = $sms->getSMS($date_from, $date);

//show($data["sms"]);
        $this->view('smsapi.show', $data);
    }
}
