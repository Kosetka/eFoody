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
    </style>

<div id="layoutSidenav">
    <?php require_once 'landings/sidebar.left.view.php' ?>
    <div id="layoutSidenav_content">
        <main class="form-signin container h-100 text-center" style="padding-top: 40px; max-width: 100%">
            <div class="card mb-4">
                <div class="card-header">
                    <h2 id="calendarHeader" class="">Kalendarz - dni wolne</h2>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                    <button id="prevMonth" class="btn btn-primary">Poprzedni miesiąc</button>
                    <button id="nextMonth" class="btn btn-primary">Następny miesiąc</button>
                </div>
            </div>

        </main>

<!-- Modal -->
<div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel">Podaj powód dnia wolnego</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reasonForm" method="POST" action="">
                    <div class="mb-3">
                        <label for="date" class="form-label">Data</label>
                        <input type="text" class="form-control bg-dark text-light" id="date" name="date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Powód</label>
                        <textarea class="form-control bg-dark text-light" id="reason" name="reason" required rows="3"></textarea>
                    </div>
                    <div class="mb-3" id="deleteContainer" style="margin-left: 40px;">
                        <input type="checkbox" id="delete" name="delete" class="form-check-input">
                        <label for="delete" class="form-check-label">Usuń</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </form>
            </div>
        </div>
    </div>
</div>


        <?php 
            $freeDays = $data["holidays"];
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
            
            // Dodanie klasy current-day dla dzisiejszej daty
            if (dateString === today.toISOString().split('T')[0]) {
                cellClass += ' current-day';
            }
            
            if ((day + firstDay - 1) % 7 == 0 && day != 1) {
                calendarBody += '</tr><tr>';
            }
            calendarBody += `<td class="${cellClass.trim()}" data-date="${dateString}" data-reason="${freeDay ? freeDay.reason : ''}">${day}</td>`;
        }

        while ((daysInMonth + firstDay) % 7 != 0) {
            calendarBody += '<td></td>';
            daysInMonth++;
        }

        calendarBody += '</tr></tbody></table>';
        $('#calendar').html(calendarBody);

        $('.calendar td').click(function() {
            let date = $(this).data('date');
            let reason = $(this).data('reason');
            $('#date').val(date);
            $('#reason').val(reason);
            $('#delete').prop('checked', false);
            if (reason) {
                $('#deleteContainer').show();
            } else {
                $('#deleteContainer').hide();
            }
            $('#reasonModal').modal('show');
        });
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