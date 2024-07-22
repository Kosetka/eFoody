<?php


/**
 * Cargo class
 */
class Userhistory
{

    use Model;

    protected $table = 'user_history';

    protected $allowedColumns = [
        'id',
        'u_id',
        'date_from',
        'date_to',
        'date',
        'role'
    ];

    public function getUser($u_id)
    {
        $query = "select * from $this->table WHERE u_id = $u_id;";
        return $this->query($query);
    }
    public function getLast($u_id)
    {
        $query = "select * from $this->table WHERE u_id = $u_id ORDER BY date DESC LIMIT 1;";
        return $this->query($query);
    }

}