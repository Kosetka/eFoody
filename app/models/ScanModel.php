<?php


/**
 * ScanModel class
 */
class ScanModel
{

    use Model;

    protected $table = 'product_scans';

    protected $allowedColumns = [
        'id',
        'p_id',
        'sku',
        'ean',
        'u_id',
        's_warehouse',
        'date',
        'ps_active'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['sku'])) {
            $this->errors['sku'] = "SKU nie może być puste";
        }

        $product = new ProductsModel;
        $temp["sku"] = $_POST['sku'];

        $row = $product->first($temp);
        if (!$row) {
            $this->errors['sku_exists'] = "Taki SKU nie widnieje w bazie danych.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getScans($p_id, $w_id, $date)
    {
        $query = "select * from $this->table WHERE p_id = $p_id AND s_warehouse = $w_id AND date >= '$date' AND ps_active = 1";
        return $this->query($query);
    }

    public function getTotalProducts($date)
    {
        $query = "select count(*) as total from $this->table WHERE date >= '$date 00:00:00' AND date <= '$date 23:59:59' AND ps_active = 1";
        return $this->query($query)[0]->total;
    }
}