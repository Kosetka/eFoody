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
        foreach ($products->getAllSauces() as $product) {
            $data["sauces"][$product->id] = (object) $product;
        }

        $productsDetails = new RecipesModel();
        if(!empty($productsDetails->getAll("recipes"))) {
            foreach($productsDetails->getAll("recipes") as $prodDet) {
                $data["productsDetails"][$prodDet->p_id] = $prodDet;
            }
        }
        if(!empty($productsDetails->getFullRecipes())) {
            foreach($productsDetails->getFullRecipes() as $prodDet) {
                $data["reciptDetails"][$prodDet->p_id][$prodDet->sub_prod]["amount"] = $prodDet->amount;
                $data["reciptDetails"][$prodDet->p_id][$prodDet->sub_prod]["sub_prod"] = $prodDet->sub_prod;
                if(isset($data["products"][$prodDet->sub_prod]->kcal)) {
                    $data["reciptDetails"][$prodDet->p_id][$prodDet->sub_prod]["kcal"] = $data["products"][$prodDet->sub_prod]->kcal;
                } else {
                    $data["reciptDetails"][$prodDet->p_id][$prodDet->sub_prod]["kcal"] = 0;
                }
            }
        }
        
        foreach($data["reciptDetails"] as $prod_id_key => $prod_id_val) {
            $data["kcal_calc"][$prod_id_key] = 0;
            foreach($prod_id_val as $sub_prod) {
                $data["kcal_calc"][$prod_id_key] += $sub_prod["amount"] * $sub_prod["kcal"];
            }
        }

        $sauce = new Sauce();
        if(!empty($sauce->getSauces())) {
            foreach($sauce->getSauces() as $sauce) {
                $data["kcal_sauce"][$sauce->p_id] = $sauce->r_id;
            }
        }

        $users = new User();
        foreach ($users->getAll("users") as $user) {
            $data["users"][$user->id] = (object) $user;
        }

        $foodcost = new Foodcost();
        $data["foodcost"] = $foodcost->getPriceDetailedWithSauce(date("Y-m-d"));

        //show($data["foodcost"]);
        //die;

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

            $pproducts = new ProductsModel();
            foreach($pproducts->getAllSubProducts() as $tetemp) {
                $temp_prod[$tetemp->id] = $tetemp;
            }
            $pids = [];
            if(isset($_POST["ordered_products"])) {
                foreach($_POST["ordered_products"] as $pprod_key => $pprod_val) {
                    $pids[] = $pprod_key;
                } 
            }
            

            $allergens = new Productalergens();
            $allergens->delete($id,"p_id");
            $ids = [];
            if(!empty($_POST["ordered_products"])) {
                foreach($_POST["ordered_products"] as $pprod_key => $pprod_val) {
                    $ids[] = $pprod_key;
                } 
            }
            


            $kcal = 0;

            $sauce = new Sauce();
            $sauce->delete($id, 'p_id');
            if(isset($_POST["is_sauce"]) && $_POST["is_sauce"] == 1) {
                $sauce->insert([
                    "p_id"=> $id,
                    "r_id"=> $_POST["selected_sauce"]
                ]);
                $rec = $recipes->getFullRecipe($_POST["selected_sauce"]);
                //show($rec);
                foreach($rec as $key => $value) {
                    //echo "kcal: ".$temp_prod[$value->sub_prod]->kcal."</br>";
                    //echo "amount: ".$value->amount."</br>";
                    $kcal += $temp_prod[$value->sub_prod]->kcal * $value->amount;
                    $ids[] = $value->sub_prod;
                    //echo "total kcal: ".$kcal."</br>";
                }
            }
            if(!empty($_POST["ordered_products"])) {
                if(!empty($allergens->getAlergensByProducts($ids))) {
                    foreach($allergens->getAlergensByProducts($ids) as $al) {
                        $allergens->insert([
                                "p_id" => $id,
                                "a_id" => $al->a_id
                                ]);
                        echo " ".$al->a_id;
                    }
                }
            }

            $pcal = [];
            if(!empty($_POST["ordered_products"])) {
                if(!empty($pproducts->getKcalByProducts($pids))) {
                    foreach($pproducts->getKcalByProducts($ids) as $al) {
                        $pcal[$al->id] = $al; 
                    }
                }
            }
            

            $recipe = new RecipeDetails();
            $recipe->delete($id, 'r_id');
            if(!empty($_POST["ordered_products"])) {
                foreach ($_POST["ordered_products"] as $key => $value) {
                    $d = ["r_id" => $id, "sub_prod" => $key, "amount" => $value];
                    $recipe = new RecipeDetails();
                    $recipe->insert($d);
                    $kcal += $pcal[$key]->kcal * $value;
                }
            }
            $kcal = roundToNearest5($kcal);
            $pproducts->update($id, ["kcal" => $kcal]);
            redirect('recipes');
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
        foreach ($products->getAllSauces() as $product) {
            $data["sauces"][$product->id] = (array) $product;
        }
        $data["sauce"] = [];
        $sauce = new Sauce();
        if(!empty($sauce->getSauce($id))) {
            $data["sauce"] = $sauce->getSauce($id);
        }
    //show($data);die;

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
            
            $pproducts = new ProductsModel();
            foreach($pproducts->getAllSubProducts() as $tetemp) {
                $temp_prod[$tetemp->id] = $tetemp;
            }
            $pids = [];
            if(isset($_POST["ordered_products"])) {
                foreach($_POST["ordered_products"] as $pprod_key => $pprod_val) {
                    $pids[] = $pprod_key;
                } 
            }
            
            
            $recipes = new RecipesModel();
            $recipes->insert([
                "p_id"=> $id,
                "active"=> $_POST["active"],
                "description"=> $data["product"]->p_name,
                "r_name"=> $data["product"]->p_name,
                "u_id"=> $_POST["u_id"],
            ]);

            $ids = [];
            $kcal = 0;
            $recipe = new RecipeDetails();
            $r_id = $recipes->getById($id)[0]->p_id; 
            $recipe->delete($r_id, 'r_id');
            $sauce = new Sauce();
            $sauce->delete($id, 'p_id');
            if(isset($_POST["is_sauce"]) && $_POST["is_sauce"] == 1) {
                $sauce->insert([
                    "p_id"=> $id,
                    "r_id"=> $_POST["selected_sauce"]
                ]);
                $rec = $recipes->getFullRecipe($_POST["selected_sauce"]);
                //show($rec);
                foreach($rec as $key => $value) {
                    //echo "kcal: ".$temp_prod[$value->sub_prod]->kcal."</br>";
                    //echo "amount: ".$value->amount."</br>";
                    $kcal += $temp_prod[$value->sub_prod]->kcal * $value->amount;
                    $ids[] = $value->sub_prod;
                    //echo "total kcal: ".$kcal."</br>";
                }
            }
            //echo $kcal." - 1<br>";
            $allergens = new Productalergens();
            $allergens->delete($id,"p_id");
            if(isset($_POST["ordered_products"])) {
                foreach($_POST["ordered_products"] as $pprod_key => $pprod_val) {
                    $ids[] = $pprod_key;
                } 
            }
            if(isset($_POST["ordered_products"])) {
                if(!empty($allergens->getAlergensByProducts($ids))) {
                    foreach($allergens->getAlergensByProducts($ids) as $al) {
                        $allergens->insert([
                                "p_id" => $id,
                                "a_id" => $al->a_id
                                ]);
                    }
                }
            }
            $pcal = [];
            if(isset($_POST["ordered_products"])) {
                if(!empty($pproducts->getKcalByProducts($pids))) {
                    foreach($pproducts->getKcalByProducts($ids) as $al) {
                        $pcal[$al->id] = $al; 
                    }
                }
            }

            
            
            
            foreach ($_POST["ordered_products"] as $key => $value) {
                $d = ["r_id" => $r_id, "sub_prod" => $key, "amount" => $value];
                $recipe = new RecipeDetails();
                $recipe->insert($d);
                $kcal += $pcal[$key]->kcal * $value;
            }
            //echo $kcal." - 2<br>";
            $kcal = roundToNearest5($kcal);
            $pproducts->update($id, ["kcal" => $kcal]);
            //die;
            redirect('recipes');
        }

        $subprice = new PriceModel();
        foreach($subprice->getCurrentPrice() as $sp) {
            $data["subprices"][$sp->p_id] = $sp;
        }

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["halfproducts"][$product->id] = (array) $product;
        }
        foreach ($products->getAllSauces() as $product) {
            $data["sauces"][$product->id] = (array) $product;
        }

        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }
        $this->view('recipes.new', $data);

    }


    public function show() {
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
            redirect('recipes');
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
        $foodcost = new Foodcost();
        $data["foodcost"] = $foodcost->getPriceDetailedWithSauce(date("Y-m-d"));
        //show($data["subprices"]);die;

        $products = new ProductsModel();
        foreach ($products->getAllSubProducts() as $product) {
            $data["halfproducts"][$product->id] = (array) $product;
        }
        $products = new ProductsModel();
        foreach ($products->getAllFullProducts() as $product) {
            $data["products"][$product->id] = (object) $product;
        }
        $data["sauce"] = "";
        $sauce = new Sauce();
        if(!empty($sauce->getSauce($id))) {
            $data["sauce"] = $products->getProduct($sauce->getSauce($id)[0]->r_id);
        }
        //show($data["sauce"]);die;

        $this->view('recipes.show', $data);

    }
    
}
