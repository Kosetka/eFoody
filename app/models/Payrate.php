<?php


/**
 * Cargo class
 */
class Payrate
{

    use Model;

    protected $table = 'payrate';

    protected $allowedColumns = [
        'id',
        'u_id',
        'type',
        'rate',
        'description',
        'date_from',
        'date_to',
        'date',
        'set_u_id'
    ];

    public function getUserPayrate($u_id)
    {
        $query = "select * from $this->table WHERE u_id = $u_id ORDER BY date_from ASC;";
        return $this->query($query);
    }
    public function getActiveByUser($u_id)
    {
        $query = "select * from $this->table WHERE u_id = $u_id AND date_to IS NULL LIMIT 1;";
        return $this->query($query);
    }
    public function getPayrate($id)
    {
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query);
    }
    public function getRates($month, $year)
    {
        $start_date = "$year-$month-01";
        $end_date = date("Y-m-t", strtotime($start_date));

        $query = "select * from $this->table WHERE 
                date_from <= '$end_date'
                AND (date_to >= '$start_date' OR date_to IS NULL);";
                
        return $this->query($query);
    }
}