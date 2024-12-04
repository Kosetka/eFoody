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
}