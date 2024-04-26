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

    public function getOneRecipt($id)
    {
        $query = "SELECT recipes.*, recipe_details.*
        FROM recipes
        LEFT JOIN recipe_details ON recipes.id = recipe_details.r_id
        WHERE recipes.active = 1 AND recipes.p_id = $id;";
        return $this->query($query);
    }

    public function getFullRecipes() {
        $query = "SELECT recipes.*, recipe_details.*
        FROM recipes
        LEFT JOIN recipe_details ON recipes.id = recipe_details.r_id
        WHERE recipes.active = 1;";
        return $this->query($query);
    }
}