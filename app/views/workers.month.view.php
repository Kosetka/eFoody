<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Lista godzin pracowników</h2>
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
                                                echo '<option value="' . $month . '" ' . $sel . '>' . date("F", mktime(0, 0, 0, $month, 1)) . '</option>';
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
                if($data["show_table"] == true) {
            ?>
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">
                            <?php 
                                echo POLISHMONTHS[$data["month"]] . " - " . $data["year"];
                            ?>
                        </h2>
                    </div>
                    <div class="card-body">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">Pracownik</th>
                                <th scope="col">Oddział</th>
                                <th scope="col">Stanowisko</th>
                                <th scope="col">Suma godzin</th>
                                <th scope="col">Wypłata</th>
                                <?php
                                    $year = $data["year"];
                                    $month = $data["month"];
                                    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-01");
                                    $daysInMonth = $date->format('t');
                                    for ($day = 1; $day <= $daysInMonth; $day++) {
                                        $date->setDate($year, $month, $day);
                                        if(isset($data["holidays"][$date->format('Y-m-d')])) {
                                            echo "<td scope='col'style='background-color: #ee8866;'>".$date->format('Y-m-d')."</td>";
                                        } else {
                                            echo "<th scope='col'>".$date->format('Y-m-d')."</td>";
                                        }
                                        
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $hours = [];
                                $daily = [];
                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    $date->setDate($year, $month, $day);
                                    if(!empty($data["users"])) {
                                        foreach($data["users"] as $user) {
                                            if(!isset($hours[$user->u_id])) {
                                                $hours[$user->u_id] = 0;
                                            } 
                                            if(isset($data["accepted"][$date->format('Y-m-d')][$user->u_id])) {
                                                $hours[$user->u_id] += $data["accepted"][$date->format('Y-m-d')][$user->u_id]->accept_time;
                                            }
                                            
    
                                            if(!isset($daily[$date->format('Y-m-d')])) {
                                                $daily[$date->format('Y-m-d')] = 0;
                                            } 
                                            if(isset($data["accepted"][$date->format('Y-m-d')][$user->u_id])) {
                                                $daily[$date->format('Y-m-d')] += $data["accepted"][$date->format('Y-m-d')][$user->u_id]->accept_time;
                                            }
                                            
                                        }
                                    }
                                }
                                if(!empty($data["users"])) {
                                    foreach($data["users"] as $user) {
                                        echo '<tr>';
                                        $active_user = "";
                                        if($user->active == 0) {
                                            $active_user = " style='background: #ffbfaa'";
                                        }
                                        echo '<th '.$active_user.'>'.$user->first_name .' '.$user->last_name.' '.$user->u_id.'</th>';
                                        echo '<th>'.$data["cities"][$user->u_warehouse]["c_fullname"].' -> '.$data["cities"][$user->u_warehouse]["wh_fullname"].'</th>';
                                        echo '<th>'.$data["roles"][$user->u_role]->role_name.'</th>';
                                        echo '<td>'.showInHours($hours[$user->u_id]).'</td>';
                                        echo '<td></td>'; //wypłata
                                        
                                        for ($day = 1; $day <= $daysInMonth; $day++) {
                                            $date->setDate($year, $month, $day);
                                            $seconds = "";
                                            if(!empty($data["accepted"][$date->format('Y-m-d')][$user->u_id]->accept_time)) {
                                                $seconds = showInHours($data["accepted"][$date->format('Y-m-d')][$user->u_id]->accept_time);
                                            }

                                            if($user->date_from > $date->format('Y-m-d')) {
                                                echo "<td scope='col'style='background-color: #78EEFF;'></td>";
                                            } elseif($user->date_to != NULL && $user->date_to <= $date->format('Y-m-d')) {
                                                echo "<td scope='col'style='background-color: #0097AD;'></td>";
                                            } else {
                                                if(isset($data["holidays"][$date->format('Y-m-d')])) { //pracuje i dzień wolny
                                                    echo "<td scope='col'style='background-color: #ffbfaa;'>".$seconds."</td>";
                                                } else { //pracuje w normalny dzień
                                                    echo "<td scope='col'>".$seconds."</td>";
                                                }
                                            }

                                        }
                                        echo '</tr>';
                                    }
                                }
                                if(!empty($data["users"])) {
                            ?>
                            <tr>
                                <th colspan="3" scope="col">TOTAL</th>
                                <th scope="col"><?php echo showInHours(array_sum($daily));?></th>
                                <th scope="col"></th><!-- wypłata -->
                                <?php
                                    $year = $data["year"];
                                    $month = $data["month"];
                                    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-01");
                                    $daysInMonth = $date->format('t');
                                    for ($day = 1; $day <= $daysInMonth; $day++) {
                                        $date->setDate($year, $month, $day);
                                        if($daily[$date->format('Y-m-d')] == "0") {
                                            echo "<th scope='col'></td>"; //tutaj zmienić na zaakceptowane godziny
                                        } else {
                                            echo "<th scope='col'>".showInHours($daily[$date->format('Y-m-d')])."</td>"; //tutaj zmienić na zaakceptowane godziny
                                        }
                                    }
                                ?>
                            </tr>
                            <?php
                                } else {
                                    echo "<tr><td>Brak pracowników w podamym miesiącu.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php //show($daily);?>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        


<?php
//show($data);
?>
        </main>
        <?php require_once 'landings/footer.view.php' ?>