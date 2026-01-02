<?php
$conn = new mysqli("localhost", "root", "", "todo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

if ($sort === 'priority') {
    $sql = "
        SELECT * FROM tasks
        ORDER BY 
            CASE 
                WHEN priority = 'High' THEN 1
                WHEN priority = 'Medium' THEN 2
                WHEN priority = 'Low' THEN 3
            END,
            id DESC
    ";
} elseif ($sort === 'smart') {
    // --- SMART SORTING LOGIC ---
    // Score based on priority, category, and task age
    $sql = "
        SELECT *,
        (
            CASE priority
                WHEN 'High' THEN 3
                WHEN 'Medium' THEN 2
                ELSE 1
            END
            +
            CASE category
                WHEN 'Work' THEN 2
                WHEN 'School' THEN 2
                ELSE 0
            END
            +
            CASE
                WHEN created_at < DATE_SUB(NOW(), INTERVAL 2 DAY) THEN 1
                ELSE 0
            END
        ) AS smart_score
        FROM tasks
        ORDER BY smart_score DESC, id DESC
    ";
} else {
    // Default sorting
    $sql = "SELECT * FROM tasks ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>

<button class="theme-toggle">🌙 Dark Mode</button>

<div class="container">
    <h2>To-Do List</h2>

    <form action="add.php" method="POST" class="add-form" onsubmit="return confirmAdd();">
        <input type="text" name="task" placeholder="Task description" required>

        <select name="category">
            <option value="General">General</option>
            <option value="School">School</option>
            <option value="Work">Work</option>
            <option value="Personal">Personal</option>
        </select>

        <select name="priority">
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>

        <button type="submit">Add</button>
    </form>

    <div class="sort">
        <a href="index.php">Default</a>
        <a href="index.php?sort=priority">Sort by Priority</a>
        <a href="index.php?sort=smart">Smart Order</a>
    </div>

    <ul class="task-list">
        <?php while($row = $result->fetch_assoc()): ?>
         <li class="<?php echo $row['status'] ? 'done' : ''; ?> priority-<?php echo strtolower($row['priority']); ?>">
                <span>
                <?php echo htmlspecialchars($row['task'], ENT_QUOTES, 'UTF-8'); ?>

                <small class="cat">
                    <?php echo htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8'); ?>
                </small>

                <small class="priority-badge <?php echo strtolower($row['priority']); ?>">
                    <?php echo htmlspecialchars($row['priority'], ENT_QUOTES, 'UTF-8'); ?>
                </small>
            </span>


                <div class="actions">
                    <a href="mark.php?id=<?php echo $row['id']; ?>">✔</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">✏</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();">🗑</a>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>

</div>

</body>
</html>
