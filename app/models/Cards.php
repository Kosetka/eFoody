<?php


/**
 * Cargo class
 */
class Cards
{

    use Model;

    protected $table = 'cards';

    protected $allowedColumns = [
        'id',
        'card_id',
        'status'
    ];

    public function getCard($card_id)
    {
        $query = "select * from $this->table WHERE card_id = '$card_id' LIMIT 1;";
        return $this->query($query);
    }
    
}