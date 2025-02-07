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
                    $date_to = "";
                    if (isset($data["date_from"])) {
                        $date_from = $data["date_from"];
                    }
                    if (isset($data["date_from"])) {
                        $date_to = $data["date_to"];
                    }
                    if ($date_from == $date_to) {
                        if ($date_from == "") {
                            $date = "Zamówienia";
                        } else {
                            $date = "Zamówienia z dni od " . $date_from . " do " . $date_to;
                        }
                    } else {
                        $date = "Zamówienia z dnia " . $date_from;
                    }
                    ?>
                    <h2 class=""><?php echo $date; ?></h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <div class="row"></div>
                                <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                                <input type='date' class='form-control col-sm-2' name='date_from'
                                    value='<?php echo $date_from; ?>'>
                                <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                                <input type='date' class='form-control col-sm-2' name='date_to'
                                    value='<?php echo $date_to; ?>'>

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
                                        <th>ID zamówienia</th>
                                        <th>Klient</th>
                                        <th>Adres zamówienia</th>
                                        <th>Data</th>
                                        <th>Wiadomość od kupującego</th>
                                        <th>Status</th>
                                        <th>Rabat</th>
                                        <th>Dzień</th>
                                        <th>Produkty</th>
                                        <th>Wartość</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $is_msg = false;
                                    if (!empty($data["ordered"])) {
                                        foreach ($data["ordered"] as $order_id => $order_data) {
                                            $int_row = 1;
                                            foreach ($order_data as $date_here => $prod_det) {
                                                if ($date_here <> "data") {
                                                    $int_row++;
                                                }
                                            }
                                            echo "<tr class='my-tr'>";
                                            echo "
                                                    <td rowspan='$int_row'>$order_id</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["u_id"] . "</td>
                                                    <td rowspan='$int_row'>adres</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["order_date"] . "</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["description"] . "</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["order_status"] . "</td>
                                                    <td rowspan='$int_row'>Wartość: " . $order_data["data"]["discount"] . "% | Kod: '" . $order_data["data"]["id_discount_code"] . "' | Kwota: " . $order_data["data"]["discount_amount"] . "zł</td>
                                                    ";
                                            foreach ($order_data as $date_here => $prod_det) {
                                                if ($date_here <> "data") {
                                                    echo "<tr >";
                                                    echo "<td>$date_here</td>";
                                                    $prod_names = "";
                                                    $prod_cost = 0;
                                                    foreach ($prod_det as $pr) {
                                                        $prod_names .= $pr["p_id"] . " - " . $pr["amount"] . "szt.</br>";
                                                        $prod_cost += $pr["cost"];

                                                    }
                                                    echo "<td>$prod_names</td>";
                                                    echo "<td>" . number_format($prod_cost, 2) . " zł</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                        $is_msg = true;
                                    }

                                    if (!$is_msg) {
                                        echo "<tr><td colspan='10'>Brak zamówień</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>