<?php


/**
 * Cargo class
 */
class Fingerfoodscategory
{

    use Model;

    protected $table = 'fingerfoods_category';

    protected $allowedColumns = [
        'id',
        'fc_name',
        'fc_description',
        'fc_photo_1',
        'fc_photo_2',
        'fc_photo_3',
        'f_active',
        'f_order',
        'u_id',
        'date',
        'type'
    ];

    public function getAll()
    {
        $query = "select * from $this->table;";
        return $this->query($query);
    }

    public function getCategory($id)
    {
        $query = "select * from $this->table WHERE id = $id;";
        return $this->query($query);
    }
}