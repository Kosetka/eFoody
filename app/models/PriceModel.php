<?php


/**
 * Cargo class
 */
class PriceModel
{

    use Model;

    protected $table = 'prices';

    protected $allowedColumns = [
        'id',
        'p_id',
        'date_from',
        'date_to',
        'active',
        'date',
        'u_id',
        'production_cost',
        'price'
    ];

    public function getPrices(): array
    {
        $this->product = [];
        $array = [];
        $products = new PriceModel;
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
    public function getCurrentPrice()
    {
        $now = date("Y-m-d H:i:s");
        $query = "select * from $this->table WHERE date_from <= '$now' AND date_to >= '$now' AND active = 1";
        return $this->query($query);
    }
    public function getAllPrices($id)
    {
        $now = date("Y-m-d H:i:s");
        $query = "select * from $this->table WHERE p_id = $id ORDER by date_to DESC";
        return $this->query($query);
    }
}