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
    public function getPlannedByDates($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date_split >= '$date_from' AND date_split <= '$date_to';";
        return $this->query($query);
    }

    public function deleteByDate($date)
	{

		$query = "delete from $this->table where date_split = '$date' ";
		$this->query($query);

		return false;

	}

    public function updateChange($date_split, $p_id, $new_p_id)
	{
		$query = "UPDATE $this->table SET p_id = $new_p_id WHERE date_split = '$date_split' AND p_id = $p_id;";
        return $this->query($query);
	}

}