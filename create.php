<?php
session_start();
require "db.php";
require "functions.php";

$errors = [];
$title = "";
$description = "";
$category = "";
$priority = "Medium";
$due_date = "";
$completed = 0;

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
            "INSERT INTO tasks (title, description, category, priority, due_date, completed)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $title,
            $description,
            $category,
            $priority,
            $due_date,
            $completed
        ]);

        setFlash("Task added successfully.");
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add Task</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>">

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea>

        <label>Category</label>
        <input type="text" name="category" value="<?= htmlspecialchars($category) ?>">

        <label>Priority</label>
        <select name="priority">
            <option value="Low" <?= $priority === "Low" ? "selected" : "" ?>>Low</option>
            <option value="Medium" <?= $priority === "Medium" ? "selected" : "" ?>>Medium</option>
            <option value="High" <?= $priority === "High" ? "selected" : "" ?>>High</option>
        </select>

        <label>Due Date</label>
        <input type="date" name="due_date" value="<?= htmlspecialchars($due_date) ?>">

        <label>
            <input type="checkbox" name="completed" <?= $completed ? "checked" : "" ?>>
            Completed
        </label>

        <button type="submit">Add Task</button>
        <a href="index.php">Cancel</a>
    </form>
</div>
</body>
</html>
