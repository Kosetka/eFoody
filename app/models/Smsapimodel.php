<?php


/**
 * Cargo class
 */
class Smsapimodel
{

    use Model;

    protected $table = 'sms_api';

    protected $allowedColumns = [
        'id',
        'sms_from',
        'sms_text',
        'sms_date',
        'sms_to',
        'username',
        'date'
    ];

    public function getAllSMS()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getSMSbyNumber($number)
    {
        $query = "select * from $this->table WHERE sms_from = '48$number' ORDER BY date DESC;";
        return $this->query($query);
    }
    public function getSMSbyDate($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date >= '$date_from 00:00:00' AND date <= '$date_to 23:59:59' ORDER BY date DESC;";
        return $this->query($query);
    }

    public function getSMS($date_from, $date_to) {
        $query = "
        SELECT 
            sms_api.date,
            sms_api.sms_from,
            sms_api.sms_text,
            companies.full_name,
            companies.friendly_name,
            companies.address,
            users.first_name,
            users.last_name,
            users.id
        FROM 
            sms_api
        LEFT JOIN 
            companies_phone ON SUBSTRING(sms_api.sms_from, 3) = companies_phone.c_phone
        LEFT JOIN 
            companies ON companies_phone.c_id = companies.id
        LEFT JOIN 
            users ON companies.guardian = users.id
        WHERE 
            sms_api.date BETWEEN '$date_from 00:00:00' AND '$date_to 23:59:59';";
    
        return $this->query($query);
    }
}