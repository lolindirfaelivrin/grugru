<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utenti</title>
    <link rel="stylesheet" href="./css/ossicino.min-0.2.css">
</head>
<body>
    
</body>
</html>
<h1>Utente</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($dati as $dato): ?>
        <tr>
            <td><?php echo $dato->id ?></td>
            <td><?php echo $dato->email?></td>
            <td><?php echo $dato->password?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>