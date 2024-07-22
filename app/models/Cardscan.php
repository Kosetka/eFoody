<?php


/**
 * Cargo class
 */
class Cardscan
{

    use Model;

    protected $table = 'card_scan';

    protected $allowedColumns = [
        'id',
        'card_name',
        'w_id',
        'date',
        'status',
        'user_id'
    ];

    public function getScan($card_id)
    {
        $query = "select * from $this->table WHERE card_name = '$card_id' ORDER BY date DESC LIMIT 1;";
        return $this->query($query);
    }
    public function getScanDate($date)
    {
        $query = "select * from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59' ORDER BY date ASC;";
        return $this->query($query);
    }
    public function getScanOld($date)
    {
        $query = "select * from $this->table WHERE date < '$date 00:00:00' ORDER BY date ASC;";
        return $this->query($query);
    }
    public function getScanMonth($month, $year, $u_id)
    {
        $query = "select * from $this->table WHERE YEAR(date) = $year AND MONTH(date) = $month AND user_id = $u_id ORDER BY date ASC;";
        return $this->query($query);
    }
    
}