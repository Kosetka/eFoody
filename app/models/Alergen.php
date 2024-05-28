<?php


/**
 * Cargo class
 */
class Alergen
{

    use Model;

    protected $table = 'alergens';

    protected $allowedColumns = [
        'id',
        'a_name',
        'a_description',
        'a_photo'
    ];

    public function getAlergens()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getAlergensById($id)
    {
        $query = "select * from $this->table WHERE p_id = $id;";
        return $this->query($query);
    }
}