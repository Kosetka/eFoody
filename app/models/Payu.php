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
    public function getPayuStatus($id)
    {
        $query = "select * from $this->table WHERE order_id = $id ORDER BY date DESC LIMIT 1;";
        return $this->query($query);
    }
}