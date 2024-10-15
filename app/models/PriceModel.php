<?php


/**
 * Cargo class
 */
class PriceModel
{

    use Model;

    protected $table = 'prices';

    protected $allowedColumns = [
        'id',
        'p_id',
        'date_from',
        'date_to',
        'active',
        'date',
        'u_id',
        'production_cost',
        'price',
        'priceshops'
    ];

    public function getPrices(): array
    {
        $this->product = [];
        $array = [];
        $products = new PriceModel;
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
    public function getCurrentPrice()
    {
        $now = date("Y-m-d");
        $query = "SELECT * FROM $this->table 
                WHERE date_from <= '$now' 
                AND (date_to >= '$now' OR date_to IS NULL) 
                AND active = 1";
        return $this->query($query);
    }
    public function getCurrentSubPrice()
    {
        $now = date("Y-m-d");
        $query = "SELECT * FROM $this->table 
                WHERE date_from <= '$now' 
                AND (date_to >= '$now' OR date_to IS NULL) 
                AND active = 1";
        return $this->query($query);
    }
    public function getPriceMonth($month, $year)
    {
        $start_date = "$year-$month-01";
        $end_date = date("Y-m-t", strtotime($start_date));

        $query = "SELECT * FROM $this->table WHERE 
                date_from <= '$end_date' 
                AND (date_to >= '$start_date' OR date_to IS NULL)";
        return $this->query($query);
    }
    public function getAllPrices($id)
    {
        $query = "SELECT * FROM $this->table WHERE p_id = $id ORDER BY date_from DESC";
        return $this->query($query);
    }
    public function getLastPrice($id)
    {
        $query = "SELECT * FROM $this->table WHERE p_id = $id ORDER BY date_to ASC LIMIT 1";
        return $this->query($query);
    }

    public function getGroupedPrices($date_from, $date_to) {
        $query = "SELECT
            p_id,
            date_from,
            date_to,
            SUM(production_cost) AS total_production_cost,
            SUM(price) AS total_price
        FROM
            $this->table
        WHERE
            date_from <= '$date_to'
            AND (date_to >= '$date_from' OR date_to IS NULL)
        GROUP BY
            p_id,
            date_from,
            date_to
        ORDER BY
            p_id,
            date_from;";
        return $this->query($query);
    }
    public function getGroupedPrice($date_from, $date_to) {
        $query = "SELECT
            p_id,
            date_from,
            date_to,
            price,
            priceshops
        FROM
            $this->table
        WHERE
            date_from <= '$date_to'
            AND (date_to >= '$date_from' OR date_to IS NULL)
        GROUP BY
            p_id,
            date_from,
            date_to,
            price,
            priceshops
        ORDER BY
            p_id,
            date_from;";
        return $this->query($query);
    }
}