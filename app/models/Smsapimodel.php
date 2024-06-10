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

    public function getSku()
    {
        $query = "select * from $this->table ORDER BY full_type ASC;";
        return $this->query($query);
    }
    
}