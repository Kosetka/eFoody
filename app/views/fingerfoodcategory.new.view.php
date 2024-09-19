<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <?php
                if($data["edit"] === True) {
                    $edit = True;
                    $head2 = "Edytowanie kategorii";
                    $button2 = "Zapisz zmiany";
                    $blocked = " disabled";
                } else {
                    $head2 = "Dodawanie nowej kategorii";
                    $button2 = "Dodaj kategorię";
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
                            <label for="fc_name" class="col-sm-2 col-form-label">Nazwa kategorii:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="fc_name" name="fc_name" required $blocked <?php if($edit) {echo " value='".$data["fingerfoodcategory"]->fc_name."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="fc_description" class="col-sm-2 col-form-label">Opis kategorii:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="fc_description" name="fc_description" required $blocked <?php if($edit) {echo " value='".$data["fingerfoodcategory"]->fc_description."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="fc_photo_1" class="col-sm-2 col-form-label">Zdjęcie 1:</label>
                            <div class="col-sm-10">
                                <label for="fileInput_1">Wybierz zdjęcie (JPG, PNG, JPEG, WebP)</label>
                                <input type="file" class="form-control-file" id="fileInput_1" name="fileInput_1" accept=".jpg, .jpeg, .png, .webp">
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="fc_photo_1" class="col-sm-2 col-form-label">Zdjęcie 2:</label>
                            <div class="col-sm-10">
                                <label for="fileInput_2">Wybierz zdjęcie (JPG, PNG, JPEG, WebP)</label>
                                <input type="file" class="form-control-file" id="fileInput_2" name="fileInput_2" accept=".jpg, .jpeg, .png, .webp">
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="fc_photo_1" class="col-sm-2 col-form-label">Zdjęcie 3:</label>
                            <div class="col-sm-10">
                                <label for="fileInput_3">Wybierz zdjęcie (JPG, PNG, JPEG, WebP)</label>
                                <input type="file" class="form-control-file" id="fileInput_3" name="fileInput_3" accept=".jpg, .jpeg, .png, .webp">
                            </div>
                        </div>


                        <div class="form-group row m-3">
                            <label for="f_active" class="col-sm-2 col-form-label">Kategoria aktywna:</label>
                            <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="f_active" name="f_active" value="1" <?php if($edit) {if($data["fingerfoodcategory"]->f_active == 1) {echo " checked"; }}?>>
                            </div>
                        </div>
                        </div>
                        
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="newadd"><?=$button2;?></button>
                    </form>
                </div>
            </div>
    </main>
    <?php require_once 'landings/footer.view.php' ?>