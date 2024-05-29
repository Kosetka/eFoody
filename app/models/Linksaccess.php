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
}