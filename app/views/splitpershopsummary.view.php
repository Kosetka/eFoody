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
                    $date_now = date("Y-m-d");
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                    $toBlock = "";
                    $toBlockButton = "";
                    if ($date < date("Y-m-d")) {
                        $toBlock = ""; //disabled
                        $toBlockButton = ""; //hidden
                    }
                    ?>
                    <h2 class="">Podział produktów dla sklepów i kierowców</h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="date" class="col-sm-2 col-form-label">Dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET["date"])) {
                //show($data["cargo_per_driver"]);
                ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Produkty do zrobienia na dzień: <?php echo $date; ?> <span
                                style="color: green;">RANO</span></h2>
                        <div class="">
                            <div class="form-group row m-3">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="orderedProductsTable">
                                        <thead>
                                            <tr>
                                                <th>Nazwa produktu</th>
                                                <th>Łącznie do przygotowania</th>
                                                <?php
                                                foreach ($data["drivers"] as $driver) {
                                                    echo "<th><a href='#d$driver->id'>" . $driver->first_name . " " . $driver->last_name . "</a></th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            if (isset($data["planned"])) {
                                                foreach ($data["planned"] as $product) {
                                                    $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                    $vege = "";
                                                    if ($data["fullproducts"][$product["p_id"]]["vege"] == 1) {
                                                        $vege = "<span style='color: green; font-weight: bold;'>VEGE </span>";
                                                    }
                                                    $to_prod = 0;

                                                    if (isset($data["c_total_morning"][$pid])) {
                                                        $to_prod = $data["c_total_morning"][$pid];
                                                    }
                                                    if ($to_prod > 0) {
                                                        echo "<tr>";
                                                        echo '<td>' . $vege . ' ' . $data["fullproducts"][$product["p_id"]]["p_name"] . '</td>';

                                                        $total += $to_prod;
                                                        echo '<td>' . $to_prod . '</td>';


                                                        foreach ($data["drivers"] as $driver) {
                                                            $prod_i = 0;
                                                            if (isset($data["cargo_per_driver"][$driver->id]["total"][$pid])) {
                                                                $prod_i = $data["cargo_per_driver"][$driver->id]["total"][$pid];
                                                            }
                                                            echo "<td>$prod_i</td>";
                                                        }

                                                        echo "</tr>";
                                                    }
                                                }
                                            }


                                            ?>
                                            <tr id="totalRow">
                                                <th>Total</th>
                                                <th><?php echo $total; ?></th>
                                                <?php
                                                foreach ($data["drivers"] as $driver) {
                                                    $prod_i = "";
                                                    if (isset($data["cargo_per_driver"][$driver->id]["total"]["sum"])) {
                                                        $prod_i = $data["cargo_per_driver"][$driver->id]["total"]["sum"];
                                                    }
                                                    echo "<th>$prod_i</th>";
                                                }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Produkty do zrobienia na dzień: <?php echo $date; ?> <a href="#pdiv"><span
                                    style="color: red;">PO POŁUDNIU</span></a></h2>
                        <div class="">
                            <div class="form-group row m-3">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="orderedProductsTable">
                                        <thead>
                                            <tr>
                                                <th>Nazwa produktu</th>
                                                <th>Łącznie do przygotowania</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($data["planned"])) {
                                                $total = 0;
                                                foreach ($data["planned"] as $product) {
                                                    $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                    $vege = "";
                                                    if ($data["fullproducts"][$product["p_id"]]["vege"] == 1) {
                                                        $vege = "<span style='color: green; font-weight: bold;'>VEGE </span>";
                                                    }
                                                    $to_prod = 0;

                                                    if (isset($data["c_total_evening"][$pid])) {
                                                        $to_prod = $data["c_total_evening"][$pid];
                                                    }
                                                    if ($to_prod > 0) {
                                                        echo "<tr>";
                                                        echo '<td>' . $vege . ' ' . $data["fullproducts"][$product["p_id"]]["p_name"] . '</td>';

                                                        $total += $to_prod;
                                                        echo '<td>' . $to_prod . '</td>';
                                                        echo "</tr>";
                                                    }
                                                }
                                            }


                                            ?>
                                            <tr id="totalRow">
                                                <th>Total</th>
                                                <th><?php echo $total; ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                foreach ($data["drivers"] as $driver) {
                    ?>
                    <div class="card mb-4" id="d<?php echo $driver->id; ?>">
                        <div class="card-header">
                            <h2 class="">Podział na sklepy dla: <?php echo $driver->first_name . " " . $driver->last_name; ?>
                                <span style="color: green;">RANO</span>
                            </h2>
                            <div class="">
                                <div class="form-group row m-3">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered" id="orderedProductsTable">
                                            <thead>
                                                <tr>
                                                    <th>Nazwa sklepu</th>
                                                    <th>Produkty do przygotowania</th>
                                                    <th>Ilość</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tot_tot = 0;
                                                if (isset($data["cargo_per_driver"][$driver->id])) {
                                                    foreach ($data["cargo_per_driver"][$driver->id] as $shop_key => $shop_val) {
                                                        if ($shop_key <> "total") {
                                                            echo "<tr>";
                                                            $r_span = 1;
                                                            $tot = 0;
                                                            foreach ($shop_val as $pr_key => $pr_val) {
                                                                $r_span++;
                                                            }
                                                            $f_name = "";
                                                            if (isset($data["shops"][$shop_key]->friendly_name)) {
                                                                if (!empty($data["shops"][$shop_key]->friendly_name)) {
                                                                    $f_name = " (" . $data["shops"][$shop_key]->friendly_name . ")";
                                                                }
                                                            }
                                                            echo "<td rowspan='$r_span'>" . $data["shops"][$shop_key]->full_name . "$f_name
                                                                    </br>
                                                                    Adres: " . $data["shops"][$shop_key]->address . "</td>";
                                                            foreach ($shop_val as $pr_key => $pr_val) {
                                                                echo "<tr>";
                                                                echo "<td>" . $data["fullproducts"][$pr_key]["p_name"] . "</td>";
                                                                echo "<td>$pr_val</td>";
                                                                echo "</tr>";
                                                                $tot += $pr_val;
                                                                $tot_tot += $pr_val;
                                                            }
                                                            echo "</tr>";
                                                            echo "<tr>";
                                                            echo "<th style='background-color: lightgray !important;'></th>";
                                                            echo "<th style='background-color: lightgray !important;'>TOTAL</th>";
                                                            echo "<th style='background-color: lightgray !important;'>$tot</th>";
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }

                                                ?>
                                                <tr id="totalRow">
                                                    <th colspan="2">Total</th>
                                                    <th><?php echo $tot_tot; ?></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="card mb-4" id="pdiv">
                    <div class="card-header">
                        <h2 class="">Podział na sklepy <span style="color: red;">PO POŁUDNIU</span></h2>
                        <div class="">
                            <div class="form-group row m-3">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="orderedProductsTable">
                                        <thead>
                                            <tr>
                                                <th>Nazwa sklepu</th>
                                                <th>Produkty do przygotowania</th>
                                                <th>Ilość</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $tot_tot = 0;
                                            if (isset($data["cargo_night"])) {
                                                foreach ($data["cargo_night"] as $shop_key => $shop_val) {
                                                    if ($shop_key <> "total") {
                                                        $r_span = 1;
                                                        $tot = 0;
                                                        foreach ($shop_val as $pr_key => $pr_val) {
                                                            $r_span++;
                                                        }
                                                        $f_name = "";
                                                        if (isset($data["shops"][$shop_key]->friendly_name)) {
                                                            if (!empty($data["shops"][$shop_key]->friendly_name)) {
                                                                $f_name = " (" . $data["shops"][$shop_key]->friendly_name . ")";
                                                            }
                                                        }
                                                        echo "<tr>";
                                                        echo "<td rowspan='$r_span'>" . $data["shops"][$shop_key]->full_name . "$f_name
                                                                    </br>
                                                                    Adres: " . $data["shops"][$shop_key]->address . "</td>";
                                                        foreach ($shop_val as $pr_key => $pr_val) {
                                                            echo "<tr>";
                                                            echo "<td>" . $data["fullproducts"][$pr_key]["p_name"] . "</td>";
                                                            echo "<td>$pr_val</td>";
                                                            echo "</tr>";
                                                            $tot += $pr_val;
                                                            $tot_tot += $pr_val;
                                                        }
                                                        echo "</tr>";
                                                        echo "<tr>";
                                                        echo "<th style='background-color: lightgray !important;'></th>";
                                                        echo "<th style='background-color: lightgray !important;'>TOTAL</th>";
                                                        echo "<th style='background-color: lightgray !important;'>$tot</th>";
                                                        echo "</tr>";
                                                    }
                                                }
                                            }

                                            ?>
                                            <tr id="totalRow">
                                                <th colspan="2">Total</th>
                                                <th><?php echo $tot_tot; ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>









                <?php
            }
            ?>



        </main>

        <script>
            document.getElementById('prepareTableButton').addEventListener('click', function () {
                var inputs = document.querySelectorAll('.prepared-amount');
                var preparedData = [];

                inputs.forEach(function (input) {
                    var productData = {
                        id: input.getAttribute('id'),
                        amount: input.value
                    };
                    preparedData.push(productData);
                });

                // Create a form to send the result data
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = ''; // Adjust the action URL if needed

                // Add hidden inputs for each entry in the preparedData array
                preparedData.forEach(function (product) {
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = `prepared_products[${product.id}][id]`;
                    inputId.value = product.id;

                    const inputAmount = document.createElement('input');
                    inputAmount.type = 'hidden';
                    inputAmount.name = `prepared_products[${product.id}][amount]`;
                    inputAmount.value = product.amount;

                    form.appendChild(inputId);
                    form.appendChild(inputAmount);
                });

                // Add the form to the document body and submit it
                document.body.appendChild(form);
                form.submit();
            });
        </script>
        <?php require_once 'landings/footer.view.php' ?>