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
                    <?php
    $sk = "";
    $tt = 1;
    if(isset($data["target_sku"])) {
        $sk = $data["target_sku"];
    }
    if(isset($data["target_type"])) {
        $tt = $data["target_type"];
    }
                    ?>
                <h1 class="h3 mb-3 fw-normal">Dodawanie produktu/SKU</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="sku" class="col-sm-2 col-form-label">SKU:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="sku" name="sku" <?php echo "value='$sk'";?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_name" class="col-sm-2 col-form-label">Pełna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_name" name="p_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="friendly_name" class="col-sm-2 col-form-label">Przyjazna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="friendly_name" name="friendly_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="first_letter" class="col-sm-2 col-form-label">Skrót jednoznakowy:</label>
                        <div class="col-sm-10">
                            <input type="text" maxlength="2" style="text-transform: uppercase;" class="form-control" id="first_letter" name="first_letter" >
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="vege" class="col-sm-2 col-form-label">VEGE:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="vege" name="vege" value="0">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="upsel" class="col-sm-2 col-form-label">Możliwy upsel:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="upsel" name="upsel" value="0">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <legend class="col-sm-2 col-form-label ">Data ważności do:</legend>
                        <div class="col-sm-10">
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date0' value='0' checked>
                                <label class='form-check-label' for='show_prod_date0'>Nie pokazuj</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date1' value='1'>
                                <label class='form-check-label' for='show_prod_date1'>1 dzień</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date2' value='2'>
                                <label class='form-check-label' for='show_prod_date2'>2 dni</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='show_prod_date' id='show_prod_date3' value='3'>
                                <label class='form-check-label' for='show_prod_date3'>3 dni</label>
                            </div>
                        </div>
                    </div>



                    <div class="form-group row m-3" hidden>
                        <label for="p_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="p_description" name="p_description">
                        </div>
                    </div>
                    <div class="form-group row m-3" hidden>
                        <label for="ean" class="col-sm-2 col-form-label">EAN:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ean" name="ean">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="kcal" class="col-sm-2 col-form-label">Kalorie:</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" class="form-control" id="kcal" name="kcal" required>
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
                                    $selected = "";
                                    if($key == 0 && $tt == 2) {
                                        $selected = "selected";
                                    }
                                    if($key == 1 && $tt == 1) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='$key' $selected>$value</option>";
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
                                    if (!empty($alergen->a_photo)) {
                                        $photo = "<img width='40' height='40' class='obrazek' id='imageBox$alergen->id' src='" . IMG_ALERGENS_ROOT . "" . $alergen->a_photo . "'>";
                                    } else {
                                        $photo = "";
                                    }
                                    echo '<input style="margin-top: 15px;" type="checkbox" class="form-check-input" id="alergens'.$alergen->id.'" name="alergens['.$alergen->id.']" value="1">['.$alergen->id.'] '. $photo .' '. $alergen->a_name.'</input></br>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Dodaj produkt/SKU</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>