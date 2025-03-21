<?php
$send = $data["get"]["send"];
$days = 0;

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
                    </div>
                    <div class="form-group row m-3">
                        <label for="prop" class="col-sm-2 col-form-label">Pokaż propozycje:</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="form-check-input" id="prop" name="prop"
                                value="1">
                        </div>
                    </div>
                    ';

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

    <button class="w-40 btn btn-lg btn-primary" style="margin-bottom: 40px;" type="submit" name="search" value=1>Wyświetl
        raport</button>
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

$prod = [];
if (isset($_GET["date_from"])) {
    $days = countDaysExcludingSundays($_GET["date_from"], $_GET["date_to"], HOLIDAYS);
} else {
    $days = 6;
}

$prop = [];

if (isset($data["cargo_temp"])) {
    foreach ($data["cargo_temp"] as $company_id => $compval) {
        $f_name = "";
        if ($data["shops"][$company_id]->friendly_name <> "") {
            $f_name = " (" . $data["shops"][$company_id]->friendly_name . ")";
        }
        $mess .= "<table style='border: 1px solid'>
            <thead style='border: 1px solid'>
                <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                    <th colspan='12'>Raport sprzedaży do firmy - " . $data["shops"][$company_id]->full_name . " $f_name - $dates</th>
                </tr>
                <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                    <th style='border: 1px solid #000; width: 8%'>Produkt</th>
                    <th style='border: 1px solid #000; width: 8%'>Ilość dostarczona</th>
                    <th style='border: 1px solid #000; width: 8%'>Zwroty</th>
                    <th style='border: 1px solid #000; width: 8%'>Cena za sztukę (brutto)</th>
                    <th style='border: 1px solid #000; width: 8%'>Cena łączna do zapłaty</th>
                    <th style='border: 1px solid #000; width: 8%'>Dni pracujące</th>
                    <th style='border: 1px solid #000; width: 8%'>Średnia sprzedaż [na dzień]</th>
                    <th style='border: 1px solid #000; width: 8%'>Średnia zwrotów [na dzień]</th>
                </tr>
            </thead>
            <tbody>";
        $total_sales = 0;
        $total_money = 0;
        $total_return = 0;

        foreach ($compval as $product_id => $prod_date) {
            //show($product_id);
            if ($product_id <> "dates") {
                $amo = 0;
                $cost = 0;
                $cost_last = 0;
                $tot_amo = 0;
                $costb = true;
                $total_cost = 0;

                foreach ($prod_date as $key_date => $one_date) {

                    $amo += $one_date["amount"];
                    if ($data["shops"][$company_id]->company_type == 2) {
                        if (isset($one_date["cost_zm"])) {
                            $cost = $one_date["cost_zm"];
                        } else {
                            $cost = $one_date["cost"];
                        }
                    } else {
                        if (isset($one_date["cost_f"])) {
                            $cost = $one_date["cost_f"];
                        } else {
                            $cost = $one_date["cost"];
                        }
                    }
                    if ($costb) {
                        if ($cost_last == 0) {
                            $cost_last = $cost;
                        } else if ($cost_last != $cost) {
                            $costb = false;
                        }
                    }
                    $day_ret = 0;
                    if (isset($data["returns"][$company_id][$key_date][$product_id]["amount"])) {
                        $day_ret = $data["returns"][$company_id][$key_date][$product_id]["amount"];
                    }

                    $tot_amo = ($one_date["amount"] - $day_ret) * $cost;
                    $total_sales += $one_date["amount"];
                    $total_money += ($one_date["amount"] - $day_ret) * $cost;
                    $total_cost += ($one_date["amount"] - $day_ret) * $cost;
                }
                $txtadd = "";
                if (!$costb) {
                    $txtadd = "<b>*</b>";
                }


                if ($amo > 0) {
                    $ret_show = 0;
                    if (isset($data["returns"][$company_id][$product_id]["amount"])) {
                        $ret_show = $data["returns"][$company_id][$product_id]["amount"];
                        $total_return += $ret_show;
                    }
                    $days = countDaysExcludingSundays($compval["dates"]["start_date"], $compval["dates"]["stop_date"], HOLIDAYS) + 2;
                    $mess .= "
                        <tr style='text-align: center;'>
                            <td style='border: 1px solid;'>" . $data["fullproducts"][$product_id]["p_name"] . "</td>
                            <td style='border: 1px solid;'>$amo</td>
                            <td style='border: 1px solid;'>$ret_show</td>
                            <td style='border: 1px solid;' title='Gwiazda oznacza zmianę ceny w trakcie wybranej daty, kwota liczy się prawidłowo, jednak wyświetla się najnowsza cena za sztukę.'>$cost_last zł$txtadd</td>
                            <td style='border: 1px solid;'>" . $total_cost . " zł</td>
                            <td style='border: 1px solid;'>" . $days . "</td>
                            <td style='border: 1px solid;'>" . number_format(($amo - $ret_show) / $days, 2) . "</td>
                            <td style='border: 1px solid;'>" . number_format(($ret_show) / $days, 2) . "</td>
                        </tr>";
                    if (!isset($prod[$product_id]["amount"])) {
                        $prod[$product_id]["amount"] = 0;
                    }
                    $prod[$product_id]["amount"] += $amo;

                    if (!isset($prod[$product_id]["return"])) {
                        $prod[$product_id]["return"] = 0;
                    }
                    $prod[$product_id]["return"] += $ret_show;

                    if (!isset($prod[$product_id]["cost"])) {
                        $prod[$product_id]["cost"] = 0;
                    }
                    $prod[$product_id]["cost"] += $total_cost;
                    if (!isset($prod[$product_id]["return_val"])) {
                        $prod[$product_id]["return_val"] = 0;
                    }
                    $prod[$product_id]["return_val"] += $ret_show * $cost_last;
                    $prop[$company_id]["id"] = $company_id;
                    $prop[$company_id]["name"] = $data["shops"][$company_id]->full_name . " " . $f_name;
                    $prop[$company_id]["delivery"] = $compval["dates"]["unique"];
                    $prop[$company_id]["products"][$product_id]["id"] = $product_id;
                    $prop[$company_id]["products"][$product_id]["name"] = $data["fullproducts"][$product_id]["p_name"];
                    $prop[$company_id]["products"][$product_id]["amount"] = $amo;
                    $prop[$company_id]["products"][$product_id]["returns"] = $ret_show;
                    $prop[$company_id]["products"][$product_id]["cost"] = $cost_last;
                    $prop[$company_id]["products"][$product_id]["total_cost"] = $total_cost;
                    $prop[$company_id]["products"][$product_id]["daysopen"] = $days;
                    $prop[$company_id]["products"][$product_id]["avgsell"] = number_format(($amo - $ret_show) / $days, 2);
                    $prop[$company_id]["products"][$product_id]["avgret"] = number_format(($ret_show) / $days, 2);
                }

            }
        }
        $mess .= "
            </tbody>
            <tfoot>
                <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                    <td style='border: 1px solid;'>TOTAL</td>
                    <td style='border: 1px solid;'>$total_sales</td>
                    <td style='border: 1px solid;'>$total_return</td>
                    <td style='border: 1px solid;'></td>
                    <td style='border: 1px solid;'>$total_money zł</td>
                    <td style='border: 1px solid;'></td>
                    <td style='border: 1px solid;'>" . number_format(($total_sales - $total_return) / $days, 2) . "</td>
                    <td style='border: 1px solid;'>" . number_format(($total_return) / $days, 2) . "</td>
                </tr>
            </tfoot>
        </table>";
        $mess .= "</br>";
    }

}

