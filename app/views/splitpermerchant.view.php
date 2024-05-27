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
                    <h2 class="">Przydzielanie produktów</h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <label for="c_name" class="col-sm-2 col-form-label">Handlowiec:</label>
                                    <select class="form-control col-sm-2" id="u_id" name="u_id">
                                        <?php
                                        if(isset($_GET["u_id"])) {
                                            $u_id = $_GET["u_id"];
                                        } else {
                                            $u_id = '';
                                        }
                                        foreach ($data["traders"] as $trader) {
                                                $selected = "";
                                                if($trader->id == $u_id) {
                                                    $selected = " selected";
                                                }
                                                $full_name = $trader->first_name . " " . $trader->last_name;
                                                $id = $trader->id;
                                                echo "<option value='$id' $selected>$full_name</option>";
                                            }
                                        ?>
                                    </select>

                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                    if(isset($_GET["u_id"])) {
                ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Produkty na dzień: <?php echo $date;?> dla: <?php
                        echo $data["traders"][$_GET["u_id"]]->first_name.' '.$data["traders"][$_GET["u_id"]]->last_name
                    ?></h2>
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
                                            <th>Wolna ilość</th>
                                            <th>Przypisana ilość</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tot_plan = 0;
                                        $tot_left = 0;
                                        $sp = [];
                                        /*foreach($data["split_total"] as $us) {
                                            foreach($us as $pr) {
                                                if(isset($sp[$pr["p_id"]])) {
                                                    $sp[$pr["p_id"]] += $pr["amount"];
                                                } else {
                                                    $sp[$pr["p_id"]] = $pr["amount"];
                                                }
                                            }
                                        }*/
                                        //show($data["cargo_total"]);
                                        foreach($data["cargo_total"] as $pr) {
                                            if(isset($sp[$pr["p_id"]])) {
                                                $sp[$pr["p_id"]] += $pr["amount"];
                                            } else {
                                                $sp[$pr["p_id"]] = $pr["amount"];
                                            }
                                        }
                                        if(isset($data["split"])) {
                                            foreach($data["split"] as $user) {
                                                foreach($user as $product) {
                                                    $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                    $tot_plan += $product["amount"];

                                                    echo "<tr>";
                                                    echo '
                                                    <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                    ';
                                                    
                                                    echo '<td>'.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>';
                                                    

                                                    echo '<td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                    <td>'.$product["amount"].'</td>';
                                                    if(isset($data["cargo"])) {
                                                        $am = $data["cargo"][$pid]["amount"];
                                                    } else {
                                                        $am = 0;
                                                    }
                                                    $free = $data["planned_total"][$pid]["amount"] - $sp[$pid];
                                                    echo '<td>'.$free.'/'.$data["planned_total"][$pid]["amount"].'</td>';
                                                    echo "<td><input $toBlock type='number' class='form-control prepared-amount' value='$am' min='0' max = '$free' id='$pid' name='in_".$pid." data-pid='".$pid."'></td>";
                                                    
                                                    echo "</tr>";
                                                }
                                            }
                                        }
                                        ?>
                                        <tr id="totalRow">
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><?=$tot_plan?></th>
                                            <th><?=$tot_left?></th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <button id="prepareTableButton" <?=$toBlockButton?> class="btn btn-primary">Potwierdź pobrane produkty</button>
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
        document.getElementById('prepareTableButton').addEventListener('click', function() {
            var inputs = document.querySelectorAll('.prepared-amount');
            var preparedData = [];

            inputs.forEach(function(input) {
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
            preparedData.forEach(function(product) {
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