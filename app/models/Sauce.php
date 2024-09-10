<?php


/**
 * Cargo class
 */
class Sauce
{

    use Model;

    protected $table = 'sauce';

    protected $allowedColumns = [
        'id',
        'p_id',
        'r_id',
        'date'
    ];

    public function getSauces()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getSauce($id)
    {
        $query = "select * from $this->table WHERE p_id = $id;";
        return $this->query($query);
    }
}