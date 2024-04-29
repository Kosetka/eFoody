<?php


/**
 * Cargo class
 */
class CargoExchange
{

    use Model;

    protected $table = 'cargo_exchange';

    protected $allowedColumns = [
        'id',
        'u_id_init',
        'u_id_target',
        'result',
        'date_init',
        'date_result',
        'p_id',
        'amount'
    ];

    public function getExchange(): array
    {
        $this->product = [];
        $array = [];
        $products = new CargoExchange;
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
    public function getExchangeTodayMyOffers($u_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id_init = $u_id AND date_init >= '$today 00:00:00' AND date_init <='$today 23:59:59'";
        return $this->query($query);
    }

    public function getExchangeTodayMyOffersSelected($u_id, $status)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id_init = $u_id AND result = $status AND date_init >= '$today 00:00:00' AND date_init <='$today 23:59:59'";
        return $this->query($query);
    }

    public function getExchangeTodayOffersToMe($u_id)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id_target = $u_id AND date_init >= '$today 00:00:00' AND date_init <='$today 23:59:59'";
        return $this->query($query);
    }
    public function getExchangeTodayOffersToMeSelected($u_id, $status)
    {
        $today = date("Y-m-d");
        $query = "select * from $this->table WHERE u_id_target = $u_id AND result = $status AND date_init >= '$today 00:00:00' AND date_init <='$today 23:59:59'";
        return $this->query($query);
    }

    public function reportData($date_from, $date_to): array
    {
        $query = "SELECT 
        u_id_init,
        u_id_target,
        p_id,
        SUM(amount) AS num
    FROM 
    cargo_exchange
    WHERE 
        date_init BETWEEN '$date_from' AND '$date_to' -- Zmodyfikowany warunek daty
        AND result = 1
    GROUP BY 
        u_id_init, u_id_target, p_id
    ";
        return $this->query($query);
    }

}