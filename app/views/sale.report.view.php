<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
    <div id="modal" class="modal">
                    <span class="close">&times;</span>
                    <div class="modal-content">
                        <img id="modal-image" src="" alt="Modal Image">
                    </div>
                </div>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["sales"]);
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
                                                if(!empty($user->helper_for)) {
                                                    $full_name .= " (". $data["users"][$user->helper_for]->first_name . " " . $data["users"][$user->helper_for]->last_name .")";
                                                }
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

                //show($data);
                ?>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Firma (Adres)</th>
                                            <th>Handlowiec</th>
                                            <th>Sprzedana ilość</th>
                                            <th>Wartość</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //show($data["sales"]["scan"]);
                                        if(!empty($data["sales"]["scan"])) {
                                            $total_result_number = 0;
                                            $total_result_value = 0;
                                            foreach($data["sales"]["scan"] as $company_key => $company_val) {
                                                if($company_val["u_id"] == $data["guardian"] || $data["guardian"] == 0 || $company_val["h_id"] == $data["guardian"]) {
                                                    $comp_add = isset($data["companies"][$company_key]->address) ? $data["companies"][$company_key]->address : '';
                                                    $comp_name = isset($data["companies"][$company_key]->full_name) ? $data["companies"][$company_key]->full_name : 'Inna';
                                                    $trader = $data["users"][$company_val["u_id"]]->first_name." ".$data["users"][$company_val["u_id"]]->last_name;
                                                    if(!empty($company_val["h_id"])) {
                                                        $trader = $data["users"][$company_val["h_id"]]->first_name." ".$data["users"][$company_val["h_id"]]->last_name . ' ('.$data["users"][$company_val["u_id"]]->first_name." ".$data["users"][$company_val["u_id"]]->last_name.')';
                                                    }
    
                                                    $total_num = 0;
                                                    $total_val = 0;
                                                    foreach($company_val as $prod) {
                                                        if(is_array($prod)) {
                                                            $total_num += $prod["s_amount"];
                                                            if(isset($data["prices"][$prod["p_id"]][0]->total_price)) { // tylko pierwsza kwoata jaka jest w systemie
                                                                $total_val += $prod["s_amount"] * $data["prices"][$prod["p_id"]][0]->total_price;
                                                            }
                                                        }
                                                    }
    
                                                    
    
                                                    echo "<tr>";
                                                    //echo "<td>".$company_val["date"]."</td>";
                                                    echo "<td title='".$comp_add."' style='font-weight: bold;'>".$comp_name."</td>
                                                    <td style='font-weight: bold;'>".$trader."</td>
                                                    <td>".$total_num." Szt.</td>
                                                    <td>".$total_val." zł</td>";
                                                    echo "<td><button class='btn btn-primary toggle-products' data-company='".$company_key."'>Pokaż produkty</button></td>";
                                                    echo "</tr>";
    
                                                    $total_result_number += $total_num;
                                                    $total_result_value += $total_val;
    
                                                    foreach($company_val as $prod) {
                                                        if(is_array($prod)) {
                                                            if (!empty($data["products"][$prod["p_id"]]->p_photo)) {
                                                                $photo = "<img width='40' height='40' class='obrazek' id='imageBox".$data["products"][$prod["p_id"]]->id."' src='" . IMG_ROOT . "" . $data["products"][$prod["p_id"]]->p_photo . "'>";
                                                            } else {
                                                                $photo = "";
                                                            }
                                                            echo "<tr class='product-list' data-company='".$company_key."' style='display:none; background-color: lightgray;'>";
                                                            echo "<td>".$photo."</td>";
                                                            echo "<td>".$data["products"][$prod["p_id"]]->p_name."</td>";
                                                            echo "<td>".$prod["s_amount"]. ' '.$data["products"][$prod["p_id"]]->p_unit."</td>";
                                                            $val = 0;
                                                            if(isset($data["prices"][$prod["p_id"]][0]->total_price)) { // tylko pierwsza kwoata jaka jest w systemie
                                                                $val += $prod["s_amount"] * $data["prices"][$prod["p_id"]][0]->total_price;
                                                            }
                                                            echo "<td>$val zł</td>";
                                                            echo "<td></td>";
    
    
    
                                                            echo "</tr>";
                                                        }
                                                    }
                                                }
                                                
                                                
                                            }
                                            echo "<tr style='background-color: lightgray; font-weight: bold'>
                                                <td colspan='2'>TOTAL</td>
                                                <td>$total_result_number Szt.</td>
                                                <td>$total_result_value zł</td>
                                                <td></td>
                                                </tr>";
                                        } else {
                                            echo "<tr><td colspan='5'>Brak sprzedaży</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".toggle-products").click(function() {
            var companyKey = $(this).data("company");
            $("tr.product-list[data-company='" + companyKey + "']").toggle();
        });
    });
</script>
        <?php require_once 'landings/footer.view.php' ?>