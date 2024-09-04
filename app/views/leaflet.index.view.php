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
                        <h2 class="">Wybierz datę</h2><a href="<?php echo ROOT."/workers/hours?show=1";?>" class="btn btn-sm btn-primary" name="show" value=1>Pokaż niezaakceptowane</a>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="form-group row m-3">
                                <label for="date" class="col-sm-2 col-form-label">Data:</label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="date" id="date" name="date" value="<?=$data["date"];?>" required>
                                </div>
                            </div>
                            
                            <button class="w-40 btn btn-lg btn-primary" type="submit">Pokaż dane</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once 'landings/footer.view.php' ?>