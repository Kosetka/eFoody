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
        'unit',
        'unit_order'
    ];

    public function getSupplierProducts()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getSupplier($id)
    {
        $query = "select * from $this->table WHERE id_company = $id;";
        return $this->query($query);
    }
    public function getLast()
    {
        $query = "select * from $this->table ORDER BY ID DESC LIMIT 1";
        return $this->query($query)[0]->id;
    }
}