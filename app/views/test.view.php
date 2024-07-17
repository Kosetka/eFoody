<?php
// Endpoint URL do wysyłania wiadomości
$url = 'https://graph.facebook.com/v19.0/363618450171455/messages';

// Token dostępu
$token = 'EAAFI0kVV4xEBOZB5ZCKAJaXahdQ91ZCD7wEnElXHtwBRG6n5IFm9AE5eVsiXbLom2tqqIkM4wJeOSNsUPyZBD6ZAwH7DLrNuwKoG5xG3naRou8GbSbDROrblcVMki8K3kpBRPsuOfxSdCOE4ZCjFkwu7qzrZA4uuepdXp6dNzhZAeH0fQtueBOMMfAwegg7NxZBHZCdrCJ6hYZAVxTZADBY6MBcZD';

// Numer telefonu odbiorcy
$recipientPhoneNumber = '48609713824';

// Dane do wysłania
$data = [
    'messaging_product' => 'whatsapp',
    'to' => $recipientPhoneNumber,
    'type' => 'template',
    'template' => [
        'name' => 'ulotka', //hello_world
        'language' => [
            'code' => 'pl_PL' //en_US
        ]
    ]
];

// Inicjalizacja cURL
$ch = curl_init($url);

// Ustawienia cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Wykonanie zapytania
$response = curl_exec($ch);

// Zamknięcie cURL
curl_close($ch);

// Wyświetlenie odpowiedzi
echo $response;
