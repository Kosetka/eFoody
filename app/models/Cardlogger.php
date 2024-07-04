<?php


/**
 * Cargo class
 */
class Cardlogger
{

    use Model;

    protected $table = 'card_logger';

    protected $allowedColumns = [
        'id',
        'date',
        'w_id',
        'card_name',
        'error'
    ];

    public function getCard($card_id)
    {
        $query = "select * from $this->table WHERE card_id = '$card_id' LIMIT 1;";
        return $this->query($query);
    }
    public function getLast($limit)
    {
        $query = "select * from $this->table WHERE error = 'OK,atcErr01' ORDER BY date DESC LIMIT $limit;";
        return $this->query($query);
    }
    public function getAll($limit)
    {
        $query = "select * from $this->table ORDER BY date DESC LIMIT $limit;";
        return $this->query($query);
    }
    
}