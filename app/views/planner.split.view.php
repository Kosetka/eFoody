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
            <div class="alert alert-info">
                <h2>UWAGA!</h2>
                <span>Po dodaniu planu podziału lub wprowadzeniu zmian, pamiętaj o ich zapisaniu!</span>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["traders"]);
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
                                            <?php
                                                foreach($data["traders"] as $user) {
                                                    echo "<th>".$user->first_name." ".$user->last_name."</th>";
                                                }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>
                                                <td>'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td>'.$product["amount"].'</td>';

                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                foreach($data["traders"] as $user) {
                                                    $us = $user->id;
                                                    echo "<td><input type='number' class='form-control' value='0' min='0' id='in_".$pid."_".$us."' name='in_".$pid."_".$us."'>in_".$pid."_".$us."</td>";
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
                                <button id="prepareTableButton" class="btn btn-primary">Zapisz podział</button>
                            </div>
                        </div>
                    </div>
            
        </main>
        <script>
            document.getElementById('prepareTableButton').addEventListener('click', function() {
                let traders = <?php echo json_encode($data["traders"]); ?>;
                let planned = <?php echo json_encode($data["planned"]); ?>;
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
        </script>
        <?php require_once 'landings/footer.view.php' ?>