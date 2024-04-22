<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="container h-100 text-center">
            <div class="container-fluid px-4">
                <ol class="breadcrumb mb-4">
                    <li class=""></li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista miast</h2>
                    </div>
                    <div class="card-body">
                        <a type="button" class="btn btn-primary" href="<?= ROOT ?>/cities/new">Dodaj nowe miasto</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tag</th>
                                    <th scope="col">Pełna nazwa</th>
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
                                    foreach ($data as $city) {
                                        if ($city->c_active) {
                                            $active = "<td><span class='btn btn-success'>Aktywny</span></td>";
                                        } else {
                                            $active = "<td><span class='btn btn-danger'>Nieaktywny</span></td>";
                                        }
                                        echo "  <tr>
                                                    <th scope='row'>$city->id</th>
                                                    <td>$city->c_name</td>
                                                    <td>$city->c_fullname</td>
                                                    <td>$city->c_description</td>
                                                    $active
                                                    <td><a class='btn btn-info' href=' " . ROOT . "/cities/edit/$city->id'
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