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

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
        <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["recipes"]);
                $date_from = "";
                $date_to = "";
                $date_now = date("Y-m-d");
                if (isset($data["date_from"])) {
                    $date_from = $data["date_from"];
                }
                if (isset($data["date_to"])) {
                    $date_to = $data["date_to"];
                }

                ?>
                    <h2 class="">Raport zwrotów</h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="date_from" class="col-sm-2 col-form-label">Dzień od:</label>
                                <input type='date' class='form-control col-sm-2' name='date_from'
                                    value='<?php echo $date_from; ?>'>
                                <label for="date_to" class="col-sm-2 col-form-label">Dzień do:</label>
                                <input type='date' class='form-control col-sm-2' name='date_to'
                                    value='<?php echo $date_to; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                    if(isset($_GET["date_from"])) {
                        $days = 0;
                        $days = countDaysExcludingSundays($_GET["date_from"], $_GET["date_to"], HOLIDAYS);
                ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Wszystkie sklepy</h2>
                    <button class="btn btn-primary" onclick="sortTable(4)">Sortuj po % zwrotów</button>
                    <button class="btn btn-primary" onclick="sortTable(7)">Sortuj po średnia sprzedaż</button>
                    <button class="btn btn-primary" onclick="sortTable(8)">Sortuj po średnia zwrotów</button>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th onclick="sortTable(0)">Sklep</th>
                                            <th onclick="sortTable(1)">Produkty rano</th>
                                            <th onclick="sortTable(2)">Produkty wieczorem</th>
                                            <th onclick="sortTable(3)">Zwroty</th>
                                            <th onclick="sortTable(4)">% zwrotów</th>
                                            <th onclick="sortTable(5)">Dni pracujące</th>
                                            <th onclick="sortTable(6)">Dostarczone produkty</th>
                                            <th onclick="sortTable(7)">Średnia sprzedaż [na dzień]</th>
                                            <th onclick="sortTable(8)">Średnia zwrotów [na dzień]</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data["cargo"])) {
                                            $total = 0;
                                            foreach($data["cargo"] as $shop_id => $shop_val) {
                                                $f_name = "";
                                                if($data["shops"][$shop_id]->friendly_name <> "") {
                                                    $f_name = " (".$data["shops"][$shop_id]->friendly_name.")";
                                                }
                                                echo "<tr>";
                                                echo '<td>'.$data["shops"][$shop_id]->full_name.' '.$f_name.'</td>';
                                                $early = 0;
                                                $late = 0;
                                                $return = 0;
                                                $ret = 0;
                                                $sumdays = 0;
                                                $avg_sell = 0;
                                                $avg_ret = 0;
                                                foreach($shop_val as $date => $prod_val) {
                                                    $early += $prod_val["delivery_early"];
                                                    $late += $prod_val["delivery_late"];
                                                    if(isset($prod_val["return"])) {
                                                        $return += $prod_val["return"];
                                                    }
                                                }
                                                echo '<td>'.$early.'</td>';
                                                echo '<td>'.$late.'</td>';
                                                echo '<td>'.$return.'</td>';
                                                $sumdays = $early + $late;
                                                if($early <> 0) {
                                                    $ret = $return / $early * 100;
                                                } else {
                                                    $ret = $return / $late * 100;
                                                }
                                                echo '<td>'.number_format($ret, 2).'%</td>';
                                                echo '<td>'.$days.'</td>';
                                                echo '<td>'.$sumdays.'</td>';
                                                if($days > 0) {
                                                    $avg_sell = number_format(($sumdays - $return) / $days,2);
                                                }
                                                if($days > 0) {
                                                    $avg_ret = number_format(($return) / $days,2);
                                                }
                                                echo '<td>'.$avg_sell.'</td>';
                                                echo '<td>'.$avg_ret.'</td>';
                                                echo "</tr>";
                                                
                                            }
                                        }
                                    
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        

            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Podział według czasu dostawy</h2>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Sklep</th>
                                            <th>Produkty</th>
                                            <th>Zwroty</th>
                                            <th>% zwrotów</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data["cargo"])) {
                                            $total = 0;
                                            $early = 0;
                                            $late = 0;
                                            $return_early = 0;
                                            $return_late = 0;
                                            
                                            foreach($data["cargo"] as $shop_id => $shop_val) {
                                                foreach($shop_val as $date => $prod_val) {
                                                    $early += $prod_val["delivery_early"];
                                                    $late += $prod_val["delivery_late"];
                                                    if(isset($prod_val["return"])) {
                                                        if($prod_val["delivery_early"] > 0) {
                                                            $return_early += $prod_val["return"];
                                                        } else {
                                                            $return_late += $prod_val["return"];
                                                        }
                                                    }
                                                }
                                            }
                                            $ret_early = $return_early / $early * 100;
                                            $ret_late = $return_late / $late * 100;
                                            echo "<tr>";
                                            echo '<td>Poranna dostawa</td>';
                                            echo '<td>'.$early.'</td>';
                                            echo '<td>'.$return_early.'</td>';
                                            echo '<td>'.number_format($ret_early, 2).'%</td>';
                                            echo "</tr>";

                                            echo "<tr>";
                                            echo '<td>Wieczorna dostawa</td>';
                                            echo '<td>'.$late.'</td>';
                                            echo '<td>'.$return_late.'</td>';
                                            echo '<td>'.number_format($ret_late, 2).'%</td>';
                                            echo "</tr>";
                                            
                                            
                                            
                                        }
                                    
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Podział z dniami tygodnia</h2>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Sklep</th>
                                            <th>Produkty</th>
                                            <th>Zwroty</th>
                                            <th>% zwrotów</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(isset($data["cargo"])) {
                                            $early = [];
                                            $late = [];
                                            $return_early = [];
                                            $return_late = [];
                                            $ret_early = [];
                                            $ret_late = [];
                                            
                                            foreach($data["cargo"] as $shop_id => $shop_val) {
                                                foreach($shop_val as $date => $prod_val) {
                                                    $dayOfWeek = date('w', strtotime($date));
                                                    if(!isset($early[$dayOfWeek])) {
                                                        $early[$dayOfWeek] = 0;
                                                    }
                                                    if(!isset($late[$dayOfWeek])) {
                                                        $late[$dayOfWeek] = 0;
                                                    }
                                                    if(!isset($return_early[$dayOfWeek])) {
                                                        $return_early[$dayOfWeek] = 0;
                                                    }
                                                    if(!isset($return_late[$dayOfWeek])) {
                                                        $return_late[$dayOfWeek] = 0;
                                                    }
                                                    $early[$dayOfWeek] += $prod_val["delivery_early"];
                                                    $late[$dayOfWeek] += $prod_val["delivery_late"];
                                                    
                                                    if(isset($prod_val["return"])) {
                                                        if($prod_val["delivery_early"] > 0) {
                                                            $return_early[$dayOfWeek] += $prod_val["return"];
                                                        } else {
                                                            $return_late[$dayOfWeek] += $prod_val["return"];
                                                        }
                                                    }
                                                }
                                            }
                                            echo "<tr>";
                                            echo '<td colspan="4">Poranna dostawa</td>';
                                            echo "</tr>";
                                            for($i = 0; $i<7;$i++) {
                                                echo "<tr>";
                                                echo '<td>'.WEEKDAYNAMES[$i].'</td>';
                                                if(!isset($early[$i])) {
                                                    $early[$i] = 0;
                                                }
                                                if(!isset($return_early[$i])) {
                                                    $return_early[$i] = 0;
                                                }
                                                echo '<td>'.$early[$i].'</td>';
                                                echo '<td>'.$return_early[$i].'</td>';
                                                if($early[$i] > 0) {
                                                    echo '<td>'.number_format($return_early[$i] / $early[$i] * 100, 2).'%</td>';
                                                } else {
                                                    echo "<td>0</td>";
                                                }
                                                echo "</tr>";
                                            }

                                            echo "<tr>";
                                            echo '<td colspan="4">Wieczorna dostawa</td>';
                                            echo "</tr>";
                                            for($i = 0; $i<7;$i++) {
                                                echo "<tr>";
                                                echo '<td>'.WEEKDAYNAMES[$i].'</td>';
                                                if(!isset($late[$i])) {
                                                    $late[$i] = 0;
                                                }
                                                if(!isset($return_late[$i])) {
                                                    $return_late[$i] = 0;
                                                }
                                                echo '<td>'.$late[$i].'</td>';
                                                echo '<td>'.$return_late[$i].'</td>';
                                                if($late[$i] > 0) {
                                                    echo '<td>'.number_format($return_late[$i] / $late[$i] * 100, 2).'%</td>';
                                                } else {
                                                    echo "<td>0</td>";
                                                }
                                                echo "</tr>";
                                            }
                                            
                                            
                                            
                                        }
                                    
                                        
                                        ?>
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
    function sortTable(id) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("orderedProductsTable");
        switching = true;
        // Początkowo ustawiamy sortowanie rosnące
        dir = "desc"; 
        while (switching) {
            switching = false;
            rows = table.rows;
            // Przechodzimy przez wszystkie wiersze (pomijając pierwszy wiersz z nagłówkami)
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[id]; // Wybieramy piątą kolumnę (indeks 4)
                y = rows[i + 1].getElementsByTagName("TD")[id];
                // Sprawdzamy, czy wartości muszą zostać zamienione
                if (dir == "asc") {
                    if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                // Zamieniamy wiersze, jeśli to konieczne
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                // Jeśli nie było zamiany i sortowanie jest rosnące, zmieniamy kierunek na malejące
                if (switchcount == 0 && dir == "desc") {
                    dir = "asc";
                    switching = true;
                }
            }
        }
    }
</script>

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