<?php


/**
 * Cargo class
 */
class Alergen
{

    use Model;

    protected $table = 'alergens';

    protected $allowedColumns = [
        'id',
        'a_name',
        'a_description',
        'a_photo'
    ];

    public function getAlergens()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
}