<?php
$send = $data["get"]["send"];

if ($send == 2) {
    if ($data["get"]["type"] == "hour") {
        $f1 = "godzinę";
    }
    if ($data["get"]["type"] == "day") {
        $f1 = "dzień";
    }
    if ($data["get"]["type"] == "week") {
        $f1 = "zakres dat";
    }
    if ($data["get"]["type"] == "month") {
        $f1 = "miesiąc";
    }


    echo '<form method="get">';

    echo '<h1 class="h3 mb-3 fw-normal">Wybierz ' . $f1 . ' do wyświetlenia raportu:</h1>';
    $date_from = "";
    $date_to = "";
    if (isset($data["date_from"])) {
        $date_from = $data["date_from"];
    }
    if (isset($data["date_to"])) {
        $date_to = $data["date_to"];
    }

    ?>
    <div class="text-start">
        <?php
        //POPRAWIĆ wyświetlanie godzin po przesłaniu formularza, sprawdzić czy działa dla godzin porannych (6:00, 7:00, 8:00, 9:00)
        if ($data["get"]["type"] == "hour") {
            echo '  <div class="form-group row m-3">
            <label for="date_from" class="col-sm-2 col-form-label">Godzina:</label>
            <div class="col-sm-4">
                <select class="form-control" id="date_from" name="date_from" required>';
            for ($hour = 7; $hour < 17; $hour++) {
                $selected = "";
                if ($data["get"]["param1"] == $hour) {
                    $selected = "selected";
                }
                $hour_padded = sprintf("%02d", $hour);
                $hour_padded_to = sprintf("%02d", $hour + 1);
                echo '<option value="' . $hour_padded . '" ' . $selected . '>' . $hour_padded . ':00 - ' . $hour_padded_to . ':00</option>';
            }
            echo '</select>
            </div>
        </div>';
        }

        if ($data["get"]["type"] == "day") {

            echo '  <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Dzień:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="' . $date_from . '" required>
                        </div>
                    </div>';
        }
        if ($data["get"]["type"] == "week") {
            $datetime = new DateTime($data["get"]["param1"]);
            $param1 = $datetime->format('Y-m-d');
            $datetime = new DateTime($data["get"]["param2"]);
            $param2 = $datetime->format('Y-m-d');

            echo '  <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="' . $param1 . '" required>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="' . $param2 . '" required>
                        </div>
                    </div>';
        }
        if ($data["get"]["type"] == "month") {
            $param1 = $data["get"]["param1"];
            $param2 = $data["get"]["param2"];

            echo '  <div class="form-group row m-3">
            <label for="date_from" class="col-sm-2 col-form-label">Miesiąc:</label>
            <div class="col-sm-4">
                <select class="form-control" id="date_from" name="date_from" required>';
            for ($month = 1; $month <= 12; $month++) {
                $sel = "";
                if ($param1 == $month) {
                    $sel = "selected";
                }
                echo '<option value="' . $month . '" ' . $sel . '>' . date("F", mktime(0, 0, 0, $month, 1)) . '</option>';
            }

            echo '</select>
            </div>
        </div>';

            echo '<div class="form-group row m-3">
            <label for="date_to" class="col-sm-2 col-form-label">Rok:</label>
            <div class="col-sm-4">
                <select class="form-control" id="date_to" name="date_to" required>';
            for ($year = 2024; $year <= 2025; $year++) {
                $sel = "";
                if ($param1 == $year) {
                    $sel = "selected";
                }
                echo '<option value="' . $year . '" ' . $sel . '>' . $year . '</option>';
            }
            echo '</select>
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
            if (!isset($data["date_from"])) {
                if (!isset($param1)) {
                    echo "document.getElementById('date_from').setAttribute('value', currentDate);";
                }
            }
            if (!isset($data["date_to"])) {
                if (!isset($param2)) {
                    echo "document.getElementById('date_to').setAttribute('value', currentDate);";
                }
            }
            ?>
                            </script>
                        </div>
                        <button class="w-40 btn btn-lg btn-primary" style="margin-bottom: 40px;" type="submit" name="search" value=1>Wyświetl raport</button>
                    </form>
        <?php
}

$name = REPORTTYPES[$data["get"]["type"]];
$dates = "";

if ($data["get"]["type"] == "hour") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $dates = $new_date_format . " - " . $data["get"]["param1"] . ":00";
}
if ($data["get"]["type"] == "day") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $dates = $new_date_format;
}
if ($data["get"]["type"] == "week") {
    $new_date_format_from = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $new_date_format_to = date("d-m-Y", strtotime($data["get"]["date_to"]));
    $dates = $new_date_format_from . " - " . $new_date_format_to;
}
if ($data["get"]["type"] == "month") {
    $month = date("F Y", strtotime($data["get"]["date_from"]));
    $dates = $month;
}


$mess = "<table style='border: 1px solid'>
    <thead style='border: 1px solid'>
        <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
            <th colspan='12'>Raport $name sprzedaży - $dates</th>
        </tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            <th style='border: 1px solid #000; width: 8%'>Handlowiec</th>
            <th style='border: 1px solid #000; width: 8%'>Sprzedany towar</th>
            <th style='border: 1px solid #000; width: 8%'>Stan</th>
            <th style='border: 1px solid #000; width: 8%'>% sprzedaży</th>
            <th style='border: 1px solid #000; width: 8%'>Odwiedzone firmy</th>
            <th style='border: 1px solid #000; width: 8%'>Wszystkie firmy</th>
            <th style='border: 1px solid #000; width: 8%'>% odwiedzonych firm</th>
            <th style='border: 1px solid #000; width: 8%'>Pobrane z magazynu</th>
            <th style='border: 1px solid #000; width: 8%'>Wymiany</th>
            <th style='border: 1px solid #000; width: 8%'>Uszkodzone</th>
            <th style='border: 1px solid #000; width: 8%'>Zwroty</th>
            <th style='border: 1px solid #000; width: 8%'>Gratisy</th>
        </tr>
    </thead>
    <tbody>";
