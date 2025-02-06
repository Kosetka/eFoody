<?php


/**
 * Cargo class
 */
class Ankieta
{

    use Model;

    protected $table = 'ankieta';

    protected $allowedColumns = [
        'id',
        'order_id',
        'answer',
        'u_id',
        'date'
    ];

    public function getAnwers()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }

}