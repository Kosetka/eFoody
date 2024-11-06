<?php


/**
 * Warehouse class
 */
class WarehouseModel
{

    use Model;

    protected $table = 'warehouses';

    protected $allowedColumns = [
        'id',
        'wh_name',
        'wh_fullname',
        'id_city',
        'wh_description',
        'w_active',
        'w_lat',
        'w_lon'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['wh_name'])) {
            $this->errors['wh_name'] = "Tag magazynu jest wymagany.";
        }

        if (empty($data['wh_fullname'])) {
            $this->errors['wh_fullname'] = "Pełna nazwa magazynu jest wymagana.";
        }

        $wh = new WarehouseModel;
        $temp["wh_name"] = $_POST['wh_name'];

        $row = $wh->first($temp);
        if ($row) {
            $this->errors['wh_name_exists'] = "Taki TAG magazynu już widnieje w bazie danych.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getWarehouse($w_id)
    {
        $query = "
            SELECT 
                w.id AS warehouse_id, 
                w.wh_name, 
                w.wh_fullname, 
                w.wh_description, 
                w.w_active, 
                w.w_lat,
                w.w_lon,
                c.id AS city_id, 
                c.c_name, 
                c.c_fullname, 
                c.c_description, 
                c.c_active
            FROM 
                warehouses w
            JOIN 
                cities c 
            ON 
                w.id_city = c.id
            WHERE 
                w.id = '$w_id'
        ";
        return $this->query($query);
    }
    public function getWarehouses()
    {
        $query = "
            SELECT 
                w.id AS warehouse_id, 
                w.wh_name, 
                w.wh_fullname, 
                w.wh_description, 
                w.w_active, 
                w.w_lat,
                w.w_lon,
                c.id AS city_id, 
                c.c_name, 
                c.c_fullname, 
                c.c_description, 
                c.c_active
            FROM 
                warehouses w
            JOIN 
                cities c 
            ON 
                w.id_city = c.id
            WHERE 
                w.w_active = 1
        ";
        return $this->query($query);
    }
}