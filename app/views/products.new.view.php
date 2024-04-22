<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post" enctype="multipart/form-data">

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

                <h1 class="h3 mb-3 fw-normal">Dodawanie produktu/SKU</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="sku" class="col-sm-2 col-form-label">SKU:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sku" name="sku">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_name" class="col-sm-2 col-form-label">Pełna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_name" name="p_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_description" name="p_description">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="ean" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ean" name="ean">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="p_unit">Jednostka:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="p_unit" name="p_unit">
                                <option value='Szt.'>Sztuka</option>
                                <option value='l'>Litr</option>
                                <option value='kg'>Kilogram</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_photo" class="col-sm-2 col-form-label">Zdjęcie:</label>
                        <div class="col-sm-10">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <?php //<input type="text" class="form-control" id="p_photo" name="p_photo">  ?>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="prod_type" class="col-sm-2 col-form-label">Typ produktu:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="prod_type" name="prod_type">
                                <?php
                                foreach (PRODUCTTYPENAMES as $key => $value) {
                                    echo "<option value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Dodaj produkt/SKU</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>