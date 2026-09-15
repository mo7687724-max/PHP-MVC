<?php
$base = (isset($_SERVER['SCRIPT_NAME']) && ($d = dirname($_SERVER['SCRIPT_NAME'])) && $d !== '/' && $d !== '\\') ? preg_replace('#/public$#', '', $d) : '/php-mvc';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Details</title>
</head>

<body>
    <h1>User Details</h1>

    <p><strong>ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Created At:</strong> <?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></p>

    <br>
    <a href="<?= $base ?>/users/edit?id=<?= $user['id'] ?>">Edit</a>
    |
    <a href="<?= $base ?>/users">Back to Users</a>
</body>

</html>