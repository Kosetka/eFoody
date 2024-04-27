<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <div class="modal-content">
                    <img id="modal-image" src="" alt="Modal Image">
                </div>
            </div>
            <script>
                var buttonsAndModals = [];
            </script>
            <div class="card mb-4">
                <div class="card-header">
                <?php
                $date = "";
                    if (isset($_SESSION["date_plan"])) {
                        $date = $_SESSION["date_plan"];
                    }
                ?>
                    <h2 class="">Plan produkcji na <?php echo $date;?></h2>
                    <div class="form-group row m-3">
                        <form method='post'>
                            <div class="col-sm-12" style='display: flex'>
                                <label for="c_name" class="col-sm-2 col-form-label">Wybierz dzień:</label>
                                
                                <input type='date' class='form-control col-sm-2' name='date'
                                    value='<?php echo $date; ?>'>
                                <button class='btn btn-primary' style='margin-left: 20px;' type='submit' name='dateSend'
                                    value='1'>Pokaż</button>
                            </div>
                        </form>
                    </div>

                </div>
                <?php //show($data); ?>
                <div class="form-group row m-3">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produkt</th>
                                    <?php
                                    foreach ($data["cities"] as $city) {
                                        echo "<th scope='col'>".$city["c_name"] . "_" . $city["wh_name"] . " -> " . $city["c_fullname"] . " " . $city["wh_fullname"] . "</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $used = [];
                                echo "<tr>";
                                echo "<td><table width='100%;'><tr><th>Zdjęcie</th><th>Nazwa produktu</th><th>Zrealizowane/Plan</th> <th>%</th></tr>";
                                if(isset($data["prod_planned"])) {
                                    foreach ($data["prod_planned"] as $key => $value) {
                                        if (!empty($data["fullproducts"][$key]->p_photo)) {
                                            $photo = "<img width='40' height='40' class='obrazek' src='" . IMG_ROOT . "" . $data["fullproducts"][$key]->p_photo . "'>";
                                        } else {
                                            $photo = "";
                                        }
                                        $plpl = $value["total"];
                                        $zrzr = (isset($data["scans"][$key]["total"])) ? $data["scans"][$key]["total"] : 0;
                                        $prpr = ($zrzr) ? round($zrzr / $plpl * 100,2) : 0;

                                        if ($prpr >=100) {
                                            $color = "pa100";
                                        } else if ($prpr >=85) {
                                            $color = "pa85";
                                        } else if ($prpr >= 50) {
                                            $color = "pa50";
                                        } else if ($prpr >= 0) {
                                            $color = "pa0";
                                        } else {
                                            $color = "";
                                        }

                                        echo "<tr style='height: 80px;' class='$color '>";
                                        echo "<td>$photo</td>";
                                        echo "<td>".$data["fullproducts"][$key]->p_name ."</td>";
                                        echo "<td>".$zrzr." / ".$plpl."</td>"; // plan zrealizowane
                                        echo "<td><b>".$prpr."%</b></td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</table></td>";
                                $int = 1;
                                foreach ($data["cities"] as $city) {
                                    echo "<td><table width='100%;'><tr><th>Zrobione</th><th>Planowane</th><th>%</th></tr>";
                                    if(isset($data["prod_planned"])) {

                                    
                                    foreach ($data["prod_planned"] as $key => $value) {
                                        $plan = isset($value[$city["id"]]) ? $value[$city["id"]] : NULL;
                                        $scan = (isset($data["scans"][$key][$city["id"]])) ? $data["scans"][$key][$city["id"]] : NULL;
                                        $percent = ($plan > 0) ? round($scan/$plan*100,2) : NULL;
                                        if($percent <> "") {
                                            if ($percent >=100) {
                                                $color = "pa100";
                                            } else if ($percent >=85) {
                                                $color = "pa85";
                                            } else if ($percent >= 50) {
                                                $color = "pa50";
                                            } else if ($percent >= 0) {
                                                $color = "pa0";
                                            }
                                            echo "<tr style='height: 80px;' class='$color '>";
                                            echo "<td>".$scan."</td>";
                                            echo "<td>".$plan."</td>";
                                            echo "<td>".$percent."%</td>";
                                            echo "</tr>";
                                        } else {
                                            echo "<tr style='height: 80px;'>";
                                            echo "<td></td>";
                                            echo "<td></td>";
                                            echo "<td></td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                                    echo "</table></td>";
                                }

                                echo "</tr>";

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>