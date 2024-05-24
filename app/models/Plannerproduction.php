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

}