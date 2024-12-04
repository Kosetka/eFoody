<?php


/**
 * Cargo class
 */
class Supplierproducts
{

    use Model;

    protected $table = 'supplier_products';

    protected $allowedColumns = [
        'id',
        'id_supplier_category',
        'id_company',
        'full_name',
        'producent',
        'producent_id',
        'name',
        'amount',
        'unit'
    ];

    public function getSupplierProducts()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
}