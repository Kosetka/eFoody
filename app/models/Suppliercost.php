<?php


/**
 * Cargo class
 */
class Suppliercost
{

    use Model;

    protected $table = 'supplier_cost';

    protected $allowedColumns = [
        'id',
        'id_supplier_products',
        'netto_price',
        'vat',
        'brutto_price',
        'netto_price_100g',
        'netto_price_1kg',
        'netto_per_unit',
        'date',
        'datenow'
    ];

    public function getSupplierCost()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    
}