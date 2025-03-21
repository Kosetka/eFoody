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
                <h1 class="h3 mb-3 fw-normal">Edycja firmy</h1>

                <div class="text-start">
                    <div class="form-group row m-3">
                        <label for="full_name" class="col-sm-2 col-form-label">Nazwa firmy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="full_name" name="full_name" required
                                value="<?= $data["companies"]->full_name ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="friendly_name" class="col-sm-2 col-form-label">Przyjazna nazwa:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="friendly_name" name="friendly_name"
                                value="<?= $data["companies"]->friendly_name ?>">
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
                                    if ($data["companies"]->city_id == $id) {
                                        echo "<option value='$id' selected>$full_tag : $full_name</option>";
                                    } else {
                                        echo "<option value='$id'>$full_tag : $full_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="email" class="col-sm-2 col-form-label">E-mail kontaktowy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?= $data["companies"]->email ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="contact_first_name" class="col-sm-2 col-form-label">Imię:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact_first_name" name="contact_first_name"
                                value="<?= $data["companies"]->contact_first_name ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="contact_last_name" class="col-sm-2 col-form-label">Nazwisko:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact_last_name" name="contact_last_name"
                                value="<?= $data["companies"]->contact_last_name ?>">
                        </div>
                    </div>
                    <div id="phone-number-container">
                        <div class="form-group row m-3">
                            <label for="phone_number" class="col-sm-2 col-form-label">Tel. kontaktowy:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="phone_number" name="phone_numbers[]"
                                    value="<?= $data["companies"]->phone_number ?>">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-secondary"
                                    onclick="addPhoneNumberField()">+</button>
                            </div>
                        </div>
                        <?php
                        $first = true;
                        if (!empty($data["phone_numbers"])) {
                            foreach ($data["phone_numbers"] as $phone) {
                                if ($first == false) {
                                    echo '  <div class="form-group row m-3">
                                                <label for="phone_number" class="col-sm-2 col-form-label">Dodatkowy numer:</label>
                                                <div class="col-sm-2">
                                                <input type="text" class="form-control" id="phone_number" name="phone_numbers[]" value="' . $phone->c_phone . '">
                                                </div>
                                            </div>';

                                }
                                if ($first == true) {
                                    $first = false;
                                }
                            }
                        }

                        ?>
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

                                    if ($data["companies"]->guardian == $id) {
                                        echo "<option value='$id' selected>$full_name</option>";
                                    } else {
                                        echo "<option value='$id'>$full_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="nip" class="col-sm-2 col-form-label">NIP:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nip" name="nip"
                                value="<?= $data["companies"]->nip ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="street" class="col-sm-2 col-form-label">Ulica:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="street" name="street"
                                value="<?= $data["companies"]->street ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="street_number" class="col-sm-2 col-form-label">Numer domu/lokalu:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="street_number" name="street_number"
                                value="<?= $data["companies"]->street_number ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="city" class="col-sm-2 col-form-label">Miasto:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="city" name="city"
                                value="<?= $data["companies"]->city ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="postal_code" class="col-sm-2 col-form-label">Kod pocztowy:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="postal_code" name="postal_code"
                                value="<?= $data["companies"]->postal_code ?>">
                        </div>
                    </div>
                    <div class="form-group row m-3">
                        <label for="company_type" class="col-sm-2 col-form-label">Rodzaj firmy:</label>
                        <div class="col-sm-10">
                            <?php
                            $selected = "";
                            foreach (COMPANIESTYPE as $key => $value) {
                                if ($data["companies"]->company_type == $key) {
                                    $selected = "checked";
                                } else {
                                    $selected = "";
                                }
                                echo "<div class='form-check'>
                                    <input class='form-check-input company-type-radio' type='radio' name='company_type' id='company_type$key' value='$key' $selected>
                                    <label class='form-check-label' for='company_type$key'>
                                    $value
                                    </label>
                                    </div>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row m-3" id="delivery-hour-group" <?php
                    if ($data["companies"]->company_type <> 2 && $data["companies"]->company_type <> 3) {
                        echo "hidden";
                    }
                    ?>>
                        <label for="delivery_hour" class="col-sm-2 col-form-label">Termin dostawy:</label>
                        <div class="col-sm-10">
                            <?php
                            $selected = "";
                            foreach (DELIVERYHOUR as $key => $value) {
                                if ($data["companies"]->delivery_hour == $key) {
                                    $selected = "checked";
                                } else {
                                    $selected = "";
                                }
                                if ($key)
                                    echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='delivery_hour' id='delivery_hour$key' value='$key' $selected>
                                    <label class='form-check-label' for='delivery_hour$key'>
                                    $value
                                    </label>
                                    </div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group row m-3" id="open_hour-group" <?php
                    if ($data["companies"]->company_type <> 2 && $data["companies"]->company_type <> 3) {
                        echo "hidden";
                    }
                    ?>>
                        <label for="open_hour" class="col-sm-2 col-form-label">Godzina otwarcia:</label>
                        <div class="col-sm-10">
                            <input type="time" class="form-control" id="open_hour" name="open_hour"
                                value="<?= $data["companies"]->open_hour ?>">
                        </div>
                    </div>

                    <div class="form-group row m-3" id="close_hour-group" <?php
                    if ($data["companies"]->company_type <> 2 && $data["companies"]->company_type <> 3) {
                        echo "hidden";
                    }
                    ?>>
                        <label for="close_hour" class="col-sm-2 col-form-label">Godzina zamknięcia:</label>
                        <div class="col-sm-10">
                            <input type="time" class="form-control" id="close_hour" name="close_hour"
                                value="<?= $data["companies"]->close_hour ?>">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="description" class="col-sm-2 col-form-label">Notatki:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="description" name="description"
                                value="<?= $data["companies"]->description ?>">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="active" class="col-sm-2 col-form-label">Aktywna:</label>
                        <div class="col-sm-10">
                            <?php
                            $active = $data['companies']->active;
                            $checked = "";
                            if ($active == 1) {
                                $checked = "checked";
                            } else {
                                $active = 0;
                                $checked = "";
                            }
                            ?>
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" <?php echo $checked; ?>>
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="latitude" class="col-sm-2 col-form-label">Szerokość geogr.:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                value="<?= $data['companies']->latitude ?>">
                        </div>
                    </div>

                    <div class=" form-group row m-3">
                        <label for="longitude" class="col-sm-2 col-form-label">Długość geogr.:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                value="<?= $data['companies']->longitude ?>">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="workers" class="col-sm-2 col-form-label">Ilość pracowników</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="workers" name="workers"
                                value="<?= $data['companies']->workers ?>">
                        </div>
                    </div>

                    <div class="form-group row m-3">
                        <label for="c_type" class="col-sm-2 col-form-label">Wielkość firmy:</label>
                        <div class="col-sm-10">
                            <?php

                            foreach (COMPANYSIZE as $key => $value) {
                                if ($data["companies"]->c_type == $key) {
                                    $selected = "checked";
                                } else {
                                    $selected = "";
                                }
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='c_type' id='c_type$key' value='$key' $selected>
                                    <label class='form-check-label' for='c_type$key'>
                                    $value
                                    </label>
                                    </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <button class=" w-100 btn btn-lg btn-primary" type="submit" name="companyEdit">Zapisz zmiany</button>
            </form>

        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Pobierz wszystkie radio buttony dla 'Rodzaj firmy'
                const companyTypeRadios = document.querySelectorAll('.company-type-radio');
                const deliveryHourGroup = document.getElementById('delivery-hour-group');
                const openHourGroup = document.getElementById('open_hour-group');
                const closeHourGroup = document.getElementById('close_hour-group');

                companyTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        // Jeśli wybrana wartość to 2 lub 3, usuń 'hidden', w przeciwnym wypadku ukryj
                        if (this.value === '2' || this.value === '3') {
                            deliveryHourGroup.hidden = false;
                            openHourGroup.hidden = false;
                            closeHourGroup.hidden = false;
                        } else {
                            deliveryHourGroup.hidden = true;
                            openHourGroup.hidden = true;
                            closeHourGroup.hidden = true;
                        }
                    });
                });
            });
        </script>
        <script>
            function addPhoneNumberField() {
                // Create a new div element
                var newDiv = document.createElement("div");
                newDiv.className = "form-group row m-3";

                // Create a new label element
                var newLabel = document.createElement("label");
                newLabel.className = "col-sm-2 col-form-label";
                newLabel.innerText = "Dodatkowy numer:";

                // Create a new div for input
                var inputDiv = document.createElement("div");
                inputDiv.className = "col-sm-2";

                // Create a new input element
                var newInput = document.createElement("input");
                newInput.type = "text";
                newInput.className = "form-control";
                newInput.name = "phone_numbers[]"; // Using array notation

                // Append the label and input to the new div
                inputDiv.appendChild(newInput);
                newDiv.appendChild(newLabel);
                newDiv.appendChild(inputDiv);

                // Append the new div to the container
                document.getElementById("phone-number-container").appendChild(newDiv);
            }
        </script>
        <?php require_once 'landings/footer.view.php' ?>