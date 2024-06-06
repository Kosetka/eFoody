<?php


/**
 * Cargo class
 */
class Linksaccess
{

    use Model;

    protected $table = 'links_access';

    protected $allowedColumns = [
        'id',
        'l_id',
        'u_id',
        'r_id'
    ];

    public function getAccessByRole($id)
    {
        $query = "select * from $this->table WHERE r_id = $id";
        return $this->query($query);
    }
    public function getEmailsByLinks($l_id) {
        $query = "select * from $this->table WHERE l_id = $l_id";
        return $this->query($query);
    }
}