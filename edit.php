<?php
session_start();
require "db.php";
require "functions.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid task ID.");
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Task not found.");
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $priority = $_POST["priority"] ?? "Medium";
    $due_date = $_POST["due_date"] ?? "";
    $completed = isset($_POST["completed"]) ? 1 : 0;

    if ($title === "") {
        $errors[] = "Title is required.";
    }

    if ($category === "") {
        $errors[] = "Category is required.";
    }

    if ($due_date === "") {
        $errors[] = "Due date is required.";
    }

    if (!in_array($priority, ["Low", "Medium", "High"])) {
        $errors[] = "Invalid priority.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "UPDATE tasks
             SET title = ?, description = ?, category = ?, priority = ?,
                 due_date = ?, completed = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $title,
            $description,
            $category,
            $priority,
            $due_date,
            $completed,
            $id
        ]);

        setFlash("Task updated successfully.");
        header("Location: index.php");
        exit;
    }

    $task["title"] = $title;
    $task["description"] = $description;
    $task["category"] = $category;
    $task["priority"] = $priority;
    $task["due_date"] = $due_date;
    $task["completed"] = $completed;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Task</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($task["title"]) ?>">

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($task["description"]) ?></textarea>

        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($task["category"]) ?>">

        <label>Priority</label>
        <select name="priority">
            <?php foreach (["Low", "Medium", "High"] as $option): ?>
                <option value="<?= $option ?>"
                    <?= $task["priority"] === $option ? "selected" : "" ?>>
                    <?= $option ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Due Date</label>
        <input type="date" name="due_date" value="<?= htmlspecialchars($task["due_date"]) ?>">

        <label>
            <input type="checkbox" name="completed" <?= $task["completed"] ? "checked" : "" ?>>
            Completed
        </label>

        <button type="submit">Save Changes</button>
        <a href="index.php">Cancel</a>
    </form>
</div>
</body>
</html>
