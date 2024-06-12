<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

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
                //show($data);
                $date = "";
                    if (isset($data["date"])) {
                        $date = $data["date"];
                    }
                    $show_button = false;
                ?>
                    <h2 class="">Sprzedaż produktów na firmę "Inna" z dnia: <?php echo $date;?></h2>
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
                                            <th>Data skanu</th>
                                            <th>Zdjęcie</th>
                                            <th>Produkt</th>
                                            <th>SKU</th>
                                            <th>Ilość (Jednostka)</th>
                                            <th>Rodzaj sprzedaży</th>
                                            <th>Handlowiec</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!empty($data["scans"])) {
                                            $show_button = true;
                                            foreach($data["scans"] as $scan) {
                                                echo "<tr>";
                                                echo "<td>$scan->date</td>";
                                                echo '
                                                <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="'.IMG_ROOT.''.$data["fullproducts"][$scan->p_id]["p_photo"].'"></td>
                                                <td>'.$data["fullproducts"][$scan->p_id]["p_name"].'</td>
                                                <td style="width: 100px">'.$data["fullproducts"][$scan->p_id]["sku"].'</td>';


                                                echo "<td>$scan->s_amount (".$data["fullproducts"][$scan->p_id]["p_unit"].")</td>";
                                                $sell_type = "";
                                                if($scan->sale_description == "scan" || $scan->sale_description == "") {
                                                    $sell_type = "Sprzedaż";
                                                } else if ($scan->sale_description == "gratis") {
                                                    $sell_type = "Gratis";
                                                } else if ($scan->sale_description == "destroy") {
                                                    $sell_type = "Uszkodzone";
                                                }
                                                echo "<td>$sell_type</td>";
                                                $trader = "";
                                                if(!empty($scan->h_id)) {
                                                    $trader = $data["users"][$scan->h_id]->first_name . ' ' . $data["users"][$scan->h_id]->last_name . ' (Pomoc dla: '.
                                                    $data["users"][$scan->u_id]->first_name . ' ' . $data["users"][$scan->u_id]->last_name .')';
                                                } else {
                                                    $trader = $data["users"][$scan->u_id]->first_name . ' ' . $data["users"][$scan->u_id]->last_name;
                                                }
                                                echo "<td>$trader</td>";
                                                echo "<td>";
                                                
                                                echo '<select class="company-select" style="width: 100%" id="scan_'.$scan->id.'" name="scan_'.$scan->id.'" placeholder="Wybierz firmę...">';
                                                echo "<option value='0' selected>Inna</option>";
                                                foreach ($data["companies"] as $company) {
                                                    $full_name = $company->full_name . " | " . $company->address;
                                                    $id = $company->id;
                                                    if ($scan->u_id == $company->guardian) {
                                                        echo "<option value='$id'>$full_name</option>";
                                                    }
                                                }
                                                echo "</select>";
                                                echo "</td>";
                                                
                                                echo "</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php if($show_button) echo '<button class="btn btn-primary" id="sendDataButton">Zapisz zmiany</button>';?>
                            </div>
                        </div>
                    </div>
            
        </main>

        <script>
document.getElementById('sendDataButton').addEventListener('click', function() {
    var selects = document.querySelectorAll('.company-select');
    var selectedData = [];

    selects.forEach(function(select) {
        var selectData = {
            id: select.getAttribute('id').split('_')[1],
            company_id: select.value
        };
        selectedData.push(selectData);
    });

    // Create a form to send the result data
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = ''; // Adjust the action URL if needed

    // Add hidden inputs for each entry in the selectedData array
    selectedData.forEach(function(item) {
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `selected_companies[${item.id}][id]`;
        inputId.value = item.id;

        const inputCompanyId = document.createElement('input');
        inputCompanyId.type = 'hidden';
        inputCompanyId.name = `selected_companies[${item.id}][company_id]`;
        inputCompanyId.value = item.company_id;

        form.appendChild(inputId);
        form.appendChild(inputCompanyId);
    });

    // Add the form to the document body and submit it
    document.body.appendChild(form);
    form.submit();
});
</script>
        <?php require_once 'landings/footer.view.php' ?>