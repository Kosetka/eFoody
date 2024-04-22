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
        foreach ($recipes->getRecipes() as $receipt) {
            $data["recipes"][$receipt["id"]] = (object) $receipt;
        }

        $products = new ProductsModel();
        foreach ($products->getProducts() as $product) {
            $data["products"][$product["id"]] = (object) $product;
        }

        $productsDetails = new RecipeDetails();
        $data["productsDetails"] = $productsDetails->getAll("recipe_details");


        $users = new User();
        foreach ($users->getAll("users") as $user) {
            $data["users"][$user->id] = (object) $user;
        }


        $this->view('recipes', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        $id = $URL[2];
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["recipeEdit"])) {
                $_POST["u_id"] = $_SESSION["USER"]->id;
                $recipes = new RecipesModel();
                $recipes->update($id, $_POST);
            }

            if (isset($_POST["detailsEdit"]) && isset($_POST["sub_prod"])) {
                //tu formularz edycji
                $recipe = new RecipeDetails();
                $recipe->delete($id, 'r_id');
                foreach ($_POST["sub_prod"] as $key => $value) {
                    $amount = $_POST["amount"][$key];
                    $d = ["r_id" => $id, "sub_prod" => $key, "amount" => $amount];
                    $recipe = new RecipeDetails();
                    $recipe->insert($d);
                }
            }

        }



        $data["product"] = $id;
        $recipes = new RecipesModel();
        $data["recipes"] = $recipes->get($id);

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["sub_products"][$product->id] = (object) $product;
        }
        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }
        $productsDetails = new RecipeDetails();
        foreach ($productsDetails->get($id) as $productDetail) {
            $data["productsDetails"][$productDetail->sub_prod] = (object) $productDetail;
        }

        $this->view('recipes.edit', $data);

    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST["recipeEdit"])) {
                $_POST["u_id"] = $_SESSION["USER"]->id;
                $recipes = new RecipesModel();
                $recipes->insert($_POST);
            }
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["sub_products"][$product->id] = (object) $product;
        }
        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }
        $this->view('recipes.new', $data);

    }
}
