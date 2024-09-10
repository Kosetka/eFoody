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
        'prod_type',
        'kcal',
        'friendly_name',
        'vege'
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

    public function getAllBySku($sku)
	{
		$query = "
        SELECT * FROM $this->table
        WHERE sku LIKE '$sku%'
        ORDER BY 
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sku, '-', 1), '-', -1) AS UNSIGNED),
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sku, '-', 2), '-', -1) AS UNSIGNED),
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sku, '-', 3), '-', -1) AS UNSIGNED),
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sku, '-', 4), '-', -1) AS UNSIGNED)
        ASC";
        return $this->query($query);
	}
    public function getAllById($id)
	{
		$query = "select * from $this->table WHERE id = $id";
		return $this->query($query);
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
    public function getAllSauces()
    {
        $query = "select * from $this->table WHERE prod_type = 2";
        return $this->query($query);
    }
    public function getAllFullProductsSorted()
    {
        $query = "select * from $this->table WHERE prod_type = 1 ORDER BY p_name ASC";
        return $this->query($query);
    }
    public function getAllSubProducts()
    {
        $query = "select * from $this->table WHERE prod_type = 0";
        return $this->query($query);
    }

    public function getAllSubProductsSorted()
    {
        $query = "select * from $this->table WHERE prod_type = 0 ORDER BY p_name ASC";
        return $this->query($query);
    }

    public function getAllProducts()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
    public function getProduct($id)
    {
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query);
    }
    public function getLast()
    {
        $query = "select * from $this->table ORDER BY ID DESC LIMIT 1";
        return $this->query($query)[0]->id;
    }
    public function getKcalByProducts($ids)
    {
        $idsList = implode(',', array_map('intval', $ids));
        
        $query = "SELECT DISTINCT kcal, id FROM $this->table WHERE id IN ($idsList);";
        
        return $this->query($query);
    }
}