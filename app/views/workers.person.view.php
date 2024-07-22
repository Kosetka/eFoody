<?php require_once 'landings/header.view.php' ?>
<?php require_once 'landings/nav.view.php' ?>
    <style>
        .calendar {
            table-layout: fixed;
        }
        .calendar th, .calendar td {
            width: 14.28%;
            text-align: center;
            font-weight: bold;
            height: 100px;
        }
        .calendar .header {
            background-color: #f8f9fa;
        }
        .calendar .holiday {
            background-color: lightcoral !important;
            color: white;
        }
        .calendar-holiday {
            background-color: lightcoral !important;
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
        .accepted-day {
            background-color: green !important;
            color: white;
        }
        .work-hours {
            background-color: lightgreen !important;
            color: black;
        }
        .holiday-work-hours {
            background-color: lightyellow !important;
            color: black;
        }
        .holiday-accepted-day {
            background-color: yellow !important;
            color: black;
        }
        .accept-time-black {
            font-size: 0.8em;
            color: black;
            font-weight: normal;
            font-style: italic
        }
        .accept-time {
            font-size: 0.8em;
            color: white;
            font-weight: normal;
            font-style: italic
        }
    </style>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">

            <div class="container-fluid px-4">
                <div class="alert alert-info">
                    <h2>UWAGA!</h2>
                    <p>Kolorem <span class="calendar-holiday" style="padding: 4px;">czerwonym</span> oznaczone są wolne dni od pracy - do ustalenia w Panelu Administracyjnym.</p>
                    <p>Kolorem <span class="work-hours" style="padding: 4px;">jasnozielonym</span> oznaczone są dni, w których osoba była w pracy (odbiła się kartą), ale nie ma zaakceptowanych godzin.</p>
                    <p>Kolorem <span class="accepted-day" style="padding: 4px;">zielonym</span> oznaczone są dni, w których osoba ma zaakceptowane godziny pracy.</p>
                    <p>Kolorem <span class="holiday-work-hours" style="padding: 4px;">jasnożółtym</span> oznaczone są dni wolne, w których osoba była w pracy (odbiła się kartą), ale nie ma zaakceptowanych godzin.</p>
                    <p>Kolorem <span class="holiday-accepted-day" style="padding: 4px;">żółtym</span> oznaczone są dni wolne, w których osoba ma zaakceptowane godziny pracy.</p>
                    <br>
                    <p><b>Przy dniach w których osoba była w pracy widnieje liczba godzin:</b>
                    <p>Dla zaakceptowanego dnia - zaakceptowane godzin</p>
                    <p>Dla niezaakceptowanego dnia - liczba godzin według systemu (czas między odbiciem wejścia i wyjścia). Jeśli danego dnia nie było odbitego wyjścia czas będzie wynosił 0.</p>
                        
                    </p>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="">Wybierz pracownika i datę</h2>
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
                            <div class="form-group row m-3">
                                <label for="u_id" class="col-sm-2 col-form-label">Pracownik:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="u_id" name="u_id" required>
                                        <?php 
                                            foreach($data["users"] as $user) {
                                                $sel = "";
                                                if ($data["u_id"] == $user->id) {
                                                    $sel = "selected";
                                                }
                                                echo '<option value="' . $user->id . '" ' . $sel . '>' . $user->first_name .' '. $user->last_name . '</option>';
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
                if($data["show_calendar"] == true) {
            ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Kalendarz - dni wolne</h2>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Szczegółowa lista godzin</h2>
                </div>
                <div class="card-body">
                <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Data</th>
                                <th scope="col">Pierwsze wejście</th>
                                <th scope="col">Ostatnie wyjście</th>
                                <th scope="col">Czas pracy</th>
                                <th scope="col">Wejście</th>
                                <th scope="col">Wyjście</th>
                                <th scope="col">Akcja</th>
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
                                    $date->setDate($year, $month, $day);
                                    $holiday = "";
                                    if(!isset($data["accepted"][$date->format('Y-m-d')])) {
                                        foreach($data["holidays"] as $holi) {
                                            if($holi->date == $date->format('Y-m-d')) {
                                                $holiday = ' class="calendar-holiday"';
                                            }
                                        }
                                        //nie są zaakceptowane
                                        echo '<tr '.$holiday.'>';
                                        echo '<td>'.$date->format('d-m-Y').'</td>';
                                        $wymiar = "";
                                        $in = "";
                                        $out = "";
                                        $work_time = "";
                                        if(isset($data["scans_ok"][$date->format('Y-m-d')])) {
                                            $wymiar = count($data["scans_ok"][$date->format('Y-m-d')]);
                                            $in = $data["scans_ok"][$date->format('Y-m-d')][0]["in"];
                                            $out = $data["scans_ok"][$date->format('Y-m-d')][$wymiar-1]["out"];
                                            $work_time = showInHours($work[$date->format('Y-m-d')]);
                                        }
                                        echo '<td>'.subYear($in).'</td>';
                                        echo '<td>'.subYear($out).'</td>';
                                        echo '<td>'.$work_time.'</td>';
                                        $not_accepted = false;

                                        if($work_time != "") $not_accepted = true;

                                        if($not_accepted == true) {
                                            echo '<td colspan="3">Oczekuje na akceptację godzin</td>';
                                        } else {
                                            //zaakceptowane godziny, czyli do zmiany
                                            echo '<form method="post">';
                                            ?>
                                            <td>
                                                <div class="input-group mb-3" style="min-width: 140px">
                                                    <span class="input-group-text" id="accept_in"><i class="fa-solid fa-arrow-right-to-bracket"></i></span>
                                                    <input type="time" class="form-control" name="accept_in" required>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group mb-3" style="min-width: 140px">
                                                    <span class="input-group-text" id="accept_in"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                                                    <input type="time" class="form-control" name="accept_out" required>
                                                </div>
                                            </td>
                                            
                                            <?php
                                            echo '<input hidden type="text" name="u_id" value="'.$data["u_id"].'">';
                                            echo '<input hidden type="text" name="date_sel" value="'.$date->format('Y-m-d').'">';
                                            echo '<td><button class="w-40 btn btn-sm btn-primary" type="submit" name="save_add" value=1>Dodaj</button></td>';
                                            echo '</form>';
                                        }
                                        echo '</tr>';
                                    } else {
                                        //są zaakceptowane
                                        foreach($data["holidays"] as $holi) {
                                            if($holi->date == $date->format('Y-m-d')) {
                                                $holiday = ' class="calendar-holiday"';
                                            }
                                        }
                                        echo '<tr '.$holiday.'>';
                                        echo '<td>'.$date->format('d-m-Y').'</td>';
                                        $wymiar = "";
                                        $in = "";
                                        $out = "";
                                        $work_time = "";
                                        if(isset($data["accepted"][$date->format('Y-m-d')])) {
                                            $in = $data["accepted"][$date->format('Y-m-d')]->accept_in;
                                            $out = $data["accepted"][$date->format('Y-m-d')]->accept_out;
                                            $work_time = showInHours($data["accepted"][$date->format('Y-m-d')]->accept_time);
                                        }
                                        echo '<td>'.$in.'</td>';
                                        echo '<td>'.$out.'</td>';
                                        echo '<td>'.$work_time.'</td>';

                                        echo '<form method="post">';
                                        ?>
                                        <td>
                                            <div class="input-group mb-3" style="width: 140px">
                                                <span class="input-group-text" id="accept_in"><i class="fa-solid fa-arrow-right-to-bracket"></i></span>
                                                <input type="time" class="form-control" name="accept_in" value="<?=$in;?>" required>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="accept_in"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                                                <input type="time" class="form-control" name="accept_out" value="<?=$out;?>" required>
                                            </div>
                                        </td>
                                        
                                        <?php
                                        echo '<input hidden type="text" name="u_id" value="'.$data["u_id"].'">';
                                        echo '<input hidden type="text" name="date_sel" value="'.$date->format('Y-m-d').'">';
                                        echo '<input hidden type="text" name="row_id" value="'.$data["accepted"][$date->format('Y-m-d')]->id.'">';
                                        echo '<td><button class="w-40 btn btn-sm btn-primary" type="submit" name="save_edit" value=1>Zapisz zmiany</button></td>';
                                        echo '</form>';
                                        
                                        echo '</tr>';
                                    }

                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>



            <?php
                }
            ?>
        </main>

        <?php 
            $freeDays = $data["holidays"];
            $accepted = $data["accepted"];
            $workHour = $data["work"];
        ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        const monthNames = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

        // Importowanie danych z PHP
        const freeDays = <?php echo json_encode($freeDays); ?>;
        const accepted = <?php echo json_encode($accepted); ?>;
        const workHour = <?php echo json_encode($workHour); ?>;
        console.log(freeDays);
        console.log(accepted);
        console.log(workHour);

        function updateHeader(month, year) {
            $('#calendarHeader').text(`Kalendarz - ${monthNames[month]} ${year}`);
        }

        function generateCalendar(month, year) {
            let daysInMonth = new Date(year, month + 1, 0).getDate();
            let firstDay = (new Date(year, month, 1).getDay() + 6) % 7; // Adjusted to start on Monday
            let calendarBody = `<table class="table calendar">
                                    <thead>
                                        <tr>
                                            <th class="header">Poniedziałek</th>
                                            <th class="header">Wtorek</th>
                                            <th class="header">Środa</th>
                                            <th class="header">Czwartek</th>
                                            <th class="header">Piątek</th>
                                            <th class="header">Sobota</th>
                                            <th class="header">Niedziela</th>
                                        </tr>
                                    </thead>
                                    <tbody><tr>`;

            for (let i = 0; i < firstDay; i++) {
                calendarBody += '<td></td>';
            }

            for (let day = 1; day <= daysInMonth; day++) {
                let dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                let freeDay = freeDays.find(day => day.date === dateString);
                let cellClass = freeDay ? 'holiday' : '';
                let acceptTime = '';
                let workHoursInfo = '';

                // Sprawdzenie czy dzień jest zaakceptowany
                if (accepted.hasOwnProperty(dateString)) {
                    cellClass += ' accepted-day';
                    let seconds = parseInt(accepted[dateString].accept_time); // Konwersja na liczby sekund
                    let formattedTime = formatTime(seconds); // Formatowanie czasu
                    if(freeDay) {
                        cellClass = 'holiday-accepted-day';// work-hours
                        acceptTime = `<div class="accept-time-black">${formattedTime} RBH</div>`;
                    } else {
                        acceptTime = `<div class="accept-time">${formattedTime} RBH</div>`;
                    }
                } else {
                    
                    // Sprawdzenie czy są godziny pracy dla tego dnia
                    if (workHour.hasOwnProperty(dateString)) {
                        cellClass += ' work-hours';
                        if(freeDay) {
                            cellClass = 'holiday-work-hours';
                        }
                        let seconds = parseInt(workHour[dateString]); // Pobranie liczby sekund pracy
                        let formattedTime = formatTime(seconds); // Formatowanie czasu
                        workHoursInfo = `<div class="accept-time-black">${formattedTime} RBH</div>`;
                    }
                }

                if ((day + firstDay - 1) % 7 == 0 && day != 1) {
                    calendarBody += '</tr><tr>';
                }
                calendarBody += `<td class="${cellClass.trim()}" data-date="${dateString}" data-reason="${freeDay ? freeDay.reason : ''}">
                                    ${day}
                                    ${acceptTime}
                                    ${workHoursInfo}
                                 </td>`;
            }

            while ((daysInMonth + firstDay) % 7 != 0) {
                calendarBody += '<td></td>';
                daysInMonth++;
            }

            calendarBody += '</tr></tbody></table>';
            $('#calendar').html(calendarBody);
        }

        function formatTime(seconds) {
            let hours = Math.floor(seconds / 3600);
            let minutes = Math.floor((seconds % 3600) / 60);
            let secs = seconds % 60;

            hours = String(hours).padStart(2, '0');
            minutes = String(minutes).padStart(2, '0');
            secs = String(secs).padStart(2, '0');

            return `${hours}:${minutes}:${secs}`;
        }

        function updateCalendar() {
            updateHeader(currentMonth, currentYear);
            generateCalendar(currentMonth, currentYear);
        }

        $('#prevMonth').click(function() {
            if (currentMonth == 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            updateCalendar();
        });

        $('#nextMonth').click(function() {
            if (currentMonth == 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            updateCalendar();
        });

        updateCalendar();
    });
</script>
        <?php require_once 'landings/footer.view.php' ?>