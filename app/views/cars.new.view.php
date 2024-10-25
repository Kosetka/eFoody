<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
  <?php require_once 'landings/sidebar.left.view.php' ?>
  <div id="layoutSidenav_content">
    <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <?php
                if($data["edit"] === True) {
                    $edit = True;
                    $head2 = "Edytowanie samochodu";
                    $button2 = "Zapisz zmiany";
                    $blocked = " disabled";
                } else {
                    $head2 = "Dodawanie nowego samochodu";
                    $button2 = "Dodaj samochód";
                    $edit = False;
                    $blocked = "";
                }
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class=""><?= $head2;?></h2>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="text-start">
                        <div class="form-group row m-3">
                            <label for="objectno" class="col-sm-2 col-form-label">Numer samochodu (objectno):</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="objectno" name="objectno" required $blocked <?php if($edit) {echo " value='".$data["car"]->objectno."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="objectname" class="col-sm-2 col-form-label">Nazwa samochodu (objectname):</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="objectname" name="objectname" required $blocked <?php if($edit) {echo " value='".$data["car"]->objectname."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="model" class="col-sm-2 col-form-label">Model:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="model" name="model" $blocked <?php if($edit) {echo " value='".$data["car"]->model."'"; }?>>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="plate" class="col-sm-2 col-form-label">Rejestracja:</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="plate" name="plate" required $blocked <?php if($edit) {echo " value='".$data["car"]->plate."'"; }?>>
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="fuel_type" class="col-sm-2 col-form-label">Rodzaj paliwa:</label>
                            <div class="col-sm-10">
            <?php
                foreach (FUELTYPE as $f_type_key => $f_type_val) {
                    $checked = "";
                    if($edit) {
                        if ($data["car"]->fuel_type == $f_type_key) {
                            $checked = "checked";
                        }
                    }
                    echo "  <div class='form-check'>
                                <input class='form-check-input' type='radio' name='fuel_type' id='fuel_type$f_type_key' value='$f_type_key' $checked>
                                <label class='form-check-label' for='fuel_type$f_type_key'>
                                $f_type_val
                                </label>
                            </div>";
                }
            ?>
                        
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="tank_cap" class="col-sm-2 col-form-label">Pojemność zbiornika:</label>
                            <div class="col-sm-2">
                            <input type="number" min="0" max="100" class="form-control" id="tank_cap" name="tank_cap" required $blocked <?php if($edit) {echo " value='".$data["car"]->tank_cap."'"; }?>>
                            </div>
                        </div>

                        <div class="form-group row m-3">
                            <label for="active" class="col-sm-2 col-form-label">Samochód aktywny:</label>
                            <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php if($edit) {if($data["car"]->active == 1) {echo " checked"; }}?>>
                            </div>
                        </div>
                        </div>
                        
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="newadd"><?=$button2;?></button>
                    </form>
                </div>
            </div>

<?php
if($edit) {
?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Przypisywanie samochodu</h2>
                </div>
                <div class="card-body">
                <form method="post">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?= implode("<br>", $errors) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success">
                            <?= $success ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $th1 = "Przypisz kierowcę";
                    $th2 = "";
                    $th3 = "";
                    $th4 = "";
                    $th5 = "";
                    $th6 = "";
                    $th7 = "Zapisz";
                    if (isset($data["card_data"])) {
                        $th1 = "Edytuj przypisanie samochodu";
                        $th2 = $data["card_data"]->date_from;
                        $th3 = $data["card_data"]->date_to;
                        $th4 = $data["card_data"]->card_id;
                        $th7 = "Zapisz zmiany";
                    }

                    ?>

                    <h1 class="h3 mb-3 fw-normal"><?php echo $th1; ?></h1>

                    <div class="text-start">
                        <div class="form-group row m-3">
                            <label for="date_from" class="col-sm-2 col-form-label">Data od:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    value="<?php echo $th2; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row m-3">
                            <label for="date_to" class="col-sm-2 col-form-label">Data do:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                    value="<?php echo $th3; ?>">
                            </div>
                        </div>
                        <?php
                        if(isset($data["card_data"])) {
                            ?>
                            <div class="form-group row m-3">
                                <label for="car_id" class="col-sm-2 col-form-label">Samochód:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="car_id" name="car_id"
                                        value="<?php echo $th4; ?>" disabled>
                                    <input type="text" class="form-control" id="input_edit" name="input_edit"
                                        hidden value="1">
                                </div>
                            </div>
                        <?php
                        } else {
                            ?>
                        
                        <div class="form-group row m-3">
                            <label class="col-sm-2 col-form-label" for="u_id">Wybierz kierowcę:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="u_id" name="u_id">
                                    <?php
                                        foreach ($data["users"] as $user) {
                                            $id = $user->id;
                                            echo "<option value='$id'>$user->first_name $user->last_name</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit" name="caruser"><?php echo $th7; ?>
                    </button>
                </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Historia kierowców</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Kierowca</th>
                                <th scope="col">Data od</th>
                                <th scope="col">Data do</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($data["car_users"])) {
                                foreach ($data["car_users"] as $car_user) {
                                    echo "<tr>";
                                    echo "<td>" . $car_user->first_name . " " . $car_user->last_name ."</td>";
                                    echo "<td>" . $car_user->date_from . "</td>";
                                    echo "<td>" . $car_user->date_to . "</td>";
                                    //echo "<td><a href='".ROOT."/cars/edit/".$data['user_id']."/$card_user->id'>Edytuj</a></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php
}
?>
    </main>
    <?php require_once 'landings/footer.view.php' ?>