<?php
// Endpoint URL do wysyłania wiadomości
$url = 'https://graph.facebook.com/v19.0/363635803503920/messages';

// Token dostępu
$token = 'EAAFI0kVV4xEBO8vJVr9kIeB4xY0rIHR1mfkyu8F5dGujigvL5buUvcBHqLeIE5FAjVt4J3FhrNXnQgVm6dQ6sr6TByNYb0A3vfKeb6qcNM975mSTxKL9Vin000ZCSRZAGGJt2O4ouZB9ZAZBcYy16KJLUXcg4WHqhGtwj2PcQvSpSoa4LfWynGZCM36dUlmCn6YwBit2pgfQbYIA0CYaZA2';

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
            'code' => 'pl' //en_US
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
