<?php


/**
 * Cargo class
 */
class Linksmodel
{

    use Model;

    protected $table = 'links';

    protected $allowedColumns = [
        'id',
        'l_name',
        'l_directory',
        'l_icon',
        'l_type',
        'id_parent',
        'l_order',
        'l_active'
    ];

    public function getLinks()
    {
        $query = "select * from $this->table WHERE l_active = 1 ORDER BY l_type ASC, id_parent ASC, l_order ASC;";
        return $this->query($query);
    }
}