<?php
session_start();
require "db.php";
require "functions.php";

$filter = $_GET["filter"] ?? "all";

if ($filter === "incomplete") {
    $stmt = $pdo->query("SELECT * FROM tasks WHERE completed = 0 ORDER BY due_date ASC");
} else {
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY due_date ASC");
}

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
$flash = getFlash();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Student Task Manager</h1>

    <?php if ($flash): ?>
        <div class="flash <?= htmlspecialchars($flash["type"]) ?>">
            <?= htmlspecialchars($flash["message"]) ?>
        </div>
    <?php endif; ?>

    <div class="top-bar">
        <a class="button" href="create.php">+ Add Task</a>
        <a href="index.php">All Tasks</a>
        <a href="index.php?filter=incomplete">Incomplete Tasks</a>
    </div>

    <p>Total tasks: <?= count($tasks) ?></p>

    <?php if (count($tasks) > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task["title"]) ?></td>
                    <td><?= htmlspecialchars($task["category"]) ?></td>
                    <td><?= htmlspecialchars($task["priority"]) ?></td>
                    <td><?= htmlspecialchars($task["due_date"]) ?></td>
                    <td>
                        <?= $task["completed"] ? "Completed" : "Incomplete" ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $task["id"] ?>">Edit</a>
                        |
                        <a href="delete.php?id=<?= $task["id"] ?>"
                           onclick="return confirm('Delete this task?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</div>
</body>
</html>
