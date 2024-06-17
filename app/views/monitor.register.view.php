<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona RFID</title>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/monitor_styles.css">
</head>
<body>
    <header>
        <div class="header-left">
            <p>Nazwa Firmy</p>
            <p>Lokalizacja</p>
        </div>
        <div class="header-right">
            <p id="datetime"></p>
        </div>
    </header>

    <main>
        <div class="main-left">
            <button id="enterBtn" onclick="readNFC('Wejście')" class="action-btn">Wejście</button>
            <button id="exitBtn" onclick="readNFC('Wyjście')" class="action-btn">Wyjście</button>
            <pre id="output"></pre>
        </div>
        <div class="main-right">
            <div class="log-container">
                <h2>Ostatnie działania:</h2>
                <ul id="logList">
                    <!-- Logi będą dodawane dynamicznie przez JavaScript -->
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <p>Numer telefonu: 123-456-789</p>
        <p>Adres email: admin@example.com</p>
        <button onclick="refreshPage()" class="refresh-btn">Odśwież</button>
    </footer>

    <script src="<?=ROOT?>/assets/js/monitor_script.js"></script>
</body>
</html>
