<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="" style="max-width: 100%; padding: 20px; ">
            <div class="alert alert-info text-center alert-dismissible"> <!-- danger, info, warning, success-->
                <h2>Dashboard</h2>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span></span>
            </div>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                        <h1 class="m-0"><!-- Dashboard --></h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->

            </div>
        </div>
    </main>
<?php require_once 'landings/footer.view.php' ?>