$total_sales = 0;
$total_companies = 0;
$total_cargo = 0;
$total_visit = 0;
$total_destroy = 0;
$total_returns = 0;
$total_gratis = 0;
$total_plus = 0;
$total_minus = 0;
$total_stan = 0;
foreach ($data["users"] as $user) {
    $u_id = $user->id;
    $sales = 0;
    $sales_hour = 0;
    $companies = 0;
    $cargos = 0;
    $visit = 0;
    $visit_hour = 0;
    $destroy = 0;
    $destroy_hour = 0;
    $returns = 0;
    $gratis = 0;
    $gratis_hour = 0;
    $plus = 0;
    $minus = 0;
    $stan = 0;
    foreach ($data["sales"] as $sale) {
        if ($sale->u_id == $u_id) {
            $sales += $sale->scan_and_empty;
            $destroy += $sale->destroy;
            $gratis += $sale->gratis;
        }
    }

    if (isset($data["sales_hour"])) {
        foreach ($data["sales_hour"] as $sale_hour) {
            if ($sale_hour->u_id == $u_id) {
                $sales_hour += $sale_hour->scan_and_empty;
                $destroy_hour += $sale_hour->destroy;
                $gratis_hour += $sale_hour->gratis;
            }
        }
    }

    foreach ($data["cargo"] as $cargo) {  //dodać wymiany
        if ($cargo->u_id == $u_id) {
            $cargos += $cargo->num;
        }
    }

    foreach ($data["exchanges"] as $exchange) {  //dodać wymiany
        if ($exchange->u_id_init == $u_id) {
            $minus += $exchange->num;
        }
        if ($exchange->u_id_target == $u_id) {
            $plus += $exchange->num;
        }
    }

    foreach ($data["returns"] as $return) {
        if ($return->u_id == $u_id) {
            $returns += $return->num;
        }
    }

    foreach ($data["places"] as $place) {
        if ($place->u_id == $u_id) {
            $visit += $place->num;
        }
    }

    if (isset($data["places_hour"])) {
        foreach ($data["places_hour"] as $place_hour) {
            if ($place_hour->u_id == $u_id) {
                $visit_hour += $place_hour->num;
            }
        }
    }

    if (isset($data["companies"][$u_id])) {
        $companies = $data["companies"][$u_id];
    }

    $total_sales += $sales;
    $total_companies += $companies;
    $total_visit += $visit;
    $total_cargo += $cargos;
    $total_destroy += $destroy;
    $total_returns += $returns;
    $total_gratis += $gratis;
    $total_plus += $plus;
    $total_minus += $minus;

    $stan = $cargos + $plus - $minus;
    $stan2 = $cargos + $plus - $minus - $sales - $destroy - $returns - $gratis;

    $sale_diff = "";
    $destroy_diff = "";
    $gratis_diff = "";
    $visit_diff = "";
    if ($data["get"]["type"] == "hour") {
        $sale_diff = "(+$sales_hour)";
        $destroy_diff = "(+$destroy_hour)";
        $gratis_diff = "(+$gratis_hour)";
        $visit_diff = "(+$visit_hour)";
    }

    $mess .= "
        <tr style='text-align: center;'>
            <td style='border: 1px solid;'>$user->first_name $user->last_name</td>
            <td style='border: 1px solid;'>$sales $sale_diff</td>
            <td style='border: 1px solid;'>$stan2</td>
            <td style='border: 1px solid;'>" . getPercent($sales, $stan) . "%</td>
            <td style='border: 1px solid;'>$visit $visit_diff</td>
            <td style='border: 1px solid;'>$companies</td>
            <td style='border: 1px solid;'>" . getPercent($visit, $companies) . "%</td>
            <td style='border: 1px solid;'>$cargos</td>
            <td style='border: 1px solid;'>" . $plus - $minus . "</td>
            <td style='border: 1px solid;'>$destroy $destroy_diff</td>
            <td style='border: 1px solid;'>$returns</td>
            <td style='border: 1px solid;'>$gratis $gratis_diff</td>
        </tr>";
}
$total_stan = $total_cargo + $total_plus - $total_minus;
$total_stan2 = $total_cargo + $total_plus - $total_minus - $total_sales - $total_destroy - $total_returns - $total_gratis;
$mess .= "
    </tbody>
    <tfoot>
        <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
            <td style='border: 1px solid;'>TOTAL</td>
            <td style='border: 1px solid;'>$total_sales</td>
            <td style='border: 1px solid;'>$total_stan2</td>
            <td style='border: 1px solid;'>" . getPercent($total_sales, $total_stan) . "%</td>
            <td style='border: 1px solid;'>$total_visit</td>
            <td style='border: 1px solid;'>$total_companies</td>
            <td style='border: 1px solid;'>" . getPercent($total_visit, $total_companies) . "%</td>
            <td style='border: 1px solid;'>$total_cargo</td>
            <td style='border: 1px solid;'>" . $total_plus - $total_minus . "</td>
            <td style='border: 1px solid;'>$total_destroy</td>
            <td style='border: 1px solid;'>$total_returns</td>
            <td style='border: 1px solid;'>$total_gratis</td>
        </tr>
    </tfoot>
</table>";


echo $mess;
?>



<?php
$to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
$subject = "Raport $name sprzedaży - $dates";

if ($send == 1) {
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

