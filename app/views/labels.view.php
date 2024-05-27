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
                        <?= implode("<br>", $success) ?>
                    </div>
                <?php endif; ?>
                <h1 class="h1 mb-3 fw-normal">Dodaj etykiety</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="fileToUpload" class="col-sm-2 col-form-label">Etykiety:</label>
                        <div class="col-sm-10">
                            <input type="file" name="fileToUpload[]" id="fileToUpload" multiple accept=".lbx">
                        </div>
                    </div>
                </div>
                <button class="w-40 btn btn-lg btn-primary" type="submit">Wyślij</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>