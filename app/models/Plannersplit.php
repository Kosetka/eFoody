<?php


/**
 * City class
 */
class Plannersplit
{

    use Model;

    protected $table = 'planner_split';

    protected $allowedColumns = [
        'id',
        'date_split',
        'p_id',
        'amount',
        'u_id',
        'u_set_id',
        'date'
    ];

    public function getAll($date)
    {
        $query = "select * from $this->table WHERE date_split = '$date'";
        return $this->query($query);
    }

    public function getPlanned($date)
    {
        $query = "select * from $this->table WHERE date_split = '$date'";
        return $this->query($query);
    }
    public function getPlannedUser($date, $u_id)
    {
        $query = "select * from $this->table WHERE date_split = '$date' AND u_id = $u_id";
        return $this->query($query);
    }

    public function deleteByDate($date)
	{

		$query = "delete from $this->table where date_split = '$date' ";
		$this->query($query);

		return false;

	}

}