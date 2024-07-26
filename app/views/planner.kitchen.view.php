<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
    th:nth-child(2n+6), 
    td:nth-child(2n+6),
    tr:nth-child(1) th {
        background-color: #f0f0f0;
    }
    tr:hover {
        background-color: #f0f0f0;
    }
</style>
<?php
    //show($data["planned"]);
?>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["recipes"]);
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                ?>
                    <h2 class="">Plan produkcji dla kuchni: <?php echo $date;?></h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Wybierz dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Zdjęcie</th>
                                            <th>Nazwa produktu</th>
                                            <th>SKU</th>
                                            <th>Planowana ilość</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tot_plan = 0;
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                $tot_plan += $product["amount"];

                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                ';
                                                if(isset($data["recipes"][$pid])) {
                                                    echo '<td>'.$data["fullproducts"][$product["p_id"]]["p_name"].' [<a href="'.ROOT.'/recipes/show/'.$product["p_id"].'">przepis</a>]</td>';
                                                } else {
                                                    echo '<td>'.$data["fullproducts"][$product["p_id"]]["p_name"].' [<span style="color: red;">brak</span>]</td>';
                                                }

                                                echo '<td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td>'.$product["amount"].'</td>';
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                        <tr id="totalRow">
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><?=$tot_plan?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                    $recipes = [];
                    foreach($data["recipes"] as $key => $value) {
                        foreach($value as $k => $v) {
                            $recipes[$k] = 0;
                        }
                    }
                    //show($data["planned"]);
                    if(!empty($data["planned"])) {
                        foreach($data["planned"] as $key => $value) {
                            $p = $value["p_id"]; //produkt który mam w planach
                            foreach($data["recipes"] as $k => $v) {
                                if($p == $k) { // produkt ma przepis
                                    foreach($v as $kk => $vv) {
                                        $recipes[$kk] += $vv->amount * $value["amount"]; //tu pomnożyć razy ilości z planów
                                    }
                                }
                            }
                        }
                    }
                    //show($recipes);
                ?>
                <div class="alert alert-info">
                    <h2>UWAGA!</h2>
                    <span>Lista potrzebnych półproduktów uwzględnia tylko produkty, które mają dodany przepis!</span>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                    <h2 class="">Lista potrzebnych półproduktów</h2>
                    </div>

                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Zdjęcie</th>
                                            <th>Nazwa półproduktu</th>
                                            <th>Potrzebna ilość</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($recipes)) {
                                            foreach($recipes as $key => $value) {
                                                if($value > 0) {
                                                    echo "<tr>";
                                                    echo '
                                                    <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["subproducts"][$key]["p_photo"].'"></td>
                                                    <td>'.$data["subproducts"][$key]["p_name"].'</td>
                                                    <td>'.$value.' '.$data["subproducts"][$key]["p_unit"].'</td>';
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    
        </main>
        <?php require_once 'landings/footer.view.php' ?>