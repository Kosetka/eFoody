<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>


<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">

            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Wybierz datę do ulotki</h2>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="form-group row m-3">
                                <label for="date" class="col-sm-2 col-form-label">Data:</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="date" id="date" name="date" value="<?=$data["date"];?>" required>
                                </div>
                            </div>
                            
                            <button class="w-40 btn btn-lg btn-primary" type="submit">Pokaż ulotkę</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>