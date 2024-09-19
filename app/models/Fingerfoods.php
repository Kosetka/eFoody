<?php


/**
 * Cargo class
 */
class Fingerfoods
{

    use Model;

    protected $table = 'fingerfoods';

    protected $allowedColumns = [
        'id',
        'f_name',
        'f_description',
        'f_cost',
        'f_category',
        'f_photo',
        'f_active',
        'f_order',
        'u_id',
        'date'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }

    public function getFingerfood($id)
    {
        $query = "select * from $this->table WHERE id = $id;";
        return $this->query($query);
    }
}





