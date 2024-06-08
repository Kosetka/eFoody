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
$prices_producted_array = [];
$prices_producted_price_array = [];
$prices_producted_cost_array = [];
$prices_cargo_price_array = [];
$prices_cargo_cost_array = [];
$prices_returns_array = [];
$prices_returns_amount_array = [];

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
                $prices_cargo_price_array[$plan["p_id"]][$trader->id] = 0;
                $prices_cargo_price_array[$plan["p_id"]]["total"] = 0;
                $prices_cargo_cost_array[$plan["p_id"]][$trader->id] = 0;
                $prices_cargo_cost_array[$plan["p_id"]]["total"] = 0;
                $prices_returns_array[$plan["p_id"]][$trader->id] = 0;
                $prices_returns_array[$trader->id]["total"] = 0;
                $prices_returns_amount_array[$plan["p_id"]][$trader->id] = 0;
                $prices_returns_amount_array[$trader->id]["total"] = 0;
            }
            $prices_producted_price_array[$plan["p_id"]] = 0;
            $prices_producted_price_array["total"] = 0;
            $prices_producted_cost_array[$plan["p_id"]] = 0;
            $prices_producted_cost_array["total"] = 0;
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

            if (isset($data["prices"][$plan["p_id"]])) {
                foreach ($data["prices"][$plan["p_id"]] as $price_temp) { //ustawienie cen wyproduwanych produktów
                    if ($plan["date_producted"] >= $price_temp->date_from && $plan["date_producted"] <= $price_temp->date_to) {

                        $prices_producted_cost_array[$plan["p_id"]] += $price_temp->total_production_cost * $plan["amount"];
                        $prices_producted_cost_array["total"] += $price_temp->total_production_cost * $plan["amount"];
                    }
                }
            }
        }
    }
}

if (isset($data["planned"])) {
    if (isset($data["returns"])) {
        foreach ($data["returns"] as $prod_key => $prod_val) {
            foreach ($prod_val as $usr_key => $usr_val) {
                //show($usr_key);
                foreach ($usr_val as $pri) {
                    $prices_returns_array[$prod_key][$usr_key] += $pri->amount;
                    $prices_returns_array[$usr_key]["total"] += $pri->amount;
                    if (isset($data["prices"][$prod_key])) {
                        foreach ($data["prices"][$prod_key] as $price_temp) {
                            if ($pri->date >= $price_temp->date_from && $pri->date <= $price_temp->date_to) {
                                $prices_returns_amount_array[$prod_key][$usr_key] += $pri->amount * $price_temp->total_price;
                                $prices_returns_amount_array[$usr_key]["total"] += $pri->amount * $price_temp->total_price;
                            }
                        }
                    }
                }
            }
        }
    }
}
//show($prices_returns_amount_array);

//show($prices_producted_price_array); <- spodziewany utarg z WYPRODUKOWANYCH
//show($prices_producted_cost_array); <- koszt z WYPRODUKOWANYCH

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

                    if (isset($data["prices"][$plan["p_id"]])) {
                        foreach ($data["prices"][$plan["p_id"]] as $price_temp) { //ustawienie cen wyproduwanych produktów
                            if ($plan["date"] >= $price_temp->date_from && $plan["date"] <= $price_temp->date_to) {
                                if (!isset($prices_cargo_price_array[$plan["p_id"]][$trader->id])) {
                                    $prices_cargo_price_array[$plan["p_id"]][$trader->id] = 0;
                                }
                                if (!isset($prices_cargo_price_array[$trader->id]["total"])) {
                                    $prices_cargo_price_array[$trader->id]["total"] = 0;
                                }
                                if (!isset($prices_cargo_cost_array[$plan["p_id"]][$trader->id])) {
                                    $prices_cargo_cost_array[$plan["p_id"]][$trader->id] = 0;
                                }
                                if (!isset($prices_cargo_cost_array[$trader->id]["total"])) {
                                    $prices_cargo_cost_array[$trader->id]["total"] = 0;
                                }
                                $prices_cargo_price_array[$plan["p_id"]][$trader->id] += $price_temp->total_price * $plan["amount"];
                                $prices_cargo_price_array[$trader->id]["total"] += $price_temp->total_price * $plan["amount"];
                                $prices_cargo_cost_array[$plan["p_id"]][$trader->id] += $price_temp->total_production_cost * $plan["amount"];
                                $prices_cargo_cost_array[$trader->id]["total"] += $price_temp->total_production_cost * $plan["amount"];
                                $prices_producted_price_array[$plan["p_id"]] += $price_temp->total_price * $plan["amount"];
                                $prices_producted_price_array["total"] += $price_temp->total_price * $plan["amount"];
                            }
                        }
                    }
                }
            }
        }
    }
}

