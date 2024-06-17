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
            <p>Pan Obiadek</p>
            <p>Lokalizacja</p>
        </div>
        <div class="header-right">
            <p id="datetime"></p>
    <button onclick="refreshPage()" class="refresh-btn">Odśwież</button>
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
            <div class="log-container">
                <span><b>Akcja: </b></span>
                <span id="info"></span>
                <p style="margin-top: 20px;">Komunikat:
                    <pre id="output"></pre>
                </p>
                <ul id="logList">
                    <!-- Logi będą dodawane dynamicznie przez JavaScript -->
                </ul>
            </div>
        </div>
    </main>

    <footer>
        
        <p>W razie problemów technicznych napisz e-mail na <a>mateusz.zybura@radluks.pl</a> lub zadzwoń <a>609 713 824</a> © Mateusz Zybura 2024</p>
    </footer>
    <script src="<?=ROOT?>/assets/js/monitor_script.js"></script>
</body>
</html>
