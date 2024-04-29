<table>
    <thead>
        <tr>
            <th>Imię i nazwisko</th>
            <th>Sprzedany towar</th>
            <th>Stan</th>
            <th>% sprzedaży</th>
            <th>Odwiedzone firmy</th>
            <th>Wszystkie firmy</th>
            <th>% odwiedzonych firm</th>
            <th>Pobrane z magazynu</th>
            <th>Wymiany</th>
            <th>Uszkodzone</th>
            <th>Zwroty</th>
            <th>Gratisy</th>
        </tr>
    </thead>
    <tbody>
        <?php
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
        ?>
        <tr>
            <td><?php echo $user->first_name." ".$user->last_name;?></td>
            <td><?php echo $sales; ?></td>
            <td><?php echo $stan; ?></td>
            <td><?php echo getPercent($sales, $stan); ?>%</td>
            <td><?php echo $visit; ?></td>
            <td><?php echo $companies; ?></td>
            <td><?php echo getPercent($visit, $companies); ?>%</td>
            <td><?php echo $cargos; ?></td>
            <td><?php echo $plus - $minus; ?></td>
            <td><?php echo $destroy; ?></td>
            <td><?php echo $returns; ?></td>
            <td><?php echo $gratis; ?></td>
        </tr>
        <?php
        }
        $total_stan = $total_cargo + $total_plus - $total_minus;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td>TOTAL</td>
            <td><?php echo $total_sales;?></td>
            <td><?php echo $total_stan;?></td>
            <td><?php echo getPercent($total_sales,$total_stan); ?>%</td>
            <td><?php echo $total_visit;?></td>
            <td><?php echo $total_companies;?></td>
            <td><?php echo getPercent($total_visit,$total_companies); ?>%</td>
            <td><?php echo $total_cargo; ?></td>
            <td><?php echo $total_plus - $total_minus; ?></td>
            <td><?php echo $total_destroy; ?></td>
            <td><?php echo $total_returns; ?></td>
            <td><?php echo $total_gratis; ?></td>
        </tr>
    </tfoot>
</table>