//show($prices_cargo_price_array); //<- spodziewany utarg z pobranych przez handlowca
//show($prices_cargo_cost_array); //<- koszt z pobranych przez handlowca

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

if (isset($data["planned"])) {
    if (isset($data["sales"]["gratis"])) {
        foreach ($data["sales"]["gratis"] as $prod_key => $prod_val) {
            foreach ($prod_val as $usr_key => $usr_val) {
                //show($data["sales"]["gratis"]);
                foreach ($usr_val as $pri) {
                    if (!isset($t_gratis["user"][$prod_key]["total"])) {
                        $t_gratis["user"][$prod_key]["total"] = 0;
                    }
                    $t_gratis["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_gratis[$usr_key]["user"]["total"])) {
                        $t_gratis["user"][$prod_key]["total"] = 0;
                    }
                    $t_gratis["user"][$prod_key]["total"] += $pri->s_amount;

                    if (!isset($t_gratis["user"][$prod_key]["total"])) {
                        $t_gratis["user"][$prod_key]["total"] = 0;
                    }
                    $t_gratis["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_gratis[$prod_key][$pri->u_id])) {
                        $t_gratis[$prod_key][$pri->u_id] = 0;
                    }
                    $t_gratis[$prod_key][$pri->u_id] += $pri->s_amount;
                    if (!isset($t_gratis[$usr_key]["user"]["total"])) {
                        $t_gratis["user"][$prod_key]["total"] = 0;
                    }
                    $t_gratis["user"][$prod_key]["total"] += $pri->s_amount;
                    if (isset($data["prices"][$prod_key])) {
                        foreach ($data["prices"][$prod_key] as $price_temp) {
                            if ($pri->date >= $price_temp->date_from && $pri->date <= $price_temp->date_to) {
                                if (!isset($t_gratis_amount["user"][$prod_key]["total"])) {
                                    $t_gratis_amount["user"][$prod_key]["total"] = 0;
                                }
                                $t_gratis_amount["user"][$prod_key]["total"] += $pri->s_amount * $price_temp->total_price; //total_production_cost


                                if (!isset($t_gratis_amount[$prod_key][$pri->u_id])) {
                                    $t_gratis_amount[$prod_key][$pri->u_id] = 0;
                                }
                                $t_gratis_amount[$prod_key][$pri->u_id] += $pri->s_amount * $price_temp->total_price; //total_production_cost
                            }
                        }
                    }
                }
            }
        }
    }
}


