<?php


/**
 * Cargo class
 */
class Skumodel
{

    use Model;

    protected $table = 'sku';

    protected $allowedColumns = [
        'id',
        'type',
        'name',
        'parent',
        'full_type',
        'priceshops',
        'pricefixed'
    ];

    public function getSku()
    {
        $query = "select * from $this->table ORDER BY full_type ASC;";
        return $this->query($query);
    }
    public function getFullType($id)
    {
        $query = "select * from $this->table WHERE id = '$id' ORDER BY full_type ASC;";
        return $this->query($query);
    }
    public function getByParent($id)
    {
        $query = "select * from $this->table WHERE parent = '$id' ORDER BY full_type ASC;";
        return $this->query($query);
    }
    
}