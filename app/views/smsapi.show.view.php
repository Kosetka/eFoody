<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<?php
    //show($data["planned"]);
?>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                <?php
                //show($data["split"]);
                $date = "";
                    if (isset($data["date_plan"])) {
                        $date = $data["date_plan"];
                    }
                ?>
                    <h2 class="">Odebrane wiadomości od dnia: <?php echo $date;?></h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Wybierz dzień:</label>
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <label for="guardian" class="col-sm-2 col-form-label">Handlowiec:</label>
                                <select class="form-control col-sm-2" id="guardian" name="guardian">
                                    <?php
                                    
                                    if(!isset($data["guardian"])) {
                                        echo "<option value='0' selected>Wszyscy</option>";
                                    } else {
                                        echo "<option value='0'>Wszyscy</option>";
                                    }
                                    foreach ($data["traders"] as $user) {
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
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit'>Pokaż</button>
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="">
                        <div class="form-group row m-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered" id="orderedProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Źródło</th>
                                            <th>Data odebrania</th>
                                            <th>Numer telefonu</th>
                                            <th>E-mail</th>
                                            <th>Firma</th>
                                            <th>Przyjazna nazwa</th>
                                            <th>Adres</th>
                                            <th>Handlowiec</th>
                                            <th>Treść wiadomości</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $is_msg = false;
                                        if(!empty($data["sms"])) {
                                            foreach($data["sms"] as $sms) {
                                                $sms_from = substr($sms->sms_from,2);
                                                if(empty($sms->id)) {
                                                    $trader = "Brak numeru w bazie";
                                                    $color_trader = " background-color: red;";
                                                } else {
                                                    $trader = $sms->first_name ." ". $sms->last_name;
                                                    $color_trader = "";
                                                }
                                                if($sms->id == $data["guardian"] || $data["guardian"]==0) {
                                                    echo "<tr>";
                                                    echo "
                                                    <td>SMS</td>
                                                    <td>$sms->date</td>
                                                    <td>$sms_from</td>
                                                    <td>$sms->email</td>
                                                    <td>$sms->full_name</td>
                                                    <td>$sms->friendly_name</td>
                                                    <td>$sms->address</td>
                                                    <td style='$color_trader'>$trader</td>
                                                    <td>$sms->sms_text</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            $is_msg = true;
                                        } 
                                        if(!empty($data["cf"])) {
                                            foreach($data["cf"] as $sms) {
                                                if($sms->id == $data["guardian"] || $data["guardian"]==0) {
                                                    echo "<tr>";
                                                    echo "
                                                    <td>e-mail</td>
                                                    <td>$sms->date</td>
                                                    <td>$sms->phone</td>
                                                    <td>$sms->email</td>
                                                    <td></td>
                                                    <td>$sms->full_name</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>$sms->txt</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                            $is_msg = true;
                                        } 



                                        if(!$is_msg) {
                                            echo "<tr><td colspan='8'>Brak wiadomości</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            
        </main>
        <?php require_once 'landings/footer.view.php' ?>