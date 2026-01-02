<?php
$conn = new mysqli("localhost", "root", "", "todo");

$id = $_POST['id'];
$task = $_POST['task'];
$category = $_POST['category'];
$priority = $_POST['priority'];

$conn->query("
    UPDATE tasks 
    SET task='$task', category='$category', priority='$priority'
    WHERE id=$id
");

header("Location: index.php");
?>
