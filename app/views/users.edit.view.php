<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
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

                <h1 class="h3 mb-3 fw-normal">Edycja konta</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="Email" class="col-sm-2 col-form-label">Adres e-mail:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?= $data["user"]->email ?>">
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
                            foreach ($roles as $role) {
                                //show($role);
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
                <input class='form-check-input' type='radio' name='u_role' id='u_role$r_id' value='$r_id' $checked $active>
                <label class='form-check-label' for='u_role$r_id'>
                  $role_name
                </label>
              </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" name="userEdit">Zapisz zmiany
                </button>
            </form>
        </main>
        <div class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 70%">
            <form method="post">

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

                <h1 class="h3 mb-3 fw-normal">Przypisywanie magazynów</h1>
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
        <?php require_once 'landings/footer.view.php' ?>