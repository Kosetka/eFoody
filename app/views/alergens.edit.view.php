<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post" enctype="multipart/form-data">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?= $success ?>
                    </div>
                <?php endif; ?>
                <h1 class="h3 mb-3 fw-normal">Edycja alergenów</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="a_name" class="col-sm-2 col-form-label">Pełna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="a_name" name="a_name" <?php echo "value = '" . $data['alergen']->a_name . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_description" class="col-sm-2 col-form-label">Opis:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="a_description" name="a_description" <?php echo "value = '" . $data['alergen']->a_description . "'"; ?>>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="p_photo" class="col-sm-2 col-form-label">Zdjęcie:</label>
                        <div class="col-sm-10">
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Zapisz zmiany</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>