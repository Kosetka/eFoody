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

                <h1 class="h3 mb-3 fw-normal">Dodawanie magazynu</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="wh_name" class="col-sm-2 col-form-label">TAG:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wh_name" name="wh_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="wh_fullname" class="col-sm-2 col-form-label">Nazwa magazynu:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wh_fullname" name="wh_fullname">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="wh_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wh_description" name="wh_description">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label class="col-sm-2 col-form-label" for="id_city">Wybierz miasto:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="id_city" name="id_city">
                                <?php
                                foreach ($data["cities"] as $city) {
                                    $full_tag = $city->c_name;
                                    $full_name = $city->c_fullname;
                                    $id = $city->id;
                                    echo "<option value='$id'>$full_tag : $full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="w_active" class="col-sm-2 col-form-label">Magazyn aktywny:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="w_active" name="w_active" value="1"
                                checked>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Dodaj magazyn</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>