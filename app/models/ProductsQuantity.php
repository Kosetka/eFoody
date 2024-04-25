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
    public function getAllSetAllwarehouse()
    {
        $query = "SELECT t1.*, products.*
        FROM $this->table t1 
        JOIN (
            SELECT `p_id`, `w_id`, MAX(`date`) AS max_date 
            FROM $this->table 
            WHERE `transaction_type` = 'set' 
            GROUP BY `p_id`, `w_id`
        ) t2 ON t1.`p_id` = t2.`p_id` AND t1.`w_id` = t2.`w_id` AND t1.`date` = t2.`max_date`
        JOIN products ON t1.`p_id` = products.`id`
        WHERE t1.`transaction_type` = 'set' AND products.`prod_type` = 0
        ORDER BY t1.`date` DESC;";
        return $this->query($query);
    }
    public function getAllAddSub() {
        $query = "SELECT t1.`p_id`, t1.`w_id`, t1.`date`, t1.`amount`, t1.`transaction_type`, products.*
        FROM $this->table t1 
        JOIN products ON t1.`p_id` = products.`id`
        WHERE t1.`transaction_type` IN ('add', 'sub') AND products.`prod_type` = 0;";
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