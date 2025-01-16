<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post" >
                <h1 class="h3 mb-3 fw-normal">Edycja SKU</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="type" class="col-sm-2 col-form-label">Typ SKU:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="type" name="type" <?php echo "value = " . $data['sku']->type; ?> disabled>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="name" class="col-sm-2 col-form-label">Pełna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" <?php echo "value = '" . $data['sku']->name . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="parent" class="col-sm-2 col-form-label">Nadkategoria:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="parent" name="parent" <?php echo "value = '" . $data['sku']->parent . "'"; ?> disabled>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="priceshops" class="col-sm-2 col-form-label">Cena dla sklepów (zmienna):</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="0.01" class="form-control" id="priceshops" name="priceshops" <?php echo "value = '" . $data['sku']->priceshops . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="pricefixed" class="col-sm-2 col-form-label">Cena dla sklepów (stała):</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" step="0.01" class="form-control" id="pricefixed" name="pricefixed" <?php echo "value = '" . $data['sku']->pricefixed . "'"; ?>>
                        </div>
                    </div>

                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Zapisz zmiany</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>