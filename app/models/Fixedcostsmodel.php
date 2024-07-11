<?php


/**
 * Cargo class
 */
class Fixedcostsmodel
{

    use Model;

    protected $table = 'costs_fixed';

    protected $allowedColumns = [
        'id',
        'date_from',
        'date_to',
        'date_add',
        'name',
        'date',
        'type',
        'price',
        'description',
        'active',
        'category',
        'method'
    ];

    public function getByID($id)
    {
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query)[0];
    }
    public function getAll()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
    public function getByMonth($month, $year)
    {
        $start_date = "$year-$month-01";
        $end_date = date("Y-m-t", strtotime($start_date));

        $query = "
            SELECT * 
            FROM $this->table 
            WHERE 
                date_from <= '$end_date'
                AND (date_to >= '$start_date' OR date_to IS NULL)
        ";
//może źle działać
        return $this->query($query);
    }
}