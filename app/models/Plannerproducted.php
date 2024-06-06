<?php


/**
 * City class
 */
class Plannerproducted
{

    use Model;

    protected $table = 'planner_producted';

    protected $allowedColumns = [
        'id',
        'date_producted',
        'w_id',
        'p_id',
        'amount',
        'u_id',
        'date'
    ];

    public function getAll($date)
    {
        $query = "select * from $this->table WHERE date_producted = '$date'";
        return $this->query($query);
    }
    public function getAllDates($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date_producted >= '$date_from' AND date_producted <= '$date_to'";
        return $this->query($query);
    }

    public function getProducted($date, $w_id)
    {
        $query = "select * from $this->table WHERE date_producted = '$date' AND w_id = $w_id";
        return $this->query($query);
    }

    public function deleteByDate($date)
	{

		$query = "delete from $this->table where date_producted = '$date' ";
		$this->query($query);

		return false;

	}
    public function updateChange($date_split, $p_id, $new_p_id, $w_id)
	{
		$query = "UPDATE $this->table SET p_id = $new_p_id WHERE date_producted = '$date_split' AND p_id = $p_id AND w_id = $w_id;";
        return $this->query($query);
	}

}