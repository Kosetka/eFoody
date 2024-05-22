<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<?php
    //show($data["fullproducts"]);
    $productsjson = json_encode($data["fullproducts"]);
?>
<script>
    var jsArray = <?php echo $productsjson; ?>;
    console.log(jsArray);
</script>
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
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
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
                                <button id="addProductButton" class="btn btn-primary">+</button>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nazwa produktu</th>
                                            <th>SKU</th>
                                            <th>Zdjęcie</th>
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
                            <div class="col-sm-10 offset-sm-2">
                                <button id="submitOrderButton" class="btn btn-success">Zapisz plan</button>
                            </div>
                        </div>
                    </div>
            
        </main>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const products = [
                    <?php
                    foreach($data["fullproducts"] as $product) {
                        echo "{ ID: ".$product['id'].", p_name: '".$product['p_name']."', sku: '".$product['sku']."', p_photo: '".$product['p_photo']."' },";
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
    }

    function addProduct() {
    const selectedProductId = parseInt(selectElement.value);
    const selectedProductIndex = products.findIndex(product => product.ID === selectedProductId);
    if (selectedProductIndex !== -1) {
        const selectedProduct = products[selectedProductIndex];

        // Add selected product to ordered products table
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${selectedProduct.ID}</td>
            <td>${selectedProduct.p_name}</td>
            <td>${selectedProduct.sku}</td>
            <td><img src="${selectedProduct.p_photo}" alt="${selectedProduct.p_name}" width="50"></td>
            <td><input type="number" class="form-control" value="1" min="1"></td>
            <td><button class="btn btn-danger remove-product">Usuń</button></td>
        `;
        orderedProductsTable.appendChild(tr);

        // Add event listener to the remove button
        tr.querySelector('.remove-product').addEventListener('click', function() {
            removeProduct(tr, selectedProduct);
        });

        // Remove selected product from products array
        products.splice(selectedProductIndex, 1);

        // Update the select element
        populateSelect();

        // Update the span text to the first available product name
        if (selectElement.options.length > 0) {
            selectElement.selectedIndex = 0;
            selectedSpan.textContent = selectElement.options[0].textContent;
        } else {
            selectedSpan.textContent = '';
        }
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

    // Add event listener to the add product button
    addProductButton.addEventListener('click', addProduct);
});
        </script>


        <?php require_once 'landings/footer.view.php' ?>