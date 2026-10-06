<?php
session_start();
require "db.php";
require "functions.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    setFlash("Invalid task ID.", "error");
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([$id]);

setFlash("Task deleted successfully.");
header("Location: index.php");
exit;
?>
