<?php


/**
 * Cargo class
 */
class Cargo
{

    use Model;

    protected $table = 'cargo';

    protected $allowedColumns = [
        'id',
        'w_id',
        'p_id',
        'date',
        'u_id',
        'amount',
        'date_stamp',
        'u_set_id',
        'c_id'
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
    public function getAllFullProductsByDate($date_from, $date_to)
{
    $query = "
        SELECT p.*, c.exclude, c.delivery_hour 
        FROM $this->table AS p
        LEFT JOIN companies AS c ON p.c_id = c.id
        WHERE p.date >= '$date_from' AND p.date <= '$date_to'
    ";
    return $this->query($query);
}
public function getAllFullProductsByDateAndAmount($date_from, $date_to)
{
    $query = "
        SELECT p.*, c.exclude, c.delivery_hour, pr.sku
        FROM $this->table AS p
        LEFT JOIN companies AS c ON p.c_id = c.id
        LEFT JOIN products AS pr ON pr.id = p.p_id
        WHERE p.date >= '$date_from' AND p.date <= '$date_to' AND p.amount > 0
    ";
    return $this->query($query);
}
public function getLatestTwoRecordsPerPair()
{
    $query = "
        SELECT subquery.*
        FROM (
            SELECT p.*, pr.p_name, pr.first_letter, c.exclude, c.delivery_hour, pr.sku,
                   ROW_NUMBER() OVER (PARTITION BY p.c_id, p.p_id ORDER BY p.date DESC) AS row_num
            FROM $this->table AS p
            LEFT JOIN companies AS c ON p.c_id = c.id
            LEFT JOIN products AS pr ON pr.id = p.p_id
            WHERE p.amount > 0 AND p.c_id IS NOT NULL 
            ORDER BY p.date DESC
        ) AS subquery
        WHERE subquery.row_num <= 2 
    ";
    return $this->query($query);
}
    public function getAllFullProductsDateAndShop($id, $date_from, $date_to)
    {
        $query = "select * from $this->table WHERE c_id = $id AND date >= '$date_from' AND date <='$date_to'";
        return $this->query($query);
    }
    
    public function getAllFullProductsDateAndShops($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE c_id IS NOT NULL AND date >= '$date_from' AND date <='$date_to'";
        return $this->query($query);
    }
    public function getFullProductsDate($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date >= '$date_from' AND date <='$date_to'";
        return $this->query($query);
    }

    public function getCargo($w_id, $p_id, $date)
    {
        $query = "select * from $this->table WHERE w_id = $w_id AND p_id = $p_id AND date >= '$date'";
        return $this->query($query);
    }

    public function getLatestCargoDates()
    {
        $query = "SELECT c_id, MAX(DATE(date)) AS latest_date 
                FROM $this->table 
                WHERE amount > 0 
                GROUP BY c_id";
        return $this->query($query);
    }

    public function getLastCargo()
    {
        $query = "SELECT filtered_records.*, p.*
FROM (
    SELECT *, 
           MAX(DATE(date)) OVER (PARTITION BY c_id) AS max_date_for_cid
    FROM $this->table
    WHERE amount > 0 AND c_id IS NOT NULL
) AS filtered_records
JOIN products AS p ON p.id = filtered_records.p_id
WHERE DATE(filtered_records.date) = filtered_records.max_date_for_cid;";
        return $this->query($query);
    }

    public function reportData($date_from, $date_to): array
    {
        $query = "SELECT 
        u_id,
        p_id,
        SUM(amount) AS num
    FROM 
    cargo
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

    public function deleteByDateId($date, $id)
    {

        $query = "delete from $this->table where date = '$date' AND c_id = $id";
        $this->query($query);

        return false;

    }

    public function updateChange($date_split, $p_id, $new_p_id, $w_id)
    {
        $query = "UPDATE $this->table SET p_id = $new_p_id WHERE date = '$date_split 06:00:00' AND p_id = $p_id AND w_id = $w_id;";
        return $this->query($query);
    }
}