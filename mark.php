<?php
$conn = new mysqli("localhost","root","","todo");

$id = $_GET['id'];

$conn->query("UPDATE tasks SET status = NOT status WHERE id=$id");

header("Location: index.php");
?>
