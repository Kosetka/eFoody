<?php


/**
 * Cargo class
 */
class Workhours
{

    use Model;

    protected $table = 'work_hours';

    protected $allowedColumns = [
        'id',
        'u_id',
        'accept_u_id',
        'date',
        'hour_first_in',
        'hour_first_out',
        'work_seconds',
        'break_seconds',
        'accept_in',
        'accept_out',
        'accept_time',
        'date_now'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getByDate($date)
    {
        $query = "select * from $this->table WHERE date = '$date' ORDER BY u_id ASC;";
        return $this->query($query);
    }
    
    public function getMonth($month, $year)
    {
        $query = "SELECT * FROM $this->table WHERE YEAR(date) = $year AND MONTH(date) = $month ORDER BY date ASC;";
        return $this->query($query);
    }
    public function getPerson($month, $year, $u_id)
    {
        $query = "SELECT * FROM $this->table WHERE YEAR(date) = $year AND MONTH(date) = $month AND u_id = $u_id ORDER BY date ASC;";
        return $this->query($query);
    }
    
}