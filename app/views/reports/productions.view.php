<?php

$send = $data["get"]["send"];
$num_traders = 0;
foreach ($data["users"] as $trader) {
    $num_traders++;
}
if ($send == 2) {
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

$planned_array = [];
$producted_array = [];
$cargo_array = [];
$split_array = [];

if (isset($data["planned"])) {
    if (isset($data["users"])) {
        foreach ($data["planned"] as $plan) {
            foreach ($data["users"] as $trader) {
                $planned_array[$plan["p_id"]][$trader->id] = 0;
                $planned_array[$plan["p_id"]]["total"] = 0;
                $producted_array["total"] = 0;
                $producted_array[$plan["p_id"]] = 0;
                $cargo_array[$plan["p_id"]][$trader->id] = 0;
                $cargo_array[$plan["p_id"]]["total"] = 0;
                $split_array[$plan["p_id"]][$trader->id] = 0;
                $split_array[$plan["p_id"]]["total"] = 0;
            }
        }
    }
}
if (isset($data["planned"])) {
    foreach ($data["planned"] as $plan) {
        if (!isset($planned_array[$plan["p_id"]][$plan["u_id"]])) {
            $planned_array[$plan["p_id"]][$plan["u_id"]] = 0;
        }
        $planned_array[$plan["p_id"]][$plan["u_id"]] += $plan["amount"];
        if (!isset($planned_array[$plan["p_id"]]["total"])) {
            $planned_array[$plan["p_id"]]["total"] = 0;
        }
        $planned_array[$plan["p_id"]]["total"] += $plan["amount"];
    }
}

if (isset($data["planned"])) {
    if (isset($data["producted"])) {
        foreach ($data["producted"] as $plan) {
            if (!isset($producted_array[$plan["p_id"]])) {
                $producted_array[$plan["p_id"]] = 0;
            }
            if (!isset($producted_array["total"])) {
                $producted_array["total"] = 0;
            }
            $producted_array[$plan["p_id"]] += $plan["amount"];
            $producted_array["total"] += $plan["amount"];
        }
    }
}

if (isset($data["planned"])) {
    if (isset($data["cargo"])) {
        foreach ($data["cargo"] as $plan) {
            foreach ($data["users"] as $trader) {
                if ($plan["u_id"] == $trader->id) {
                    if (!isset($cargo_array[$plan["p_id"]][$trader->id])) {
                        $cargo_array[$plan["p_id"]][$trader->id] = 0;
                    }
                    if (!isset($cargo_array[$plan["p_id"]]["total"])) {
                        $cargo_array[$plan["p_id"]]["total"] = 0;
                    }
                    $cargo_array[$plan["p_id"]][$trader->id] += $plan["amount"];
                    $cargo_array[$plan["p_id"]]["total"] += $plan["amount"];
                }
            }
        }
    }
}

if (isset($data["planned"])) {
    if (isset($data["split"])) {
        foreach ($data["split"] as $plan) {
            foreach ($data["users"] as $trader) {
                if ($plan["u_id"] == $trader->id) {
                    if (!isset($split_array[$plan["p_id"]][$trader->id])) {
                        $split_array[$plan["p_id"]][$trader->id] = 0;
                    }
                    if (!isset($split_array[$plan["p_id"]]["total"])) {
                        $split_array[$plan["p_id"]]["total"] = 0;
                    }
                    $split_array[$plan["p_id"]][$trader->id] += $plan["amount"];
                    $split_array[$plan["p_id"]]["total"] += $plan["amount"];
                }
            }
        }
    }
}



$total_prod = [];
foreach ($producted_array as $prod_key => $prod_val) {
    if (!isset($total_prod[$prod_key])) {
        $total_prod[$prod_key] = 0;
    }
    $total_prod[$prod_key] += $prod_val;

}


$sum_prod = 0;
$sum_cargo = 0;
$sum_wyd = [];
$sum_split = [];
$num_rows = $num_traders * 3 + 8;
$mess = "<table style='border: 1px solid'>
    <thead style='border: 1px solid'>
        <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
            <th colspan='$num_rows'>Raport $name produkcji - $dates</th>
        </tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            <th rowspan='2' style='border: 1px solid #000; width: 6%'>Produkty</th>
            <th rowspan='2' style='border: 1px solid #000; width: 6%'>SKU</th>
            <th rowspan='2'style='border: 1px solid #000; '>Wydane</th>
            <th rowspan='2'style='border: 1px solid #000; '>Przygotowane</th>
            <th rowspan='2'style='border: 1px solid #000; '>Planowane</th>
            <th rowspan='2' style='border: 1px solid #000; width: 4%'>PR/PL %</th>
            <th rowspan='2' style='border: 1px solid #000; width: 4%'>W/PL%</th>
            <th rowspan='2' style='border: 1px solid #000; width: 4%'>W/PR%</th>";
foreach ($data["users"] as $trader) {
    $mess .= "<th colspan='3' style='border: 1px solid #000; width: 12%'>$trader->first_name $trader->last_name</th>";
}
$mess .= "</tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            ";
foreach ($data["users"] as $trader) {
    $mess .= "<th style='border: 1px solid #000; '>Wyd.</th>";
    $mess .= "<th style='border: 1px solid #000; '>Plan.</th>";
    $mess .= "<th style='border: 1px solid #000; '>W/P%</th>";
}
$mess .= "</tr>
    </thead>
    <tbody>";

foreach ($planned_array as $product_key => $product_val) {
    $row_num = 0;
    if (fmod($row_num, 2) == 0) {
        $even = true;
    } else {
        $even = false;
    }
    $sum_prod += $product_val["total"];
    $sum_cargo += $cargo_array[$product_key]["total"];

    $wpr = "";
    if (getPercent($cargo_array[$product_key]["total"], $total_prod[$product_key], 1) != 100) {
        $wpr = " background-color: red;";
    }

    $mess .= "
        <tr style='text-align: center;'>
            <td style='border: 1px solid;'>" . $data["fullproducts"][$product_key]["p_name"] . "</td>
            <td style='border: 1px solid;'>" . $data["fullproducts"][$product_key]["sku"] . "</td>
            <td style='border: 1px solid;'>" . $cargo_array[$product_key]["total"] . "</td>
            <td style='border: 1px solid;'>" . $total_prod[$product_key] . "</td>
            <td style='border: 1px solid;'>" . $product_val["total"] . "</td>
            <td style='border: 1px solid;'>" . getPercent($total_prod[$product_key], $product_val["total"], 1) . "%</td>
            <td style='border: 1px solid;'>" . getPercent($cargo_array[$product_key]["total"], $product_val["total"], 1) . "%</td>
            <td style='border: 1px solid; $wpr'>" . getPercent($cargo_array[$product_key]["total"], $total_prod[$product_key], 1) . "%</td>";
    foreach ($data["users"] as $trader) {
        if (!isset($sum_wyd[$trader->id])) {
            $sum_wyd[$trader->id] = 0;
        }
        if (!isset($sum_split[$trader->id])) {
            $sum_split[$trader->id] = 0;
        }
        $sum_wyd[$trader->id] += $cargo_array[$product_key][$trader->id];
        $sum_split[$trader->id] += $split_array[$product_key][$trader->id];

        $bg_color = "";
        if ($even == true) {
            $even = false;
            $bg_color = " background-color: lightgray;";
        } else {
            $even = true;
        }

        $mess .= "<td style='border: 1px solid; " . $bg_color . "'>" . $cargo_array[$product_key][$trader->id] . "</td>";
        $mess .= "<td style='border: 1px solid; " . $bg_color . "'>" . $split_array[$product_key][$trader->id] . "</td>";
        $mess .= "<td style='border: 1px solid; " . $bg_color . "'>" . getPercent($cargo_array[$product_key][$trader->id], $split_array[$product_key][$trader->id], 1) . "%</td>";

    }
    $mess .= "</tr>";
    $row_num += 1;
}

$mess .= "
    </tbody>";
if (isset($data["planned"])) {
    $wpr = "";
    if (getPercent($sum_cargo, $total_prod["total"], 1) != 100) {
        $wpr = " background-color: red;";
    }
    $mess .= "<tfoot>
            <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                <td colspan='2' style='border: 1px solid;'>TOTAL</td>
                <td style='border: 1px solid;'>" . $sum_cargo . "</td>
                <td style='border: 1px solid;'>" . $total_prod["total"] . "</td>
                <td style='border: 1px solid;'>" . $sum_prod . "</td>
                <td style='border: 1px solid;'>" . getPercent($total_prod["total"], $sum_prod, 1) . "%</td>
                <td style='border: 1px solid;'>" . getPercent($sum_cargo, $sum_prod, 1) . "%</td>
                <td style='border: 1px solid; $wpr'>" . getPercent($sum_cargo, $total_prod["total"], 1) . "%</td>";
    $even = true;
    foreach ($data["users"] as $trader) {
        $bg_color = "";
        if ($even == true) {
            $even = false;
            $bg_color = " background-color: gray;";
        } else {
            $even = true;
        }
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "'>" . $sum_wyd[$trader->id] . "</td>";
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "'>" . $sum_split[$trader->id] . "</td>";
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "'>" . getPercent($sum_wyd[$trader->id], $sum_split[$trader->id], 1) . "%</td>";

    }

    /*    <td style='border: 1px solid;'>$total_visit</td>
        <td style='border: 1px solid;'>$total_companies</td>
        <td style='border: 1px solid;'>".getPercent($total_visit,$total_companies)."%</td>
        <td style='border: 1px solid;'>$total_cargo</td>
        <td style='border: 1px solid;'>".$total_plus - $total_minus."</td>
        <td style='border: 1px solid;'>$total_destroy</td>
        <td style='border: 1px solid;'>$total_returns</td>
        <td style='border: 1px solid;'>$total_gratis</td>*/
    $mess .= "</tr>
        </tfoot>";
}
$mess .= "</table>";


echo $mess;
?>



<?php
$to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
$subject = "Raport $name produkcji - $dates";

if ($send == 1) {
    $mailer = new Mailer($to, $subject, $mess);
    if (SEND_ON === true) {
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

