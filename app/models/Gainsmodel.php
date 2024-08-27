<?php


/**
 * Cargo class
 */
class Gainsmodel
{

    use Model;

    protected $table = 'gains';

    protected $allowedColumns = [
        'id',
        'u_id',
        'date',
        'now',
        'profit',
        'insert_u_id',
        'main_u_id',
        'card',
        'cash'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getByDate($date)
    {
        $query = "select * from $this->table WHERE date = '$date';";
        return $this->query($query);
    }
    public function getByDates($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date >= '$date_from' AND date <= '$date_to';";
        return $this->query($query);
    }
    public function checkExists($date, $u_id)
    {
        $query = "select * from $this->table WHERE date = '$date' AND u_id = $u_id;";
        return $this->query($query);
    }
}