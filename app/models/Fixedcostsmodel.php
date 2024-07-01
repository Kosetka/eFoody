<?php


/**
 * Cargo class
 */
class Fixedcostsmodel
{

    use Model;

    protected $table = 'costs_fixed';

    protected $allowedColumns = [
        'id',
        'date_from',
        'date_to',
        'date_add',
        'name',
        'date',
        'type',
        'price',
        'description',
        'active',
        'category',
        'method'
    ];

    public function getByID($id)
    {
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query)[0];
    }
    public function getAll()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
}