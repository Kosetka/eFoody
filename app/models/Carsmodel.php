<?php


/**
 * Cargo class
 */
class Carsmodel
{

    use Model;

    protected $table = 'cars';

    protected $allowedColumns = [
        'id',
        'objectno',
        'objectname',
        'model',
        'color',
        'plate',
        'active',
        'fuel_type',
        'tank_cap',
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getCar($id)
    {
        $query = "select * from $this->table WHERE id = $id;";
        return $this->query($query);
    }
}