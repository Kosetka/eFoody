<?php


/**
 * Cargo class
 */
class Suppliercategory
{

    use Model;

    protected $table = 'supplier_category';

    protected $allowedColumns = [
        'id',
        'sub_prod_id',
        'name',
        'supplier_id'
    ];

    public function getSupplierCategory()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getSupplier($id)
    {
        $query = "select * from $this->table WHERE supplier_id = $id;";
        return $this->query($query);
    }
    public function getLast()
    {
        $query = "select * from $this->table ORDER BY ID DESC LIMIT 1";
        return $this->query($query)[0]->id;
    }
}