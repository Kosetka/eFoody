<?php


/**
 * ProductsQuantity class
 */
class ProductsQuantity
{

    use Model;

    protected $table = 'product_quantity';

    protected $allowedColumns = [
        'id',
        'w_id',
        'p_id',
        'u_id',
        'amount',
        'date',
        'old_amount',
        'transaction_type'
    ];

    public function getProducts(): array
    {
        $this->product = [];
        $array = [];
        $products = new ProductsQuantity;
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

    public function getAllSet($w_id, $p_id)
    {
        $query = "select * from $this->table WHERE `w_id` = $w_id AND `p_id` = $p_id AND `transaction_type` = 'set' ORDER BY `date` DESC LIMIT 1";
        return $this->query($query);
    }
    public function getAllSetByWarehouse($w_id)
    {
        $query = "select * from $this->table WHERE `w_id` = $w_id AND `transaction_type` = 'set' ORDER BY `date` DESC LIMIT 1";
        return $this->query($query);
    }

    public function getAllAdd($w_id, $p_id, $date)
    {
        $query = "select * from $this->table WHERE `w_id` = $w_id AND `p_id` = $p_id AND `transaction_type` = 'add' AND date >= '$date'";
        return $this->query($query);
    }
    public function getAllSub($w_id, $p_id, $date)
    {
        $query = "select * from $this->table WHERE `w_id` = $w_id AND `p_id` = $p_id AND `transaction_type` = 'sub' AND date >= '$date'";
        return $this->query($query);
    }

    public function getAllProducts()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
}