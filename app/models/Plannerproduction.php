<?php


/**
 * City class
 */
class Plannerproduction
{

    use Model;

    protected $table = 'planner_production';

    protected $allowedColumns = [
        'id',
        'date_plan',
        'w_id',
        'p_id',
        'amount',
        'u_id',
        'date'
    ];

    public function getAll($date)
    {
        $query = "select * from $this->table WHERE date_plan = '$date'";
        return $this->query($query);
    }

    public function getPlanned($date, $w_id)
    {
        $query = "select * from $this->table WHERE date_plan = '$date' AND w_id = $w_id";
        return $this->query($query);
    }
}