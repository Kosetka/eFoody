<?php


/**
 * Returns class
 */
class ReturnsModel
{

    use Model;

    protected $table = 'returns';

    protected $allowedColumns = [
        'id',
        'w_id',
        'p_id',
        'date',
        'u_id',
        'amount',
        'u_set_id',
        'c_id',
        'date_now',
        'date_timestamp'
    ];

    public function getProducts(): array
    {
        $this->product = [];
        $array = [];
        $products = new ProductsModel;
        $arr = $products->getAll($this->table);

        foreach ($arr as $product) {
            //foreach ($role as $r) {
            $product = (array) $product;
            $array[] = (array) $product;
            //}
        }
        $this->products = $array;
        //show($array);
        return $array;
    }
    public function getAllFullProducts($id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id = $id AND date >= '$today 00:00:00' AND date <='$today 23:59:59'";
        return $this->query($query);
    }

    public function getAllFullProductsDate($id, $date_from, $date_to)
    {
        $query = "select * from $this->table WHERE u_id = $id AND date >= '$date_from' AND date <='$date_to'";
        return $this->query($query);
    }
    public function getReturns($w_id, $p_id, $date)
    {
        $query = "select * from $this->table WHERE w_id = $w_id AND p_id = $p_id AND date >= '$date'";
        return $this->query($query);
    }
    public function getShopsReturn($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE c_id IS NOT NULL AND date >= '$date_from 00:00:00' AND date <='$date_to 23:59:59'";
        return $this->query($query);
    }
    public function getShopsReturnNew($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE c_id IS NOT NULL AND date_now >= '$date_from' AND date_now <='$date_to'";
        return $this->query($query);
    }
  
    public function getReturnsMonth($month, $year)
    {
        $start_date = "$year-$month-01";
        $end_date = date("Y-m-t", strtotime($start_date));

        $query = "select * from $this->table WHERE 
                c_id is NULL 
                AND date <= '$end_date 00:00:00'
                AND date >= '$start_date 23:59:59';";
        return $this->query($query);
    }

    public function reportData($date_from, $date_to): array
    {
        $query = "SELECT 
        u_id,
        p_id,
        SUM(amount) AS num
    FROM 
    $this->table
    WHERE 
        date BETWEEN '$date_from' AND '$date_to' -- Zmodyfikowany warunek daty
    GROUP BY 
        u_id, p_id
    ";
        $result = $this->query($query);

        if (empty($result)) {
            return [];
        }

        return $result;
    }
    public function returnsByDate($date_from, $date_to): array
    {
        $query = "SELECT * FROM $this->table WHERE date BETWEEN '$date_from' AND '$date_to'";

        $result = $this->query($query);

        if (empty($result)) {
            return [];
        }

        return $result;
    }


    public function deleteByDate($date)
	{
		$query = "delete from $this->table where date >= '$date 00:00:00' AND date <= '$date 23:59:59' ";
		$this->query($query);
		return false;
	}
    public function deleteByDateAndShop($date, $c_id)
	{
		$query = "delete from $this->table where c_id = $c_id AND date >= '$date 00:00:00' AND date <= '$date 23:59:59' ";
		$this->query($query);
		return false;
	}

    public function getAll($date)
    {
        $query = "select * from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59'";
        return $this->query($query);
    }

}
