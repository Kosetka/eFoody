<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["split"]);
                    $date_from = "";
                    $date_to = "";
                    if (isset($data["date_from"])) {
                        $date_from = $data["date_from"];
                    }
                    if (isset($data["date_to"])) {
                        $date_to = $data["date_to"];
                    }
                ?>
                    <h2 class="">Historia szczegółowa sprzedaży: <?php echo $date_from;?> - <?php echo $date_to;?></h2>
                    <div class="form-group row m-3">
                        <form method="get">
                            <div class="text-start">
                                <div class="form-group row m-3">
                                    <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="date_from" name="date_from"
                                            value="<?php echo $date_from; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row m-3">
                                    <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="date_to" name="date_to"
                                        value="<?php echo $date_to; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row m-3">
                                    <label for="guardian" class="col-sm-2 col-form-label">Handlowiec:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="guardian" name="guardian">
                                            <?php
                                            
                                            if(!isset($data["guardian"])) {
                                                echo "<option value='0' selected>Wszyscy</option>";
                                            } else {
                                                echo "<option value='0'>Wszyscy</option>";
                                            }
                                            foreach ($data["users"] as $user) {
                                                $selected = "";
                                                $full_name = $user->first_name . " " . $user->last_name;
                                                $id = $user->id;
                                                if($data["guardian"] == $id) {
                                                    $selected = " selected";
                                                }
                                                echo "<option value='$id' $selected>$full_name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="w-40 btn btn-lg btn-primary" type="submit" name="search" value=1>Pokaż dane</button>
                        </form>
                    </div>
                </div>
                <?php

                show($data["sales"]);
                ?>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Firma (Adres)</th>
                                            <th>Handlowiec</th>
                                            <th>Sprzedana ilość</th>
                                            <th>Wartość</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!empty($data["sales"]["scan"])) {
                                            foreach($data["sales"]["scan"] as $company_key => $company_val) {
                                                

                                                if(isset($data["companies"][$company_key]->address)) {
                                                    $comp_add = $data["companies"][$company_key]->address;
                                                }
                                                if(isset($data["companies"][$company_key]->full_name)) {
                                                    $comp_name = $data["companies"][$company_key]->full_name;
                                                }
                                                $trader = $data["users"][$company_val["u_id"]]->first_name." ".$data["users"][$company_val["u_id"]]->last_name;
                                                if(!empty($company_val["h_id"])) {
                                                    $trader = $data["users"][$company_val["h_id"]]->first_name." ".$data["users"][$company_val["h_id"]]->last_name . ' ('.$data["users"][$company_val["u_id"]]->first_name." ".$data["users"][$company_val["u_id"]]->last_name.')';
                                                }

                                                //wartość sprzedaży
                                                $total_val = 0;
                                                $total_num = 0;
                                                foreach($company_val as $prod) {
                                                    if(is_array($prod)) {
                                                        $total_num += $prod["s_amount"];
                                                    }
                                                }

                                                echo "<tr>";
                                                echo "
                                                <td>".$company_val["date"]."</td>
                                                <td title='".$comp_add."'>".$comp_name."</td>
                                                <td>".$trader."</td>
                                                <td>".$total_num."</td>
                                                <td>".$total_val."</td>";
                                                echo "<td></td>";
                                                echo "</tr>";
                                                
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>Brak sprzedaży</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>
        <?php require_once 'landings/footer.view.php' ?>