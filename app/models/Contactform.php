<?php


/**
 * Cargo class
 */
class Contactform
{

    use Model;

    protected $table = 'contactform';

    protected $allowedColumns = [
        'id',
        'full_name',
        'email',
        'phone',
        'txt',
        'date'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }

    public function getFrom($date)
    {
        $query = "select * from $this->table WHERE date >= '$date 00:00:00';";
        return $this->query($query);
    }
}