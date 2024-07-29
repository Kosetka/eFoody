<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Lista samochodów</h2>
                    
                </div>
                <div class="card-body">
                    <?php
                        $access = [1, 2];
                        if(in_array($your_id,$access)) {
                            echo '<a type="button" class="btn btn-primary" href="'.ROOT.'/cars/new">Dodaj nowy samochód</a>';
                        }

                    ?>
                    
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Numer samochodu</th>
                                <th>Rejestracja</th>
                                <th>Kierowca</th>
                                <th>Status</th>
                                <th>Model</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numer samochodu</th>
                                <th>Rejestracja</th>
                                <th>Kierowca</th>
                                <th>Status</th>
                                <th>Model</th>
                                <th>Akcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if(!empty($data["cars"] )) {
                                foreach($data["cars"] as $car) {
                                    if($car->active == 1) {
                                        $status = "Aktywny";
                                    } else {
                                        $status = "Nieaktywny";
                                    }
                                    echo "<tr>
                                        <td>$car->objectno</td>
                                        <td>$car->plate</td>";
                                        $owner = 0;
                                        if(!empty($data["car_user"])) {
                                            foreach($data["car_user"] as $cu) {
                                                if($cu->car_id == $car->id) {
                                                    $owner = $cu->u_id;
                                                }
                                            }
                                        }
                                        if($owner == 0) {
                                            echo "<td>wolny</td>";
                                        } else {
                                            echo "<td>".$data["users"][$owner]->first_name ." ".$data["users"][$owner]->last_name."</td>";
                                        }
                                    echo "  <td>$status</td>
                                            <td>$car->model</td>";

                                    if(in_array($your_id,$access)) {
                                        echo "<td><a href='" . ROOT . "/cars/edit/" . $car->id . "'>Edytuj</a></td>";
                                    } else {
                                        echo "<td></td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php require_once 'landings/footer.view.php' ?>