<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <?php
                if($data["edit"] === True) {
                    $edit = True;
                    $head2 = "Edytowanie Fingerfood";
                    $button2 = "Zapisz zmiany";
                    $blocked = " disabled";
                } else {
                    $head2 = "Dodawanie nowego Fingerfood";
                    $button2 = "Dodaj Fingerfood";
                    $edit = False;
                    $blocked = "";
                }
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class=""><?= $head2;?></h2>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="text-start">
                        <div class="form-group row m-3">
                            <label for="f_name" class="col-sm-2 col-form-label">Nazwa:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="f_name" name="f_name" required $blocked <?php if($edit) {echo " value='".$data["fingerfoods"]->f_name."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="f_description" class="col-sm-2 col-form-label">Opis:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="f_description" name="f_description" $blocked <?php if($edit) {echo " value='".$data["fingerfoods"]->f_description."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="f_cost" class="col-sm-2 col-form-label">Cena sprzedaży:</label>
                            <div class="col-sm-10">
                            <input type="number" min="0" step="0.01" class="form-control" id="f_cost" required name="f_cost" <?php if($edit) {echo " value='".$data["fingerfoods"]->f_cost."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="f_photo" class="col-sm-2 col-form-label">Zdjęcie:</label>
                            <div class="col-sm-10">
                                <label for="fileInput">Wybierz zdjęcie (JPG, PNG, JPEG, WebP)</label>
                                <input type="file" class="form-control-file" id="fileInput" name="fileInput" accept=".jpg, .jpeg, .png, .webp">
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="fuel_type" class="col-sm-2 col-form-label">Kategoria:</label>
                            <div class="col-sm-10">
            <?php
                foreach ($data["fingerfoodscategory"] as $f_type_key => $f_type_val) {
                    $checked = "";
                    if($edit) {
                        if ($data["fingerfoods"]->f_category == $f_type_val->id) {
                            $checked = "checked";
                        }
                    } else {
                        if(isset($data["id"])) {
                            if ($data["id"] == $f_type_val->id) {
                                $checked = "checked";
                            }
                        }
                    }
                    echo "  <div class='form-check'>
                                <input class='form-check-input' type='radio' name='f_category' id='f_category$f_type_val->id' value='$f_type_val->id' $checked>
                                <label class='form-check-label' for='f_category$f_type_val->id'>
                                $f_type_val->fc_name
                                </label>
                            </div>";
                }
            ?>
                        
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="f_active" class="col-sm-2 col-form-label">Fingerfood aktywny:</label>
                            <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="f_active" name="f_active" value="1" <?php if($edit) {if($data["fingerfoods"]->f_active == 1) {echo " checked"; }}?>>
                            </div>
                        </div>
                        </div>
                        
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="newadd"><?=$button2;?></button>
                    </form>
                </div>
            </div>
    </main>
    <?php require_once 'landings/footer.view.php' ?>