<!DOCTYPE html> 
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potwierdzenie rejestracji</title>
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
            background: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .a {
            color: #fff;
        }

        .btn:hover {
            background: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cześć, <?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?>!</h2>
        <p>Dziękujemy za rejestrację w naszym serwisie!</p>
        <p>Aby przejść do swojego panelu użytkownika, kliknij tutaj: <a href="<?= htmlspecialchars($link) ?>">Przejdź do panelu</a></p>
        <p>Życzymy miłego korzystania z naszych usług!</p>
        <p>Pozdrawiamy,<br><strong>Zespół Pan Obiadek</strong></p>
    </div>
</body>

</html>
