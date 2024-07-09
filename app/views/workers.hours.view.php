<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
    <style>
        .calendar {
            table-layout: fixed;
        }
        .calendar th, .calendar td {
            width: 14.28%;
            text-align: center;
            height: 100px;
            cursor: pointer;
        }
        .calendar .header {
            background-color: #f8f9fa;
        }
        .calendar .holiday {
            background-color: lightcoral;
            color: white;
        }
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.85);
        }
        .btn-close-white {
            filter: invert(1);
        }
        .current-day {
            background-color: lightgoldenrodyellow !important; /* Jasnożółty kolor */
            color: #000;
        }
        .inputs {
            display: none;
        }
    </style>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">

            <div class="container-fluid px-4">
                <div class="alert alert-info">
                    <h2>UWAGA!</h2>
                    <p><b>Pierwsze wejście</b> - czas pierwszego odbicia kartą danego dnia</p>
                    <p><b>Ostatnie wyjście</b> - czas ostatniego odbicia kartą danego dnia</p>
                    <p><b>Czas pracy</b> - czas jaki osoba spędziła w pracy - wyliczony czas między poszczególnymi odbiciami karty</p>
                    <p><b>Czas wyjść</b> - czas jaki pracownik spędził po za firmą, np. gdy musiał wyjść coś załatwić prywatnego</p>
                    <br>
                    <p>Przy każdym wejściu i wyjściu z budynku firmy w celu innym niż służbowy pracownik powinien odbić się kartą. Czas pracy jest to wyliczony przez system czas jaki pracownik spędził w budynku firmy. Czas wyjść to czas jaki pracownik spędził po za firmą w celach prywatnych.</p>
                    <br>
                    <p>Jeśli pracownik prawidłowo odbijał się kartą i czasy pracy się zgadzają należy zapisać każdy rekord przyciskiem <button class="w-40 btn btn-sm btn-primary">Zapisz</button></p>
                    <p>Jeśli czas pracy z jakiegoś powodu się nie zgadza (np. brak odbicia karty przy wyjściu), należy odznaczyć checkbox w kolumnie <b>Akceptuj</b> a w polach które się pojawią, należy podać godzinę wejścia i wyjścia danej osoby, a następnie zapisać dane.</p>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Wybierz datę</h2>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="form-group row m-3">
                                <label for="date" class="col-sm-2 col-form-label">Data:</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="date" id="date" name="date" value="<?=$data["date"];?>" required>
                                </div>
                            </div>
                            
                            <button class="w-40 btn btn-lg btn-primary" type="submit" name="search" value=1>Pokaż dane</button>
                        </form>
                    </div>
                </div>
            </div>
<?php if($data["show_list"] == true) { ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Lista godzin do zaakceptowania</h2>
                </div>
                <div class="card-body">
                    <?php

                        //show($data["scans_ok"]);
                        
                    ?>

<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pracownik</th>
                                <th scope="col">Oddział</th>
                                <th scope="col">Stanowisko</th>
                                <th scope="col">Pierwsze wejście</th>
                                <th scope="col">Ostatnie wyjście</th>
                                <th scope="col">Czas pracy</th>
                                <th scope="col">Czas wyjść</th>
                                <th scope="col">Akceptuj</th>
                                <th scope="col">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($data["users"] as $user) {

                                    $wymiar = "";
                                    $in = "";
                                    $out = "";
                                    if(isset($data["scans_ok"][$user->id])) {
                                        $wymiar = count($data["scans_ok"][$user->id]);
                                        $in = $data["scans_ok"][$user->id][0]["in"];
                                        $out = $data["scans_ok"][$user->id][$wymiar-1]["out"];
                                    }
                                    if($in != "") { //czy był start
                                        if(!isset($data["accepted"][$user->id])) {
                                            echo '<tr>';
                                            echo '<th>'.$user->first_name .' '.$user->last_name.'</th>';
                                            echo '<th>'.$data["cities"][$user->u_warehouse]["c_fullname"].' -> '.$data["cities"][$user->u_warehouse]["wh_fullname"].'</th>';
                                            echo '<th>'.$data["roles"][$user->u_role]->role_name.'</th>';
                                            echo '<td>'.subYear($in).'</td>';
                                            echo '<td>'.subYear($out).'</td>';
                                            echo '<td>'.showInHours($work[$user->id]).'</td>';
                                            echo '<td>'.showInHours($break[$user->id]).'</td>';
                                            echo '<td>';
                                            ?>
                                            <form action="" method="POST">
                                                <input type="checkbox" class="checkbox" id="checkbox<?=$user->id?>" onclick="toggleInputs(this)" checked>
                                                <div class="inputs">
                                                    <div class="input-group mb-3" style="width: 140px">
                                                        <span class="input-group-text" id="accept_in"><i class="fa-solid fa-arrow-right-to-bracket"></i></span>
                                                        <input type="time" class="form-control" name="accept_in">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="accept_in"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                                                        <input type="time" class="form-control" name="accept_out">
                                                    </div>
                                                </div>
                                            <?php
                                            echo '</td>';
                                            echo '<td>';
                                            echo '<input hidden type="text" name="u_id" value="'.$user->id.'">';
                                            echo '<input hidden type="text" name="date_sel" value="'.$data["date"].'">';
                                            echo '<input hidden type="text" name="accept_id" value="'.$_SESSION["USER"]->id.'">';
                                            echo '<input hidden type="text" name="hour_first_in" value="'.subYear($in).'">';
                                            echo '<input hidden type="text" name="hour_first_out" value="'.subYear($out).'">';
                                            echo '<input hidden type="text" name="work_seconds" value="'.$work[$user->id].'">';
                                            echo '<input hidden type="text" name="break_seconds" value="'.$break[$user->id].'">';
                                            echo '<button class="w-40 btn btn-sm btn-primary" type="submit" name="hours_accept" value=1>Zapisz</button>';
                                            echo '</td>';
                                            
    
    
    
    
                                            echo '</form>';
                                            echo '</tr>';
                                        } 
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php }?>

        </main>
        <script>
            function toggleInputs(checkbox) {
                var inputs = checkbox.nextElementSibling;
                var input1 = inputs.querySelector('.input1');
                var input2 = inputs.querySelector('.input2');
                if (checkbox.checked) {
                    inputs.style.display = 'none';
                    input1.value = '';
                    input2.value = '';
                    input1.required = false;
                    input2.required = false;
                } else {
                    inputs.style.display = 'inline-block';
                    input1.required = true;
                    input2.required = true;
                }
            }
        </script>

        <?php require_once 'landings/footer.view.php' ?>