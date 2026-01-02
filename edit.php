<?php
$conn = new mysqli("localhost", "root", "", "todo");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tasks WHERE id = $id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>

<button class="theme-toggle">🌙 Dark Mode</button>

<div class="container">

    <h2>Edit Task</h2>

    <form action="update.php" method="POST" class="add-form" onsubmit="return confirmEdit();">
        
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <input type="text" name="task" value="<?php echo $row['task']; ?>" required>

        <select name="category">
            <option value="General"  <?php if ($row['category']=="General") echo "selected"; ?>>General</option>
            <option value="School"   <?php if ($row['category']=="School") echo "selected"; ?>>School</option>
            <option value="Work"     <?php if ($row['category']=="Work") echo "selected"; ?>>Work</option>
            <option value="Personal" <?php if ($row['category']=="Personal") echo "selected"; ?>>Personal</option>
        </select>

        <!-- PRIORITY EDIT DROPDOWN -->
        <select name="priority">
            <option value="Low"    <?php if ($row['priority']=="Low") echo "selected"; ?>>Low</option>
            <option value="Medium" <?php if ($row['priority']=="Medium") echo "selected"; ?>>Medium</option>
            <option value="High"   <?php if ($row['priority']=="High") echo "selected"; ?>>High</option>
        </select>

        <button type="submit">Save</button>

    </form>

</div>

</body>
</html>
