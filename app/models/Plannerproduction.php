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
    public function getPlannedMonth($month, $year)
    {
        $start_date = "$year-$month-01";
        $end_date = date("Y-m-t", strtotime($start_date));

        $query = "select * from $this->table WHERE 
                date_plan <= '$end_date'
                AND date_plan >= '$start_date';";
        return $this->query($query);
    }
    public function getPlannedDates($date_from, $date_to, $w_id)
    {
        $query = "select * from $this->table WHERE date_plan >= '$date_from' AND date_plan <= '$date_to' AND w_id = $w_id";
        return $this->query($query);
    }
    public function getPlannedUser($date, $w_id, $u_id)
    {
        $query = "select * from $this->table WHERE date_plan = '$date' AND w_id = $w_id AND u_id = $u_id";
        return $this->query($query);
    }

    public function deleteByDate($date, $w_id)
    {

        $query = "delete from $this->table where w_id = $w_id AND date_plan = '$date' ";
        $this->query($query);

        return false;

    }
    public function getByDate($date, $w_id)
    {

        $query = "SELECT *  from $this->table where w_id = $w_id AND date_plan = '$date' ";
        $this->query($query);

        return $this->query($query);

    }

    public function updateChange($date_split, $p_id, $new_p_id, $w_id)
    {
        $query = "UPDATE $this->table SET p_id = $new_p_id WHERE date_plan = '$date_split' AND p_id = $p_id AND w_id = $w_id;";
        return $this->query($query);
    }

}