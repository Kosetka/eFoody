<?php


/**
 * Cargo class
 */
class Confirmationcode
{

    use Model;

    protected $table = 'confirmation_code';

    protected $allowedColumns = [
        'id',
        'phone',
        'code',
        'date_send',
        'date_confirmation',
        'status'
    ];

    public function getCode($phone, $date)
    {
        $query = "select * from $this->table WHERE phone = '$phone' AND status = 0;";
        return $this->query($query);
    }

}