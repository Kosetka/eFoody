<?php


/**
 * Companies class
 */
class PlacesModel
{

    use Model;

    protected $table = 'places';

    protected $allowedColumns = [
        'id',
        'u_id',
        'date',
        'sold',
        'c_id'
    ];

    public function getMyPlaces($u_id)
    {
        $today = date("Y-m-d");
        $query = "select *, pl.date as pl_date from $this->table as pl INNER JOIN companies AS c ON pl.c_id = c.id WHERE pl.u_id = $u_id AND pl.date>= '$today 00:00:00' AND pl.date <= '$today 23:59:59'";
        return $this->query($query);
    }
    public function checkVisit($c_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE c_id = $c_id AND date>= '$today 00:00:00' AND date <= '$today 23:59:59'";
        return $this->query($query);
    }

    public function reportData($date_from, $date_to): array
    {
        $query = "SELECT 
        u_id,
        sold,
        SUM(sold) AS num
    FROM 
    places
    WHERE 
        date BETWEEN '$date_from' AND '$date_to' -- Zmodyfikowany warunek daty
    GROUP BY 
        u_id, sold
    ";
        return $this->query($query);
    }
}