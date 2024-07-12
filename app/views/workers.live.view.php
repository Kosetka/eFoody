<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
        <div class="container-fluid px-4">
            <div class="alert alert-info">
                <h2>UWAGA!</h2>
                <p><b>Wejście</b> - czas pierwszego odbicia kartą danego dnia</p>
                <p><b>Wyjście</b> - czas ostatniego odbicia kartą danego dnia</p>
                <p><b>Czas pracy [zarejestrowany]</b> - czas jaki osoba spędziła w pracy - wyliczony czas między poszczególnymi odbiciami karty</p>
                <p><b>Przerwy</b> - czas jaki pracownik spędził po za firmą, np. gdy musiał wyjść coś załatwić prywatnego</p>
                <br>
                <p>Klikając przycisk <button class='btn btn-primary show-details-btn'>Pokaż</button> pokaże się szczegółowa tabelka z każdym wejściem i wyjściem danego pracownika oraz informacją w którym lokalu był. </p>
                <br><br>
                <p>Kolorem <span class="table-success" style="padding: 4px;">zielonym</span> oznaczone są osoby, które są aktualnie w pracy.</p>
                <p>Kolorem <span class="table-warning" style="padding: 4px;">żółtym</span> oznaczone są osoby, które wyszły z budynku (odbiły się kartą), a ich łączny czas pracy w danym dniu jest zbyt krótki, żeby uznać że zakończyły pracę na dziś.</p>
                <p>Kolorem <span class="table-info" style="padding: 4px;">niebieskim</span> oznaczone są osoby, które zakończyły pracę w dniu dzisiejszym.</p>
                <p>Kolorem <span class="table-danger" style="padding: 4px;">czerwonym</span> oznaczone są osoby, których nie ma w pracy (nie odbiły się kartą na wejściu)</p>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="">Pracownicy LIVE : <?=$data["date"];?></h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pracownik</th>
                                <th scope="col">Oddział</th>
                                <th scope="col">Stanowisko</th>
                                <th scope="col">Wejście</th>
                                <th scope="col">Wyjście</th>
                                <th scope="col">Czas pracy [zarejestrowany]</th>
                                <th scope="col">Przerwy</th>
                                <th scope="col">Szczegóły</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if (!$data["users"]) {
                                echo "<tr><th colspan='8'>Brak danych do wyświetlenia</th></tr>";
                            } else {
                                foreach ($data["users"] as $user) {
                                    $status_pracy = "Nieobecny";
                                    $status_class = "table-danger";
                                    
                                    $wymiar = "";
                                    $in = "";
                                    $out = "";
                                    if(isset($data["scans_ok"][$user->id])) {
                                        $wymiar = count($data["scans_ok"][$user->id]);
                                        $in = $data["scans_ok"][$user->id][0]["in"];
                                        $out = $data["scans_ok"][$user->id][$wymiar-1]["out"];
                                    }

                                    if($in != "") {
                                        $status_pracy = "Pracuje";
                                        $status_class = "table-success";
                                        if($out != "") {
                                            $status_pracy = "Przerwa";
                                            $status_class = "table-warning";
                                            if($work[$user->id] >= 17000) { //7:30RBH <- 27000
                                                $status_pracy = "Zakończona";
                                                $status_class = "table-info";
                                            }
                                        }
                                    }

                                    echo "<tr class='$status_class'>";
                                    echo "<td scope='row'>$user->first_name $user->last_name</td>";
                                    echo "<td scope='row'>".$data["cities"][$user->u_warehouse]["c_fullname"]." -> ".$data["cities"][$user->u_warehouse]["wh_fullname"]."</td>";
                                    echo "<td scope='row'>".$data["roles"][$user->u_role]->role_name."</td>";
                                    echo "<td>".subYear($in)."</td>";
                                    echo "<td>".subYear($out)."</td>";
                                    if(isset($work[$user->id])) {
                                        echo "<td>".showInHours($work[$user->id])."</td>";
                                        echo "<td>".showInHours($break[$user->id])."</td>";
                                    } else {
                                        echo "<td></td>";
                                        echo "<td></td>";
                                    }
                                    echo "<td><button type='button' class='btn btn-primary show-details-btn'>Pokaż</button></td>";
                                    echo "<td>$status_pracy</td>";
                                    echo "</tr>";

                                    if(!empty($data["scans_ok"][$user->id])) {
                                        // Dodaj ukrytą tabelę z szczegółami dla każdego użytkownika
                                        echo "<tr class='details-row' style='display: none; background-color: black; color: antiquewhite;'>";
                                        echo "<td colspan='9'>";
                                        echo "<table class='table table-bordered'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th rowspan='2' scope='col'>Status</th>";
                                        echo "<th colspan = '2' scope='col'>Wejście</th>";
                                        echo "<th colspan = '2' scope='col'>Wyjście</th>";
                                        echo "<th rowspan='2' scope='col'>Czas trwania</th>";
                                        echo "</tr>";
                                        echo "<tr>";
                                        echo "<th scope='col'>Czas</th>";
                                        echo "<th scope='col'>Miejsce</th>";
                                        echo "<th scope='col'>Czas</th>";
                                        echo "<th scope='col'>Miejsce</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";
                                        $out = "";
                                            foreach($data["scans_ok"][$user->id] as $scan) {
                                                if($out != "") {
                                                    echo "<tr style='background-color: ivory; color: black'>";
                                                    echo "<td style='background-color: khaki'>Przerwa</td>";
                                                    echo "<td>" .$out . "</td>";
                                                    echo "<td></td>";
                                                    echo "<td>" . subYear($scan["in"]) . "</td>";
                                                    echo "<td></td>";
                                                    echo "<td>" . showInHours(timeDiffInSeconds($out,subYear($scan["in"]))) . "</td>";
                                                    echo "</tr>";
                                                    $out = "";
                                                }
                                                echo "<tr style='background-color: lightgreen; color: black'>";
                                                echo "<td style='background-color: forestgreen;'>Praca</td>";
                                                echo "<td>" . subYear($scan["in"]) . "</td>";
                                                echo "<td>" . $data["cities"][$scan["w_id_in"]]["c_fullname"] . " -> ".$data["cities"][$scan["w_id_in"]]["wh_fullname"]."</td>";
                                                echo "<td>" . subYear($scan["out"]) . "</td>";
                                                $out = subYear($scan["out"]);
                                                if(!empty($scan["w_id_out"])) {
                                                    echo "<td>" . $data["cities"][$scan["w_id_out"]]["c_fullname"] . " -> ".$data["cities"][$scan["w_id_out"]]["wh_fullname"]."</td>";
                                                } else {
                                                    echo "<td></td>";
                                                }
                                                echo "<td>" . showInHours(timeDiffInSeconds(subYear($scan["in"]),subYear($scan["out"]))) . "</td>";
                                                echo "</tr>";
                                            }
                                        echo "</tbody>";
                                        echo "</table>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<script>
    // Skrypt JavaScript do obsługi pokazywania/ukrywania szczegółów
    document.addEventListener("DOMContentLoaded", function () {
        const showDetailsButtons = document.querySelectorAll('.show-details-btn');
        showDetailsButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const detailsRow = this.closest('tr').nextElementSibling;
                if (detailsRow.classList.contains('details-row')) {
                    detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' : 'none';
                }
            });
        });
    });
</script>
        </main>
        <?php require_once 'landings/footer.view.php' ?>