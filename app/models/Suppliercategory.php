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
        'name'
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
}