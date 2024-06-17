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
const output = document.getElementById('info');

// Funkcja aktualizująca tekst w elemencie output na podstawie stanu przycisków
function updateActionText() {
    if (enterBtn.classList.contains('clicked')) {
        output.textContent = 'Wejście';
    } else if (exitBtn.classList.contains('clicked')) {
        output.textContent = 'Wyjście';
    } else {
        output.textContent = 'Oczekiwanie';
    }
}

// Funkcja obsługująca kliknięcie przycisku
function handleButtonClick(btnId) {
    const button = document.getElementById(btnId);

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
        } else {
            // Dodaj klasę clicked do klikniętego przycisku
            button.classList.add('clicked');
            // Dodaj klasę disable do drugiego przycisku
            if (btnId === 'enterBtn') {
                exitBtn.classList.add('disable');
            } else if (btnId === 'exitBtn') {
                enterBtn.classList.add('disable');
            }
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




