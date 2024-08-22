<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
@keyframes miganie {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.25;
    }
}
.status {
    position: relative;
    padding-left: 25px; 
    margin-bottom: 5px;
    display: inline-block;
}

.status::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border-radius: 50%; 
    animation: miganie 1.4s infinite; 
}
.status-Online::before {
    background-color: green; 
}
.status-Offline::before {
    background-color: red; 
}
</style>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Status czytników kart</h2>
                        <h5>Stan na: <?= $data["now"];?></h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Budynek</th>
                                    <th scope="col">Data aktualizacji</th>
                                    <th scope="col">Ostatni stan offline</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data["city"]) {
                                    echo "<tr><th colspan='4'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    foreach ($data["city"] as $err) {
                                        $status_now = "";
                                        $last_date = "-";
                                        
                                        if(isset($data["status"][$err->id])) {
                                            $last_date = $data["status"][$err->id][0]->date;
                                        }
                                        $last_offline = "-";
                                        if(isset($data["breaks"][$err->id])) {
                                            $last_offline = "<b>Od:</b> ".end($data["breaks"][$err->id])->break_start . " <br><b>Do:</b> ".end($data["breaks"][$err->id])->break_end;
                                        }
                                        $dif_sec = "-";
                                        if($last_date <> "-") {
                                            $dif_sec = abs(strtotime($data["now"]) - strtotime($last_date));
                                            if($dif_sec > 70) {
                                                $last_offline = "Aktualnie offline";
                                                $status_now = "Offline";
                                            } else {
                                                $status_now = "Online";
                                            }
                                        }

                                        echo "  <tr>";
                                        $city_name = $err->c_fullname . " : " . $err->wh_fullname;
                                        echo "<td><span class='status status-$status_now'></span></td>";
                                        echo "<td>$city_name</td>";
                                        echo "<td>$last_date</td>";
                                        echo "<td>$last_offline</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista stanów offline</h2>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Budynek</th>
                                    <th scope="col">Data od</th>
                                    <th scope="col">Data do</th>
                                    <th scope="col">Czas trwania</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!$data["city"]) {
                                    echo "<tr><th colspan='3'>Brak danych do wyświetlenia</th></tr>";
                                } else {
                                    foreach ($data["breaks"] as $err_key => $err_val) {
                                        $city_name = $data["city"][$err_key]->c_fullname . " : " . $data["city"][$err_key]->wh_fullname;
                                        foreach($err_val as $break) {
                                            echo "  <tr>";
                                            echo "<td>$city_name</td>";
                                            echo "<td>$break->break_start</td>";
                                            echo "<td>$break->break_end</td>";
                                            $dif_sec = abs(strtotime($break->break_end) - strtotime($break->break_start));
                                            echo "<td>".gmdate("H:i:s", $dif_sec)."</td>";
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


        </main>
        <?php require_once 'landings/footer.view.php' ?>