<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Baza firm</h2>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa firmy</th>
                                <th>Przyjazna nazwa</th>
                                <th>NIP</th>
                                <th>Osoba kontaktowa</th>
                                <th>Numer telefonu</th>
                                <th>Opiekun</th>
                                <th>Pełny adres</th>
                                <th>Rodzaj firmy</th>
                                <th>Notatki</th>
                                <th>Godziny otwarcia</th>
                                <th>Status</th>
                                <th>Współrzędne</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa firmy</th>
                                <th>Przyjazna nazwa</th>
                                <th>NIP</th>
                                <th>Osoba kontaktowa</th>
                                <th>Numer telefonu</th>
                                <th>Opiekun</th>
                                <th>Pełny adres</th>
                                <th>Rodzaj firmy</th>
                                <th>Notatki</th>
                                <th>Godziny otwarcia</th>
                                <th>Status</th>
                                <th>Współrzędne</th>
                                <th>Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php

                            $cities = [0 => "Brak magazynu"];
                            foreach ($data["cities"] as $s) {
                                $cities[$s["id"]] = $s;
                            }
                            foreach ($data["companies"] as $company) {
                                $city_name = $cities[$company->city_id]["c_name"] . " : " . $cities[$company->city_id]["c_fullname"];
                                $active = $company->active;
                                $latlong = $company->latitude . ", " . $company->longitude;
                                $company_type = COMPANIESTYPE[$company->company_type];
                                if ($company->guardian == 0) {
                                    $user_name = "Brak opiekuna";
                                } else {
                                    $user_name = $data["users"][$company->guardian]["first_name"] . " " . $data["users"][$company->guardian]["last_name"];
                                }
                                if ($active === 1) {
                                    $active_display = 'Aktywna';
                                } else {
                                    $active_display = 'Nieaktywna';
                                }
                                $edit_link = '<a href="' . ROOT . '/company/edit/' . $company->id . '">Edytuj</a>';
                                $numbers = $company->phone_number;
                                $i = 0;
                                foreach ($data["phone_numbers"] as $number_key => $number_val) {
                                    if ($number_key == $company->id) {
                                        foreach ($number_val as $numb) {
                                            if ($i > 0) {
                                                $numbers .= ", " . $numb;
                                            }
                                            $i++;
                                        }
                                    }
                                }
                                $open_hours = "";
                                if (isset($company->open_hour)) {
                                    $open_hours = substr($company->open_hour, 0, 5) . " - " . substr($company->close_hour, 0, 5);
                                }
                                echo "<tr>
                                    <td>$company->id</td>
                                    <td>$company->full_name</td>
                                    <td>$company->friendly_name</td>
                                    <td>$company->nip</td>
                                    <td>$company->contact_first_name $company->contact_last_name</td>
                                    <td>$numbers</td>
                                    <td>$user_name</td>
                                    <td>$company->address</td>
                                    <td>$company_type</td>
                                    <td>$company->description</td>
                                    <th>$open_hours</th>
                                    <td>$active_display</td>
                                    <td>$latlong</td>
                                    <td>$edit_link</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>