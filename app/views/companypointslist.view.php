<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Baza punktów</h2>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa</th>
                                <th>Numer telefonu</th>
                                <th>Pełny adres</th>
                                <th>Rodzaj punktu</th>
                                <th>Notatki</th>
                                <th>Data odwiedzin</th>
                                <th>Status</th>
                                <th>Współrzędne</th>
                                <th>Akcje</th>
                                <th>Aktwny</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa</th>
                                <th>Numer telefonu</th>
                                <th>Pełny adres</th>
                                <th>Rodzaj punktu</th>
                                <th>Notatki</th>
                                <th>Data odwiedzin</th>
                                <th>Status</th>
                                <th>Współrzędne</th>
                                <th>Akcje</th>
                                <th>Aktwny</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($data["companies"] as $company) {
                                $latlong = $company->latitude . ", " . $company->longitude;
                                $company_type = COMPANYTYPE[$company->type];
                                $edit_link = '<a href="' . ROOT . '/company/pointedit/' . $company->id . '">Edytuj</a>';
                                $active = "Aktywny";
                                if(isset($company->to_delete)) {
                                    if($company->to_delete == 0) {
                                        $active = "Aktywny";
                                    } else {
                                        $active = "Nieaktywna";
                                    }
                                }
                                if($company->moved == 1) {
                                    $active = "<span style='color: green'>Przeniesiony jako sklep</span>";
                                    $edit_link = "";
                                }
                                foreach (COMPANYVISIT as $k => $v) {
                                    if ($k == 0)
                                      $type[$k] = "black";
                                    if ($k == 1)
                                      $type[$k] = "red";
                                    if ($k == 2)
                                      $type[$k] = "green";
                                    if ($k == 3)
                                      $type[$k] = "red";
                                    if ($k == 4)
                                      $type[$k] = "black";
                                    if ($k == 5)
                                      $type[$k] = "blue";
                                    if ($k == 6)
                                      $type[$k] = "black";
                                    if ($k == 7)
                                      $type[$k] = "blue";
                                    if ($k == 8)
                                      $type[$k] = "blue";
                                    if ($k == 9)
                                      $type[$k] = "yellow";
                                  }
                                    if($company->visit_date != "0000-00-00 00:00:00") {
                                        $visit_date = $company->visit_date;
                                    } else {
                                        $visit_date = "";
                                    }
                                echo "<tr>
                                    <td>$company->id</td>
                                    <td>$company->name</td>
                                    <td>$company->phone_number</td>
                                    <td>$company->address</td>
                                    <td>$company_type</td>
                                    <td>$company->description</td>
                                    <td>$visit_date</td>
                                    <td data-id='$company->status'><span style='color: ".$type[$company->status]."; font-size: bold;'>".COMPANYVISIT[$company->status]."</span></td>
                                    <td>$latlong</td>
                                    <td>$edit_link</td>
                                    <td>$active</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>