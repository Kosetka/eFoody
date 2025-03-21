<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<?php
    //show($data["fullproducts"]);
    $productsjson = json_encode($data["halfproducts"]);
?>
<script>
    var jsArray = <?php echo $productsjson; ?>;
</script>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
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

                <h1 class="h3 mb-3 fw-normal">Edytuj recepturę</h1>
                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="r_name" class="col-sm-2 col-form-label">Produkt:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="r_name" name="r_name" value="<?php echo $data["product"]->p_name;?>" readonly>
                            <input type="text" class="form-control" id="p_id" name="p_id" value="<?php echo $data["product"]->id;?>" hidden>
                            <input type="text" class="form-control" id="description" name="description" value="<?php echo $data["product"]->p_name;?>" hidden>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="active" class="col-sm-2 col-form-label">Aktywna:</label>
                        <div class="col-sm-10">
                            <?php 
                                $checked = "checked";
                                if($data["product_active"] == 0) {
                                    $checked = "";
                                }
                            ?>
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?= $checked; ?>>
                        </div>
                    </div>
                    <?php
                    $hid_show = "";
                    if($data["product"]->prod_type == 2) {
                        $hid_show = " hidden";
                    }
                    ?>
                    <div class="form-group row m-3" <?=$hid_show;?>>
                        <label for="is_sauce" class="col-sm-2 col-form-label">Dodaj sos:</label>
                        <div class="col-sm-10">
                            <?php
                                $show_checked = "";
                                if(!empty($data["sauce"])) {
                                    $show_checked = "checked";
                                }
                            ?>
                            <input type="checkbox" class="form-check-input" id="is_sauce" name="is_sauce" value="1" <?=$show_checked;?>>
                        </div>
                    </div>
                    <div class="form-group row m-3" id="sauce-selection" hidden>
                        <label for="sauce" class="col-sm-2 col-form-label">Sosy:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="sauce" name="sauce" required>
                                <?php
                                
                                    foreach($data["sauces"] as $sauce) {
                                        $sel = "";
                                        if(isset($data["sauce"])) {
                                            if($sauce["id"] == $data["sauce"][0]->r_id) {
                                                $sel = " selected";
                                            }
                                        }
                                        echo '<option value="' . $sauce["id"] . '" ' . $sel . '>' . $sauce["p_name"] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row m-3">
                            <label for="p_id" class="col-sm-2 col-form-label">Produkt:</label>
                            <div class="col-sm-3" style="display: inline;">
                                <select style="width: 80%" id="c_id" name="p_id" placeholder="Wybierz produkt...">
                                </select>
                                <button id="addProductButton" class="btn btn-success">+</button>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Zdjęcie</th>
                                            <th>Nazwa produktu</th>
                                            <th>SKU</th>
                                            <th>Jednostka</th>
                                            <th>Ilość</th>
                                            <th>Cena (porcja / jednostka)</th>
                                            <th>Kalorie (porcja / jednostka)</th>
                                            <th>Akcja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Zamówione produkty będą tutaj dodawane -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <button id="submitOrderButton" class="btn btn-primary">Zapisz zmiany</button>
                    </div>
                </div>

        </main>



        <script>


//OKKKKKKK
document.addEventListener("DOMContentLoaded", function() {
    const products = [
        <?php
        foreach($data["halfproducts"] as $product) {
            $subprices_temp = 0;
            if(isset($data["subprices"][$product['id']]->production_cost)) {
                $subprices_temp = $data["subprices"][$product['id']]->production_cost;
            }
            echo "{ ID: ".$product['id'].", p_name: '".$product['p_name']."', sku: '".$product['sku']."', kcal: '".$product['kcal']."', p_photo: '".$product['p_photo']."', p_unit: '".$product['p_unit']."', subprice: '".$subprices_temp."' },";
        }
        ?>
    ];
    const initialOrder = [
        <?php
        if(isset($data["planned"])) {
            foreach($data["planned"] as $product) {
                $subprices_temp = 0;
                if(isset($data["subprices"][$product->id]->production_cost)) {
                    $subprices_temp = $data["subprices"][$product->id]->production_cost;
                }
                echo "{ id: ".$product->sub_prod.", amount: ".$product->amount.", subprice: '".$subprices_temp."' },";
            }
        }
        ?>
    ];

    const selectElement = document.getElementById('c_id');
    const orderedProductsTable = document.getElementById('orderedProductsTable').querySelector('tbody');
    const addProductButton = document.getElementById('addProductButton');
    const selectedSpan = document.getElementById('select2-chosen-1');

    function populateSelect() {
        selectElement.innerHTML = ''; // Clear the select element
        products.forEach(product => {
            const option = document.createElement('option');
            option.value = product.ID;
            option.textContent = product.p_name;
            selectElement.appendChild(option);
        });

        // Update the span text to the first available product name
        if (selectElement.options.length > 0) {
            selectElement.selectedIndex = 0;
            if (document.getElementById('select2-chosen-1')) {
                document.getElementById('select2-chosen-1').innerHTML = selectElement.options[0].textContent;
            }
        } else {
            if (document.getElementById('select2-chosen-1')) {
                document.getElementById('select2-chosen-1').innerHTML  = '';
            }
        }
    }

    function addProductToTable(product, quantity) {
        const tr = document.createElement('tr');
        let pr = (product.subprice === 0 || !isFinite(quantity * product.subprice)) 
                ? 0 
                : (quantity * product.subprice).toFixed(2);
        let prk = (product.kcal === 0 || !isFinite(quantity * product.kcal)) 
                ? 0 
                : (quantity * product.kcal).toFixed(1);
        tr.innerHTML = `
            <td>${product.ID}</td>
            <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="<?php echo IMG_ROOT;?>${product.p_photo}"></td>
            <td>${product.p_name}</td>
            <td>${product.sku}</td>
            <td>${product.p_unit}</td>
            <td><input type="number" class="form-control" value="${quantity}" min="1"></td>
            <td>${pr} zł / ${product.subprice} zł</td>
            <td>${prk} / ${product.kcal}</td>
            <td><button class="btn btn-danger remove-product">Usuń</button></td>
        `;
        orderedProductsTable.appendChild(tr);

        // Add event listener to the remove button
        tr.querySelector('.remove-product').addEventListener('click', function() {
            removeProduct(tr, product);
        });
    }

    function addProduct() {
        const selectedProductId = parseInt(selectElement.value);
        const selectedProductIndex = products.findIndex(product => product.ID === selectedProductId);
        if (selectedProductIndex !== -1) {
            const selectedProduct = products[selectedProductIndex];

            // Add selected product to ordered products table
            addProductToTable(selectedProduct, 1);

            // Remove selected product from products array
            products.splice(selectedProductIndex, 1);

            // Update the select element
            populateSelect();
        }
    }

    function removeProduct(row, product) {
        // Remove the row from the table
        row.remove();

        // Add the product back to the products array
        products.push(product);

        // Update the select element
        populateSelect();
    }

    // Initialize the select element with products
    populateSelect();

    // Add initial products to the table
    initialOrder.forEach(orderItem => {
        const product = products.find(p => p.ID === orderItem.id);
        if (product) {
            addProductToTable(product, orderItem.amount);

            // Remove initial products from the products array
            const index = products.findIndex(p => p.ID === product.ID);
            if (index !== -1) {
                products.splice(index, 1);
            }
        }
    });

    // Update the select element again to remove initial products
    populateSelect();

    // Add event listener to the add product button
    addProductButton.addEventListener('click', addProduct);

    // Add event listener to the submit button
    document.getElementById('submitOrderButton').addEventListener('click', function() {
        const orderedProducts = [];
        const rows = orderedProductsTable.querySelectorAll('tr');
        rows.forEach(row => {
            const id = row.cells[0].textContent; // ID produktu
            const quantity = row.cells[5].querySelector('input').value; // Planowana ilość
            orderedProducts.push({ id: id, quantity: quantity });
        });

        // Utwórz formularz
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        // Dodaj pola do formularza dla każdego zamówionego produktu
        orderedProducts.forEach(product => {
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = `ordered_products[${product.id}]`; // Klucz to ID produktu, wartość to ilość
            inputId.value = product.quantity;
            form.appendChild(inputId);
        });

        // Sprawdź, czy checkbox o id "active" jest zaznaczony
        const activeCheckbox = document.getElementById('active');
        const activeValue = activeCheckbox.checked ? 'true' : 'false';

        // Dodaj pole "active" do formularza
        const inputActive = document.createElement('input');
        inputActive.type = 'hidden';
        inputActive.name = 'active';
        inputActive.value = activeValue;
        form.appendChild(inputActive);

        // Obsługa checkboxa "Dodaj sos"
        const sauceCheckbox = document.getElementById('is_sauce');
        const sauceSelected = sauceCheckbox.checked ? document.getElementById('sauce').value : '';

        // Dodaj informacje o sosie do formularza
        const inputSauceChecked = document.createElement('input');
        inputSauceChecked.type = 'hidden';
        inputSauceChecked.name = 'is_sauce';
        inputSauceChecked.value = sauceCheckbox.checked ? '1' : '0';
        form.appendChild(inputSauceChecked);

        if (sauceSelected) {
            const inputSauce = document.createElement('input');
            inputSauce.type = 'hidden';
            inputSauce.name = 'selected_sauce';
            inputSauce.value = sauceSelected;
            form.appendChild(inputSauce);
        }

        // Dodaj formularz do body dokumentu i wyślij
        document.body.appendChild(form);
        form.submit();
    });

});
        </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sauceCheckbox = document.getElementById('is_sauce');
        const sauceSelection = document.getElementById('sauce-selection');
        
        // Funkcja do ukrywania/pokazywania sosów
        function toggleSauceSelection() {
            if (sauceCheckbox.checked) {
                sauceSelection.removeAttribute('hidden');
            } else {
                sauceSelection.setAttribute('hidden', true);
            }
        }

        // Sprawdź stan początkowy przy ładowaniu strony
        toggleSauceSelection();
        
        // Dodaj nasłuchiwanie na kliknięcia checkboxa
        sauceCheckbox.addEventListener('change', toggleSauceSelection);
    });
</script>
        <?php require_once 'landings/footer.view.php' ?>