if (isset($data["planned"])) {
    if (isset($data["sales"]["destroy"])) {
        foreach ($data["sales"]["destroy"] as $prod_key => $prod_val) {
            foreach ($prod_val as $usr_key => $usr_val) {
                //show($data["sales"]["destroy"]);
                foreach ($usr_val as $pri) {
                    if (!isset($t_destroy["user"][$prod_key]["total"])) {
                        $t_destroy["user"][$prod_key]["total"] = 0;
                    }
                    $t_destroy["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_destroy[$prod_key][$pri->u_id])) {
                        $t_destroy[$prod_key][$pri->u_id] = 0;
                    }
                    $t_destroy[$prod_key][$pri->u_id] += $pri->s_amount;
                    if (!isset($t_destroy[$usr_key]["user"]["total"])) {
                        $t_destroy["user"][$prod_key]["total"] = 0;
                    }
                    $t_destroy["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_destroy["total"][$pri->u_id])) {
                        $t_destroy["total"][$pri->u_id] = 0;
                    }
                    $t_destroy["total"][$pri->u_id] += $pri->s_amount;
                    if (isset($data["prices"][$prod_key])) {
                        foreach ($data["prices"][$prod_key] as $price_temp) {
                            if ($pri->date >= $price_temp->date_from && $pri->date <= $price_temp->date_to) {
                                if (!isset($t_destroy_amount["user"][$prod_key]["total"])) {
                                    $t_destroy_amount["user"][$prod_key]["total"] = 0;
                                }
                                $t_destroy_amount["user"][$prod_key]["total"] += $pri->s_amount * $price_temp->total_price; //total_production_cost

                                if (!isset($t_destroy_amount[$prod_key][$pri->u_id])) {
                                    $t_destroy_amount[$prod_key][$pri->u_id] = 0;
                                }
                                $t_destroy_amount[$prod_key][$pri->u_id] += $pri->s_amount * $price_temp->total_price; //total_production_cost
                            }
                        }
                    }
                }
            }
        }
    }
}
//show($t_destroy_amount);
//realne dane sprzedaży zaraportowanej
if (isset($data["planned"])) {
    if (isset($data["sales"]["scan"])) {
        foreach ($data["sales"]["scan"] as $prod_key => $prod_val) {
            foreach ($prod_val as $usr_key => $usr_val) {
                //show($data["sales"]["scan"]);
                foreach ($usr_val as $pri) {
                    if (!isset($t_scan["user"][$prod_key]["total"])) {
                        $t_scan["user"][$prod_key]["total"] = 0;
                    }
                    $t_scan["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_scan[$usr_key]["user"]["total"])) {
                        $t_scan["user"][$prod_key]["total"] = 0;
                    }
                    $t_scan["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_scan[$usr_key]["user"]["total"])) {
                        $t_scan["user"][$prod_key]["total"] = 0;
                    }
                    $t_scan["user"][$prod_key]["total"] += $pri->s_amount;
                    if (!isset($t_scan["total"][$pri->u_id])) {
                        $t_scan["total"][$pri->u_id] = 0;
                    }
                    $t_scan["total"][$pri->u_id] += $pri->s_amount;
                    if (isset($data["prices"][$prod_key])) {
                        foreach ($data["prices"][$prod_key] as $price_temp) {
                            if ($pri->date >= $price_temp->date_from && $pri->date <= $price_temp->date_to) {
                                if (!isset($t_scan_amount["user"][$prod_key]["total"])) {
                                    $t_scan_amount["user"][$prod_key]["total"] = 0;
                                }
                                $t_scan_amount["user"][$prod_key]["total"] += $pri->s_amount * $price_temp->total_price; //total_production_cost


                                if (!isset($t_scan_amount[$prod_key][$pri->u_id])) {
                                    $t_scan_amount[$prod_key][$pri->u_id] = 0;
                                }
                                $t_scan_amount[$prod_key][$pri->u_id] += $pri->s_amount * $price_temp->total_price; //total_production_cost
                            }
                        }
                    }
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
$num_rows = $num_traders * 4 + 8;
$mess = "<table style='border: 1px solid'>
    <thead style='border: 1px solid'>
        <tr style='background-color: #4a4a4a; color: #e6e6e6; font-size: 26px'>
            <th colspan='$num_rows'>Raport $name rentowności - $dates</th>
        </tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            <th rowspan='2' style='border: 1px solid #000; width: 6%'>Produkty</th>
            <th rowspan='2' style='border: 1px solid #000; width: 6%'>SKU</th>
            <th rowspan='2' style='border: 1px solid #000; ' title='Wydane - ilość wydana przez kuchnię dla handlowców; Wyprodukowane - ilość wyprodukowanych potrwa przez kuchnię'>Wydane (Wyprodukowane)</th>
            <th colspan='5' style='border: 1px solid #000; '>TOTAL</th>";
foreach ($data["users"] as $trader) {
    $mess .= "<th colspan='4' style='border: 1px solid #000; width: 12%'>$trader->first_name $trader->last_name</th>";
}
$mess .= "</tr>
        <tr style='background-color: #4a4a4a; color: #e6e6e6;'>
            ";
$mess .= "<th style='border: 1px solid #000; ' title='Spodziewany utarg na podstawie ilości wydanych potrwa i ceny ich sprzedaży'>Spodziewany utarg</th>";
$mess .= "<th style='border: 1px solid #000; ' title='Koszt obliczony na podstawie wyprodukowanych potrwa i ich ceny produkcji'>Koszt produkcji</th>";
$mess .= "<th style='border: 1px solid #000; ' title='Suma z towaru, który nie został sprzedany (Zwroty), rozdane prezenty (gratis), uszkodzone opakowania (zniszczone). Dla każdego produktu strata liczona po cenie sprzedaży'>Straty</th>";
$mess .= "<th style='border: 1px solid #000; ' title='Ilość produktów wyprodukowanych minus straty, pomnożone przez cenę sprzedaży'>Utarg</th>";
$mess .= "<th style='border: 1px solid #000; ' title='Spodziewany utarg minus Straty minus koszt produkcji'>Rentowność</th>";
foreach ($data["users"] as $trader) {
    $mess .= "<th style='border: 1px solid #000; ' title='Ilość potraw pobrana z kuchni'>Pobrane</th>";
    $mess .= "<th style='border: 1px solid #000; ' title='Pobrane potrawy pomnożone przez ich cenę'>Sp. utarg</th>";
    $mess .= "<th style='border: 1px solid #000; ' title='Suma potraw, które nie zostały sprzedane plus prezenty plus uszkodzenia'>Straty</th>";
    $mess .= "<th style='border: 1px solid #000; ' title='Spodziewany utarg minus straty'>Utarg</th>";
}
$mess .= "</tr>
    </thead>
    <tbody>";
$sum_waste_destroyed = 0;
$sum_waste_gratis = 0;
$sum_waste_return = 0;
$sum_rent = 0;
$sum_waste_destroyed_num = 0;
$sum_waste_gratis_num = 0;
$sum_waste_return_num = 0;
$sum_rent_num = 0;
foreach ($planned_array as $product_key => $product_val) {
    $row_num = 0;
    if (fmod($row_num, 2) == 0) {
        $even = true;
    } else {
        $even = false;
    }
    $sum_prod += $product_val["total"];
    $sum_cargo += $cargo_array[$product_key]["total"];

    $price_planned = 0;

    $title = "";
    $color_name = "";
    if (isset($data["prices"][$product_key])) {
        foreach ($data["prices"][$product_key] as $prprr) {
            $title .= "[Cena sprzedaży: " . $prprr->total_price . "; Koszt produkcji: " . $prprr->total_production_cost . "; Okres obowiązywania: " . $prprr->date_from . " -> " . $prprr->date_to . "] ";
        }
        $color_name = "";
    } else {
        $title = "Brak danych";
        $color_name = " background-color: red;";
    }


    $tot_waste_destroyed = 0;
    if (isset($t_destroy_amount["user"][$product_key]["total"])) {
        $tot_waste_destroyed = $t_destroy_amount["user"][$product_key]["total"];
    }
    $tot_waste_gratis = 0;
    if (isset($t_gratis_amount["user"][$product_key]["total"])) {
        $tot_waste_gratis = $t_gratis_amount["user"][$product_key]["total"];
    }
    $tot_waste_return = 0;
    $tot_rent = 0;
    $tot_waste_destroyed_num = 0;
    if (isset($t_destroy["user"][$product_key]["total"])) {
        $tot_waste_destroyed_num = $t_destroy["user"][$product_key]["total"];
    }
    $tot_waste_gratis_num = 0;
    if (isset($t_gratis["user"][$product_key]["total"])) {
        $tot_waste_gratis_num = $t_gratis["user"][$product_key]["total"];
    }
    $tot_waste_return_num = 0;
    $tot_rent_num = 0;

    //utarg u handlowców po faktycznej sprzedaży?
    // utarg total też po faktycznejh sprzedaży?

    foreach ($data["users"] as $trader) {
        $tot_waste_return += $prices_returns_amount_array[$product_key][$trader->id];
        $tot_waste_return_num += $prices_returns_array[$product_key][$trader->id];//tu obliczać gratisy i zniszczenia w TOTAL
    }

    $tot_waste_tot = $tot_waste_destroyed + $tot_waste_gratis + $tot_waste_return;
    $tot_waste_tot_num = $tot_waste_destroyed_num + $tot_waste_gratis_num + $tot_waste_return_num;

    $sum_waste_return += $tot_waste_return;
    $sum_waste_return_num += $tot_waste_return_num;

    $sum_waste_gratis += $tot_waste_gratis;
    $sum_waste_gratis_num += $tot_waste_gratis_num;

    $sum_waste_destroyed += $tot_waste_destroyed;
    $sum_waste_destroyed_num += $tot_waste_destroyed_num;

    $sum_waste_return_tot = $sum_waste_destroyed + $sum_waste_gratis + $sum_waste_return;
    $sum_waste_return_num_tot = $sum_waste_destroyed_num + $sum_waste_gratis_num + $sum_waste_return_num;


    $waste_title = "Zwroty: " . $tot_waste_return_num . " -> " . $tot_waste_return . "zł 
Gratisy: " . $tot_waste_gratis_num . " -> " . $tot_waste_gratis . "zł 
Zniszczenia: " . $tot_waste_destroyed_num . " -> " . $tot_waste_destroyed . "zł";

    $color_cargo = "";
    if ($cargo_array[$product_key]["total"] <> $total_prod[$product_key]) {
        $color_cargo = " background-color: yellow;";
    }
    $mess .= "
        <tr style='text-align: center;'>
            <td style='border: 1px solid; $color_name' title='$title'>" . $data["fullproducts"][$product_key]["p_name"] . "</td>
            <td style='border: 1px solid;'>" . $data["fullproducts"][$product_key]["sku"] . "</td>
            <td style='border: 1px solid; $color_cargo'>" . $cargo_array[$product_key]["total"] . " (" . $total_prod[$product_key] . ")</td>
            <td style='border: 1px solid;'>" . $prices_producted_price_array[$product_key] . " zł</td>
            <td style='border: 1px solid;'>" . $prices_producted_cost_array[$product_key] . " zł</td>
            <td style='border: 1px solid;' title='$waste_title'>" . $tot_waste_tot . " zł</td>
            <td style='border: 1px solid;'>" . $prices_producted_price_array[$product_key] - $tot_waste_tot . " zł</td>
            <td style='border: 1px solid;'>" . $prices_producted_price_array[$product_key] - $tot_waste_tot - $prices_producted_cost_array[$product_key] . " zł</td>";
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
        if (!isset($t_gratis[$product_key][$trader->id])) {
            $t_gratis[$product_key][$trader->id] = 0;
        }
        if (!isset($t_gratis_amount[$product_key][$trader->id])) {
            $t_gratis_amount[$product_key][$trader->id] = 0;
        }
        if (!isset($t_destroy[$product_key][$trader->id])) {
            $t_destroy[$product_key][$trader->id] = 0;
        }
        if (!isset($t_destroy_amount[$product_key][$trader->id])) {
            $t_destroy_amount[$product_key][$trader->id] = 0;
        }
        $waste_title = "Zwroty: " . $prices_returns_array[$product_key][$trader->id] . " -> " . $prices_returns_amount_array[$product_key][$trader->id] . "zł 
Gratisy: " . $t_gratis[$product_key][$trader->id] . " -> " . $t_gratis_amount[$product_key][$trader->id] . " zł  
Zniszczenia: " . $t_destroy[$product_key][$trader->id] . " -> " . $t_destroy_amount[$product_key][$trader->id] . " zł";
        $waste = $prices_returns_amount_array[$product_key][$trader->id] + $t_gratis_amount[$product_key][$trader->id] + $t_destroy_amount[$product_key][$trader->id]; // tu dodac gratisy i zniszczenia

        $mess .= "<td style='border: 1px solid; " . $bg_color . "'>" . $cargo_array[$product_key][$trader->id] . "</td>";
        $mess .= "<td style='border: 1px solid; " . $bg_color . "'>" . $prices_cargo_price_array[$product_key][$trader->id] . " zł</td>"; //spodziewany utarg po handlowcu
        $mess .= "<td style='border: 1px solid; " . $bg_color . "' title='$waste_title'>" . $waste . " zł</td>";
        $mess .= "<td style='border: 1px solid; " . $bg_color . "'>" . $prices_cargo_price_array[$product_key][$trader->id] - $waste . " zł</td>";

    }
    $mess .= "</tr>";
    $row_num += 1;
}

$mess .= "
    </tbody>";
if (isset($data["planned"])) {
    $waste_title = "Zwroty: " . $sum_waste_return_num . " -> " . $sum_waste_return . "zł 
Gratisy: " . $sum_waste_gratis_num . " -> " . $sum_waste_gratis . "zł 
Zniszczenia: " . $sum_waste_destroyed_num . " -> " . $sum_waste_destroyed . "zł";

    $mess .= "<tfoot>
            <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
                <td colspan='2' style='border: 1px solid;'>TOTAL</td>
                <td style='border: 1px solid;'>" . $sum_cargo . " (" . $total_prod["total"] . ")</td>
                <td style='border: 1px solid;'>" . $prices_producted_price_array["total"] . " zł</td>
                <td style='border: 1px solid;'>" . $prices_producted_cost_array["total"] . " zł</td>
                <td style='border: 1px solid;' title='$waste_title'>" . $sum_waste_return_tot . " zł</td>
                <td style='border: 1px solid;'>" . $prices_producted_price_array["total"] - $sum_waste_return_tot . " zł</td>
                <td style='border: 1px solid;'>" . $prices_producted_price_array["total"] - $prices_producted_cost_array["total"] - $sum_waste_return_tot . " zł</td>";
    $even = true;
    foreach ($data["users"] as $trader) {
        $bg_color = "";
        if ($even == true) {
            $even = false;
            $bg_color = " background-color: gray;";
        } else {
            $even = true;
        }
        $wst = 0;
        $wst_c = 0;
        $del = 0;
        $del_c = 0;
        foreach ($t_gratis_amount as $pr_k => $pr) {
            if (!isset($pr[$trader->id]["total"])) {
                if (isset($pr[$trader->id])) {
                    $wst += $pr[$trader->id];
                }
            }
        }
        foreach ($t_gratis as $pr_k => $pr) {
            if (!isset($pr[$trader->id]["total"])) {
                if (isset($pr[$trader->id])) {
                    $wst_c += $pr[$trader->id];
                }
            }
        }
        foreach ($t_destroy_amount as $pr_k => $pr) {
            if (!isset($pr[$trader->id]["total"])) {
                if (isset($pr[$trader->id])) {
                    $del += $pr[$trader->id];
                }
            }
        }
        foreach ($t_destroy as $pr_k => $pr) {
            if (!isset($pr[$trader->id]["total"])) {
                if (isset($pr[$trader->id])) {
                    $del_c += $pr[$trader->id];
                }
            }
        }


        $waste_title = "Zwroty: " . $prices_returns_array[$trader->id]["total"] . " -> " . $prices_returns_amount_array[$trader->id]["total"] . "zł 
Gratisy: " . $wst_c . " -> " . $wst . "zł 
Zniszczenia: " . $del_c . " -> " . $del . "zł";
        $total_waste = $prices_returns_amount_array[$trader->id]["total"] + $wst + $del; // tu dodac gratisy i zniszczenia PODSUMOWANIE

        if (!isset($prices_cargo_price_array[$trader->id]["total"])) {
            $prices_cargo_price_array[$trader->id]["total"] = 0;
        }
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "'>" . $sum_wyd[$trader->id] . "</td>";
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "'>" . $prices_cargo_price_array[$trader->id]["total"] . " zł</td>";
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "' title='$waste_title'>" . $total_waste . " zł</td>";
        $mess .= "<td style='border: 1px solid #000; " . $bg_color . "'>" . $prices_cargo_price_array[$trader->id]["total"] - $total_waste . " zł</td>";

    }
    $mess .= "</tr>
        </tfoot>";
}
$mess .= "</table>";


echo $mess;
?>



<?php
$to = $data["emails"]; //'mateusz.zybura@radluks.pl, mateusz.zybura@gmail.com'
$subject = "Raport $name rentowności - $dates";

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

