<?php

$verify_token = "verona123"; // Ustaw swój token weryfikacyjny
// Weryfikacja webhooka
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] === $verify_token) {
    echo $_GET['hub_challenge'];
    exit;
}

// Odbieranie wiadomości z webhooka
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

// Zapis do pliku log
file_put_contents(IMG_ROOT_UPLOAD.'webhook.log', print_r($data, true), FILE_APPEND);

if (!empty($data['entry'])) {
    foreach ($data['entry'] as $entry) {
        if (!empty($entry['messaging'])) {
            foreach ($entry['messaging'] as $messagingEvent) {
                if (!empty($messagingEvent['message'])) {
                    $senderId = $messagingEvent['sender']['id'];
                    $messageText = $messagingEvent['message']['text'];
                    
                    // Przetwarzanie odebranej wiadomości
                    file_put_contents(IMG_ROOT_UPLOAD.'messages.log', "From: $senderId - Message: $messageText\n", FILE_APPEND);
                    
                    // Możesz dodać logikę wysyłania odpowiedzi tutaj
                }
            }
        }
    }
}

http_response_code(200);
