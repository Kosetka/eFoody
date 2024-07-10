<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
<style>
    .calendar-holiday {
        background-color: lightcoral !important;
        color: white;
    }
</style>
<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Koszty i przychody</h2>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="form-group row m-3">
                                <label for="month" class="col-sm-2 col-form-label">Miesiąc:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="month" name="month" required>
                                        <?php
                                            for ($month = 1; $month <= 12; $month++) {
                                                $sel = "";
                                                if ($data["month"] == $month) {
                                                    $sel = "selected";
                                                }
                                                echo '<option value="' . $month . '" ' . $sel . '>' . date("F", mktime(0, 0, 0, $month, 1)) . '</option>';
                                            }
                                            echo '</select>';
                                        ?>
                                </div>
                            </div>

                            <div class="form-group row m-3">
                                <label for="year" class="col-sm-2 col-form-label">Rok:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="year" name="year" required>
                                        <?php 
                                            for ($year = 2024; $year <= 2025; $year++) {
                                                $sel = "";
                                                if ($data["year"] == $year) {
                                                    $sel = "selected";
                                                }
                                                echo '<option value="' . $year . '" ' . $sel . '>' . $year . '</option>';
                                            }
                                            echo '</select>';
                                        ?>
                                </div>
                            </div>
                            <button class="w-40 btn btn-lg btn-primary" type="submit" name="search" value=1>Pokaż dane</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
                if($data["show_table"] == true) {
            ?>
            <div class="container-fluid px-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">
                            <?php 
                                echo POLISHMONTHS[$data["month"]] . " - " . $data["year"];
                            ?>
                        </h2>
                    </div>
                    <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Dzień tygodnia</th>
                                <th scope="col">Koszty produktów</th>
                                <th scope="col">Koszty stałe</th>
                                <th scope="col">Koszty pracowników</th>
                                <th scope="col">Dodatkowe koszty wyliczone (naklejki)</th>
                                <th scope="col">Sprzedane produkty</th>
                                <th scope="col">Rentowność</th>
                                <?php
                                    $year = $data["year"];
                                    $month = $data["month"];
                                    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-01");
                                    $daysInMonth = $date->format('t');
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    $holiday = "";
                                    $date->setDate($year, $month, $day);
                                    foreach($data["holidays"] as $holi) {
                                        if($holi->date == $date->format('Y-m-d')) {
                                            $holiday = ' class="calendar-holiday"';
                                        }
                                    }
                                    echo '<tr '.$holiday.'>';
                                    
                                    echo "<td>".$date->format('Y-m-d')."</td>";
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '</tr>'; 
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php //show($daily);?>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        



        </main>
        <?php require_once 'landings/footer.view.php' ?>