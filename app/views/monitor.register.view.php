<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel rejestracji czasu pracy - Pan Obiadek</title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/monitor_styles.css">
</head>
<body>
    <header>
        <div class="header-left">
            <p>Pan Obiadek</p>
        </div>
        <div>
            <p>ul. Traugutta 1</p>
        </div>
        <div class="header-right">
            <p id="datetime"></p>
        </div>
    </header>
    <main>
        <div class="main-left">
        <button id="enterBtn" onclick="handleButtonClick('enterBtn')" class="action-btn original-button button-in">
            <div style="width: 50%; margin: 20px auto;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5V448H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H96 288h32V480 32zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128h96V480c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H512V128c0-35.3-28.7-64-64-64H352v64z"/>
                </svg>
            </div>
            Wejście
        </button>
        <button id="exitBtn" onclick="handleButtonClick('exitBtn')" class="action-btn original-button button-out">
            <div style="width: 50%; margin: 20px auto;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M96 64c0-35.3 28.7-64 64-64H416c35.3 0 64 28.7 64 64V448h64c17.7 0 32 14.3 32 32s-14.3 32-32 32H432 144 32c-17.7 0-32-14.3-32-32s14.3-32 32-32H96V64zM384 288a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                </svg>
            </div>
            Wyjście
        </button>
        </div>
        <div class="main-right">
            <div class="status-container">
                <span><b>Status: </b></span>
                <span id="info"></span>
            </div>
            <div class="log-container">
                <p>Witaj,</p>
                <p><b>Imię Nazwisko!</b></p>
                <div style="width: 100%">
                    <table class="workhours">
                        <thead>
                            <tr>
                                <th>Wejścia</th>
                                <th>Wyjścia</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>8.00h</td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>08:00:00</td>
                                <td>16:00:00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul id="logList"></ul>
            </div>
            <div class="error-container">
                <p>Komunikaty:
                    <pre id="output"></pre>
                </p>
            </div>
        </div>
    </main>

    <script type="text/javascript"
            src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <script type="text/javascript">
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });

function startScanner(camIndex) {
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            console.log(cameras);
            if (camIndex >= cameras.length) {
                console.log("Invalid camera index");
                output.textContent ="Invalid camera index";
                return;
            }
            scanner.start(cameras[camIndex]).catch(function (e) {
                console.error("Error starting camera:", e);
                console.log("Error starting camera: " + e.message);
                output.textContent ="Error starting camera: " + e.message;
            });
        } else {
            console.log("No cameras found.");
            output.textContent ="No cameras found.";
        }
    }).catch(function (e) {
        console.error(e);
    });
}

function stopScanner() {
    scanner.stop().then(function () {
        console.log("Scanner stopped.");
        output.textContent ="Scanner stopped.";
    }).catch(function (e) {
        console.error("Error stopping scanner:", e);
    });
}

            document.addEventListener("visibilitychange", function () {
            if (document.visibilityState === 'hidden') {
                stopScanner();
            } else if (document.visibilityState === 'visible') {
                startScanner(0);
            }
            });

            window.addEventListener("blur", function () {
            stopScanner();
            });

            window.addEventListener("focus", function () {
            startScanner(0);
            });

            window.addEventListener("beforeunload", function () {
            stopScanner();
            });



            //scan then qr code part
            scanner.addListener('scan', function (c) {
                addLog(clickedStatus, c);
                clickedStatus = 3;
                console.log(c);
                updateClasses();
            //let sendButton = document.getElementById("sendButton");
            //sendButton.click();
            });
        </script>


<style>
        /* Stylowanie modalu */
        .modal {
            display: none; /* Domyślnie ukryty */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span id="closeBtn">&times;</span>
        <p>To jest modal.</p>
    </div>
</div>

<script>
    // Funkcja otwierająca modal
    function showModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
        
        // Ukryj modal po 5 sekundach (5000 milisekund)
        setTimeout(function() {
            modal.style.display = "none";
        }, 5000);
    }

    // Pokaż modal przy załadowaniu strony
    window.onload = showModal;

    // Zamknij modal przy kliknięciu na <span> (X)
    document.getElementById("closeBtn").onclick = function() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    // Zamknij modal, gdy użytkownik kliknie poza nim
    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

    <footer>
        <button onclick="refreshPage()" class="refresh-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H352c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V80c0-17.7-14.3-32-32-32s-32 14.3-32 32v35.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V432c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H160c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/>
            </svg>
        </button>
        <p>E-mail: <a>helpdesk@pan-obiadek.pl</a> Telefon: <a>609 713 824</a> © Mateusz Zybura 2024</p>
    </footer>
    <script src="<?=ROOT?>/assets/js/monitor_script.js"></script>
</body>
</html>
