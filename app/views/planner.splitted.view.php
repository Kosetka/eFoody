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
                //show($data["split"]);
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                ?>
                    <h2 class="">Plan podziału: <?php echo $date;?></h2>
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
                                            <th>Pozostało</th>
                                            <th>Sklepy</th>
                                            <?php
                                                foreach($data["traders"] as $user) {
                                                    echo "<th>".$user->first_name." ".$user->last_name."</th>";
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tot = [];
                                        $tot_plan = 0;
                                        $tot_left = 0;
                                        $tot_shops = 0;
                                        foreach($data["traders"] as $user) {
                                            $tot[$user->id] = 0;
                                        }
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                $left = $product["amount"];
                                                foreach($data["traders"] as $user) {
                                                    $us = $user->id;
                                                    if(isset($data["split"][$us][$pid])) {
                                                        $left -= $data["split"][$us][$pid]["amount"];
                                                    }
                                                }
                                                
                                                $tot_left += $left;
                                                $tot_plan += $product["amount"];
                                                $vege = "";
                                                $tshops = 0;
                                                if(isset($data["cargo"][$product["p_id"]])) {
                                                    $tshops = $data["cargo"][$product["p_id"]];
                                                }
                                                $tot_shops += $tshops;
                                                if($data["fullproducts"][$product["p_id"]]["vege"] == 1) {
                                                    $vege = "<span style='color: green; font-weight: bold;'>VEGE </span>";
                                                }
                                                $left -= $tshops;
                                                $tot_left -= $tshops;

                                                $color = '';
                                                if($left < 0) {
                                                    $color = "red";
                                                } else if ($left == 0) {
                                                    $color = "green";
                                                } else if($left > 0) {
                                                    $color = "yellow";
                                                }

                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$vege.' '.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td style="background: '.$color.'">'.$product["amount"].'</td>
                                                <td>'.$left.'</td>
                                                <td>'.$tshops.'</td>';

                                                foreach($data["traders"] as $user) {
                                                    $us = $user->id;
                                                    $val = 0;
                                                    if(isset($data["split"][$us][$pid])) {
                                                        $val = $data["split"][$us][$pid]["amount"];
                                                        $tot[$us] += $data["split"][$us][$pid]["amount"];
                                                    }
                                                    echo "<td>$val</td>";
                                                }
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                        <tr id="totalRow">
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><?=$tot_plan?></th>
                                            <th><?=$tot_left?></th>
                                            <th><?=$tot_shops?></th>
                                            <?php
                                                foreach($data["traders"] as $user) {
                                                    echo "<th>".$tot[$user->id]."</th>";
                                                }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <h2 class="">Szczegółowy podział sklepów: <?php echo $date;?></h2>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Zdjęcie</th>
                                            <th>Nazwa produktu</th>
                                            <th>SKU</th>
                                            <th>Total</th>
                                            <?php
                                                foreach($data["shops"] as $shop) {
                                                    echo "<th>".$shop->full_name."</th>";
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tot = [];
                                        $tot_shops = 0;
                                        foreach($data["shops"] as $sh) {
                                            $tot[$sh->id] = 0;
                                        }
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                
                                                $vege = "";
                                                $tshops = 0;
                                                if(isset($data["cargo"][$product["p_id"]])) {
                                                    $tshops = $data["cargo"][$product["p_id"]];
                                                }
                                                $tot_shops += $tshops;
                                                if($data["fullproducts"][$product["p_id"]]["vege"] == 1) {
                                                    $vege = "<span style='color: green; font-weight: bold;'>VEGE </span>";
                                                }
                                                
                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$vege.' '.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td>'.$tshops.'</td>';

                                                foreach($data["shops"] as $shop) {
                                                    $val = 0;
                                                    if(isset($data["cargo_comp"][$shop->id][$pid])) {
                                                        $val = $data["cargo_comp"][$shop->id][$pid];
                                                        $tot[$shop->id] += $val;
                                                    }
                                                    echo "<td>$val</td>";
                                                }
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                        <tr id="totalRow">
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><?=$tot_shops?></th>
                                            <?php
                                                foreach($data["shops"] as $shop) {
                                                    echo "<th>".$tot[$shop->id]."</th>";
                                                }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>
        <?php require_once 'landings/footer.view.php' ?>