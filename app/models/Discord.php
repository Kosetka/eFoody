<?php


/**
 * Cargo class
 */
class Discord
{

    use Model;

    protected $link_dc = 'https://discord.com/api/webhooks/';

    protected $allowedColumns = [
        'id',
        'a_name',
        'a_description',
        'a_photo'
    ];


    public function sendMsg($msg)
    {
        $api_key = new Apitokens();
        $dc_id = $api_key->getToken("dc_wh_id_form");
        $dc_token = $api_key->getToken("dc_wh_token_form");

        $full_link = $this->link_dc . $dc_id . "/" . $dc_token;

        $data = array(
            "content" => "$msg",
            "username" => "Pan Obiadek"
            //"avatar_url" => "https://example.com/avatar.png"
        );

        $options = array(
            CURLOPT_URL => $full_link,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => json_encode($data),
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            //echo 'Błąd cURL: ' . curl_error($ch);
        } else {
            //echo 'Wiadomość wysłana pomyślnie!';
        }
        curl_close($ch);
    }

    public function logins($status, $data = [])
    {
        $api_key = new Apitokens();
        $dc_id = $api_key->getToken("dc_wh_id_login");
        $dc_token = $api_key->getToken("dc_wh_token_login");

        $full_link = $this->link_dc . $dc_id . "/" . $dc_token;

        $date_now = date("Y-m-d H:i:s");
        $msg = "";

        if ($status == 1) {
            $msg = "**" . $data['first_name'] . " " . $data['last_name'] . "** (" . $data['role'] . ") **pomyślnie** zalogował się o: $date_now";
        } else if ($status == 2) {
            $msg = "**" . $data['first_name'] . " " . $data['last_name'] . " próbował** zalogować się o: $date_now. Konto **zablokowane**.";
        } else if ($status == 3) {
            $msg = "**Próba** logowania o: $date_now. Błędne dane logowania.";
        }

        $data = array(
            "content" => "$msg",
            "username" => "Pan Obiadek"
            //"avatar_url" => "https://example.com/avatar.png"
        );

        $options = array(
            CURLOPT_URL => $full_link,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => json_encode($data),
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            //echo 'Błąd cURL: ' . curl_error($ch);
        } else {
            //echo 'Wiadomość wysłana pomyślnie!';
        }
        curl_close($ch);
    }

}