<?php
//show($data["logbook"]);
$send = $data["get"]["send"];

$grouped = [];

if($data["hide"] == false) {
    if ($send == 2 || $send == 0) {
        if ($data["get"]["type"] == "show") {
            $f1 = "dzień";
        }


        echo '<form method="get">';

        echo '<h1 class="h3 mb-3 fw-normal">Wybierz dzień do wyświetlenia raportu:</h1>';
        $date = "";
        $date_to = "";
        if (isset($data["get"]["day"])) {
            $date = $data["get"]["day"];
        }
        if (isset($data["get"]["day_to"])) {
            $date_to = $data["get"]["day_to"];
        }

        ?>
        <div class="text-start">
            <?php
            if ($data["get"]["type"] == "show" || $send == 0) {

                echo '  <div class="form-group row m-3">
                            <label for="date" class="col-sm-2 col-form-label">Dzień od:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date" name="date"
                                    value="' . $date . '" required>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="date_to" class="col-sm-2 col-form-label">Dzień do:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="' . $date_to . '" required>
                            </div>
                        </div>';
            }
            ?>
            <script>
                const date = new Date();
                let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
                let month = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(date);
                let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);

                let currentDate = `${year}-${month}-${day}`;

                <?php
                if (!isset($data["get"]["day"])) {
                    echo "document.getElementById('date').setAttribute('value', currentDate);";
                }
                if (!isset($data["get"]["day_to"])) {
                    echo "document.getElementById('date_to').setAttribute('value', currentDate);";
                }
                ?>
                                </script>
                            </div>
                            <button class="w-40 btn btn-lg btn-primary" style="margin-bottom: 40px;" type="submit" name="search" value=1>Wyświetl raport</button>
                        </form>
            <?php
    }
} else {
    $date = date("Y-m-d");
}

$name = "dziennego używania aut firmowych po pracy";
$dates = "";
//show($data);
if ($data["get"]["type"] == "show") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["day"]));
    $dates = $new_date_format;
}
if ($data["get"]["type"] == "send") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["day"]));
    $dates = $new_date_format;
}
$mess = "";

