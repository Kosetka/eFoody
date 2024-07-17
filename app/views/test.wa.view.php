<?php
// webhook.php

// Ustaw odpowiedni nagłówek Content-Type
header("Content-Type: application/json");

// Odczytaj dane z żądania POST
$request = file_get_contents("php://input");
$data = json_decode($request, true);

// Przykład prostego logowania otrzymanych danych do pliku
file_put_contents("webhook_log.txt", print_r($data, true), FILE_APPEND);

// Przykład odpowiedzi na webhook - tutaj po prostu potwierdzamy odbiór
$response = [
    'status' => 'success',
    'message' => 'Webhook received'
];

echo json_encode($response);