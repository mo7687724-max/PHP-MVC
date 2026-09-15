<?php
$base = (isset($_SERVER['SCRIPT_NAME']) && ($d = dirname($_SERVER['SCRIPT_NAME'])) && $d !== '/' && $d !== '\\') ? preg_replace('#/public$#', '', $d) : '/php-mvc';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>

<body>
    <h1>Edit User</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <h3>Please fix the following:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= $base ?>/users/update" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
        </div>
        <br>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        </div>
        <br>

        <button type="submit">Update</button>
    </form>
    <br>
    <a href="<?= $base ?>/users">Back</a>
</body>

</html>