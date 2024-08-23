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
            if ($data["get"]["type"] == "show") {

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
}

$name = "dziennego używania aut firmowych po pracy";
$dates = "";

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
        <thead style='border: 1px solid'>
            <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                <th colspan='5'>Szczegóły - ".$data["cars"][$car_key]->plate."</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th colspan='2' style='border: 1px solid #000; width: 40%;'>Początek trasy</th>
                <th colspan='2' style='border: 1px solid #000; width: 40%;'>Koniec trasy</th>
                <th rowspan='2' style='border: 1px solid #000; width: 20%;'>Długość trasy</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th style='border: 1px solid #000; width: 10%;'>Godzina</th>
                <th style='border: 1px solid #000; width: 25%;'>Miejsce</th>
                <th style='border: 1px solid #000; width: 10%;'>Godzina</th>
                <th style='border: 1px solid #000; width: 25%;'>Miejsce</th>
            </tr>
        </thead>
        <tbody>";
        $show_break = false;
        $subDay = "";
    foreach($car_value as $route) {
        if($subDay == "") {
            $subDay = subDay($route->start_time);
            $mess .= "<tr style='background-color: #4a4a4a; color: #e6e6e6;'><td colspan='5'>$subDay</td></tr>";
        }
        if(subDay($route->start_time) != $subDay) {
            $subDay = subDay($route->start_time);
            $mess .= "<tr style='background-color: #4a4a4a; color: #e6e6e6;'><td colspan='5'>$subDay</td></tr>";
        }
        $mess .= "<tr style='text-align: center;'>";
        $mess .= "<td style='border: 1px solid;'>$route->start_time</td>";
        $mess .= "<td style='border: 1px solid;'>$route->start_postext</td>";
        $mess .= "<td style='border: 1px solid;'>$route->end_time</td>";
        $mess .= "<td style='border: 1px solid;'>$route->end_postext</td>";
        $mess .= "<td style='border: 1px solid;'>".round($route->distance / 1000,1) ." km</td>";
        $mess .= "</tr>";
    }
    $mess .= "
        </tbody>
    </table>";
}

//show($data["logbook"]);

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

