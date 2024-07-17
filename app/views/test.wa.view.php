<?php
// webhook.php

// Ustaw odpowiedni nagłówek Content-Type
header("Content-Type: application/json");

// Funkcja do weryfikacji webhooka
function verifyWebhook() {
    $verify_token = "verona123"; // Ustaw swój token weryfikacyjny
    
    // Sprawdź, czy wszystkie parametry są obecne
    if (isset($_GET['hub_mode']) && $_GET['hub_mode'] === 'subscribe' &&
        isset($_GET['hub_verify_token']) && $_GET['hub_verify_token'] === $verify_token) {
        
        // Zwróć wyzwanie weryfikacyjne
        echo $_GET['hub_challenge'];
        exit;
    } else {
        // Nieudana weryfikacja
        http_response_code(403);
        echo json_encode(['error' => 'Invalid verification token']);
        exit;
    }
}

// Funkcja do obsługi żądania POST
function handlePostRequest() {
    // Odczytaj dane z żądania POST
    $request = file_get_contents("php://input");
    $data = json_decode($request, true);

    // Przykład prostego logowania otrzymanych danych do pliku
    file_put_contents(IMG_ROOT_UPLOAD."webhook_log.txt", print_r($data, true), FILE_APPEND);

    // Przykład odpowiedzi na webhook - tutaj po prostu potwierdzamy odbiór
    $response = [
        'status' => 'success',
        'message' => 'Webhook received'
    ];

    echo json_encode($response);
}

// Sprawdź metodę żądania
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    verifyWebhook();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
} else {
    // Obsługa innych metod HTTP, jeśli konieczne
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
?>
