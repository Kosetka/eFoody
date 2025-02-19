<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetowanie hasła</title>
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
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cześć, <?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?>!</h2>
        <p>Otrzymaliśmy prośbę o zmianę Twojego hasła. Nowe hasło zostało już ustawione, ale musisz je potwierdzić.</p>
        <p>Aby zakończyć proces, kliknij tutaj: <a href="<?= htmlspecialchars($reset_link) ?>" class="">Potwierdź zmianę hasła</a></p>
        
        <p><strong>Uwaga:</strong> Link jest ważny przez 24 godziny. Po tym czasie konieczne będzie ponowne
            wygenerowanie nowego hasła.</p>
        <p>Jeśli to nie Ty inicjowałeś tę zmianę, zignoruj tę wiadomość.</p>
        <p>Pozdrawiamy,<br><strong>Pan Obiadek</strong></p>
    </div>
</body>

</html>