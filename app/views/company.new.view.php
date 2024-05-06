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

                <h1 class="h3 mb-3 fw-normal">Dodawanie firmy</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="full_name" class="col-sm-2 col-form-label">Nazwa firmy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="city_id" class="col-sm-2 col-form-label">Miasto:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="city_id" name="city_id">
                                <?php
                                foreach ($data["cities"] as $city) {
                                    $full_tag = $city["c_name"];
                                    $full_name = $city["c_fullname"];
                                    $id = $city["id"];
                                    echo "<option value='$id'>$full_tag : $full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="email" class="col-sm-2 col-form-label">E-mail kontaktowy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="contact_first_name" class="col-sm-2 col-form-label">Imię:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact_first_name" name="contact_first_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="contact_last_name" class="col-sm-2 col-form-label">Nazwisko:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact_last_name" name="contact_last_name">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="phone_number" class="col-sm-2 col-form-label">Tel. kontaktowy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="guardian" class="col-sm-2 col-form-label">Opiekun handlowy:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="guardian" name="guardian">
                                <option value='0' selected>Brak opiekuna</option>
                                <?php

                                foreach ($data["users"] as $user) {
                                    $full_name = $user->first_name . " " . $user->last_name;
                                    $id = $user->id;
                                    echo "<option value='$id'>$full_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="nip" class="col-sm-2 col-form-label">NIP:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nip" name="nip">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="street" class="col-sm-2 col-form-label">Ulica:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="street" name="street">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="street_number" class="col-sm-2 col-form-label">Numer domu/lokalu:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="street_number" name="street_number">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="city" class="col-sm-2 col-form-label">Miasto:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="postal_code" class="col-sm-2 col-form-label">Kod pocztowy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="company_type" class="col-sm-2 col-form-label">Rodzaj firmy:</label>
                        <div class="col-sm-10">
                            <?php
                            $selected = "checked";
                            foreach (COMPANIESTYPE as $key => $value) {
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='company_type' id='company_type$key' value='$key' $selected>
                                    <label class='form-check-label' for='company_type$key'>
                                    $value
                                    </label>
                                    </div>";
                                $selected = "";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="description" class="col-sm-2 col-form-label">Notatki:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="active" class="col-sm-2 col-form-label">Aktywna:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" checked>
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="latitude" class="col-sm-2 col-form-label">Szerokość geogr.:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="latitude" name="latitude">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="longitude" class="col-sm-2 col-form-label">Długość geogr.:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="longitude" name="longitude">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="workers" class="col-sm-2 col-form-label">Ilość pracowników</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="workers" name="workers">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="c_type" class="col-sm-2 col-form-label">Rodzaj firmy:</label>
                        <div class="col-sm-10">
                            <?php
                            $selected = "checked";
                            foreach (COMPANYSIZE as $key => $value) {
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='c_type' id='c_type$key' value='$key' $selected>
                                    <label class='form-check-label' for='c_type$key'>
                                    $value
                                    </label>
                                    </div>";
                                $selected = "";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Dodaj firmę</button>
            </form>

        </main>
        <?php require_once 'landings/footer.view.php' ?>