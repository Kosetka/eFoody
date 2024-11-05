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
                echo '<option value="' . $month . '" ' . $sel . '>' . getPolishMonthName($month) . '</option>';
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
//show($data["cargo_temp"]);
$mess = "";

if(isset($data["cargo_temp"])) {
    $mess .= "<table style='border: 1px solid'>
        <thead style='border: 1px solid'>
            <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                <th colspan='12'>Raport sprzedaży po firmach - $dates</th>
            </tr>
            <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                <th style='border: 1px solid #000; width: 8%'>Produkt</th>
                <th style='border: 1px solid #000; width: 8%'>Ilość dostarczona</th>
                <th style='border: 1px solid #000; width: 8%'>Zwroty</th>
                <th style='border: 1px solid #000; width: 8%'>% zwrotów</th>
                <th style='border: 1px solid #000; width: 8%'>Łącznie do zapłaty</th>
            </tr>
        </thead>
        <tbody>";
    $tt_sales = 0;
    $tt_money = 0;
    $tt_return = 0;
    foreach($data["cargo_temp"] as $company_id => $compval) {
        $total_sales = 0;
        $total_money = 0;
        $total_return = 0;
        
        foreach ($compval as $product_id => $prod_date) {
            $amo = 0;
            $cost = 0;
            $cost_last = 0;
            $tot_amo = 0;
            $costb = true;
            $total_cost = 0;
    
            foreach($prod_date as $key_date => $one_date) {

                $amo += $one_date["amount"];
                if($data["shops"][$company_id]->company_type == 2) {
                    if(isset($one_date["cost_zm"])) {
                        $cost = $one_date["cost_zm"];
                    } else {
                        $cost = $one_date["cost"];
                    }
                } else {
                    if(isset($one_date["cost_f"])) {
                        $cost = $one_date["cost_f"];
                    } else {
                        $cost = $one_date["cost"];
                    }
                }
                if($costb) {
                    if($cost_last == 0) {
                        $cost_last = $cost;
                    }
                    else if ($cost_last != $cost) {
                        $costb = false;
                    }
                }
                $day_ret = 0;
                if(isset($data["returns"][$company_id][$key_date][$product_id]["amount"])) {
                    $day_ret = $data["returns"][$company_id][$key_date][$product_id]["amount"];
                }
    
                $tot_amo = ($one_date["amount"] - $day_ret) * $cost;
                $total_sales += $one_date["amount"];
                $total_money += ($one_date["amount"] - $day_ret) * $cost;
                $total_cost += ($one_date["amount"] - $day_ret) * $cost;
            }
            $txtadd = "";
            if(!$costb) {
                $txtadd = "<b>*</b>";
            }
    
    
            if($amo > 0) {
                $ret_show = 0;
                if(isset($data["returns"][$company_id][$product_id]["amount"])) {
                    $ret_show = $data["returns"][$company_id][$product_id]["amount"];
                    $total_return += $ret_show;
                }
                /*$mess .= "
                    <tr style='text-align: center;'>
                        <td style='border: 1px solid;'>".$data["fullproducts"][$product_id]["p_name"]."</td>
                        <td style='border: 1px solid;'>$amo</td>
                        <td style='border: 1px solid;'>$ret_show</td>
                        <td style='border: 1px solid;' title='Gwiazda oznacza zmianę ceny w trakcie wybranej daty, kwota liczy się prawidłowo, jednak wyświetla się najnowsza cena za sztukę.'>$cost_last zł$txtadd</td>
                        <td style='border: 1px solid;'>" . $total_cost . " zł</td>
                    </tr>";*/
            }
        }
        $mess .= "
                <tr style='text-align: center;'>
                    <td style='border: 1px solid;'>".$data["shops"][$company_id]->full_name."</td>
                    <td style='border: 1px solid;'>$total_sales</td>
                    <td style='border: 1px solid;'>$total_return</td>
                    <td style='border: 1px solid;'>".getPercent($total_return,$total_sales)." %</td>
                    <td style='border: 1px solid;'>$total_money zł</td>
                </tr>";
        $tt_sales += $total_sales;
        $tt_return += $total_return;
        $tt_money += $total_money;
    }
    $mess .= "
            </tbody>
            <tfoot>
                <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                    <td style='border: 1px solid;'>TOTAL</td>
                    <td style='border: 1px solid;'>$tt_sales</td>
                    <td style='border: 1px solid;'>$tt_return</td>
                    <td style='border: 1px solid;'>".getPercent($tt_return,$tt_sales)." %</td>
                    <td style='border: 1px solid;'>$tt_money zł</td>
                </tr>
            </tfoot>
        </table>";

}


echo $mess;

?>



<?php
$to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
$subject = "Raport sprzedaży do firm - $dates";

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