foreach($data["logbook"] as $car_key => $car_value) {
    $mess .= "<table style='border: 1px solid; width: 100%''>
        <thead style='border: 1px solid' id='".$data["cars"][$car_key]->plate."'>
            <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                <th colspan='7'>Szczegóły - ".$data["cars"][$car_key]->plate." - Kierowca: ".$data["cars"][$car_key]->first_name." ".$data["cars"][$car_key]->last_name."</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th colspan='2' style='border: 1px solid #000; width: 40%;'>Początek trasy</th>
                <th colspan='2' style='border: 1px solid #000; width: 40%;'>Koniec trasy</th>
                <th rowspan='2' style='border: 1px solid #000; width: 20%;'>Długość trasy [Śr. dł.]</th>
                <th rowspan='2' style='border: 1px solid #000; width: 20%;'>Czas postoju [Śr. czas]</th>
                <th rowspan='2' style='border: 1px solid #000; width: 20%;'>Postoje</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th style='border: 1px solid #000; width: 10%;'>Godzina</th>
                <th style='border: 1px solid #000; width: 25%;'>Miejsce</th>
                <th style='border: 1px solid #000; width: 10%;'>Godzina</th>
                <th style='border: 1px solid #000; width: 25%;'>Miejsce</th>
            </tr>
        </thead>
        <tbody>";//        <th rowspan='2' style='border: 1px solid #000; width: 20%;'>Współczynnik trasa - postój</th>
        $show_break = false;
        $lastDay = "";
        $first_row = true;
        //show(end($car_value));
        $last_id = "";
        //$if_count = true;
        $total_km = 0;
        $total_time = 0;
        $total_stops = 0;
        $show_sum = false;
    foreach($car_value as $route_key => $route) {
        $if_count = true;
        if(end($car_value)->tripid == $route->tripid) {
            $show_sum = true;
        }
            //show(end($car_value)->tripid);
            //show($route->tripid);
            if($lastDay == "") {
                $lastDay = subDay($route->start_time);
                //$mess .= "<tr style='background-color: #4a4a4a; color: #e6e6e6;'><td colspan='6'>$subDay</td></tr>";
            }
            if(subDay($route->start_time) != $lastDay) {
                $mess .= "<tr style='background-color: #4a4a4a; color: #e6e6e6;'>";
                $mess .= "<td style='border: 1px solid #000;' colspan='4'>$lastDay</td>";
                $mess .= "<td style='border: 1px solid #000;'>".round($total_km / 1000,1)." km [".avgDistance($total_km, $total_stops)." km]</td>";
                $mess .= "<td style='border: 1px solid #000;'>".secondsToTime($total_time)." [".averageStopTime($total_time, $total_stops)."]</td>";
                //$mess .= "<td style='border: 1px solid #000;'></td>";
                $mess .= "<td style='border: 1px solid #000;'>".$total_stops."</td>";
                $mess .= "</tr>";
                $lastDay = subDay($route->start_time);
                $total_km = 0;
                $total_time = 0;
                $total_stops = 0;
                $first_row = true;
            }
            $lastDay = subDay($route->start_time);
            
                $mess .= "<tr style='text-align: center;'>";
                $mess .= "<td style='border: 1px solid;'>$route->start_time</td>";
                $mess .= "<td style='border: 1px solid;'>$route->start_postext</td>";
                $mess .= "<td style='border: 1px solid;'>$route->end_time</td>";
                $mess .= "<td style='border: 1px solid;'>$route->end_postext</td>";
                $mess .= "<td style='border: 1px solid;'>".round($route->distance / 1000,1) ." km</td>";
                if($route_key-1== -1) {
                    $mess .= "<td style='border: 1px solid;'></td>";
                } else {
                    $mess .= "<td style='border: 1px solid;'>".timeDiff($route->end_time, $car_value[$route_key-1]->start_time)."</td>";
                    if(timeToSeconds(timeDiff($route->end_time, $car_value[$route_key-1]->start_time)) >= 3600) { //STOP z czasem powyżej 1h nie wlicza się
                        $if_count = false;
                    }
                }
                $grouped[$lastDay][$data["cars"][$car_key]->plate]["total_km"] = $total_km;
                $grouped[$lastDay][$data["cars"][$car_key]->plate]["total_time"] = $total_time;
                $grouped[$lastDay][$data["cars"][$car_key]->plate]["total_stops"] = $total_stops;
                $grouped[$lastDay][$data["cars"][$car_key]->plate]["driver"] = $data["cars"][$car_key]->first_name." ".$data["cars"][$car_key]->last_name;
                $grouped[$lastDay][$data["cars"][$car_key]->plate]["driver_id"] = $data["cars"][$car_key]->user_id;
                
                if(checkWords($route->start_postext, $route->end_postext)) {
                    $if_count = false;
                }
                if(checkWord($route->end_postext)) {
                    $if_count = false;
                }
                if($first_row) {
                    $if_count = false;
                }

                
                if($if_count) {
                    $total_km += $route->distance;
                    if($route_key-1== -1) {
                        $total_time = 0;
                    } else {
                        $total_time += timeToSeconds(timeDiff($route->end_time, $car_value[$route_key-1]->start_time));
                    }
                    $total_stops += 1;
                }
                $last_id = $route_key;
                if($if_count) {
                    $stop_txt = "background-color: LightGreen;"; 
                } else {
                    $stop_txt = "background-color: LightCoral;"; 
                }
                $link_maps = "";
                if($send == 0) {
                    $maps_start = $route->start_latitude.",".$route->start_longitude;
                    $maps_stop = $route->end_latitude.",".$route->end_longitude;
                    $link_maps = "<a target='_blank' href='https://www.google.com/maps/dir/?api=1&origin=$maps_start&destination=$maps_stop'><i class='fa-solid fa-map'></i></a>";
                }
                //$mess .= "<td style='border: 1px solid;'>".round($route->distance / timeToSeconds(timeDiff($route->end_time, $car_value[$route_key-1]->start_time)),4)."</td>";
                $mess .= "<td style='border: 1px solid; $stop_txt'>$link_maps</td>";
                $mess .= "</tr>";

            if($first_row) {
                $first_row = false;
            }
        if($show_sum) {
            $mess .= "<tr style='background-color: #4a4a4a; color: #e6e6e6;'>";
            $mess .= "<td style='border: 1px solid #000;' colspan='4'>$lastDay</td>";
            $mess .= "<td style='border: 1px solid #000;'>".round($total_km / 1000,1)." km [".avgDistance($total_km, $total_stops)." km]</td>";
            $mess .= "<td style='border: 1px solid #000;'>".secondsToTime($total_time)." [".averageStopTime($total_time, $total_stops)."]</td>";
            //$mess .= "<td style='border: 1px solid #000;'></td>";
            $mess .= "<td style='border: 1px solid #000;'>".$total_stops."</td>";
            $mess .= "</tr>";
            $lastDay = subDay($route->start_time);
        }
    }
    $mess .= "
        </tbody>
    </table>";
}

