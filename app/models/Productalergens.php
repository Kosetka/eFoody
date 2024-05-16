<?php


/**
 * Cargo class
 */
class Productalergens
{

    use Model;

    protected $table = 'product_alergens';

    protected $allowedColumns = [
        'id',
        'p_id',
        'a_id'
    ];
    public function getAll()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
    public function getByAlergen($id)
    {
        $query = "select * from $this->table WHERE a_id = $id;";
        return $this->query($query);
    }
    public function getByProduct($id)
    {
        $query = "select * from $this->table WHERE p_id = $id;";
        return $this->query($query);
    }
    public function getGrouped()
    {
        $query = "SELECT p_id, GROUP_CONCAT(a_id ORDER BY a_id ASC) AS lista_a_id
        FROM $this->table
        GROUP BY p_id;";
        return $this->query($query);
    }
        
}