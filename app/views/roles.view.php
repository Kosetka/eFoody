<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista ról i uprawnień</h2>
                    </div>
                    <div class="card-body">
                        <a type="button" class="btn btn-primary" href="<?= ROOT ?>/roles/new">Dodaj nową rolę</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Opis</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data) {
                                    echo "<tr><th colspan='6'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    foreach ($data["roles"] as $role) {
                                        if ($role->r_active) {
                                            $active = "<td><span class='btn btn-success'>Aktywny</span></td>";
                                        } else {
                                            $active = "<td><span class='btn btn-danger'>Nieaktywny</span></td>";
                                        }
                                        echo "  <tr>
                                                    <th scope='row'>$role->id</th>
                                                    <td>$role->role_name</td>
                                                    <td>$role->role_description</td>
                                                    $active
                                                    <td><a class='btn btn-info' href=' " . ROOT . "/roles/edit/$role->id'
                                                            role='button'>Edytuj</a></td>
                                                </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>




        </main>
        <?php require_once 'landings/footer.view.php' ?>