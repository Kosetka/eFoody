<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<?php
    //show($data["fullproducts"]);
    $productsjson = json_encode($data["fullproducts"]);
?>
<script>
    var jsArray = <?php echo $productsjson; ?>;
</script>
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
                <span>Po dodaniu planu produkcji lub wprowadzeniu zmian, pamiętaj o ich zapisaniu!</span>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                    $toBlock = "";
                    $toBlockButton = "";
                    if($date<=date("Y-m-d")) {
                        $toBlock = " disabled";
                        $toBlockButton = " hidden";
                    }
                ?>
                    <h2 class="">Plan produkcji na <?php echo $date;?></h2>
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
                            <label for="p_id" class="col-sm-2 col-form-label">Produkt:</label>
                            <div class="col-sm-3" style="display: inline;">
                                <select style="width: 80%" id="c_id" name="p_id" placeholder="Wybierz produkt...">
                                </select>
                                <button id="addProductButton" <?=$toBlockButton; ?> class="btn btn-success">+</button>
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
                                            <th>Planowana ilość</th>
                                            <th>Akcja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Zamówione produkty będą tutaj dodawane -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <button id="submitOrderButton" <?=$toBlockButton; ?> class="btn btn-primary">Zapisz plan</button>
                            </div>
                        </div>
                    </div>
            
        </main>

        <script>


//OKKKKKKK
document.addEventListener("DOMContentLoaded", function() {
    const products = [
        <?php
        foreach($data["fullproducts"] as $product) {
            echo "{ ID: ".$product['id'].", p_name: '".$product['p_name']."', sku: '".$product['sku']."', p_photo: '".$product['p_photo']."' },";
        }
        ?>
    ];
    const initialOrder = [
        <?php
        if(isset($data["planned"])) {
            foreach($data["planned"] as $product) {
                echo "{ id: ".$product['p_id'].", amount: ".$product['amount']." },";
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
        tr.innerHTML = `
            <td>${product.ID}</td>
            <td><img width="40" height="40" class="obrazek" id="imageBox${product.ID}" src="<?php echo IMG_ROOT;?>${product.p_photo}"></td>
            <td>${product.p_name}</td>
            <td>${product.sku}</td>
            <td><input <?=$toBlock;?> type="number" class="form-control" value="${quantity}" min="1"></td>
            <td><button <?=$toBlockButton;?> class="btn btn-danger remove-product">Usuń</button></td>
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
            const quantity = row.cells[4].querySelector('input').value; // Planowana ilość
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

        // Dodaj formularz do body dokumentu i wyślij
        document.body.appendChild(form);
        form.submit();
    });
});
        </script>


        <?php require_once 'landings/footer.view.php' ?>