$mess2 = "";
setlocale(LC_TIME, 'pl_PL.UTF-8');
if (isset($_GET["date_from"])) {
    $days = countDaysExcludingSundays($_GET["date_from"], $_GET["date_to"], HOLIDAYS);
} else {
    $days = 6;
}
if (isset($data["cargo_temp2"])) {
    foreach ($data["cargo_temp2"] as $company_id => $compval) {
        $mess2 .= "<table style='border: 1px solid'>
            <thead style='border: 1px solid'>
                <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                    <th colspan='12'>Raport szczegółowy sprzedaży - " . $data["shops"][$company_id]->full_name . "</th>
                </tr>
                <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                    <th style='border: 1px solid #000; width: 8%'>Produkt</th>
                    <th style='border: 1px solid #000; width: 8%'>Ilość dostarczona</th>
                    <th style='border: 1px solid #000; width: 8%'>Zwroty</th>
                    <th style='border: 1px solid #000; width: 8%'>Cena za sztukę (brutto)</th>
                    <th style='border: 1px solid #000; width: 8%'>Cena łączna do zapłaty</th>
                </tr>
            </thead>
            <tbody>";
        $total_sales = 0;
        $total_money = 0;

        $start = new DateTime($data["get"]["date_from"]);
        $end = new DateTime($data["get"]["date_to"]);

        $end = $end->modify('+1 day');

        $week_sales = 0;
        $week_money = 0;
        $week_returns = 0;
        for ($date2 = $start; $date2 < $end; $date2->modify('+1 day')) {
            $curdate = $date2->format('Y-m-d');
            $mess2 .= "     <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                                <th colspan='5'>$curdate (" . getPolishDayName($date2->format('N')) . ")</th>
                            </tr>";

            if (isset($compval[$curdate])) {
                $day_sales = 0;
                $day_money = 0;
                $day_returns = 0;
                foreach ($compval[$curdate] as $prod_id => $prod_data_detail) {
                    if ($prod_data_detail["amount"] > 0) {
                        if ($data["shops"][$company_id]->company_type == 2) {
                            if (isset($prod_data_detail["cost_zm"])) {
                                $cost3 = $prod_data_detail["cost_zm"];
                            } else {
                                $cost3 = $prod_data_detail["cost"];
                            }
                        } else {
                            if (isset($prod_data_detail["cost_f"])) {
                                $cost3 = $prod_data_detail["cost_f"];
                            } else {
                                $cost3 = $prod_data_detail["cost"];
                            }
                        }
                        $prod_returns = 0;
                        if (isset($data["returns"][$company_id][$curdate][$prod_id]["amount"])) {
                            $prod_returns = $data["returns"][$company_id][$curdate][$prod_id]["amount"];
                            $day_returns += $prod_returns;
                        }

                        $day_sales += $prod_data_detail["amount"];
                        $day_money += ($prod_data_detail["amount"] - $prod_returns) * $cost3;
                        $week_sales += $prod_data_detail["amount"];
                        $week_returns += $day_returns;
                        $week_money += ($prod_data_detail["amount"] - $prod_returns) * $cost3;
                        $mess2 .= "
                        <tr style='text-align: center;'>
                            <td style='border: 1px solid;'>" . $data["fullproducts"][$prod_id]["p_name"] . "</td>
                            <td style='border: 1px solid;'>" . $prod_data_detail["amount"] . "</td>
                            <td style='border: 1px solid;'>" . $prod_returns . "</td>
                            <td style='border: 1px solid;'>" . $cost3 . " zł</td>
                            <td style='border: 1px solid;'>" . ($prod_data_detail["amount"] - $prod_returns) * $cost3 . " zł</td>
                        </tr>";
                    }
                }
                $mess2 .= " <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                                <td style='border: 1px solid;'>TOTAL</td>
                                <td style='border: 1px solid;'>$day_sales</td>
                                <td style='border: 1px solid;'>$day_returns</td>
                                <td style='border: 1px solid;'>$curdate</td>
                                <td style='border: 1px solid;'>$day_money zł</td>
                            </tr>";
            } else {
                $mess2 .= " <tr style='text-align: center;'>
                                <td colspan='5'>Brak sprzedaży w tym dniu.</td>
                            </tr>";
            }
        }



        $mess2 .= "
            </tbody>
            <tfoot>
                <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                    <td style='border: 1px solid;'>TOTAL Z WYBRANEGO ZAKRESU</td>
                    <td style='border: 1px solid;'>$week_sales</td>
                    <td style='border: 1px solid;'></td>
                    <td style='border: 1px solid;'>$dates</td>
                    <td style='border: 1px solid;'>$week_money zł</td>
                </tr>
            </tfoot>
        </table>";
        $mess2 .= "</br>";
    }

}

