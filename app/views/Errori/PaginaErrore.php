<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $messaggio ?></title>
    <style>
        body {
            display: grid;
            place-content: center;
            height: 100dvh;
            font-size: 2.5rem;
            background-color: #f0eded;
        }
    </style>
</head>
<body>
    <div>
        <span><?php echo $codice?></span> | <span><?php echo $messaggio ?></span>
    </div>
</body>
</html>