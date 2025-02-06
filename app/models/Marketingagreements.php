<?php


/**
 * Cargo class
 */
class Marketingagreements
{

    use Model;

    protected $table = 'marketing_agreements';

    protected $allowedColumns = [
        'id',
        'u_id',
        'mc_id',
        'date_accepted',
        'date_resign'
    ];

    public function getAgreements()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
    public function getAgreementsById($id)
    {
        $query = "select * from $this->table WHERE u_id = $id;";
        return $this->query($query);
    }


}