<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<?php
//show($data["planned"]);
?>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <?php
                    //show($data["split"]);
                    $date_from = "";
                    if (isset($data["date_from"])) {
                        $date_from = $data["date_from"];
                    }
                    $date = "Zamówienia na dzień: " . $date_from;
                    
                    ?>
                    <h2 class=""><?php echo $date; ?></h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <div class="row"></div>
                                <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                                <input type='date' class='form-control col-sm-2' name='date_from'
                                    value='<?php echo $date_from; ?>'>

                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Plan produkcji ilościowy</h2>
                </div>
                <div class="">
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="orderedProductsTable">
                                <thead>
                                    <tr>
                                        <th>Nazwa produktu</th>
                                        <th>Zamówiona ilość</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $is_msg = false;
                                    $tot = 0;
                                    if (!empty($data["total"])) {
                                        foreach ($data["total"] as $p_id => $p_amount) {
                                            echo "<tr class='my-tr'>";
                                            echo "
                                                    <td >".$data["fullproducts"][$p_id]->p_name."</td>
                                                    <td ><b>$p_amount</b></td>";
                                            echo "</tr>";
                                            $tot += $p_amount;
                                        }
                                        $is_msg = true;
                                    }

                                    if (!$is_msg) {
                                        echo "<tr><td colspan='2'>Brak zamówień</td></tr>";
                                    }
                                    ?>
                                    <tr class='my-tr'>
                                        <th>Łącznie</th>
                                        <th><?php echo $tot;?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Szczegółowy plan zamówień</h2>
                </div>
                <div class="">
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <table class="table table-bordered" id="orderedProductsTable">
                                <thead>
                                    <tr>
                                        <th>ID zamówienia</th>
                                        <th>Adres zamówienia</th>
                                        <th>Wiadomość od kupującego</th>
                                        <th>Potrawy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $is_msg = false;
                                    if (!empty($data["ordered"])) {
                                        foreach ($data["ordered"] as $order_id => $order_data) {
                                            echo "<tr class='my-tr'>";
                                            echo "
                                                    <td >".$order_data["data"]["order_id"]."</td>
                                                    <td >" . $order_data["data"]["address"] . "</td>
                                                    <td >" . $order_data["data"]["description"] . "</td>";
                                                    //echo "<td rowspan='$int_row'>Wartość: " . $order_data["data"]["discount"] . "% | Kod: '" . $order_data["data"]["id_discount_code"] . "' | Kwota: " . $order_data["data"]["discount_amount"] . "zł</td>";
                                            $prod_names = "";
                                            foreach ($order_data as $date_here => $prod_det) {
                                                if ($date_here <> "data") {
                                                    $prod_cost = 0;
                                                    $prod_names .= $prod_det["p_id"] . " - <b>" . $prod_det["amount"] . "szt.</b></br>";
                                                    $prod_cost += $prod_det["cost"];
                                                }
                                            }
                                            echo "<td>$prod_names</td>";
                                            echo "</tr>";
                                        }
                                        $is_msg = true;
                                    }

                                    if (!$is_msg) {
                                        echo "<tr><td colspan='4'>Brak zamówień</td></tr>";
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