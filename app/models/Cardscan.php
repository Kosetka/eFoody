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
        'status'
    ];

    public function getScan($card_id)
    {
        $query = "select * from $this->table WHERE card_name = '$card_id' ORDER BY date DESC LIMIT 1;";
        return $this->query($query);
    }
    
}