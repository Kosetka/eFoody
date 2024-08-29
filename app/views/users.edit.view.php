<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Edycja konta</h2>
                </div>
                <div class="card-body">
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

                    <form method="post">
                        <div class="text-start">
                            <div class="form-group row m-3">
                                <label for="Email" class="col-sm-2 col-form-label">Adres e-mail:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="<?= $data["user"]->email ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="priv_email" class="col-sm-2 col-form-label">Prywatny adres e-mail:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="priv_email" name="priv_email"
                                        value="<?= $data["user"]->priv_email ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="password" class="col-sm-2 col-form-label">Hasło:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="<?= $data["user"]->password ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="first_name" class="col-sm-2 col-form-label">Imię:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="<?= $data["user"]->first_name ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="last_name" class="col-sm-2 col-form-label">Nazwisko:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="<?= $data["user"]->last_name ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="phone_business" class="col-sm-2 col-form-label">Numer służbowy:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="phone_business" name="phone_business"
                                        value="<?= $data["user"]->phone_business ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="phone_private" class="col-sm-2 col-form-label">Numer prywatny:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="phone_private" name="phone_private"
                                        value="<?= $data["user"]->phone_private ?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="active" class="col-sm-2 col-form-label">Konto aktywne:</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" class="form-check-input" id="active" name="active" value="1"
                                        <?= $data["user"]->active == 1 ? "checked" : ""; ?>>
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label class="col-sm-2 col-form-label" for="u_warehouse">Wybierz magazyn:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="u_warehouse" name="u_warehouse">
                                        <?php
                                        $user_wh = $data["user"]->u_warehouse;
                                        foreach ($data["cities"] as $city) {
                                            $full_tag = $city["c_name"] . "_" . $city["wh_name"];
                                            $full_name = $city["c_fullname"] . " -> " . $city["wh_fullname"];
                                            $id = $city["id"];
                                            if ($user_wh == $id) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='$id' $selected>$full_tag : $full_name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row m-3">
                                <legend class="col-sm-2 col-form-label ">Uprawnienia:</legend>
                                <div class="col-sm-10">
                                    <?php
                                        //show($data);
                                    foreach ($roles as $role) {
                                        $r_id = $role["id"];
                                        $id = $data["user"]->u_role;
                                        $role_name = $role["role_name"];
                                        $role_description = $role["role_description"];
                                        $r_active = $role["r_active"];
                                        $checked = "";
                                        $active = "";
                                        if ($r_id === $id) {
                                            $checked = "checked";
                                        }
                                        if ($r_active === 0) {
                                            $active = "disabled";
                                        }
                                        echo "<div class='form-check'>
                        <input class='form-check-input' type='radio' name='u_role' id='u_role$r_id' value='$r_id' $checked $active onchange='toggleHelper(this)'>
                        <label class='form-check-label' for='u_role$r_id'>
                        $role_name
                        </label>
                    </div>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row m-3" id="helperfor" hidden>
                                <label class="col-sm-2 col-form-label" for="u_warehouse">Pomocnik dla:</label>
                                <div class="col-sm-10">
                                <select class="form-control" id="helper_for" name="helper_for">
                                    <?php
                                    $helper_for = "";
                                    if(isset($data["user"]->helper_for)) {
                                        $helper_for = $data["user"]->helper_for;
                                    }
                                    foreach ($data["users"] as $trader) {
                                        $id = $trader->id;
                                        $full_name = $trader->first_name . ' '. $trader->last_name;
                                        if($id == $helper_for) {
                                            echo "<option value='$id' selected>$full_name</option>";
                                        } else {
                                            echo "<option value='$id'>$full_name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="userEdit">Zapisz zmiany</button>
                    </form>
                </div>
            </div>
            
            
            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Przypisywanie magazynów</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors_warehouse)): ?>
                        <div class="alert alert-danger">
                            <?= implode("<br>", $errors_warehouse) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success_warehouse)): ?>
                        <div class="alert alert-success">
                            <?= $success_warehouse ?>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Miasto</th>
                                    <th scope="col">Magazyn</th>
                                    <th scope="col">Opis Miasta</th>
                                    <th scope="col">Opis Magazynu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $citiesList = [];
                                foreach ($data["cityList"] as $key) {
                                    $citiesList[] = $key->id;
                                }
                                foreach ($data["cities"] as $city) {
                                    $full_tag = $city["c_name"] . "_" . $city["wh_name"];
                                    $full_name = $city["c_fullname"] . " -> " . $city["wh_fullname"];
                                    $id = $city["id"];
                                    if (in_array($id, $citiesList)) {
                                        $selected = "checked";
                                    } else {
                                        $selected = "";
                                    }

                                    echo "<tr>";
                                    echo "<th scope='row'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' $selected value='$id' name='check[]' id='$id'>
                                        <label class='form-check-label' for='flexCheckDefault'>
                                        </label>
                                    </div>
                                </th>";

                                    echo "<td>" . $city["c_fullname"] . " (" . $city["c_name"] . ")</td>";
                                    echo "<td>" . $city["wh_fullname"] . " (" . $city["wh_name"] . ")</td>";
                                    echo "<td>" . $city["c_description"] . "</td>";
                                    echo "<td>" . $city["wh_description"] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button class="w-100 btn btn-lg btn-primary" style="margin-top: 30px" type="submit"
                            name="warehouseEdit">Przypisz magazyny
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <?php
                        if($data["payrate_id"] > 0) {
                            $p_text = "Zmień dane stawki";
                        } else {
                            $p_text = "Nowa stawka godzinowa";
                        }
                    ?>
                    <h2 id="calendarHeader" class=""><?=$p_text;?></h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($success_payrate)): ?>
                        <div class="alert alert-success">
                            <?= $success_payrate ?>
                        </div>
                    <?php endif; 
                    ?>
                    <form method="post">
                        <div class="text-start">
                            <div class="form-group row m-3">
                                <label class="col-sm-2 col-form-label ">Typ wypłaty:</label>
                                <div class="col-sm-10">
                                    <div class='form-check'>
                                    <?php
                                        if($data["payrate_id"] > 0) {
                                            if($data["payrate"][0]->type == 1) {
                                                $checked = "checked";
                                            }
                                        } else {
                                            $checked = "";
                                        }
                                    ?>
                                        <input class='form-check-input' type='radio' name='type' id='type1' value='1' <?=$checked;?>>
                                        <label class='form-check-label' for='type1'>Stała</label>
                                    </div>
                                    <div class='form-check'>
                                        <?php
                                            if($data["payrate_id"] > 0) {
                                                if($data["payrate"][0]->type == 2) {
                                                    $checked = "checked";
                                                }
                                            } else {
                                                $checked = "";
                                            }
                                        ?>
                                        <input class='form-check-input' type='radio' name='type' id='type2' value='2' <?=$checked;?>>
                                        <label class='form-check-label' for='type2'>Godzinowa</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="rate" class="col-sm-2 col-form-label">Stawka:</label>
                                <?php
                                    if($data["payrate_id"] > 0) {
                                        echo "<input hidden name='edit_id' value='".$data["payrate"][0]->id."'>";
                                        $p_rate = $data["payrate"][0]->rate;
                                    } else {
                                        $p_rate = "";
                                    }
                                ?>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="rate" name="rate" min="0" step="0.01" required value="<?=$p_rate;?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="date_from" class="col-sm-2 col-form-label">Początek obowiązywania:</label>
                                <?php
                                    if($data["payrate_id"] > 0) {
                                        $p_date_from = $data["payrate"][0]->date_from;
                                    } else {
                                        $p_date_from = "";
                                    }
                                ?>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="date_from" name="date_from" required value="<?=$p_date_from;?>">
                                </div>
                            </div>
                            <div class="form-group row m-3">
                                <label for="date_to" class="col-sm-2 col-form-label">Koniec obowiązywania:</label>
                                <?php
                                    if($data["payrate_id"] > 0) {
                                        $p_date_to = $data["payrate"][0]->date_to;
                                    } else {
                                        $p_date_to = "";
                                    }
                                ?>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="date_to" name="date_to" value="<?=$p_date_to;?>">
                                </div>
                            </div>
                        </div>
                            <?php
                                if($data["payrate_id"] > 0) {
                                    $p_text = "Zapisz zmiany";
                                } else {
                                    $p_text = "Dodaj stawkę";
                                }
                            ?>
                        <button class="w-100 btn btn-lg btn-primary" type="submit" name="payrate" value="1"><?=$p_text;?></button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Historia stawek</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Data od</th>
                                <th scope="col">Data do</th>
                                <th scope="col">Typ</th>
                                <th scope="col">Stawka</th>
                                <th scope="col">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($data["payrates"])) {
                                foreach ($data["payrates"] as $payrate) {
                                    $types = [1=>"Stała", 2=>"Godzinowa"];
                                    echo "<tr>";
                                    echo "<td>" . $payrate->date_from . "</td>";
                                    echo "<td>" . $payrate->date_to . "</td>";
                                    echo "<td>" . $types[$payrate->type] . "</td>";
                                    echo "<td>" . $payrate->rate . " zł</td>";
                                    echo "<td><a href='" . ROOT . "/users/edit/" . $data["user"]->id . "/".$payrate->id."'>Edytuj</a></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="workHeader" class="">Historia zatrudnienia</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Data od</th>
                                <th scope="col">Data do</th>
                                <th scope="col">Uprawnienia</th>
                                <!--<th scope="col">Akcja</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($data["user_history"])) {
                                foreach ($data["user_history"] as $u_his) {
                                    echo "<tr>";
                                    echo "<td>" . $u_his->date_from . "</td>";
                                    echo "<td>" . $u_his->date_to . "</td>";
                                    echo "<td>" . $data["roles_history"][$u_his->role]["role_name"] . "</td>";
                                    //echo "<td><a href='" . ROOT . "/users/edit/" . $data["user"]->id . "/".$u_his->id."'>Edytuj</a></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <script>
            function toggleHelper(element) {
                var helperDiv = document.getElementById('helperfor');
                if (element.id === 'u_role10' && element.checked) {
                helperDiv.removeAttribute('hidden');
                } else {
                helperDiv.setAttribute('hidden', 'hidden');
                }
            }

            // Jeśli element z id 'u_role3' jest zaznaczony przy ładowaniu strony, pokaż helperDiv
            document.addEventListener('DOMContentLoaded', function() {
                var selectedRole = document.querySelector('input[name="u_role"]:checked');
                if (selectedRole && selectedRole.id === 'u_role10') {
                document.getElementById('helperfor').removeAttribute('hidden');
                }
            });
            </script>
        <?php require_once 'landings/footer.view.php' ?>