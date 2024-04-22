<?php


/**
 * Cargo class
 */
class RecipesModel
{

    use Model;

    protected $table = 'recipes';

    protected $allowedColumns = [
        'id',
        'p_id',
        'active',
        'description',
        'r_name',
        'u_id',
        'date'
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
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query);
    }
}