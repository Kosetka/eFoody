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
                                <th>NIP</th>
                                <th>Osoba kontaktowa</th>
                                <th>Numer telefonu</th>
                                <th>Adres e-mail</th>
                                <th>Miasto</th>
                                <th>Opiekun</th>
                                <th>Pełny adres</th>
                                <th>Rodzaj firmy</th>
                                <th>Notatki</th>
                                <th>Status</th>
                                <th>Współrzędne</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa firmy</th>
                                <th>NIP</th>
                                <th>Osoba kontaktowa</th>
                                <th>Numer telefonu</th>
                                <th>Adres e-mail</th>
                                <th>Miasto</th>
                                <th>Opiekun</th>
                                <th>Pełny adres</th>
                                <th>Rodzaj firmy</th>
                                <th>Notatki</th>
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
                                echo "<tr>
                                    <td>$company->id</td>
                                    <td>$company->full_name</td>
                                    <td>$company->nip</td>
                                    <td>$company->contact_first_name $company->contact_last_name</td>
                                    <td>$company->phone_number</td>
                                    <td>$company->email</td>
                                    <td>$city_name</td>
                                    <td>$user_name</td>
                                    <td>$company->address</td>
                                    <td>$company_type</td>
                                    <td>$company->description</td>
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