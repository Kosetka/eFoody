<?php 
$name = REPORTTYPES[$data["get"]["type"]];
$dates = "";

if ($data["get"]["type"] == "hour") {
    $new_date_format = date("d-m-Y", strtotime($data["get"]["date_from"]));
    $dates = $new_date_format." - ".$data["get"]["param1"].":00";
}
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
        foreach($data["users"] as $user) {
            $u_id = $user->id;
            $sales = 0;
            $companies = 0;
            $cargos = 0;
            $visit = 0;
            $destroy = 0;
            $returns = 0;
            $gratis = 0;
            $plus = 0;
            $minus = 0;
            $stan = 0;
            foreach($data["sales"] as $sale) {
                if($sale->u_id == $u_id) {
                    $sales += $sale->scan_and_empty;
                    $destroy += $sale->destroy;
                    $gratis += $sale->gratis;
                }
            }
            foreach($data["cargo"] as $cargo) {  //dodać wymiany
                if($cargo->u_id == $u_id) {
                    $cargos += $cargo->num;
                }
            }

            foreach($data["exchanges"] as $exchange) {  //dodać wymiany
                if($exchange->u_id_init == $u_id) {
                    $minus += $exchange->num;
                }
                if($exchange->u_id_target == $u_id) {
                    $plus += $exchange->num;
                }
            }

            foreach($data["returns"] as $return) {
                if($return->u_id == $u_id) {
                    $returns += $return->num;
                }
            }

            foreach($data["places"] as $place) {
                if($place->u_id == $u_id) {
                    $visit += $place->num;
                }
            }
            if(isset($data["companies"][$u_id])) {
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
$mess.="
        <tr style='text-align: center;'>
            <td style='border: 1px solid;'>$user->first_name $user->last_name</td>
            <td style='border: 1px solid;'>$sales</td>
            <td style='border: 1px solid;'>$stan</td>
            <td style='border: 1px solid;'>".getPercent($sales, $stan)."%</td>
            <td style='border: 1px solid;'>$visit</td>
            <td style='border: 1px solid;'>$companies</td>
            <td style='border: 1px solid;'>".getPercent($visit, $companies)."%</td>
            <td style='border: 1px solid;'>$cargos</td>
            <td style='border: 1px solid;'>".$plus - $minus."</td>
            <td style='border: 1px solid;'>$destroy</td>
            <td style='border: 1px solid;'>$returns</td>
            <td style='border: 1px solid;'>$gratis</td>
        </tr>";
        }
        $total_stan = $total_cargo + $total_plus - $total_minus;
$mess.="
    </tbody>
    <tfoot>
        <tr style='background-color: #e6e6e6; font-weight: bold; text-align: center;'>
            <td style='border: 1px solid;'>TOTAL</td>
            <td style='border: 1px solid;'>$total_sales</td>
            <td style='border: 1px solid;'>$total_stan</td>
            <td style='border: 1px solid;'>".getPercent($total_sales,$total_stan)."%</td>
            <td style='border: 1px solid;'>$total_visit</td>
            <td style='border: 1px solid;'>$total_companies</td>
            <td style='border: 1px solid;'>".getPercent($total_visit,$total_companies)."%</td>
            <td style='border: 1px solid;'>$total_cargo</td>
            <td style='border: 1px solid;'>".$total_plus - $total_minus."</td>
            <td style='border: 1px solid;'>$total_destroy</td>
            <td style='border: 1px solid;'>$total_returns</td>
            <td style='border: 1px solid;'>$total_gratis</td>
        </tr>
    </tfoot>
</table>";

    
    echo $mess;
?>



<?php
$to = 'mateusz.zybura@radluks.pl';
$subject = "Raport $name sprzedaży - $dates";

if($data["get"]["send"] == 1) {
    $mailer = new Mailer($to, $subject, $mess);
    if ($mailer->send()) {
        echo 'Wiadomość została wysłana pomyślnie.';
    } else {
        echo 'Wystąpił problem podczas wysyłania wiadomości. Błąd: ' . print_r($mailer->getLastError(), true);
    }
}
?>

