<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista kosztów stałych</h2>
                    </div>
                    <div class="card-body">
                        <a type="button" class="btn btn-primary" href="<?= ROOT ?>/fixedcosts/new">Dodaj nowy koszt</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Typ kosztu</th>
                                    <th scope="col">Kwota</th>
                                    <th scope="col">Kategoria</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Okres obowiązywania</th>
                                    <th scope="col">Akcje</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data) {
                                    echo "<tr><th colspan='8'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    if(!empty($data["costs"])) {
                                        foreach ($data["costs"] as $cost) {
                                            if ($cost->active == 1) {
                                                $active = "<td><span class='btn btn-success'>Aktywny</span></td>";
                                            } else if ($cost->active == 2) {
                                                $active = "<td><span class='btn btn-info'>Wstrzymany</span></td>";
                                            } else {
                                                $active = "<td><span class='btn btn-danger'>Nieaktywny</span></td>";
                                            }
    
                                            if( $cost->type == 5) {
                                                $date = $cost->date;
                                            } else {
                                                $date = $cost->date_from ." - ".$cost->date_to;
                                            }
                                            echo "  <tr>
                                                        <th scope='row'>$cost->id</th>
                                                        <td>$cost->name</td>
                                                        <td>".COSTTYPES[$cost->type]."</td>
                                                        <td>$cost->price zł</td>
                                                        <td>".COSTCATEGORIES[$cost->category]."</td>
                                                        $active
                                                        <td>$date</td>
                                                        <td><a class='btn btn-info' href=' " . ROOT . "/fixedcosts/edit/$cost->id'
                                                                role='button'>Edytuj</a></td>
                                                    </tr>";
                                        }
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