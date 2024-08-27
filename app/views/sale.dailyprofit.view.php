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
                    <h2 id="calendarHeader" class="">Utarg dzienny pracowników</h2>
                </div>
                <div class="card-body">
                    <?php

                        //show($data["scans_ok"]);
                        
                    ?>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Pracownik</th>
                                <th scope="col">Stanowisko</th>
                                <th scope="col">Karta</th>
                                <th scope="col">Gotówka</th>
                                <th scope="col">Total</th>
                                <th scope="col">Akcja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($data["users"] as $user) {
                                    echo '<tr>';
                                    echo '<form action="" method="POST">';
                                    echo '<th>'.$user->first_name .' '.$user->last_name.'</th>';
                                    echo '<th>'.$user->role_name.'</th>';
                                    echo '<td>';
                                    $cash = 0;
                                    $card = 0;
                                    $total = 0;
                                    if(isset($data["gains"][$user->id])) {
                                        $cash = $data["gains"][$user->id]->cash;
                                        $card = $data["gains"][$user->id]->card;
                                        $total = $data["gains"][$user->id]->profit;
                                    }
                                    echo '<input type="number" class="form-check-input p-2" style="width: 120px; height: 30px" id="card" name="card" value="'.$card.'" min="0"> zł';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<input type="number" class="form-check-input p-2" style="width: 120px; height: 30px" id="cash" name="cash" value="'.$cash.'" min="0"> zł';
                                    echo '</td>';
                                    echo '<td>'.$total.' zł</td>';
                                    echo '<td>';
                                    echo '<input hidden type="text" name="u_id" value="'.$user->id.'">';
                                    echo '<input hidden type="text" name="accept_id" value="'.$_SESSION["USER"]->id.'">';
                                    echo '<button class="w-40 btn btn-sm btn-primary" type="submit" name="profit_accept" value=1>Zapisz</button>';
                                    echo '</td>';
                                    echo '</form>';
                                    echo '</tr>';
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