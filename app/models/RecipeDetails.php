<?php


/**
 * Cargo class
 */
class RecipeDetails
{

    use Model;

    protected $table = 'recipe_details';

    protected $allowedColumns = [
        'id',
        'r_id',
        'sub_prod',
        'amount'
    ];

    public function getRecipes(): array
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
    public function get($id)
    {
        $query = "select * from $this->table WHERE r_id = $id";
        return $this->query($query);
    }
}