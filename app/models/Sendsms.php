<?php


/**
 * Cargo class
 */
class Sendsms
{

    use Model;

    protected $table = 'sms_sended';
    protected $token_name = 'sms_api';

    protected $allowedColumns = [
        'id',
        'phone',
        'date',
        'sms_txt'
    ];

    public function sendSMSconfirm($phone, $coo_id)
    {
        $api_key = new Apitokens();
        $sms_api_key = $api_key->getToken($this->token_name);
        $token = $sms_api_key;
        $sms_txt = "Twoje zamowienie zostalo przyjete. Numer zamowienia: $coo_id. Dziekujemy!";
        $params = array(
            'to' => "$phone", 
            'from' => 'Pan Obiadek',
            'message' => "$sms_txt", 
            'format' => 'json'
        );
        sms_send($params, $token);

        //tu dodać zapis o wysyłce sms do bazy

        //return true;
    }
    public function sendSMSverification($phone,$code)
    {
        $api_key = new Apitokens();
        $sms_api_key = $api_key->getToken($this->token_name);
        $token = $sms_api_key;
        $sms_txt = "Twoj kod weryfikacyjny to: $code";
        $params = array(
            'to' => "$phone", 
            'from' => 'Pan Obiadek',
            'message' => "$sms_txt", 
            'format' => 'json'
        );
        sms_send($params, $token);

        //tu dodać zapis o wysyłce sms do bazy

        //return true;
    }
}