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
<?php
//show($data["cities"][$data["user_warehouse"]]);
?>
                <h1 class="h3 mb-3 fw-normal">Dodaj zabranie półproduktów ze stanu</h1>
                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="r_name" class="col-sm-2 col-form-label">Magazyn:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="r_name" name="r_name" value="<?php echo $data["cities"][$data["user_warehouse"]]["c_fullname"]." ".$data["cities"][$data["user_warehouse"]]["wh_fullname"];?>" readonly>
                            <input type="text" class="form-control" id="w_id" name="w_id" value="<?php echo $data["user_warehouse"];?>" hidden>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="z_date" class="col-sm-2 col-form-label">Data zabrania:</label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" id="z_date" name="z_date" value="<?php echo date("Y-m-d");?>">
                        </div>
                    </div>
                    <div class="form-group row m-3" hidden>
                        <label for="company_id" class="col-sm-2 col-form-label">Firma:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="company_id" name="company_id">
                                <option value='0' selected>Inna </option>
                                <?php
                                foreach ($data["companies"] as $company) {
                                    $full_name = $company->full_name . " | " . $company->address;
                                    $id = $company->id;
                                    echo "<option value='$id'>$full_name</option>";
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
                        <button id="submitOrderButton" class="btn btn-primary">Dodaj zakup</button>
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
            echo "{ ID: ".$product['id'].", p_name: '".$product['p_name']."', sku: '".$product['sku']."', p_photo: '".$product['p_photo']."', p_unit: '".$product['p_unit']."', subprice: '".$subprices_temp."' },";
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
                document.getElementById('select2-chosen-1').innerHTML = '';
            }
        }
    }

    function addProductToTable(product, quantity) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${product.ID}</td>
            <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="<?php echo IMG_ROOT;?>${product.p_photo}"></td>
            <td>${product.p_name}</td>
            <td>${product.sku}</td>
            <td>${product.p_unit}</td>
            <td><input type="number" name="amount_${product.ID}" class="form-control" value="${quantity}" min="0" step="0.01" required></td>
            <td><input type="number" name="cost_${product.ID}" class="form-control" value="0" min="0" step="0.01" hidden></td>
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
            const cost = row.cells[6].querySelector('input').value; // Koszt
            orderedProducts.push({ id: id, quantity: quantity, cost: cost });
        });

        // Utwórz formularz
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        // Dodaj pola do formularza dla każdego zamówionego produktu
        orderedProducts.forEach(product => {
            const inputAmount = document.createElement('input');
            inputAmount.type = 'hidden';
            inputAmount.name = `ordered_products[${product.id}][amount]`;
            inputAmount.value = product.quantity;
            form.appendChild(inputAmount);

            const inputCost = document.createElement('input');
            inputCost.type = 'hidden';
            inputCost.name = `ordered_products[${product.id}][cost]`;
            inputCost.value = product.cost;
            form.appendChild(inputCost);
        });

        // Dodaj dodatkowe pola do formularza
        const rName = document.getElementById('r_name').value;
        const wId = document.getElementById('w_id').value;
        const zDate = document.getElementById('z_date').value;
        const companyId = document.getElementById('company_id').value;

        const inputRName = document.createElement('input');
        inputRName.type = 'hidden';
        inputRName.name = 'r_name';
        inputRName.value = rName;
        form.appendChild(inputRName);

        const inputWId = document.createElement('input');
        inputWId.type = 'hidden';
        inputWId.name = 'w_id';
        inputWId.value = wId;
        form.appendChild(inputWId);

        const inputZDate = document.createElement('input');
        inputZDate.type = 'hidden';
        inputZDate.name = 'z_date';
        inputZDate.value = zDate;
        form.appendChild(inputZDate);

        const inputCompanyId = document.createElement('input');
        inputCompanyId.type = 'hidden';
        inputCompanyId.name = 'company_id';
        inputCompanyId.value = companyId;
        form.appendChild(inputCompanyId);

        // Dodaj pole "active" do formularza
        const inputActive = document.createElement('input');
        inputActive.type = 'hidden';
        inputActive.name = 'active';
        form.appendChild(inputActive);

        // Dodaj formularz do body dokumentu i wyślij
        document.body.appendChild(form);
        form.submit();
    });
});
        </script>
        <?php require_once 'landings/footer.view.php' ?>