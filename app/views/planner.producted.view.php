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
            <div class="alert alert-info">
                    <h2>UWAGA!</h2>
                    <span>Pamiętaj zapisać dane po ich uzupełnieniu!</span>
                </div>
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
                    if($date<>date("Y-m-d")) {
                        $toBlock = " disabled";
                        $toBlockButton = " hidden";
                    }
                ?>
                    <h2 class="">Raportowanie produkcji z dnia: <?php echo $date;?></h2>
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
                                            <th>Przygotowana ilość</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //show($data["producted"]);
                                        $tot_plan = 0;
                                        $tot_prod = 0;
                                        if(isset($data["planned"])) {
                                            foreach($data["planned"] as $product) {
                                                $pid = $data["fullproducts"][$product["p_id"]]["id"];
                                                $tot_plan += $product["amount"];

                                                echo "<tr>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$product["p_id"]]["p_photo"].'"></td>
                                                ';
                                                
                                                echo '<td>'.$data["fullproducts"][$product["p_id"]]["p_name"].'</td>';
                                                $am = 0;
                                                if(isset($data["producted"])) {
                                                    $am = $data["producted"][$pid]["amount"];
                                                }
                                                $tot_prod += $am;
                                                $color = '';
                                                if($product["amount"] < $am) {
                                                    $color = "yellow";
                                                } else if ($product["amount"] == $am) {
                                                    $color = "green";
                                                } else if($product["amount"] > $am) {
                                                    $color = "red";
                                                }

                                                

                                                echo '<td style="width: 100px">'.$data["fullproducts"][$product["p_id"]]["sku"].'</td>
                                                <td style="background: '.$color.'">'.$product["amount"].'</td>';


                                                echo "<td><input $toBlock type='number' class='form-control prepared-amount' value='$am' min='0' id='$pid' name='in_".$pid." data-pid='".$pid."'></td>";
                                                
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                        <tr id="totalRow">
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><?=$tot_plan?></th>
                                            <th><?=$tot_prod?></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <button id="prepareTableButton" <?=$toBlockButton?> class="btn btn-primary">Zapisz produkcję</button>
                            </div>
                        </div>
                    </div>
                </div>
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