$prodsku = [];



$mess3 = "";
if (isset($_GET["date_from"])) {
    $days = countDaysExcludingSundays($_GET["date_from"], $_GET["date_to"], HOLIDAYS);
} else {
    $days = 6;
}
if (!empty($prod)) {
    $mess3 .= "<table style='border: 1px solid'>
            <thead style='border: 1px solid'>
                <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                    <th colspan='12'>Raport sprzedaży produktów</th>
                </tr>
                <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                    <th style='border: 1px solid #000; width: 8%'>Produkt</th>
                    <th style='border: 1px solid #000; width: 8%'>Ilość dostarczona</th>
                    <th style='border: 1px solid #000; width: 8%'>Zwroty</th>
                    <th style='border: 1px solid #000; width: 8%'>Wartość zwrotów</th>
                    <th style='border: 1px solid #000; width: 8%'>Cena łączna do zapłaty</th>
                    <th style='border: 1px solid #000; width: 8%'>Dni pracujące</th>
                    <th style='border: 1px solid #000; width: 8%'>Średnia sprzedaż [na dzień]</th>
                    <th style='border: 1px solid #000; width: 8%'>Średnia zwrotów [na dzień]</th>
                </tr>
            </thead>
            <tbody>";
    $total_sales = 0;
    $total_money = 0;

    $start = new DateTime($data["get"]["date_from"]);
    $end = new DateTime($data["get"]["date_to"]);

    $end = $end->modify('+1 day');

    $week_sales = 0;
    $week_money = 0;
    $week_returns = 0;
    $week_retvar = 0;

    foreach ($prod as $prod_k => $prod_v) {
        $mess3 .= "
            <tr style='text-align: center;'>
                <td style='border: 1px solid;'>" . $data["fullproducts"][$prod_k]["p_name"] . "</td>
                <td style='border: 1px solid;'>" . $prod_v["amount"] . "</td>
                <td style='border: 1px solid;'>" . $prod_v["return"] . "</td>
                <td style='border: 1px solid;'>" . $prod_v["return_val"] . "</td>
                <td style='border: 1px solid;'>" . $prod_v["cost"] . " zł</td>
                <td style='border: 1px solid;'>" . $days . "</td>
                <td style='border: 1px solid;'>" . number_format(($prod_v["amount"] - $prod_v["return"]) / $days, 2) . "</td>
                <td style='border: 1px solid;'>" . number_format(($prod_v["return"]) / $days, 2) . "</td>
            </tr>";
        $week_sales += $prod_v["amount"];
        $week_money += $prod_v["cost"];
        $week_returns += $prod_v["return"];
        $week_retvar += $prod_v["return_val"];

        $sku = substr($data["fullproducts"][$prod_k]["sku"], 0, 4);
        if (!isset($prodsku[$sku])) {
            $prodsku[$sku]["amount"] = 0;
            $prodsku[$sku]["cost"] = 0;
            $prodsku[$sku]["return"] = 0;
            $prodsku[$sku]["return_val"] = 0;
        }
        $prodsku[$sku]["amount"] += $prod_v["amount"];
        $prodsku[$sku]["cost"] += $prod_v["cost"];
        $prodsku[$sku]["return"] += $prod_v["return"];
        $prodsku[$sku]["return_val"] += $prod_v["return_val"];


    }


    $mess3 .= "
            </tbody>
            <tfoot>
                <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                    <td style='border: 1px solid;'>TOTAL Z WYBRANEGO ZAKRESU</td>
                    <td style='border: 1px solid;'>$week_sales</td>
                    <td style='border: 1px solid;'>$week_returns</td>
                    <td style='border: 1px solid;'>$week_retvar zł</td>
                    <td style='border: 1px solid;'>$week_money zł</td>
                    <td style='border: 1px solid;'></td>
                    <td style='border: 1px solid;'>" . number_format(($week_sales - $week_returns) / $days, 2) . "</td>
                    <td style='border: 1px solid;'>" . number_format(($week_returns) / $days, 2) . "</td>
                </tr>
            </tfoot>
        </table>";
    $mess3 .= "</br>";
}

