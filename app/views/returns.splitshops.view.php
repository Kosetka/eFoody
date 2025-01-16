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
                <?php
                    if(isset($_GET["u_id"])) {
                ?>
                <div class="alert alert-info">
                    <h2>UWAGA!</h2>
                    <span>Pamiętaj o zapisaniu danych po ich modyfikacji!</span>
                </div>
            <?php
                }
            ?>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["recipes"]);
                $date = "";
                $date_now = date("Y-m-d");
                if(isset($data["date_now"])) {
                    $date_now = $data["date_now"];
                }
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                    $toBlock = "";
                    $toBlockButton = "";
                    if($date<date("Y-m-d")) {
                        $toBlock = " disabled";
                        $toBlockButton = " hidden";
                    }
                ?>
                    <h2 class="">Zwroty ze sklepów</h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <label for="c_idd" class="col-sm-2 col-form-label">Sklep:</label>
                                    <select class="form-control col-sm-2" id="c_idd" name="c_idd">
                                        <?php
                                        if(isset($_GET["c_idd"])) {
                                            $u_id = $_GET["c_idd"];
                                        } else {
                                            $u_id = '';
                                        }
                                        foreach ($data["companies"] as $trader) {
                                                $selected = "";
                                                if($trader->id == $u_id) {
                                                    $selected = " selected";
                                                }
                                                $f_name = "";
                                                if($trader->friendly_name <> "") {
                                                    $f_name = " (".$trader->friendly_name.")";
                                                }
                                                $full_name = $trader->full_name;
                                                $id = $trader->id;
                                                echo "<option value='$id' $selected>$full_name $f_name</option>";
                                            }
                                        ?>
                                    </select>
                                <label for="date_now" class="col-sm-2 col-form-label">Data zwrotu:</label>
                                <input type='date' class='form-control col-sm-2' name='date_now'
                                    value='<?php echo $date_now; ?>'>

                                </div>
                                <button class='btn btn-primary' style='margin-top: 20px;' type='submit'>Pokaż</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                if($data["show_table"]) {
                    ?>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["split"]);
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                    $toBlock = "";
                    $toBlockButton = "";
                    /*if($date<=date("Y-m-d")) {
                        $toBlock = " disabled";
                        $toBlockButton = " hidden";
                    }*/
                ?>
                
                    <h2 class="">Zwroty produktów: <?php echo $date;?></h2>
                    <?php /*<div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Wybierz dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div> */ ?>
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
                                            <th>Pobrane</th>
                                            <?php
                                                foreach($data["companies"] as $user) {
                                                    if($user->id == $data["company"]) {
                                                        echo "<th>".$user->full_name."</th>";
                                                    }
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data["cargo"])) {
                                            foreach($data["cargo"] as $product) {
                                                $vege = "";
                                                if($data["fullproducts"][$product["p_id"]]["vege"] == 1) {
                                                    $vege = "<span style='color: green; font-weight: bold;'>VEGE</span>";
                                                }
                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$vege.' '.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>';
                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                foreach($data["companies"] as $user) {
                                                    if($user->id == $data["company"]) {
                                                        $us = $user->id;
                                                        $val = 0;
                                                        if(isset($data["returns"][$us][$pid])) {
                                                            $val = $data["returns"][$us][$pid]["amount"];
                                                        }
                                                        echo "<td>".$product["amount"]."</td>";
                                                        echo "<td><input $toBlock type='number' class='form-control' value='$val' min='0' id='in_".$pid."_".$us."' name='in_".$pid."_".$us."'></td>";
                                                    }
                                                }
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <button id="prepareTableButton" <?=$toBlockButton; ?> class="btn btn-primary">Zapisz zwroty</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            
        </main>
        <script>
            document.getElementById('prepareTableButton').addEventListener('click', function() {
                let traders = <?php echo json_encode($data["companies"]); ?>;
                let planned = <?php if(isset($data["planned"])) echo json_encode($data["planned"]); else echo "[]";?>;
                let fullproducts = <?php echo json_encode($data["fullproducts"]); ?>;

                let result = {};

                // Initialize result object with trader IDs
                for (let traderId in traders) {
                    result[traders[traderId].id] = {};
                }

                // Iterate over each product row
                for (let productKey in planned) {
                    let product = planned[productKey];
                    let pid = fullproducts[product["p_id"]]["id"];
                    for (let traderKey in traders) {
                        let trader = traders[traderKey];
                        let us = trader.id;
                        let inputId = `in_${pid}_${us}`;
                        let inputElement = document.getElementById(inputId);
                        if (inputElement) {
                            let value = parseInt(inputElement.value);
                            if (!isNaN(value) && value > 0) {
                                if (!result[us][pid]) {
                                    result[us][pid] = 0;
                                }
                                result[us][pid] += value;
                            }
                        }
                    }
                }

                // Create a form to send the result data
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                // Add hidden inputs for each entry in the result object
                for (let traderId in result) {
                    for (let productId in result[traderId]) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `ordered_products[${traderId}][${productId}]`;
                        input.value = result[traderId][productId];
                        form.appendChild(input);
                    }
                }

                // Add the form to the document body and submit it
                document.body.appendChild(form);
                form.submit();
            });



            function updateCellColor(row) {
                let plannedAmount = parseInt(row.querySelector('td:nth-child(4)').textContent);
                let inputs = row.querySelectorAll('input[type="number"]');
                let sum = 0;
                inputs.forEach(input => {
                    sum += parseInt(input.value) || 0;
                });
                let cell = row.querySelector('td:nth-child(4)');
                let remainingCell = row.querySelector('td:nth-child(5)');
                let remaining = plannedAmount - sum;
                remainingCell.textContent = remaining;

                if (sum < plannedAmount) {
                    cell.style.backgroundColor = 'yellow';
                } else if (sum === plannedAmount) {
                    cell.style.backgroundColor = 'green';
                } else {
                    cell.style.backgroundColor = 'red';
                }
            }

            function updateTotals() {
                const totalRow = document.getElementById('totalRow');
                const rows = document.querySelectorAll('#orderedProductsTable tbody tr:not(#totalRow)');

                // Initialize totals array
                let totals = Array.from(totalRow.children).map(() => 0);

                rows.forEach(row => {
                    let cells = row.children;
                    for (let i = 3; i < cells.length; i++) { // Start from 3 to skip first columns
                        let value = parseInt(cells[i].querySelector('input')?.value || cells[i].textContent) || 0;
                        totals[i] += value;
                    }
                });

                // Update the totalRow cells with calculated totals
                totals.forEach((total, index) => {
                    if (index >= 3) { // Skip the first 3 columns
                        totalRow.children[index].textContent = total;
                    }
                });
            }

        </script>
        <?php require_once 'landings/footer.view.php' ?>