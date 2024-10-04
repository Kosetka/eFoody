<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Wypłaty - miesiąc - rok</h2>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Imię i nazwisko</th>
                                    <th scope="col">Oddział</th>
                                    <th scope="col">Stanowisko</th>
                                    <th scope="col">Liczba godzin</th>
                                    <th scope="col">Stawka godzinowa</th>
                                    <th scope="col">Premie i kary</th>
                                    <th scope="col">Wypłata</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data) {
                                    echo "<tr><th colspan='8'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    foreach ($data["hours"] as $u_id => $u_val) {
                                        //show($data);
                                        echo "  <tr>";
                                        echo "<td></td>";
                                        echo "<th scope='row'>" . $data['users'][$u_id]->first_name . " " . $data['users'][$u_id]->last_name . "</th>";
                                        echo "<td>" . $data["cities"][$data['users'][$u_id]->u_warehouse]["c_fullname"] . " " . $data["cities"][$data['users'][$u_id]->u_warehouse]["wh_fullname"] . "</td>";
                                        echo "<td>" . $data["roles"][$data['users'][$u_id]->u_role]->role_name . "</td>";
                                        echo "<td>" . showInHours($u_val) . "</td>";

                                        if (isset($data["rates"][$u_id][0])) {
                                            echo "<td>" . $data["rates"][$u_id][0]->rate . " zł</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        echo "<td></td>";
                                        if (isset($data["pay"][$u_id])) {
                                            echo "<td>" . $data["pay"][$u_id] . " zł</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                        //echo "<td>" . getPayment($u_val, "22.50") . " zł</td>";
                                
                                        echo "</tr>";
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