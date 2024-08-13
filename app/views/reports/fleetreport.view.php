<?php
//show($data["logbook"]);
$send = $data["get"]["send"];

if($data["hide"] == false) {
    if ($send == 2) {
        if ($data["get"]["type"] == "show") {
            $f1 = "dzień";
        }


        echo '<form method="get">';

        echo '<h1 class="h3 mb-3 fw-normal">Wybierz ' . $f1 . ' do wyświetlenia raportu:</h1>';
        $date = "";
        if (isset($data["get"]["day"])) {
            $date = $data["get"]["day"];
        }

        ?>
        <div class="text-start">
            <?php
            if ($data["get"]["type"] == "show") {

                echo '  <div class="form-group row m-3">
                            <label for="date" class="col-sm-2 col-form-label">Dzień:</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="date" name="date"
                                    value="' . $date . '" required>
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
                ?>
                                </script>
                            </div>
                            <button class="w-40 btn btn-lg btn-primary" style="margin-bottom: 40px;" type="submit" name="search" value=1>Wyświetl raport</button>
                        </form>
            <?php
    }
}

$name = "dziennego używania aut firmowych po pracy";
$dates = "";

if ($data["get"]["type"] == "show") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["day"]));
    $dates = $new_date_format;
}



$mess = "<table style='border: 1px solid'>
    <thead style='border: 1px solid'>
        <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
            <th colspan='12'>Raport $name - $dates</th>
        </tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            <th style='border: 1px solid #000; width: 8%'>Kierowca</th>
            <th style='border: 1px solid #000; width: 8%'>Model auta</th>
            <th style='border: 1px solid #000; width: 8%'>Rejestracja</th>
            <th style='border: 1px solid #000; width: 8%'>Data zgaszenia silnika</th>
            <th style='border: 1px solid #000; width: 8%'>Adres ostatniego postoju</th>
            <th style='border: 1px solid #000; width: 8%'>Pokonane kilometry</th>
        </tr>
    </thead>
    <tbody>";
foreach ($data["cars"] as $car) {
    $u_name = $car->first_name .' '. $car->last_name;
    $objectno = $car->objectno;
    $total_km = 0;
    $last_date = "";
    $last_place = "";
    $bg_color = "lightblue";
    if(isset($data["logbook"][$objectno])) {
        foreach($data["logbook"][$objectno] as $logb) {
            $total_km += $logb->distance;
            if($last_date == "") {
                $last_date = $logb->end_time;
            }
            if($last_place == "") {
                $last_place = $logb->end_postext;
            }
        }
        $total_km = round($total_km / 1000,1) ." km";
        $bg_color = "lightcoral";
    }
    if($total_km == 0) {
        $total_km = "";
        if(isset($data["logbook_visit"][$objectno])) {
            $last_date = $data["logbook_visit"][$objectno][0]->end_time;
            $last_place = $data["logbook_visit"][$objectno][0]->end_postext;
            if(substr($last_date, 0, 10) == $data["get"]["day"]) {
                $bg_color = "lightgreen"; 
            }
        }
    }

    $mess .= "
        <tr style='text-align: center; background-color: $bg_color'>
            <td style='border: 1px solid;'>$u_name</td>
            <td style='border: 1px solid;'>$car->model</td>
            <td style='border: 1px solid;'>$car->plate</td>
            <td style='border: 1px solid;'>$last_date</td>
            <td style='border: 1px solid;'>$last_place</td>
            <td style='border: 1px solid;'>$total_km</td>
        </tr>";
}


$mess .= "
    </tbody>
</table>";


echo $mess;
?>



<?php

if ($send == 1) {
    $to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
    $subject = "Raport $name - $dates";
    $mailer = new Mailer($to, $subject, $mess);
    if (SEND_ON === TRUE) {
        if ($mailer->send()) {
            echo 'Wiadomość została wysłana pomyślnie.';
        } else {
            echo 'Wystąpił problem podczas wysyłania wiadomości. Błąd: ' . print_r($mailer->getLastError(), true);
        }
    } else {
        show($mailer);
    }
}
?>

