<?php
$base = (isset($_SERVER['SCRIPT_NAME']) && ($d = dirname($_SERVER['SCRIPT_NAME'])) && $d !== '/' && $d !== '\\') ? preg_replace('#/public$#', '', $d) : '/php-mvc';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users</title>
</head>

<body>
    <h1>User List</h1>

    <p>
        <a href="<?= $base ?>/users/create">+ Create New User</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="<?= $base ?>/users/show?id=<?= $user['id'] ?>">Show</a>
                            |
                            <a href="<?= $base ?>/users/edit?id=<?= $user['id'] ?>">Edit</a>
                            |
                            <form action="<?= $base ?>/users/delete" method="POST" style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <a href="<?= $base ?>/">Home</a>
</body>

</html>