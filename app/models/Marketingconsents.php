<?php


/**
 * Cargo class
 */
class Marketingconsents
{

    use Model;

    protected $table = 'marketing_consents';

    protected $allowedColumns = [
        'id',
        'name',
        'description',
        'datenow',
        'required',
        'status'
    ];

    public function getConsents()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getConsentsActive()
    {
        $query = "select * from $this->table WHERE status = 1;";
        return $this->query($query);
    }

}