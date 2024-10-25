<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">

        <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Podgląd wypłat</h2>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="form-group row m-3">
                                <label for="month" class="col-sm-2 col-form-label">Miesiąc:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="month" name="month" required>
                                        <?php
                                            for ($month = 1; $month <= 12; $month++) {
                                                $sel = "";
                                                if ($data["month"] == $month) {
                                                    $sel = "selected";
                                                }
                                                echo '<option value="' . $month . '" ' . $sel . '>' . getPolishMonthName($month) . '</option>';
                                            }
                                            echo '</select>';
                                        ?>
                                </div>
                            </div>

                            <div class="form-group row m-3">
                                <label for="year" class="col-sm-2 col-form-label">Rok:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="year" name="year" required>
                                        <?php 
                                            for ($year = 2024; $year <= 2025; $year++) {
                                                $sel = "";
                                                if ($data["year"] == $year) {
                                                    $sel = "selected";
                                                }
                                                echo '<option value="' . $year . '" ' . $sel . '>' . $year . '</option>';
                                            }
                                            echo '</select>';
                                        ?>
                                </div>
                            </div>
                            <button class="w-40 btn btn-lg btn-primary" type="submit" name="search" value=1>Pokaż dane</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
                if($data["show_table"]) {
            ?>

            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Wypłaty - <?=POLISHMONTHS[$data["month"]];?> - <?=$data["year"];?></h2>
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
                                    if(isset($data["hours"])) {
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
                                            $premia = 0;
                                            if(isset($data["bonuses"][$u_id]["bonus"])) {
                                                $premia += $data["bonuses"][$u_id]["bonus"];
                                            }
                                            if(isset($data["bonuses"][$u_id]["penalty"])) {
                                                $premia -= $data["bonuses"][$u_id]["penalty"];
                                            }
                                            echo "<td>". $premia ." zł</td>";
                                            if (isset($data["pay"][$u_id])) {
                                                if($premia > 0) {
                                                    echo "<td title='Wypłata godzinowa: ".$data["pay"][$u_id]." zł
Premia: ".$premia." zł'>" . $data["pay"][$u_id] + $premia . " zł</td>";
                                                } else {
                                                    echo "<td>" . $data["pay"][$u_id] . " zł</td>";
                                                }
                                            } else {
                                                echo "<td></td>";
                                            }
                                            //echo "<td>" . getPayment($u_val, "22.50") . " zł</td>";
                                    
                                            echo "</tr>";
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php
                }
            ?>



        </main>
        <?php require_once 'landings/footer.view.php' ?>