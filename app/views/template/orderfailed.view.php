<!DOCTYPE html> 
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieudana płatność</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #c00;
        }

        p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cześć, <?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?>!</h2>
        <p>Twoja płatność za zamówienie <strong>#<?= htmlspecialchars($order_number) ?></strong> nie powiodła się.</p>
        <p>Prosimy o ponowną próbę zamówienia.</p>
        <p>Jeśli problem będzie się powtarzał, skontaktuj się z naszym działem obsługi klienta.</p>
        <p>Pozdrawiamy,<br><strong>Zespół Pan Obiadek</strong></p>
    </div>
</body>

</html>