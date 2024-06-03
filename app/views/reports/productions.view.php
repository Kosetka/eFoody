<?php 
$send = $data["get"]["send"];

if($send == 2) {
    if($data["get"]["type"] == "day") {
        $f1 = "dzień";
    }
    if($data["get"]["type"] == "week") {
        $f1 = "zakres dat";
    }
    if($data["get"]["type"] == "month") {
        $f1 = "miesiąc";
    }
    $num_traders = 0;
    foreach($data["users"] as $trader) {
        $num_traders++;
    }

    echo '<form method="get">';

    echo '<h1 class="h3 mb-3 fw-normal">Wybierz '.$f1.' do wyświetlenia raportu:</h1>';
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
                        if($data["get"]["type"] == "day") {
                       
            echo '  <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Dzień:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="'.$date_from.'" required>
                        </div>
                    </div>';
                        }
                        if($data["get"]["type"] == "week") {
                          
            echo '  <div class="form-group row m-3">
                        <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="'.$date_from.'" required>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="'.$date_to.'" required>
                        </div>
                    </div>';
                        }
                        if($data["get"]["type"] == "month") {
                        
            echo '  <div class="form-group row m-3">
            <label for="date_from" class="col-sm-2 col-form-label">Miesiąc:</label>
            <div class="col-sm-4">
                <select class="form-control" id="date_from" name="date_from" required>';
                    for ($month = 1; $month <= 12; $month++) {
                        echo '<option value="' . $month . '">' . date("F", mktime(0, 0, 0, $month, 1)) . '</option>';
                    }
                    
               echo '</select>
            </div>
        </div>';
        
        echo '<div class="form-group row m-3">
            <label for="date_to" class="col-sm-2 col-form-label">Rok:</label>
            <div class="col-sm-4">
                <select class="form-control" id="date_to" name="date_to" required>';
                    for ($year = 2024; $year <= 2025; $year++) {
                        echo '<option value="' . $year . '">' . $year . '</option>';
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
                            echo "document.getElementById('date_from').setAttribute('value', currentDate);";
                        }
                        if (!isset($data["date_to"])) {
                            echo "document.getElementById('date_to').setAttribute('value', currentDate);";
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
    $dates = $new_date_format_from." - ".$new_date_format_to;
}
if ($data["get"]["type"] == "month") {
    $month = date("F Y", strtotime($data["get"]["date_from"]));
    $dates = $month;
}

$planned_array = [];

foreach($data["planned"] as $plan) {
    foreach($data["users"] as $trader) {
        $planned_array[$plan["p_id"]][$trader->id] = 0;
        $planned_array[$plan["p_id"]]["total"] = 0;
    }
}
foreach($data["planned"] as $plan) {
    $planned_array[$plan["p_id"]][$plan["u_id"]] += $plan["amount"];
    $planned_array[$plan["p_id"]]["total"] += $plan["amount"];
}



show($planned_array);





$num_rows = $num_traders*2+4;
$mess = "<table style='border: 1px solid'>
    <thead style='border: 1px solid'>
        <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
            <th colspan='$num_rows'>Raport $name produkcji - $dates</th>
        </tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            <th rowspan='2' style='border: 1px solid #000; width: 6%'>Produkty</th>
            <th rowspan='2' style='border: 1px solid #000; width: 6%'>SKU</th>
            <th rowspan='2'style='border: 1px solid #000; width: 6%'>Plan. | Prod. | Wyd.</th>
            <th rowspan='2' style='border: 1px solid #000; width: 10%'>Prod. / Plan. | Wyd. / Prod.</th>";
            foreach($data["users"] as $trader) {
                $mess.= "<th colspan='2' style='border: 1px solid #000; width: 12%'>$trader->first_name $trader->last_name</th>";
            }
        $mess.= "</tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            ";
            foreach($data["users"] as $trader) {
                $mess.= "<th style='border: 1px solid #000; width: 6%'>Plan. | Prod. | Wyd.</th>";
                $mess.= "<th style='border: 1px solid #000; width: 6%'>%</th>";
            }
            show($data["planned"]);
$mess.= "</tr>
    </thead>
    <tbody>";
        foreach($planned_array as $product_key => $product_val) {
            $mess.="
        <tr style='text-align: center;'>
            <td style='border: 1px solid;'>".$data["fullproducts"][$product_key]["p_name"]."</td>
            <td style='border: 1px solid;'>".$data["fullproducts"][$product_key]["sku"]."</td>
            <td style='border: 1px solid;'>".$product_val["total"]." |  | </td>
            <td style='border: 1px solid;'>".getPercent($sales, $stan)."%</td>";
        foreach($data["users"] as $trader) {
            $mess.= "<td style='border: 1px solid #000;'>".$product_val[$trader->id]." | 0 | 0</td>";
            $mess.= "<td style='border: 1px solid #000;'>100% | 100%</td>";

        }
        $mess.= "</tr>";
        }
        $mess.="
    </tbody>
    <tfoot>
        <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
            <td style='border: 1px solid;'>TOTAL</td>
            <td style='border: 1px solid;'>$total_sales</td>
            <td style='border: 1px solid;'>$total_stan2</td>
            <td style='border: 1px solid;'>".getPercent($total_sales,$total_stan)."%</td>";
        foreach($data["users"] as $trader) {
            $mess.= "<td style='border: 1px solid #000;'>0 | 0 | 0</td>";
            $mess.= "<td style='border: 1px solid #000;'>100% | 100%</td>";

        }

        /*    <td style='border: 1px solid;'>$total_visit</td>
            <td style='border: 1px solid;'>$total_companies</td>
            <td style='border: 1px solid;'>".getPercent($total_visit,$total_companies)."%</td>
            <td style='border: 1px solid;'>$total_cargo</td>
            <td style='border: 1px solid;'>".$total_plus - $total_minus."</td>
            <td style='border: 1px solid;'>$total_destroy</td>
            <td style='border: 1px solid;'>$total_returns</td>
            <td style='border: 1px solid;'>$total_gratis</td>*/
        $mess.= "</tr>
    </tfoot>
</table>";

    
    echo $mess;
?>



<?php
$to = 'mateusz.zybura@radluks.pl';
$subject = "Raport $name produkcji - $dates";

if($send == 1) {
    $mailer = new Mailer($to, $subject, $mess);
    if ($mailer->send()) {
        echo 'Wiadomość została wysłana pomyślnie.';
    } else {
        echo 'Wystąpił problem podczas wysyłania wiadomości. Błąd: ' . print_r($mailer->getLastError(), true);
    }
}
?>

