<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
        <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
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

                <?php
                    //show($data);
                    //die;
                ?>

                <h1 class="h3 mb-3 fw-normal">Edycja produktu/SKU</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="sku" class="col-sm-2 col-form-label">SKU:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sku" name="sku" <?php echo "value = " . $data['product']->sku; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_name" class="col-sm-2 col-form-label">Pełna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_name" name="p_name" <?php echo "value = '" . $data['product']->p_name . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_description" name="p_description" <?php echo "value = '" . $data['product']->p_description . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="ean" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ean" name="ean" <?php echo "value = " . $data['product']->ean; ?>>
                        </div>
                    </div>
                    <?php /*<div class="form-group row m-3">
                        <label for="labels" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-10">
                            <a href="<?php echo ROOT."/assets/labels/wzor.lbx";?>" media="print">Etykieta</a>
                            <input type="text" class="form-control" id="labels" name="labels" <?php echo "value = " . $data['product']->labels; ?>>
                        </div>
                    </div>*/?>
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="p_unit">Jednostka:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="p_unit" name="p_unit">
                                <?php
                                $p_unit = $data['product']->p_unit;
                                ?>
                                <option value='Szt.' <?php if ($p_unit == 'Szt.')
                                    echo "selected"; ?>>Sztuka</option>
                                <option value='l' <?php if ($p_unit == 'l')
                                    echo "selected"; ?>>Litr</option>
                                <option value='kg' <?php if ($p_unit == 'kg')
                                    echo "selected"; ?>>Kilogram</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_photo" class="col-sm-2 col-form-label">Zdjęcie:</label>
                        <div class="col-sm-10">
                            <?php /*<input type="text" class="form-control" id="p_photo" name="p_photo" <?php echo "value = '" . $data['product']->p_photo . "'"; ?>>*/ ?>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="prod_type" class="col-sm-2 col-form-label">Typ produktu:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="prod_type" name="prod_type">
                                <?php
                                $prod_type = $data['product']->prod_type;
                                foreach (PRODUCTTYPENAMES as $key => $value) {
                                    if ($prod_type == $key)
                                        echo "<option value='$key' selected>$value</option>";
                                    else
                                        echo "<option value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="alergens" class="col-sm-2 col-form-label">Alergeny:</label>
                        <div class="col-sm-10">
                            <?php
                                foreach($data["alergens"] as $alergen) {
                                    $checked = "";
                                    if(!empty($data["p_alergen"]) ) {
                                        foreach($data["p_alergen"] as $a) {
                                            if ($a->a_id == $alergen->id) {
                                                $checked = "checked";
                                            }
                                        }
                                    }
                                    if (!empty($alergen->a_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' id='imageBox$alergen->id' src='" . IMG_ALERGENS_ROOT . "" . $alergen->a_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    echo '<input style="margin-top: 15px;" type="checkbox" class="form-check-input" id="alergens'.$alergen->id.'" name="alergens['.$alergen->id.']" value="1" '.$checked.'>['.$alergen->id.'] '. $photo .' '. $alergen->a_name.'</input></br>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Zapisz zmiany</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>