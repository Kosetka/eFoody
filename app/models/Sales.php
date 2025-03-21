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
        's_amount',
        'h_id'
    ];

    public function getSoldProducts($u_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE sale_description != 'gratis' AND sale_description != 'destroy' AND u_id = $u_id AND date >= '$today 00:00:00' AND date <='$today 23:59:59'";
        return $this->query($query);
    }
    public function getLastScans($u_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE sale_description = 'scan' AND u_id = $u_id AND date >= '$today 00:00:00' AND date <='$today 23:59:59' ORDER BY date DESC LIMIT 5";
        return $this->query($query);
    }
    public function getSoldProductsLeft($u_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id = $u_id AND date >= '$today 00:00:00' AND date <='$today 23:59:59'";
        return $this->query($query);
    }
    public function getStatusProductsLeft($u_id, $stat)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE sale_description = '$stat' AND u_id = $u_id AND date >= '$today 00:00:00' AND date <='$today 23:59:59'";
        return $this->query($query);
    }

    public function getSoldForMap($u_id)
    {
        $today = date("Y-m-d", strtotime("-1 day"));
        $query = "SELECT 
            c_id, 
            SUM(CASE WHEN sale_description = 'gratis' THEN s_amount ELSE 0 END) AS total_gratis_amount,
            SUM(CASE WHEN sale_description = 'destroy' THEN s_amount ELSE 0 END) AS total_destroy_amount,
            SUM(CASE WHEN sale_description != 'gratis' AND sale_description != 'destroy' THEN s_amount ELSE 0 END) AS total_regular_amount
          FROM $this->table 
          WHERE u_id = $u_id 
            AND date >= '$today 00:00:00' 
            AND date <='$today 23:59:59' 
          GROUP BY c_id";
        return $this->query($query);
    }

    public function getSoldProductsDate($u_id, $date_from, $date_to)
    {
        $query = "select * from $this->table WHERE sale_description != 'gratis' AND sale_description != 'destroy' AND u_id = $u_id AND date >= '$date_from' AND date <='$date_to'";
        return $this->query($query);
    }

    public function getAllSold($date)
    {
        $query = "select SUM(s_amount) AS total from $this->table WHERE sale_description != 'gratis' AND sale_description != 'destroy' AND date >= '$date 00:00:00' AND date <='$date 23:59:59'";
        return $this->query($query)[0]->total;
    }

    public function getVisited($date)
    {
        $query = "select count(*) as total from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59'";
        return $this->query($query)[0]->total;
    }

    public function getAllData($date_from, $date_to)
    {
        $query = "select * from $this->table WHERE date >= '$date_from 00:00:00' AND date <= '$date_to 23:59:59'";
        return $this->query($query);
    }

    public function reportData($date_from, $date_to): array
    {
        $query = "SELECT 
        u_id,
        p_id,
        SUM(CASE WHEN sale_description = 'scan' OR sale_description = '' THEN s_amount ELSE 0 END) AS scan_and_empty,
        MAX(CASE WHEN sale_description = 'gratis' THEN s_amount ELSE 0 END) AS gratis,
        MAX(CASE WHEN sale_description = 'destroy' THEN s_amount ELSE 0 END) AS destroy
    FROM 
        sales
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

    public function getCompanyless($date)
    {
        $query = "select * from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59' AND c_id = 0 ORDER BY date DESC;";
        return $this->query($query);
    }

}