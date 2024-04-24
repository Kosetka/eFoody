<?php


/**
 * Sales class
 */
class Sales
{

    use Model;

    protected $table = 'sales';

    protected $allowedColumns = [
        'id',
        'u_id',
        'c_id',
        'sale_description',
        'date',
        'p_id',
        's_amount'
    ];

    public function getSoldProducts($u_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id = $u_id AND date >= '$today 00:00:00' AND date <='$today 23:59:59'";
        return $this->query($query);
    }

    public function getSoldForMap($u_id)
    {
        $today = date("Y-m-d", strtotime("-1 day"));
        $query = "SELECT 
            c_id, 
            SUM(CASE WHEN sale_description = 'gratis' THEN s_amount ELSE 0 END) AS total_gratis_amount,
            SUM(CASE WHEN sale_description != 'gratis' THEN s_amount ELSE 0 END) AS total_regular_amount
          FROM $this->table 
          WHERE u_id = $u_id 
            AND date >= '$today 00:00:00' 
            AND date <='$today 23:59:59' 
          GROUP BY c_id";
        return $this->query($query);
    }

    public function getSoldProductsDate($u_id, $date_from, $date_to)
    {
        $query = "select * from $this->table WHERE u_id = $u_id AND date >= '$date_from' AND date <='$date_to'";
        return $this->query($query);
    }

    public function getAllSold($date)
    {
        $query = "select SUM(s_amount) AS total from $this->table WHERE date >= '$date 00:00:00' AND date <='$date 23:59:59'";
        return $this->query($query)[0]->total;
    }

    public function getVisited($date)
    {
        $query = "select count(*) as total from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59'";
        return $this->query($query)[0]->total;
    }

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
}