<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <form method="post">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?= implode("<br>", $errors) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <h1 class="h3 mb-3 fw-normal">Ustaw stany magazynowe</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="w_id" class="col-sm-2 col-form-label">Magazyn:</label>
                        <label for="w_id" class="col-sm-10 col-form-label">
                            <?php
                            $wid = $data["user_warehouse"];
                            $full_name_warehouse = "[" . $data["cities"][$wid]["c_name"] . "_" . $data["cities"][$wid]["wh_name"] . "] " . $data["cities"][$wid]["c_fullname"] . " " . $data["cities"][$wid]["wh_fullname"];
                            echo $full_name_warehouse;
                            ?>
                        </label>
                        <label for="w_data" class="col-sm-2 col-form-label">Stan na:</label>
                        <label for="w_id" class="col-sm-10 col-form-label"><?php echo date("d.m.Y");?></label>
                    </div>
                    <div id="modal" class="modal">
                        <span class="close">&times;</span>
                        <div class="modal-content">
                            <img id="modal-image" src="" alt="Modal Image">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <div class="col-sm-12">
                            <form id="form_individual" method="POST">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Zdjęcie</th>
                                            <th scope="col">Produkt</th>
                                            <th scope="col">SKU</th>
                                            <th scope="col">Ostatnia aktualizacja</th>
                                            <th scope="col">Ilość [Jednostka]</th>
                                            <th scope="col">Stan faktyczny</th>
                                            <th scope="col">Stan wyliczony</th>
                                            <th scope="col">Zejście według raportu produkcji</th>
                                            <th scope="col">PZ/WZ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data["products"] as $key => $value) {
                                            $product_p_photo = $value->p_photo;
                                            if (!empty($product_p_photo)) {
                                                $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $product_p_photo . "'>";
                                            } else {
                                                $photo = "";
                                            }
                                            $product_p_name = $value->p_name;
                                            $product_type = $value->prod_type;
                                            $product_sku = $value->sku;
                                            $product_p_unit = $value->p_unit;
                                            $amount = "";
                                            $last_date = "";
                                            if(isset($data["sets"][$value->id]->transaction_type)) {
                                                if($data["sets"][$value->id]->transaction_type == "set") {
                                                    $amount = $data["sets"][$value->id]->amount;
                                                    $last_date = $data["sets"][$value->id]->date;
                                                }
                                            }
                                            $p_add = 0;
                                            $p_sub = 0;
                                            if(isset($data["sets_all"][$key]["add"])) {
                                                $p_add = $data["sets_all"][$key]["add"];
                                            }
                                            if(isset($data["sets_all"][$key]["sub"])) {
                                                $p_sub = $data["sets_all"][$key]["sub"];
                                            }
                                            
                                            $p_tot = $p_add - $p_sub;

                                            echo "  <tr><td>$photo</td>";
                                            echo "<td>$product_p_name</td>";
                                            echo "<td>$product_sku</td>";
                                            echo '<td class="last-update">'.$last_date.'</td>';
                                            echo "<td>$amount $product_p_unit</td>";
                                            echo "<td>";
                                            echo '<input type="number" class="form-check-input p-2" style="width: 80px; height: 30px" id="p_id_' . $key . '" name="p_id[' . $key . ']" value="0" min="0" step="0.1">';
                                            echo '<input type="number" hidden class="form-check-input p-2" style="width: 80px; height: 30px" id="p_id_old_' . $key . '" name="p_id_old[' . $key . ']" value="'.$amount.'">';
                                            echo '<button type="button" style="margin-left: 70px;"class="btn btn-primary" onclick="submitSingleForm(' . $key . ')">Zapisz</button>';
                                            echo "</td>";
                                            
                                            $counted_stan = (float) $amount + (float) $p_tot;

                                            echo "<td>$counted_stan</td>";
                                            echo "<td></td>";
                                            
                                            echo "<td><span style='color: green; font-weight: bold;'>$p_add</span> / <span style='color: red; font-weight: bold;'>-$p_sub</span></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <form id="form_all" method="POST">
                    <button hidden type="button" class="w-40 btn btn-lg btn-primary"  onclick="submitAllForms()">Rozlicz wszystko</button>
                </form>
            </form>
<?php 
//show($data);
?>
        </main>

<script>
    function submitSingleForm(key) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '';
        
        var inputNew = document.getElementById('p_id_' + key).cloneNode(true);
        var inputOld = document.getElementById('p_id_old_' + key).cloneNode(true);
        
        form.appendChild(inputNew);
        form.appendChild(inputOld);
        
        document.body.appendChild(form);
        form.submit();
    }
    
    function submitAllForms() {
        var formAll = document.getElementById('form_all');
        var inputs = document.querySelectorAll('input[id^="p_id_"]');
        
        inputs.forEach(function(input) {
            var inputClone = input.cloneNode(true);
            formAll.appendChild(inputClone);
        });

        formAll.submit();
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pobierz bieżącą datę
        const today = new Date();
        const todayYear = today.getFullYear();
        const todayMonth = today.getMonth();
        const todayDate = today.getDate();

        // Funkcja sprawdzająca i kolorująca daty
        function checkAndColorDates() {
            const cells = document.querySelectorAll(".last-update");
            cells.forEach(cell => {
                const cellDateStr = cell.textContent.trim();
                const cellDate = new Date(cellDateStr);
                
                // Porównanie tylko roku, miesiąca i dnia
                const cellYear = cellDate.getFullYear();
                const cellMonth = cellDate.getMonth();
                const cellDay = cellDate.getDate();

                if (cellYear === todayYear && cellMonth === todayMonth && cellDay === todayDate) {
                    // Dzisiaj
                    cell.style.backgroundColor = "lightgreen";
                } else {
                    // Różnica dni między dzisiejszą datą a datą z komórki
                    const timeDifference = today - cellDate;
                    const dayDifference = Math.floor(timeDifference / (1000 * 3600 * 24));

                    if (dayDifference >= 1 && dayDifference <= 7) {
                        // Od wczoraj do 7 dni wstecz
                        cell.style.backgroundColor = "lightyellow";
                    } else if (dayDifference > 7) {
                        // Więcej niż 7 dni
                        cell.style.backgroundColor = "lightcoral";
                    }
                }
            });
        }

        checkAndColorDates();
    });
</script>
        <?php require_once 'landings/footer.view.php' ?>