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
    public function getByAlergenAndNames($id)
    {
        $query = "
            SELECT 
                product_alergens.*, 
                alergens.*
            FROM 
                $this->table AS product_alergens
            INNER JOIN 
                alergens 
            ON 
                product_alergens.a_id = alergens.id
            WHERE 
                product_alergens.a_id = $id;
        ";
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
    public function getAlergensByProducts($ids)
    {
        $idsList = implode(',', array_map('intval', $ids));
        
        $query = "SELECT DISTINCT a_id FROM $this->table WHERE p_id IN ($idsList);";
        
        return $this->query($query);
    }
}