<?php


/**
 * ProductsModel class
 */
class ProductsModel
{

    use Model;

    protected $table = 'products';

    protected $allowedColumns = [
        'id',
        'p_name',
        'p_description',
        'sku',
        'ean',
        'p_unit',
        'p_photo',
        'prod_type'
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['sku'])) {
            $this->errors['sku'] = "SKU produktu jest wymagane.";
        }

        $product = new ProductsModel;
        $temp["sku"] = $_POST['sku'];

        $row = $product->first($temp);
        if ($row) {
            $this->errors['sku_exists'] = "Takie SKU już widnieje w bazie danych.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getProducts(): array
    {
        $this->product = [];
        $array = [];
        $products = new ProductsModel;
        $arr = $products->getAll($this->table);

        foreach ($arr as $product) {
            //foreach ($role as $r) {
            $product = (array) $product;
            $array[] = (array) $product;
            //}
        }
        $this->products = $array;
        //show($array);
        return $array;
    }

    public function getAllFullProducts()
    {
        $query = "select * from $this->table WHERE prod_type = 1";
        return $this->query($query);
    }
    public function getAllSubProducts()
    {
        $query = "select * from $this->table WHERE prod_type = 0";
        return $this->query($query);
    }

    public function getAllProducts()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
}