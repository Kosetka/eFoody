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
                    <h2 class="">Mój plan na: <?php echo $date;?></h2>
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
                                            <th>Pobrane</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tot_plan = 0;
                                        $tot_pob = 0;
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

                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>';

                                                foreach($data["traders"] as $user) {
                                                    $us = $user->id;
                                                    $val = 0;
                                                    if(isset($data["split"][$us][$pid])) {
                                                        $val = $data["split"][$us][$pid]["amount"];
                                                    }
                                                    echo "<td>$val</td>";
                                                    echo "<td></td>";
                                                    $tot_plan += $val;
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
                                            <th><?=$tot_pob?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>
        <?php require_once 'landings/footer.view.php' ?>