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
        'w_active'
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
}