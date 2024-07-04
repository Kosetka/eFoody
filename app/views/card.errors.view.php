<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista błędów czytnika kart magnetycznych</h2>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nazwa karty</th>
                                    <th scope="col">Budynek</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Rodzaj</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data["last_errors"]) {
                                    echo "<tr><th colspan='4'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    foreach ($data["last_errors"] as $err) {
                                        echo "  <tr>
                                                    <th scope='row'>$err->card_name</th>";
                                        if($err->w_id == 0) {
                                            echo "<td>App</td>";
                                        } else {
                                            $city_name = $data["city"][$err->w_id]->c_fullname . " : " . $data["city"][$err->w_id]->wh_fullname;
                                            echo "<td>$city_name</td>";
                                        }
                                        echo "<td>$err->date</td>
                                                <td>".ATTENDANCEERRORS[$err->error]."</td>
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