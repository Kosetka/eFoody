<?php


/**
 * Cargo class
 */
class Productsbought
{

    use Model;

    protected $table = 'companies_products_buy';

    protected $allowedColumns = [
        'id',
        'date',
        'datenow',
        'p_id',
        'amount',
        'cost',
        'u_id',
        'company_id',
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
}