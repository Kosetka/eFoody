<?php


/**
 * Cargo class
 */
class Ordercontent
{

    use Model;

    protected $table = 'order_content';

    protected $allowedColumns = [
        'id',
        'order_id',
        'p_id',
        'amount',
        'o_date',
        'cost',
        'o_status',
        'is_upsel'
    ];

    public function getContent()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getContentById($id)
    {
        $query = "select * from $this->table WHERE order_id = '$id';";
        return $this->query($query);
    }

}