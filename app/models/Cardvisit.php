<?php


/**
 * Cargo class
 */
class Cardvisit
{

    use Model;

    protected $table = 'card_visit';

    protected $allowedColumns = [
        'id',
        'date',
        'w_id',
        'date_now'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    
}