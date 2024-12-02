<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                <?php
                $date = "";
                    if (isset($_SESSION["date_plan"])) {
                        $date = $_SESSION["date_plan"];
                    }
                ?>
                    <h2 class="">Statusy punktów</h2>
                    <div class="form-group row m-3">
                        <form method='get'>
                            <div class="col-sm-4" style='display: flex'>
                                <label for="status" class="col-sm-2 col-form-label">Wybierz status:</label>
                                <div class="col-sm-10">
                                    <?php
                                    $selected = "";
                                    echo "<div class='form-check'>
                                    <input class='form-check-input company-type-radio' type='radio' name='status' id='status99' value='99' checked>
                                        <label class='form-check-label' for='status99'>
                                        Wszystkie
                                        </label>
                                    </div>";
                                    
                                    foreach (COMPANYVISIT as $key => $value) {
                                        if ($data["status"] == $key) {
                                            $selected = "checked";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<div class='form-check'>
                                            <input class='form-check-input company-type-radio' type='radio' name='status' id='status$key' value='$key' $selected>
                                                <label class='form-check-label' for='status$key'>
                                                $value
                                                </label>
                                            </div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <button class='btn btn-primary' style='margin-left: 20px;' type='submit' name='send' value='1'>Pokaż</button>
                        </form>
                    </div>

                </div>
                <?php //show($data); ?>
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                        <?php
                            $used = [];
                            echo "<tr>
                                    <th>Nazwa punktu</th>
                                    <th>Adres</th>
                                    <th>Typ punktu</th>
                                    <th>Status</th>
                                    <th>Data wizyty</th>
                                    <th>Mapa</th>
                                    <th>Akcje</th>
                                </tr>";
                            if(isset($data["companies"])) {
                                foreach ($data["companies"] as $key => $value) {
                                    $gps_link = "https://www.google.com/maps?q=" . $value->latitude . "," . $value->longitude;
                                    echo "<tr>";
                                    echo "<td>$value->name</td>";
                                    echo "<td>$value->address</td>";
                                    echo "<td>".COMPANYTYPE[$value->type]."</td>"; 
                                    echo "<td>".COMPANYVISIT[$value->status]."</td>";
                                    echo "<td>$value->visit_date</td>";
                                    echo "<td><a target='_blank' href='$gps_link'>Nawiguj</a></td>";
                                    echo "<td><a href='".ROOT."/company/pointedit/$value->id'>Edytuj</a></td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>