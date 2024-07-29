<?php


/**
 * Cargo class
 */
class Wflog
{

    use Model;

    protected $table = 'wf_log';

    protected $allowedColumns = [
        'id',
        'error_code',
        'message',
        'endpoint',
        'date',
        'u_id'
    ];

    public function getErrors()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }
}