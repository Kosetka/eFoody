<?php

/**
 * GetCargo class
 */
class Recipes
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $recipes = new RecipesModel();
        if(!empty($recipes->getRecipes())) {
            foreach ($recipes->getRecipes() as $receipt) {
                $data["recipes"][$receipt->p_id] = $receipt;
            }
        }

        $products = new ProductsModel();
        foreach ($products->getProducts() as $product) {
            $data["products"][$product["id"]] = (object) $product;
        }
        
        foreach ($products->getAllFullProducts() as $product) {
            $data["full_products"][$product->id] = (object) $product;
        }

        $productsDetails = new RecipesModel();
        foreach($productsDetails->getAll("recipes") as $prodDet) {
            $data["productsDetails"][$prodDet->p_id] = $prodDet;
        }

        $users = new User();
        foreach ($users->getAll("users") as $user) {
            $data["users"][$user->id] = (object) $user;
        }

        //tu koszt całej receptury
        // może w osobnej clasie 


        $this->view('recipes', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id = $URL[2];

        
        

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if($_POST["active"] == "true") {
                $active = 1;
            } else {
                $active = 0;
            }
            $_POST["u_id"] = $_SESSION["USER"]->id;
            $recipes = new RecipesModel();
            $recipes->update($id, ["active" => $active], "p_id");


            $recipe = new RecipeDetails();
            $recipe->delete($id, 'r_id');
            if(!empty($_POST["ordered_products"])) {
                foreach ($_POST["ordered_products"] as $key => $value) {
                    $d = ["r_id" => $id, "sub_prod" => $key, "amount" => $value];
                    $recipe = new RecipeDetails();
                    $recipe->insert($d);
                }
            }
        }



        $recipes = new RecipesModel();
        if(!empty($recipes->getById($id))) {
            $product = new ProductsModel();
            $data["product"] = $product->getProduct($id)[0];
            $data["product_active"] = $recipes->getById($id)[0]->active;
        } else {
            redirect('recipes');
        }

        $recipe = new RecipeDetails();
        if(!empty($recipe->getByID($id))) {
            $data["planned"] = (array) $recipe->getByID($id);
        }

        $subprice = new PriceModel();
        foreach($subprice->getCurrentPrice() as $sp) {
            $data["subprices"][$sp->p_id] = $sp;
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["halfproducts"][$product->id] = (array) $product;
        }
        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }

        $this->view('recipes.edit', $data);

    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id = $URL[2];

        $recipes = new RecipesModel();
        if(empty($recipes->getById($id))) {
            $product = new ProductsModel();
            $data["product"] = $product->getProduct($id)[0];
        } else {
            redirect('recipes');
        }


        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $_POST["u_id"] = $_SESSION["USER"]->id;
            if($_POST["active"] == "true") {
                $_POST["active"] = 1;
            } else {
                $_POST["active"] = 0;
            }
            $recipes = new RecipesModel();
            $recipes->insert([
                "p_id"=> $id,
                "active"=> $_POST["active"],
                "description"=> $data["product"]->p_name,
                "r_name"=> $data["product"]->p_name,
                "u_id"=> $_POST["u_id"],
            ]);
            $r_id = $recipes->getById($id)[0]->p_id; 
            $recipe = new RecipeDetails();
            $recipe->delete($r_id, 'r_id');
            foreach ($_POST["ordered_products"] as $key => $value) {
                $d = ["r_id" => $r_id, "sub_prod" => $key, "amount" => $value];
                $recipe = new RecipeDetails();
                $recipe->insert($d);
            }
            
        }

        $subprice = new PriceModel();
        foreach($subprice->getCurrentPrice() as $sp) {
            $data["subprices"][$sp->p_id] = $sp;
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["halfproducts"][$product->id] = (array) $product;
        }
        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }
        $this->view('recipes.new', $data);

    }
}
