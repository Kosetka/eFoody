<?php

/**
 * GetCargo class
 */
class Attendance
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('attendance', $data);
    }


    public function scanner()
    {
        $data = [];

        if(isset($_GET["sts"]) && $_GET["sts"] == "atc") {
            $card_id = "";
            if(isset($_GET["wid"])) {
                $w_id = $_GET["wid"];
            }
            if(isset($_GET["uid"])) {
                $card_id = $_GET["uid"];
            }
            $sts = $_GET["sts"];

            $card = new Cards();
            $temp= $card->getCard($card_id);
            if(empty($temp)) {
                //brak karty
                $data["return"] = "OK,atcErr01";
                $card_log = new Cardlogger();
                $card_log->insert(["w_id" => $w_id, "card_name" => $card_id, "error" => "OK,atcErr01"]);
            } else {
                //jest karta
                if($temp[0]->status == 0) {
                    //karta zablokowana
                    $data["return"] = "OK,atcErr02";
                    $card_log = new Cardlogger();
                    $card_log->insert(["w_id" => $w_id, "card_name" => $card_id, "error" => "OK,atcErr02"]);
                } else {
                    //wszystki git
                    $now = date("H:i:s"); 
                    $day = date("d-m-Y"); 
                    $day_full = date("Y-m-d");
                    $card_scan = new Cardscan();
                    $scan = $card_scan->getScan($card_id);



                    $cardusers = new Carduser();
                    $carduser = $cardusers->getCardUser($card_id);
                    if(!empty($carduser)) {
                        $name = $carduser[0]->first_name . ' ' . $carduser[0]->last_name;
                        $name = changePolishChars($name);
                        if (strlen($name) > 20) {
                            $name = substr($name, 0, 20); //skrócenie do 20 znakow
                        }
                    } else {
                        $name = "Brak danych";
                    }

                    $card_user = new Carduser();
                    if(!empty($card_user->getCardHolder($card_id))) {
                        $user_id = $card_user->getCardHolder($card_id)[0]->u_id;
                    } else {    
                        $user_id = 0;
                    }

                    if(!empty($scan)) {
                        $in = substr($scan[0]->date, 11, 8);
                        $today = substr($scan[0]->date, 0, 10);
                        if($day_full != $today) {
                            $data["return"] = "OK,TO_Successful,$name,$day,$now";
                            $card_scan->insert(["w_id" => $w_id, "card_name" => $card_id, "date" => "$day_full $now", "status" => "in", "user_id" => $user_id]);
                        } else {
                            if($scan[0]->status == "out") {
                                $data["return"] = "OK,TO_Successful,$name,$day,$now";
                                $card_scan->insert(["w_id" => $w_id, "card_name" => $card_id, "date" => "$day_full $now", "status" => "in", "user_id" => $user_id]);
                            } else {
                                $data["return"] = "OK,TO_Successful,$name,$day,$in,$now";
                                $card_scan->insert(["w_id" => $w_id, "card_name" => $card_id, "date" => "$day_full $now", "status" => "out", "user_id" => $user_id]);
                            }
                        }
                    } else {
                        $data["return"] = "OK,TO_Successful,$name,$day,$now";
                        $card_scan->insert(["w_id" => $w_id, "card_name" => $card_id, "date" => "$day_full $now", "status" => "in", "user_id" => $user_id]);
                    }
                }
            }

            //OK,TO_Successful,Test,03/07/2024,16:58:19 <- ok
            // OK,atcErr01 <- nie ma takiej karty

        }

        $this->view('attendance.scanner', $data);
    }

    public function logger() {
        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $w_id = $URL[2];

        $now = date("Y-m-d H:i:s");

        $cv = new Cardvisit();
        $cv->insert(["w_id" => $w_id, "date_now" => $now]);


        //$this->view('attendance.scanner', $data);
    }
    public function offlines() {

        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];
        
        $cv = new Cardvisit();
        if(!empty($cv->getOffline())) {
            foreach($cv->getOffline() as $rec) {
                $data["breaks"][$rec->w_id][] = $rec;
            }
        }
        if(!empty($cv->getStatus())) {
            foreach($cv->getStatus() as $rec) {
                $data["status"][$rec->w_id][] = $rec;
            }
        }
        $data["now"] = date("Y-m-d H:i:s");
        $city = new Shared();
        foreach($city->getActiveCitiesAndWarehouse() as $city) {
            $data["city"][$city->id] = $city;
        }

        $this->view('attendance.offline', $data);
    }
}
