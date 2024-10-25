<?php


/**
 * Cargo class
 */
class Bonuses
{

    use Model;

    protected $table = 'bonuses';

    protected $allowedColumns = [
        'id',
        'u_id',
        'b_description',
        'amount',
        'type',
        'date',
        'date_now',
        'u_u_id'
    ];

    public function getBonuses()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getBonusesByDate($month, $year)
    {
        $query = "SELECT * FROM $this->table WHERE MONTH(date) = $month AND YEAR(date) = $year;";
        return $this->query($query);
    }
}