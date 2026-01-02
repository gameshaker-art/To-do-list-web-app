<?php
$conn = new mysqli("localhost", "root", "", "todo");

$task = $_POST['task'];
$category = $_POST['category'];
$priority = $_POST['priority'];

$conn->query("
    INSERT INTO tasks (task, category, priority)
    VALUES ('$task', '$category', '$priority')
");

header("Location: index.php");
?>
