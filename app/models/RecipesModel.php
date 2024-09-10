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

    public function getRecipes()
    {
        $query = "select * from $this->table";
        return $this->query($query);
    }
    public function get($id)
    {
        $query = "select * from $this->table WHERE id = $id";
        return $this->query($query);
    }
    public function getById($p_id)
    {
        $query = "select * from $this->table WHERE p_id = $p_id";
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
        LEFT JOIN recipe_details ON recipes.p_id = recipe_details.r_id
        WHERE recipes.active = 1;";
        return $this->query($query);
    }
    public function getFullRecipe($id) {
        $query = "SELECT recipes.*, recipe_details.*
        FROM recipes
        INNER JOIN recipe_details ON recipes.p_id = recipe_details.r_id
        WHERE recipes.active = 1 AND recipes.p_id = $id";
        return $this->query($query);
    }
}