$mess4 = "";
if (!empty($prodsku)) {
    $mess4 .= "<table style='border: 1px solid'>
            <thead style='border: 1px solid'>
                <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                    <th colspan='12'>Raport sprzedaży produktów</th>
                </tr>
                <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                    <th style='border: 1px solid #000; width: 8%'>Produkt</th>
                    <th style='border: 1px solid #000; width: 8%'>Ilość dostarczona</th>
                    <th style='border: 1px solid #000; width: 8%'>Zwroty</th>
                    <th style='border: 1px solid #000; width: 8%'>Wartość zwrotów</th>
                    <th style='border: 1px solid #000; width: 8%'>Cena łączna do zapłaty</th>
                    <th style='border: 1px solid #000; width: 8%'>Dni pracujące</th>
                    <th style='border: 1px solid #000; width: 8%'>Średnia sprzedaż [na dzień]</th>
                    <th style='border: 1px solid #000; width: 8%'>Średnia zwrotów [na dzień]</th>
                </tr>
            </thead>
            <tbody>";
    $total_sales = 0;
    $total_money = 0;

    $start = new DateTime($data["get"]["date_from"]);
    $end = new DateTime($data["get"]["date_to"]);

    $end = $end->modify('+1 day');

    $week_sales = 0;
    $week_money = 0;
    $week_returns = 0;
    $week_retvar = 0;

    foreach ($prodsku as $prod_k => $prod_v) {
        $here_sku = str_replace("-", "_", $prod_k);
        $mess4 .= "
            <tr style='text-align: center;'>
                <td style='border: 1px solid;'>" . $data["sku"][$here_sku]->name . "</td>
                <td style='border: 1px solid;'>" . $prod_v["amount"] . "</td>
                <td style='border: 1px solid;'>" . $prod_v["return"] . "</td>
                <td style='border: 1px solid;'>" . $prod_v["return_val"] . " zł</td>
                <td style='border: 1px solid;'>" . $prod_v["cost"] . " zł</td>
                <td style='border: 1px solid;'>" . $days . "</td>
                <td style='border: 1px solid;'>" . number_format(($prod_v["amount"] - $prod_v["return"]) / $days, 2) . "</td>
                <td style='border: 1px solid;'>" . number_format(($prod_v["return"]) / $days, 2) . "</td>
                </tr>";
        $week_sales += $prod_v["amount"];
        $week_money += $prod_v["cost"];
        $week_returns += $prod_v["return"];
        $week_retvar += $prod_v["return_val"];
    }


    $mess4 .= "
            </tbody>
            <tfoot>
                <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                    <td style='border: 1px solid;'>TOTAL Z WYBRANEGO ZAKRESU</td>
                    <td style='border: 1px solid;'>$week_sales</td>
                    <td style='border: 1px solid;'>$week_returns</td>
                    <td style='border: 1px solid;'>$week_retvar zł</td>
                    <td style='border: 1px solid;'>$week_money zł</td>
                    <td style='border: 1px solid;'></td>
                    <td style='border: 1px solid;'>" . number_format(($week_sales - $week_returns) / $days, 2) . "</td>
                    <td style='border: 1px solid;'>" . number_format(($week_returns) / $days, 2) . "</td>
                </tr>
            </tfoot>
        </table>";
    $mess4 .= "</br>";
}
$mess5 = "";
if (!empty($prop)) {
    foreach ($prop as $company_id => $c_data) {
        $mess5 .= "<table style='border: 1px solid'>
                <thead style='border: 1px solid'>
                    <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
                        <th colspan='14'>Propozycja sprzedaży do sklepu: " . $c_data["name"] . "</th>
                    </tr>
                    <tr rowspan='2' style='background-color: #4a4a4a; color: #e6e6e6;'>
                        <th rowspan='2' style='border: 1px solid #000; width: 8%'>Produkt</th>
                        <th rowspan='2' style='border: 1px solid #000; width: 8%'>Ilość dostarczona</th>
                        <th rowspan='2' style='border: 1px solid #000; width: 8%'>Zwroty</th>
                        <th rowspan='2' style='border: 1px solid #000; width: 8%'>Dni pracujące (dni dostaw)</th>
                        <th rowspan='2' style='border: 1px solid #000; width: 8%'>Średnia sprzedaż [na dzień]</th>
                        <th rowspan='2' style='border: 1px solid #000; width: 8%'>Średnia zwrotów [na dzień]</th>
                        <th colspan='2' style='border: 1px solid #000; width: 8%'>Propozycja na 2 dni</th>
                        <th colspan='2' style='border: 1px solid #000; width: 8%'>Propozycja na 3 dni</th>
                    </tr>
                    <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
                        <th style='border: 1px solid #000; width: 8%'>Ilość</th>
                        <th style='border: 1px solid #000; width: 8%'>Wartość</th>
                        <th style='border: 1px solid #000; width: 8%'>Ilość</th>
                        <th style='border: 1px solid #000; width: 8%'>Wartość</th>
                    </tr>
                </thead>
                <tbody>";
        $total_sales = 0;
        $total_money = 0;

        $week_sales = 0;
        $week_money = 0;
        $week_returns = 0;
        $week_retvar = 0;
        $week_prop2 = 0;
        $week_prop2_avg = 0;
        $week_prop3 = 0;
        $week_prop3_avg = 0;
        $delivery_num = 0;

        foreach ($c_data["products"] as $prod_k => $prod_v) {
            $delivery_num = $prop[$company_id]["delivery"];
            $prop2 = $prod_v["avgsell"] * 2;
            $prop2_avg = round($prop2);
            $prop3 = $prod_v["avgsell"] * 3;
            $prop3_avg = round($prop3);
            $val2 = number_format($prod_v["cost"] * $prop2_avg, 2);
            $val3 = number_format($prod_v["cost"] * $prop3_avg, 2);


            $mess5 .= "
                <tr style='text-align: center;'>
                    <td style='border: 1px solid;'>" . $prod_v["name"] . "</td>
                    <td style='border: 1px solid;'>" . $prod_v["amount"] . "</td>
                    <td style='border: 1px solid;'>" . $prod_v["returns"] . "</td>
                    <td style='border: 1px solid;'>" . $prod_v["daysopen"] . " ($delivery_num)</td>
                    <td style='border: 1px solid;'>" . $prod_v["avgsell"] . "</td>
                    <td style='border: 1px solid;'>" . $prod_v["avgret"] . "</td>
                    <td style='border: 1px solid;'><b>" . $prop2_avg . "</b> ($prop2)</td>
                    <td style='border: 1px solid;'>" . $val2 . " zł</td>
                    <td style='border: 1px solid;'><b>" . $prop3_avg . "</b> ($prop3)</td>
                    <td style='border: 1px solid;'>" . $val3 . " zł</td>
                    </tr>";
            $week_sales += $prod_v["amount"];
            $week_returns += $prod_v["returns"];
            $week_prop2 += $val2;
            $week_prop2_avg += $prop2_avg;
            $week_prop3 += $val3;
            $week_prop3_avg += $prop3_avg;
        }


        $mess5 .= "
                </tbody>
                <tfoot>
                    <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                        <td style='border: 1px solid;'>TOTAL</td>
                        <td style='border: 1px solid;'>$week_sales</td>
                        <td style='border: 1px solid;'>$week_returns</td>
                        <td style='border: 1px solid;'></td>
                        <td style='border: 1px solid;'></td>
                        <td style='border: 1px solid;'></td>
                        <td style='border: 1px solid;'>$week_prop2_avg</td>
                        <td style='border: 1px solid;'>$week_prop2 zł</td>
                        <td style='border: 1px solid;'>$week_prop3_avg</td>
                        <td style='border: 1px solid;'>$week_prop3 zł</td>
                    </tr>
                </tfoot>
            </table>";
        $mess5 .= "</br>";
    }
}





if (isset($_GET["prop"])) {
    echo "</br></br>";
    echo "<h2>Propozycja ilości dla sklepów</h2>";
    echo "</br></br>";
    echo $mess5;

    //show($prop);
    die;

} else {
    echo $mess;

    /*echo "</br></br>";
    echo "<h2>Szczegółowe dane o sprzedaży</h2>";
    echo "</br></br>";
    echo $mess2;*/

    echo "</br></br>";
    echo "<h2>Szczegółowe dane o sprzedaży produktów</h2>";
    echo "</br></br>";
    echo $mess3;

    echo "</br></br>";
    echo "<h2>Szczegółowe dane o sprzedaży produktów - pogrupowane</h2>";
    echo "</br></br>";
    echo $mess4;

    //show($prod);

    //tu dodać szczegółowy, czyli po firmie i każdy dzień osobno
}



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