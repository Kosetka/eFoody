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
                <?php

                ?>
                <h1 class="h3 mb-3 fw-normal">Edycja miasta</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="c_name" class="col-sm-2 col-form-label">TAG:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_name" name="c_name" <?php echo "value = '" . $data['city']->c_name . "'" ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="c_fullname" class="col-sm-2 col-form-label">Nazwa miasta:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_fullname" name="c_fullname" <?php echo "value = '" . $data['city']->c_fullname . "'" ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="c_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="c_description" name="c_description" <?php echo "value = '" . $data['city']->c_description . "'" ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="c_active" class="col-sm-2 col-form-label">Miasto aktywne:</label>
                        <div class="col-sm-10">
                            <?php
                            $active = $data['city']->c_active;
                            $checked = "";
                            if ($active == 1) {
                                $checked = "checked";
                            } else {
                                $active = 0;
                                $checked = "";
                            }
                            ?>
                            <input type="checkbox" class="form-check-input" id="c_active" name="c_active" value="1"
                                <?php echo $checked; ?>>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Zapisz zmiany</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>