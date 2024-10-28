<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?= implode("<br>", $errors) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?= $success ?>
                </div>
            <?php endif; ?>
            <div class="card-header">
                <h1 class="h3 mb-3 fw-normal">Ceny produktów</h1>
            </div>

            <div class="text-start">
                <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produkt</th>
                                    <th scope="col">Zdjęcie</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Źródło</th>
                                    <th scope="col">Koszt produkcji</th>
                                    <th scope="col">Aktualna cena</th>
                                    <th scope="col">Marża</th>
                                    <th scope="col">Sklepy - zmienna</th>
                                    <th scope="col">Sklepy - stała</th>
                                    <th scope="col">Data obowiązywania</th>
                                    <th scope="col">Akcje</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($data["products"] as $key => $value) {
                                    if (!empty($value->p_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $value->p_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    $source = "<td style='background-color: lightyellow'>Stała</td>";
                                    $source_id = 0;
                                    if(isset($data["foodcost"][$value->id])) {
                                        $source = "<td style='background-color: lightgreen'>Auto</td>";
                                        $source_id = 1;
                                    }
                                    if (isset($data["prices"][$value->id])) {
                                        $price = $data["prices"][$value->id]->price;
                                        $production_cost = $data["prices"][$value->id]->production_cost;
                                        $date_from = $data["prices"][$value->id]->date_from;
                                        $date_to = $data["prices"][$value->id]->date_to;
                                        $margin = roundCost($price - $production_cost) . " zł (" . getMargin($price, $production_cost) . "%)";
                                    } else {
                                        $price = 0;
                                        $production_cost = 0;
                                        $date_from = "";
                                        $date_to = "";
                                        $margin = "";
                                    }
                                    $no_production_cost = "";
                                    $dates = $date_from ." - ". $date_to;
                                    if($source_id == 0) {
                                        if($production_cost == 0.01) {
                                            $no_production_cost = "style='background-color: lightcoral;' ";
                                        }
                                    } else {
                                        $production_cost = $data["foodcost"][$value->id][date("Y-m-d")]["total"];
                                        $margin = roundCost($price - $production_cost) . " zł (" . getMargin($price, $production_cost) . "%)";
                                        $dates = "";
                                    }
                                    $low_margin = "";
                                    if($production_cost > 0) {
                                        if(getMargin($price, $production_cost) >= 10) {
                                            $low_margin = " style='background-color: #ff5232;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 20) {
                                            $low_margin = " style='background-color: #ff5232;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 30) {
                                            $low_margin = " style='background-color: #ff7b5a;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 40) {
                                            $low_margin = " style='background-color: #ebe939;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 50) {
                                            $low_margin = " style='background-color: #b7d5ac;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 60) {
                                            $low_margin = " style='background-color: #93bf85;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 70) {
                                            $low_margin = " style='background-color: #6eaa5e;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 80) {
                                            $low_margin = " style='background-color: #469536; color:white;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 90) {
                                            $low_margin = " style='background-color: #008000; color:white; font-weight: bold;'";
                                        }
                                        if(getMargin($price, $production_cost) >= 99) {
                                            $low_margin = " style='background-color: white;'";
                                        }
                                        if(getMargin($price, $production_cost) < 0) {
                                            $low_margin = " style='background-color: red; color: red'";
                                        }
                                        
                                    }
                                    $vege = "";
                                    if($value->vege == 1) {
                                        $vege = "<span style='color: green; font-weight: bold;'>VEGE</span>";
                                    }
                                    $shop_price = "";
                                    $fixed_price = "";
                                    if(isset($data["prices"][$value->id]->priceshops)) {
                                        $shop_price = $data["prices"][$value->id]->priceshops;
                                        $shop_price_show = roundCost($shop_price) . " zł";
                                    } else {
                                        $shop_price_show = "";
                                    }
                                    if(isset($data["prices"][$value->id]->pricefixed)) {
                                        $fixed_price = $data["prices"][$value->id]->pricefixed;
                                        $fixed_price_show = roundCost($fixed_price) . " zł";
                                    } else {
                                        $fixed_price_show = "";
                                    }
                                    
                                    echo "  <tr><td $no_production_cost>$vege $value->p_name</td>
                                            <td>$photo</td>
                                            <td>$value->sku</td>
                                            $source
                                            <td $no_production_cost>".roundCost($production_cost)." zł</td>
                                            <td>".roundCost($price)." zł</td>
                                            <td $low_margin>$margin</td>
                                            <td>".$shop_price_show."</td>
                                            <td>".$fixed_price_show."</td>
                                            <td>$dates</td>";
                                    echo '<td>
                                    <a href= "' . ROOT . '/prices/edit/' . $value->id . '" class = "btn btn-success">
                                        Edytuj
                                    </a>
                                    </td>';
                                    echo "</tr>";
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>