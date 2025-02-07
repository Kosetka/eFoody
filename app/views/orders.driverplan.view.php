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
                    <h2>Lista zamówień</h2>
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
                                        <th>Akcje</th>
                                        <th>Produkty</th>
                                        <th>Wartość</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $is_msg = false;
                                    if (!empty($data["ordered"])) {
                                        foreach ($data["ordered"] as $order_id => $order_data) {
                                            $int_row = 2;
                                            foreach ($order_data as $date_here => $prod_det) {
                                                if ($date_here <> "data") {
                                                    $int_row++;
                                                }
                                            }
                                            echo "<tr class='my-tr main-row'>";
                                            echo "
                                                    <td rowspan='$int_row'>".$order_data["data"]["order_id"]."</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["full_name"] . "</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["address"] . "</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["order_date"] . "</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["description"] . "</td>
                                                    <td rowspan='$int_row'>" . $order_data["data"]["order_status"] . "</td>";
                                                    echo "<td rowspan='$int_row' class='hnone'></td>";//tutaj opcja zmiany statusu, np. że dostarczone
                                                    //echo "<td rowspan='$int_row'>Wartość: " . $order_data["data"]["discount"] . "% | Kod: '" . $order_data["data"]["id_discount_code"] . "' | Kwota: " . $order_data["data"]["discount_amount"] . "zł</td>";
                                            $sum_row = 0;
                                            foreach ($order_data as $date_here => $prod_det) {
                                                if ($date_here <> "data") {
                                                    echo "<tr class='sub-row'>";
                                                    $prod_names = "";
                                                    $prod_cost = 0;
                                                        $prod_names .= $prod_det["p_id"] . " - <b>" . $prod_det["amount"] . "szt.</b></br>";
                                                        $prod_cost += $prod_det["cost"];

                                                    
                                                    echo "<td>$prod_names</td>";
                                                    $sum_row += $prod_cost;
                                                    echo "<td>" . number_format($prod_cost, 2) . " zł</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            echo "<tr class='my-tr sub-row'>";
                                            echo "<th>TOTAL</th>";
                                            echo "<th>" . number_format($sum_row, 2) . " zł</th>";
                                            
                                            echo "</tr>";
                                            
                                            echo "</tr>";
                                            
                                        }
                                        $is_msg = true;
                                        
                                    }

                                    if (!$is_msg) {
                                        echo "<tr><td colspan='9'>Brak zamówień</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <script>
document.querySelectorAll("td[rowspan]").forEach(td => {
    td.addEventListener("mouseenter", () => {
        let row = td.parentElement; // Główny wiersz
        row.classList.add("hover");

        // Pobieramy liczbę wierszy rowspan
        let rowspan = td.getAttribute("rowspan") - 1;
        let nextRow = row.nextElementSibling;

        // Dodajemy podświetlenie do kolejnych wierszy
        for (let i = 0; i < rowspan; i++) {
            if (nextRow) {
                nextRow.classList.add("hover");
                nextRow = nextRow.nextElementSibling;
            }
        }
    });

    td.addEventListener("mouseleave", () => {
        let row = td.parentElement;
        row.classList.remove("hover");

        let rowspan = td.getAttribute("rowspan") - 1;
        let nextRow = row.nextElementSibling;

        for (let i = 0; i < rowspan; i++) {
            if (nextRow) {
                nextRow.classList.remove("hover");
                nextRow = nextRow.nextElementSibling;
            }
        }
    });
});



        </script>
        <?php require_once 'landings/footer.view.php' ?>