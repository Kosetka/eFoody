<?php


/**
 * Companies class
 */
class Companiesphone
{

    use Model;

    protected $table = 'companies_phone';

    protected $allowedColumns = [
        'id',
        'c_id',
        'c_phone'
    ];

    public function getAllNumbers()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getAllById($id)
    {
        $query = "select * from $this->table WHERE c_id = $id;";
        return $this->query($query);
    }
}