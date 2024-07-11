<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
    .calendar-holiday {
        background-color: lightcoral !important;
        color: white;
    }
</style>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Koszty i przychody</h2>
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
                show($data);
                $rate_log_error = [];
                $rate_log = [];
                if($data["show_table"] == true) {
                    $working_days = $data["working_days"];
                    
            ?>
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">
                            <?php 
                                echo POLISHMONTHS[$data["month"]] . " - " . $data["year"] ." : Dni robocze: ".$working_days;
                            ?>
                        </h2>
                    </div>
                    <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <?php
                                    $total_cost_fixed = 0;
                                    foreach($data["costs"] as $cost) {
                                        if($cost->type == 3) {
                                            $total_cost_fixed += $cost->price;
                                        } elseif($cost->type == 2) {
                                            $total_cost_fixed += $cost->price * (cal_days_in_month(CAL_GREGORIAN, $data["month"], $data["year"]) / 7);
                                        } elseif($cost->type == 1) {
                                            $total_cost_fixed += $cost->price * cal_days_in_month(CAL_GREGORIAN, $data["month"], $data["year"]);
                                        } elseif($cost->type == 4) {
                                            $total_cost_fixed += $cost->price / 12;
                                        }
                                    }

                                    $total_cost_workers = 0;
                                    $total_cost_workers_fixed = 0;
                                    $days = [];
                                    foreach($data["accepted"] as $accept_days_key => $accept_days) {
                                        if(!isset($days[$accept_days_key])) {
                                            $days[$accept_days_key] = 0;
                                        }
                                        foreach($accept_days as $accept_user) {
                                            //dane użytkownika
                                            $temp_time = $accept_user->accept_time / 60 / 60; //w godzinach czas pracy
                                            $temp_u_id = $accept_user->u_id;
                                            $add_log = true;
                                            if(isset($data["rates"][$temp_u_id])) {
                                                $fix_rate = false;
                                                foreach($data["rates"][$temp_u_id] as $t_rate) {
                                                    if ($fix_rate == true) {
                                                        break;
                                                    }
                                                    //stawka danego użytkownika
                                                    if($accept_days_key >= $t_rate->date_from && $t_rate->date_to == NULL) {
                                                        if($t_rate->type == 2) {
                                                            $total_cost_workers += $t_rate->rate * $temp_time;
                                                            $days[$accept_days_key] += $t_rate->rate * $temp_time;
                                                            $add_log = false;
                                                            $rate_log[] = "Dzień: ".$accept_days_key."; User ID: ".$temp_u_id."; Stawka: ".$t_rate->rate."; Czas pracy: ".$temp_time."; Wypłata: ".$days[$accept_days_key];
                                                        }

                                                    } elseif($accept_days_key >= $t_rate->date_from && $accept_days_key <= $t_rate->date_to) {
                                                        if($t_rate->type == 2) {
                                                            $total_cost_workers += $t_rate->rate * $temp_time;
                                                            $days[$accept_days_key] += $t_rate->rate * $temp_time;
                                                            $add_log = false;
                                                            $rate_log[] = "Dzień: ".$accept_days_key."; User ID: ".$temp_u_id."; Stawka: ".$t_rate->rate."; Czas pracy: ".$temp_time."; Wypłata: ".$days[$accept_days_key];
                                                        }
                                                    }
                                                    if($t_rate->type == 1) {
                                                        // stała stawka
                                                        $fix_rate = true;
                                                        $total_cost_workers_fixed += $t_rate->rate;
                                                        $add_log = false;
                                                        $rate_log[] = "User ID: ".$temp_u_id."; Stawka: ".$t_rate->rate."; Stała kwota wypłaty";
                                                        
                                                    }
                                                }
                                                if($add_log == true) {
                                                    $rate_log_error[] = "Dzień: ".$accept_days_key."; User ID: ".$temp_u_id."; Brak stawki.";
                                                }
                                            } else {
                                                $rate_log_error[] = "User ID: ".$temp_u_id."; Brak stawek godzinowych.";
                                            }
                                            
                                        }
                                    }

                                ?>
                                <th scope="col">Dzień tygodnia</th>
                                <th scope="col">Koszty produktów</th>
                                <th scope="col">Koszty stałe</th>
                                <th scope="col">Koszty pracowników</th>
                                <th scope="col">Dodatkowe koszty wyliczone (naklejki)</th>
                                <th scope="col">Sprzedane produkty</th>
                                <th scope="col">Rentowność</th>
                                <?php
                                    $year = $data["year"];
                                    $month = $data["month"];
                                    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-01");
                                    $daysInMonth = $date->format('t');
                                ?>
                            </tr>
                            <tr>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
                                <th scope="col"><?=roundUp($total_cost_fixed);?> zł</th>
                                <th scope="col"><?=roundUp($total_cost_workers + $total_cost_workers_fixed);?> zł</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    $holiday = "";
                                    $date->setDate($year, $month, $day);
                                    foreach($data["holidays"] as $holi) {
                                        if($holi->date == $date->format('Y-m-d')) {
                                            $holiday = ' class="calendar-holiday"';
                                        }
                                    }
                                    echo '<tr '.$holiday.'>';
                                    
                                    echo "<td>".$date->format('Y-m-d')."</td>";
                                    if($holiday == "") {
                                        echo '<td></td>';
                                        echo '<td>'.roundUp(showPrice($total_cost_fixed, $working_days)).' zł</td>';
                                        if(isset($days[$date->format('Y-m-d')])) {
                                            echo '<td>'.roundUp($days[$date->format('Y-m-d')] + showPrice($total_cost_workers_fixed, $working_days)).' zł</td>';
                                        } else {
                                            echo '<td>'.roundUp(showPrice($total_cost_workers_fixed, $working_days)).' zł</td>';
                                        }
                                        echo '<td></td>';
                                        echo '<td></td>';
                                        echo '<td></td>';
                                    } else {
                                        echo '<td colspan="6"></td>';
                                    }
                                    echo '</tr>'; 
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
show($rate_log_error);
?>
<?php
show($rate_log);
?>

        </main>
        <?php require_once 'landings/footer.view.php' ?>