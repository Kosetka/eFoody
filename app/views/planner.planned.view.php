<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

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
                //show($data["warehouse"]);

                $wh = "[".$data["warehouse"][0]->c_name."_".$data["warehouse"][0]->wh_name."] -> ".$data["warehouse"][0]->c_fullname." ".$data["warehouse"][0]->wh_fullname;

                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                ?>
                    <h2 class="">Plan produkcji: <?php echo $date;?> - Magazyn: <?=$wh?></h2>
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
                                            <th>Przygotowana ilość</th>
                                            <th>% Realizacji</th>
                                            <th>Alergeny</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                //show($product);
                                                $ids = "";
                                                if(!empty($data["prod_alergens"][$product["p_id"]]->lista_a_id)) {
                                                    $numbers = explode(",", $data["prod_alergens"][$product["p_id"]]->lista_a_id);
                                                    foreach ($numbers as $number) {
                                                        $ids .=$number.", ";
                                                    }
                                                }
                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td>'.$product["amount"].'</td>
                                                <td>0</td>
                                                <td>'.getPercent(2, $product["amount"]).'%</td>
                                                <td>'.substr($ids, 0, -2).'</td>
                                                <td><a class="btn btn-primary" href=" ' . ROOT . '/assets/labels/'.$data["fullproducts"][$product["p_id"]]["sku"].'.lbx"
                                                role="button">Etykieta</a></td>
                                                ';
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>
        <?php require_once 'landings/footer.view.php' ?>