<!DOCTYPE html> 
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potwierdzenie zamówienia</title>
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

        h2, h3 {
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .order-section {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .order-item img {
            max-width: 80px;
            margin-right: 15px;
            border-radius: 5px;
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

        .btn:hover {
            background: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Cześć, <?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?>!</h2>
        <p>Dziękujemy za Twoje zamówienie w <strong>Pan Obiadek</strong>!</p>
        <p>Numer zamówienia: <strong><?= htmlspecialchars($order_number) ?></strong></p>
        <p>Adres dostawy: <strong><?= htmlspecialchars($address) ?></strong></p>
        <p>Płatność: <strong><?= htmlspecialchars($payment) ?></strong></p>
        
        <?php foreach ($delivery_details as $delivery): ?>
            <div class="order-section">
                <h3>Dostawa na dzień: <?= htmlspecialchars($delivery['date']) ?></h3>
                
                
                <h4>Twoje zamówienie:</h4>
                <?php foreach ($delivery['items'] as $item): ?>
                    <div class="order-item">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div>
                            <p><strong><?= htmlspecialchars($item['name']) ?></strong></p>
                            <p>Ilość: <?= htmlspecialchars($item['quantity']) ?> | Cena: <?= htmlspecialchars($item['price']) ?> zł</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        
        <p>Łączna kwota zamówienia: <strong><?= htmlspecialchars($total_price) ?> zł</strong></p>

        <p>Jeśli masz jakiekolwiek pytania, skontaktuj się z nami.</p>
        <p>Pozdrawiamy,<br><strong>Pan Obiadek</strong></p>
    </div>
</body>

</html>