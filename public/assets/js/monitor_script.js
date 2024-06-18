function toggleButton(btnId) {
    var btn = document.getElementById(btnId);
    btn.classList.toggle('active');
}

function refreshPage() {
    location.reload();
}

function updateDateTime() {
    var now = new Date();
    var datetime = now.toLocaleString('pl-PL');
    document.getElementById('datetime').textContent = datetime;
}

updateDateTime(); // Aktualizacja daty i godziny na stronie
setInterval(updateDateTime, 1000); // Aktualizacja co sekundę

let clickedStatus = 0;

async function readNFC(action) {
    const output = document.getElementById('output');
    try {
        const ndef = new NDEFReader();
        await ndef.scan();
        output.textContent = 'Zbliż kartę NFC do urządzenia...';
        ndef.onreading = event => {
            const message = event.message;
            output.textContent = 'Odczytano wiadomość NFC:\n';
            for (const record of message.records) {
                output.textContent += `Typ: ${record.recordType}\n`;
                output.textContent += `MIME: ${record.mediaType}\n`;
                const textDecoder = new TextDecoder(record.encoding);
                output.textContent += `Dane: ${textDecoder.decode(record.data)}\n`;
                addLog(action, textDecoder.decode(record.data));
            }
        };
    } catch (error) {
        output.textContent = `Błąd: ${error.message}`;
    }
}

function addLog(action, data) {
    var now = new Date();
    var time = now.toLocaleTimeString();
    var logEntry = document.createElement('li');
    logEntry.textContent = `${action} - ${time} - ${data}`;
    document.getElementById('logList').appendChild(logEntry);
}

// Pobranie referencji do przycisków
const enterBtn = document.getElementById('enterBtn');
const exitBtn = document.getElementById('exitBtn');
const info = document.getElementById('info');
const output = document.getElementById('output');

// Funkcja aktualizująca tekst w elemencie output na podstawie stanu przycisków
function updateActionText() {
    if (enterBtn.classList.contains('clicked')) {
        info.textContent = 'Wejście';
    } else if (exitBtn.classList.contains('clicked')) {
        info.textContent = 'Wyjście';
    } else {
        info.textContent = 'Oczekiwanie';
    }
}
function handleButtonClick(btnId) {
    const button = document.getElementById(btnId);
    if(btnId==="enterBtn") {
        if(clickedStatus === 1) {
            clickedStatus = 0
            info.textContent = 'Oczekiwanie';
            stopScanner();
        } else {
            clickedStatus = 1;
            info.textContent = 'Wejście';
            startScanner(0);
        }
    }
    if(btnId==="exitBtn") {
        if(clickedStatus === 2) {
            clickedStatus = 0;
            info.textContent = 'Oczekiwanie';
            stopScanner();
        } else {
            clickedStatus = 2;
            info.textContent = 'Wyjście';
            startScanner(0);
        }
    }
    console.log(clickedStatus);
    updateClasses();
}






function updateClasses() {
    enterBtn.classList.remove('clicked', 'disable');
    exitBtn.classList.remove('clicked', 'disable');
    if(clickedStatus === 1) {
        exitBtn.classList.add('disable');
        enterBtn.classList.add('clicked');
    }
    if(clickedStatus === 2) {
        enterBtn.classList.add('disable');
        exitBtn.classList.add('clicked');
    }
    if(clickedStatus === 3) {
        enterBtn.classList.add('disable');
        exitBtn.classList.add('disable');
        clickedStatus = 0;
        info.textContent = 'Wyświetlanie';
        wait(4000);
    }
}
// Funkcja obsługująca kliknięcie przycisku
function handleButtonClick2(btnId) {
    const button = document.getElementById(btnId);
    clickedStatus = 0;
    if (button.classList.contains('disable')) {
        // Kliknięto przycisk z klasą disable
        enterBtn.classList.remove('clicked', 'disable');
        exitBtn.classList.remove('clicked', 'disable');

        button.classList.add('clicked');
        if (btnId === 'enterBtn') {
            exitBtn.classList.add('disable');
        } else if (btnId === 'exitBtn') {
            enterBtn.classList.add('disable');
        }
    } else {
        // Kliknięto przycisk bez klasy disable
        if (button.classList.contains('clicked')) {
            // Usuń klasę clicked z klikniętego przycisku
            button.classList.remove('clicked');
            // Usuń klasę disable z drugiego przycisku
            if (btnId === 'enterBtn') {
                exitBtn.classList.remove('disable');
            } else if (btnId === 'exitBtn') {
                enterBtn.classList.remove('disable');
            }
            // Zatrzymaj skanowanie jeśli żaden przycisk nie jest kliknięty
            stopScanner();
        } else {
            // Dodaj klasę clicked do klikniętego przycisku
            button.classList.add('clicked');
            // Dodaj klasę disable do drugiego przycisku
            if (btnId === 'enterBtn') {
                exitBtn.classList.add('disable');
            } else if (btnId === 'exitBtn') {
                enterBtn.classList.add('disable');
            }
            // Rozpocznij skanowanie
            startScanner(0);
        }
    }

    // Aktualizacja tekstu w elemencie output na podstawie stanu przycisków
    updateActionText();

    // Wywołanie funkcji readNFC z odpowiednim argumentem
    const action = btnId === 'enterBtn' ? 'Wejście' : 'Wyjście';
    readNFC(action);
}

// Wywołanie funkcji na starcie, aby ustawić domyślny tekst
updateActionText();