//show($data);
if($send == 0) {
    echo $mess;
    echo '<br><br><br>';
}
$det = "";

$det .= "<table style='border: 1px solid; width: 100%''>
        <thead style='border: 1px solid'>
            <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                <th colspan='11'>Podsumowanie kierowców - ".$date."</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th style='border: 1px solid #000;'>Numer rejestracyjny</th>
                <th style='border: 1px solid #000;'>Kierowca</th>
                <th style='border: 1px solid #000;'>Przejechane km</th>
                <th style='border: 1px solid #000;'>Średnia długość trasy</th>
                <th style='border: 1px solid #000;'>Łączny czas postojów</th>
                <th style='border: 1px solid #000;'>Średnia czas postoju</th>
                <th style='border: 1px solid #000;'>Ilość postojów</th>
                <th style='border: 1px solid #000;'>Utarg</th>
                <th style='border: 1px solid #000;'>Utarg / punkt</th>
                <th style='border: 1px solid #000;'>Utarg / czas postoju (minutę)</th>
                <th style='border: 1px solid #000;'>Utarg / przejechane km</th>
            </tr>
        </thead>
        <tbody>";
foreach($grouped as $date_gr => $grup) {
    $tot_km = 0;
    $tot_time = 0;
    $tot_stops = 0;
    $tot_profit = 0;
    $to_add = false;
    $bg_col = "";
    foreach($grup as $plate_gr => $gdata) {
        if(!isset($data["drivers_show"][$gdata["driver_id"]])) {
            $bg_col = "style='background-color: lightcoral;'";
            $to_add = false;
        } else {
            $bg_col = "";
            $to_add = true;
        }

        $det .= "<tr $bg_col>";
        if($send == 0) {
            $det .= "<td style='border: 1px solid #000;'><a href='#$plate_gr'>$plate_gr</a></td>";
        } else {
            $det .= "<td style='border: 1px solid #000;'>$plate_gr</td>";
        }
        $helper_for = "";
        $minus_profit = 0;
        $i = 0;
        if(isset($data["helpers"][$gdata["driver_id"]])) {
            foreach($data["helpers"][$gdata["driver_id"]] as $hel) {
                if($i == 0) {
                    $helper_for .= "Pomocnicy: ";
                } else {
                    $helper_for .= ", ";
                }
                $helper_for .= $data["drivers_show"][$hel->u_id]->first_name." ".$data["drivers_show"][$hel->u_id]->last_name;
                if(isset($data["gains"][$date_gr][$gdata["driver_id"]])) {
                    if(isset($data["gains"][$date_gr][$hel->u_id])) {
                        $minus_profit += $data["gains"][$date_gr][$hel->u_id]->profit;
                    }
                }
            
                $i++;
            }
        }
        $det .= "<td style='border: 1px solid #000;' title='$helper_for'>".$gdata["driver"]."</td>";
        $det .= "<td style='border: 1px solid #000;'>".round($gdata["total_km"] / 1000,1)." km</td>";
        $det .= "<td style='border: 1px solid #000;'>".avgDistance($gdata["total_km"],$gdata["total_stops"])." km</td>";
        $det .= "<td style='border: 1px solid #000;'>".secondsToTime($gdata["total_time"])."</td>";
        $det .= "<td style='border: 1px solid #000;'>".averageStopTime($gdata["total_time"],$gdata["total_stops"])."</td>";
        $det .= "<td style='border: 1px solid #000;'>".$gdata["total_stops"]."</td>";
        $profit = 0;
        if(isset($data["gains"][$date_gr][$gdata["driver_id"]])) {
            $profit = $data["gains"][$date_gr][$gdata["driver_id"]]->profit;
        }
        $profit -= $minus_profit;
        $det .= "<td style='border: 1px solid #000;'>$profit zł</td>";
        $det .= "<td style='border: 1px solid #000;'>".amountPerPoint($profit, $gdata["total_stops"])." zł</td>";
        $det .= "<td style='border: 1px solid #000;'>".amountPerPoint($profit, ($gdata["total_time"]/60))." zł</td>";
        $det .= "<td style='border: 1px solid #000;'>".amountPerPoint($profit, ($gdata["total_km"]/1000))." zł</td>";

        if($to_add) {
            $tot_km += $gdata["total_km"];
            $tot_time += $gdata["total_time"];
            $tot_stops += $gdata["total_stops"];
            $tot_profit += $profit;
        }

        $det .= "</tr>";
    }
    $det .= "<tr style='background-color: #4a4a4a; color: #e6e6e6;'>";
    $det .= "<th colspan='2' style='border: 1px solid #000;'>$date_gr</th>";
    $det .= "<th style='border: 1px solid #000;'>".round($tot_km / 1000,1)." km</th>";
    $det .= "<th style='border: 1px solid #000;'>".avgDistance($tot_km,$tot_stops)." km</th>";
    $det .= "<th style='border: 1px solid #000;'>".secondsToTime($tot_time)."</th>";
    $det .= "<th style='border: 1px solid #000;'>".averageStopTime($tot_time, $tot_stops)."</th>";
    $det .= "<th style='border: 1px solid #000;'>".$tot_stops."</th>";
    $det .= "<th style='border: 1px solid #000;'>".$tot_profit." zł</th>";
    $det .= "<th style='border: 1px solid #000;'>".amountPerPoint($tot_profit, $tot_stops)." zł</th>";
    $det .= "<th style='border: 1px solid #000;'>".amountPerPoint($tot_profit, $tot_time/60)." zł</th>";
    $det .= "<th style='border: 1px solid #000;'>".amountPerPoint($tot_profit, $tot_km/1000)." zł</th>";




    $det .= "</tr>";
    //data
}




//show($data["gains"]);
$det .= "
        </tbody>
    </table>";
echo $det;

?>



<?php

if ($send == 1) {
    $to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
    $subject = "Raport $name - $dates";
    $mailer = new Mailer($to, $subject, $det);
    if($data["holi"] == false) {
        if (SEND_ON === TRUE) {
            if ($mailer->send()) {
                echo 'Wiadomość została wysłana pomyślnie.';
            } else {
                echo 'Wystąpił problem podczas wysyłania wiadomości. Błąd: ' . print_r($mailer->getLastError(), true);
            }
        } else {
            show($mailer);
            show($data["emails"]);
        }
    } else {
        echo "Wolne";
    }
}
?>

