<?php


/**
 * Cargo class
 */
class Payu
{

    use Model;

    protected $table = 'payu_statuses';

    protected $allowedColumns = [
        'id',
        'order_id',
        'date',
        'status'
    ];

    public function getPayuStatuses()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
}