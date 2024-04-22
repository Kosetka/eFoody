<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post">

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

                <h1 class="h3 mb-3 fw-normal">Edycja magazynu</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="wh_name" class="col-sm-2 col-form-label">TAG:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wh_name" name="wh_name" <?php echo "value = '" . $data['warehouse']->wh_name . "'" ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="wh_fullname" class="col-sm-2 col-form-label">Nazwa magazynu:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wh_fullname" name="wh_fullname" <?php echo "value = '" . $data['warehouse']->wh_fullname . "'" ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="wh_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wh_description" name="wh_description" <?php echo "value = '" . $data['warehouse']->wh_description . "'" ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="id_city">Wybierz miasto:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_city" name="id_city">
                                <?php
                                foreach ($data["cities"] as $city) {
                                    $checked = "";
                                    if ($data["warehouse"]->id_city == $city->id) {
                                        $checked = "selected";
                                    } else {
                                        $checked = "";
                                    }
                                    $full_tag = $city->c_name;
                                    $full_name = $city->c_fullname;
                                    $id = $city->id;
                                    echo "<option value='$id' $checked>$full_tag : $full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="w_active" class="col-sm-2 col-form-label">Magazyn aktywny:</label>
                        <div class="col-sm-10">
                            <?php
                            $active = $data['warehouse']->w_active;
                            $checked = "";
                            if ($active == 1) {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                            ?>
                            <input type="checkbox" class="form-check-input" id="w_active" name="w_active" value="1"
                                <?php echo $checked; ?>>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Edytuj magazyn</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>