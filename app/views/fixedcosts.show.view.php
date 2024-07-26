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
                //show($data);
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
                                    if(!empty($data["costs"])) {
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
                                    }

                                    $total_cost_workers = 0;
                                    $total_cost_workers_fixed = 0;
                                    $days = [];
                                    if(isset($data["accepted"])) {
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
                                                                $rate_log[] = ["text" => "", "id" => $temp_u_id, "day" => $accept_days_key, "rate" => $t_rate->rate, "work_time" => $temp_time, "paid" => $days[$accept_days_key]];
                                                                //"Dzień: ".$accept_days_key."; User ID: ".$temp_u_id."; Stawka: ".$t_rate->rate."; Czas pracy: ".$temp_time."; Wypłata: ".$days[$accept_days_key];
                                                            }
    
                                                        } elseif($accept_days_key >= $t_rate->date_from && $accept_days_key <= $t_rate->date_to) {
                                                            if($t_rate->type == 2) {
                                                                $total_cost_workers += $t_rate->rate * $temp_time;
                                                                $days[$accept_days_key] += $t_rate->rate * $temp_time;
                                                                $add_log = false;
                                                                $rate_log[] = ["text" => "", "id" => $temp_u_id, "day" => $accept_days_key, "rate" => $t_rate->rate, "work_time" => $temp_time, "paid" => $days[$accept_days_key]];
                                                                //"Dzień: ".$accept_days_key."; User ID: ".$temp_u_id."; Stawka: ".$t_rate->rate."; Czas pracy: ".$temp_time."; Wypłata: ".$days[$accept_days_key];
                                                            }
                                                        }
                                                        if($t_rate->type == 1) {
                                                            // stała stawka
                                                            $fix_rate = true;
                                                            $total_cost_workers_fixed += $t_rate->rate;
                                                            $add_log = false;
                                                            $rate_log[] = ["id" => $temp_u_id, "rate" => $t_rate->rate, "text" => "Stała kwota wypłaty", "day" => "", "work_time" => "", "paid" => 0];
                                                            //"User ID: ".$temp_u_id."; Stawka: ".$t_rate->rate."; Stała kwota wypłaty";
                                                            
                                                        }
                                                    }
                                                    if($add_log == true) {
                                                        $rate_log_error[] = ["id" => $temp_u_id, "day" => $accept_days_key ,"text" => "Brak stawek godzinowych"];//"Dzień: ".$accept_days_key."; User ID: ".$temp_u_id."; Brak stawki.";
                                                    }
                                                } else {
                                                    $rate_log_error[] = ["id" => $temp_u_id, "day" => "", "text" => "Brak stawek godzinowych"];//"User ID: ".$temp_u_id."; Brak stawek godzinowych.";
                                                }
                                                
                                            }
                                        }
                                    }

                                ?>
                                <th scope="col">Dzień tygodnia</th>
                                <th scope="col">Koszty produkcji</th>
                                <th scope="col">Koszty stałe</th>
                                <th scope="col">Koszty pracowników</th>
                                <th scope="col">Dodatkowe koszty wyliczone (naklejki)</th>
                                <th scope="col">Sprzedane produkty</th>
                                <th scope="col">Zysk/Strata</th>
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
                                <?php

                                    $month_prod_cost = 0;
                                    $month_prod_sold = 0;
                                    $label_cost = roundUp(LABELCOST["cost"] / LABELCOST["labels"]);
                                    $labels_month = 0;
                                    foreach($data["full_prod"] as $day_data_day) {
                                        foreach($day_data_day as $day_data) {
                                            if($day_data["amount_prod"] > 0) {
                                                $month_prod_cost += (int) $day_data["production_cost"] * $day_data["amount_prod"];
                                                $labels_month += $day_data["amount_prod"];
                                                if($day_data["returns"] == "") {
                                                    $temp_ret = 0;
                                                } else {
                                                    $temp_ret = $day_data["returns"];
                                                }
                                                $month_prod_sold += (int) $day_data["price"] * ($day_data["amount_prod"] - $temp_ret);
                                            }
                                        }
                                    }
                                    

                                ?>
                                <th scope="col"><?=roundUp($month_prod_cost);?> zł</th>
                                <th scope="col"><?=roundUp($total_cost_fixed);?> zł</th>
                                <th scope="col"><?=roundUp($total_cost_workers + $total_cost_workers_fixed);?> zł</th>
                                <th scope="col"><?=roundUp($labels_month * $label_cost);?> zł</th>
                                <th scope="col"><?=roundUp($month_prod_sold);?> zł</th>
                                <th scope="col"><?=roundUp($month_prod_sold - $month_prod_cost - $total_cost_fixed - $total_cost_workers - $total_cost_workers_fixed - ($labels_month * $label_cost));?> zł</th>
                                <th scope="col"><?=getMargin($month_prod_sold, $month_prod_cost - $total_cost_fixed - $total_cost_workers - $total_cost_workers_fixed - ($labels_month * $label_cost));?> %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    $holiday = "";
                                    $labels_day = 0;
                                    $date->setDate($year, $month, $day);
                                    foreach($data["holidays"] as $holi) {
                                        if($holi->date == $date->format('Y-m-d')) {
                                            $holiday = ' class="calendar-holiday"';
                                        }
                                    }
                                    echo '<tr '.$holiday.'>';
                                    
                                    echo "<td>".$date->format('Y-m-d')."</td>";
                                    if($holiday == "") {
                                        $day_prod_cost = 0;
                                        $day_prod_sold = 0;
                                        if(isset($data["full_prod"][$date->format('Y-m-d')])) {
                                            //show($data["full_prod"][$date->format('Y-m-d')]);
                                            foreach($data["full_prod"][$date->format('Y-m-d')] as $day_data) {
                                                if($day_data["amount_prod"] > 0) {
                                                    $day_prod_cost += (int) $day_data["production_cost"] * $day_data["amount_prod"];
                                                    $labels_day += $day_data["amount_prod"];
                                                    if($day_data["returns"] == "") {
                                                        $temp_ret = 0;
                                                    } else {
                                                        $temp_ret = $day_data["returns"];
                                                    }
                                                    $day_prod_sold += (int) $day_data["price"] * ($day_data["amount_prod"] - $temp_ret);
                                                } else {
                                                    if($day_data["amount_plan"] > 0) {
                                                        $data["prod_error"][] = ["p_id" => $day_data["p_id"], "day" => $day_data["date_plan"], "plan" => $day_data["amount_plan"], "producted" => $day_data["amount_prod"], "text" => "Potencjalny brak zaraportowania produkcji"];
                                                        //"Produkt ID: ".$day_data["p_id"]."; Data: ".$day_data["date_plan"]. "; 
                                                        //Planowane: ".$day_data["amount_plan"]."; Wyprodukowane: ".$day_data["amount_prod"]."; Potencjalny brak zaraportowania produkcji";
                                                    }
                                                }
                                            }
                                        }


                                        echo '<td>'.roundUp($day_prod_cost).' zł</td>';
                                        echo '<td>'.roundUp(showPrice($total_cost_fixed, $working_days)).' zł</td>';
                                        if(isset($days[$date->format('Y-m-d')])) {
                                            echo '<td>'.roundUp($days[$date->format('Y-m-d')] + showPrice($total_cost_workers_fixed, $working_days)).' zł</td>';
                                            $temp_cost = $days[$date->format('Y-m-d')] + showPrice($total_cost_workers_fixed, $working_days);
                                        } else {
                                            echo '<td>'.roundUp(showPrice($total_cost_workers_fixed, $working_days)).' zł</td>';
                                            $temp_cost = showPrice($total_cost_workers_fixed, $working_days);
                                        }
                                        echo '<td>'.roundUp($labels_day * $label_cost).' zł</td>';
                                        echo '<td>'.roundUp($day_prod_sold).' zł</td>';
                                        echo '<td>'.roundUp($day_prod_sold - $day_prod_cost - showPrice($total_cost_fixed, $working_days) - $temp_cost - ($labels_day * $label_cost)).' zł</td>';
                                        echo '<td>'.getMargin($day_prod_sold, $day_prod_cost - showPrice($total_cost_fixed, $working_days) - $temp_cost - ($labels_day * $label_cost)).' %</td>';
                                    } else {
                                        echo '<td colspan="2"></td>';
                                        if(isset($days[$date->format('Y-m-d')])) {
                                            echo '<td>'.roundUp($days[$date->format('Y-m-d')]).' zł</td>';
                                            $temp_cost = $days[$date->format('Y-m-d')] + showPrice($total_cost_workers_fixed, $working_days);
                                        } else {
                                            echo '<td></td>';
                                        }
                                        echo '<td colspan="4"></td>';
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
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Błędy i problemy</h2>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid px-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2 class="">Brak stawek wypłat</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Użytkownik</th>
                                                <th>Treść błędu</th>
                                                <th>Akcje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($rate_log_error)) {
                                                    foreach($rate_log_error as $error) {
                                                        echo "<tr>";
                                                        echo "<td>".$error["day"]."</td>";
                                                        echo "<td>".$data["users"][$error["id"]]->first_name." ".$data["users"][$error["id"]]->last_name."</td>";
                                                        echo "<td>".$error["text"]."</td>";
                                                        echo "<td><a href='".ROOT."/users/edit/".$error["id"]."' target=blank>Napraw</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>Wszystko poprawnie</td></tr>";
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
                                    <h2 class="">Potencjalne braki w raporcie produkcji</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Produkt</th>
                                                <th>Planowane</th>
                                                <th>Wyprodukowane</th>
                                                <th>Treść błędu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($data["prod_error"])) {
                                                    foreach($data["prod_error"] as $error) {
                                                        echo "<tr>";
                                                        echo "<td>".$error["day"]."</td>";
                                                        echo "<td>".$data["fullproducts"][$error["p_id"]]->p_name."</td>";
                                                        echo "<td>".$error["plan"]."</td>";
                                                        echo "<td>".$error["producted"]."</td>";
                                                        echo "<td>".$error["text"]."</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='5'>Wszystko poprawnie</td></tr>";
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
                                    <h2 class="">Lista braków cen dla produktów</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Produkt</th>
                                                <th>Treść błędu</th>
                                                <th>Akcja</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($data["price_log_error"])) {
                                                    foreach($data["price_log_error"] as $error) {
                                                        echo "<tr>";
                                                        echo "<td>".$error["day"]."</td>";
                                                        echo "<td>".$data["fullproducts"][$error["p_id"]]->p_name."</td>";
                                                        echo "<td>".$error["text"]."</td>";
                                                        echo "<td><a href='".ROOT."/prices/edit/".$error["p_id"]."' target=blank>Napraw</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>Wszystko poprawnie</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php 
                            if($data["show_details"] == true) {

                        ?>                  
                        <div class="container-fluid px-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2 class="">Lista cen produktów</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Produkt</th>
                                                <th>Kwota sprzedaży</th>
                                                <th>Koszt produkcji</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($data["price_log"])) {
                                                    foreach($data["price_log"] as $error) {
                                                        echo "<tr>";
                                                        echo "<td>".$error["day"]."</td>";
                                                        echo "<td>".$data["fullproducts"][$error["p_id"]]->p_name."</td>";
                                                        echo "<td>".roundUp($error["price"])." zł</td>";
                                                        echo "<td>".roundUp($error["production_cost"])." zł</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'>Wszystko poprawnie</td></tr>";
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
                                    <h2 class="">Lista zwrotów</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Produkt</th>
                                                <th>Ilość</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($data["return_log"])) {
                                                    foreach($data["return_log"] as $error) {
                                                        echo "<tr>";
                                                        echo "<td>".$error["day"]."</td>";
                                                        echo "<td>".$data["fullproducts"][$error["p_id"]]->p_name."</td>";
                                                        echo "<td>".$error["returns"]."</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>Wszystko poprawnie</td></tr>";
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
                                    <h2 class="">Stawki pracowników</h2>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Pracownik</th>
                                                <th>Stawka</th>
                                                <th>Czas pracy</th>
                                                <th>Wypłata</th>
                                                <th>Opis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!empty($rate_log)) {
                                                    foreach($rate_log as $error) {
                                                        echo "<tr>";
                                                        echo "<td>".$error["day"]."</td>";
                                                        echo "<td>".$data["users"][$error["id"]]->first_name." ".$data["users"][$error["id"]]->last_name."</td>";
                                                        echo "<td>".roundUp($error["rate"])." zł</td>";
                                                        echo "<td>".round((float) $error["work_time"], 2)."</td>";
                                                        echo "<td>".roundUp($error["paid"])." zł</td>";
                                                        echo "<td>".$error["text"]."</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>Wszystko poprawnie</td></tr>";
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

                    </div>
                </div>
            </div>


            <?php
                }
            ?>

<?php
//show($rate_log_error); //lista braków stawek wypłat dla pracowników
//show($rate_log); //lista stawek wypłat dla pracowników
//show($data["price_log_error"]); //lista braków cen dla produktów
//show($data["price_log"]); //lista cen produktów
//show($data["return_log"]); //lista zwrotów
//show($data["prod_error"]); //lista potencjalnych braków azraportowania
?>

        </main>
        <?php require_once 'landings/footer.view.php' ?>