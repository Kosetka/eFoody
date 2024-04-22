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

                <h1 class="h3 mb-3 fw-normal">Dodaj nową recepturę</h1>
                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="r_name" class="col-sm-2 col-form-label">Nazwa receptury:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="r_name" name="r_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_id" class="col-sm-2 col-form-label">Produkt:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="p_id" name="p_id">
                                <?php

                                foreach ($data["products"] as $product) {
                                    $full_name = $product->p_name;
                                    $id = $product->id;
                                    echo "<option value='$id'>$full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="active" class="col-sm-2 col-form-label">Receptura aktywna:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" checked>
                        </div>
                    </div>


                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit" name="recipeEdit" value="1">Zapisz</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>