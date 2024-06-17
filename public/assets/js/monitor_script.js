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
