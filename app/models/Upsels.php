<?php


/**
 * Cargo class
 */
class Upsels
{

    use Model;

    protected $table = 'upsels';

    protected $allowedColumns = [
        'id',
        'p_id',
        'date_from',
        'date_to'
    ];

    public function getUpsels()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getUpselbyId($p_id)
    {
        $query = "select * from $this->table WHERE p_id = $p_id;";
        return $this->query($query);
    }
    public function getUpselsByDate($date)
    {
        $query = "select * from $this->table WHERE date_from <= '$date' AND date_to >= '$date';";
        return $this->query($query);
    }
}