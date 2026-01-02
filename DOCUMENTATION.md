# To-Do List Application - Complete Documentation

## Table of Contents
1. [Overview](#overview)
2. [Database](#database)
3. [Design & Styling](#design--styling)
4. [Dark Mode Feature](#dark-mode-feature)
5. [Task Input Bar](#task-input-bar)
6. [Task Markers & Badges](#task-markers--badges)
7. [Action Buttons (Check, Edit, Delete)](#action-buttons-check-edit-delete)
8. [Sorting Functionality](#sorting-functionality)
9. [Setup & Installation](#setup--installation)

---

## Overview

The To-Do List Application is a full-stack web application built with **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. It allows users to create, manage, categorize, and prioritize tasks with an intuitive interface that supports both light and dark modes.

**Key Features:**
- Add, edit, and delete tasks
- Categorize tasks (General, School, Work, Personal)
- Set task priorities (Low, Medium, High)
- Mark tasks as complete
- Sort tasks by priority
- Toggle between light and dark themes
- Responsive design
- Submit confirmations

---

## Database

### Database Structure

The application uses **MySQL** database named `todo` with a single table called `tasks`.

**SQL Creation Script:**

```sql
CREATE DATABASE IF NOT EXISTS todo
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;
USE todo;

CREATE TABLE IF NOT EXISTS tasks (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  task VARCHAR(255) NOT NULL,
  category VARCHAR(50) NOT NULL DEFAULT 'General',
  priority ENUM('Low','Medium','High') NOT NULL DEFAULT 'Low',
  status TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

**File:** `create_todo.sql`

### Database Connection

**File:** [db.php](db.php)

The database connection is configured in `db.php` with fallback defaults:

```php
<?php
// Load .env if present and phpdotenv is installed (optional)
if (file_exists(__DIR__ . '/.env')) {
    if (!class_exists('Dotenv\Dotenv') && file_exists(__DIR__ . '/vendor/autoload.php')) {
        require_once __DIR__ . '/vendor/autoload.php';
    }
    if (class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
}

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$dbname = $_ENV['DB_NAME'] ?? 'todo';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
```

**Connection Details:**
- **Host:** localhost
- **User:** root
- **Database:** todo
- **Charset:** utf8mb4

---

## Design & Styling

### CSS Architecture

The application uses **CSS custom properties (variables)** for theming, making it easy to switch between light and dark modes.

**File:** [style.css](style.css)

**Theme Variables:**

```css
:root {
    --bg-main: #f8f9fa;
    --bg-card: #ffffff;
    --text-primary: #1a1a1a;
    --text-secondary: #666666;
    --border-color: #e0e0e0;
    --input-bg: #f5f5f5;
    --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.12);
}

body.dark-mode {
    --bg-main: #0d1117;
    --bg-card: #161b22;
    --text-primary: #e6edf3;
    --text-secondary: #8b949e;
    --border-color: #30363d;
    --input-bg: #0d1117;
    --shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.4);
}
```

### Container Styling

```css
.container {
    width: 90%;
    max-width: 650px;
    background: var(--bg-card);
    margin: 50px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: var(--shadow);
    transition: background 0.3s ease;
}

.container h2 {
    margin-bottom: 25px;
    font-size: 28px;
    font-weight: 600;
    color: var(--text-primary);
}
```

**Screenshot Placement:** Show the main container with the "To-Do List" heading

### Color Palette

| Element | Light Mode | Dark Mode |
|---------|-----------|-----------|
| Background | `#f8f9fa` | `#0d1117` |
| Card/Container | `#ffffff` | `#161b22` |
| Primary Text | `#1a1a1a` | `#e6edf3` |
| Borders | `#e0e0e0` | `#30363d` |

---

## Dark Mode Feature

### Toggle Button Implementation

**File:** [index.php](index.php) (line 30)

```html
<button class="theme-toggle">🌙 Dark Mode</button>
```

### Toggle Button Styling

**File:** [style.css](style.css)

```css
.theme-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 10px 16px;
    background: var(--text-primary);
    color: var(--bg-card);
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    z-index: 100;
}

.theme-toggle:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}

.theme-toggle:active {
    transform: translateY(0);
}
```

### Dark Mode JavaScript Logic

**File:** [script.js](script.js)

```javascript
// Dark mode toggle
document.addEventListener('DOMContentLoaded', () => {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
    }

    const themeBtn = document.querySelector('.theme-toggle');
    if (themeBtn) {
        themeBtn.textContent = isDarkMode ? '☀️ Light Mode' : '🌙 Dark Mode';
        themeBtn.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isNowDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isNowDark);
            themeBtn.textContent = isNowDark ? '☀️ Light Mode' : '🌙 Dark Mode';
        });
    }
});
```

**How It Works:**
1. Button stored in top-right corner (position: fixed)
2. On click, toggles `dark-mode` class on `<body>`
3. CSS variables automatically update all colors
4. User preference saved to `localStorage` and persists across page reloads
5. Button text changes between "🌙 Dark Mode" and "☀️ Light Mode"

**Screenshot Placement:** 
- Light mode: Show toggle button in light theme
- Dark mode: Show same app in dark theme with changed colors

---

## Task Input Bar

### Form HTML Structure

**File:** [index.php](index.php) (lines 34-46)

```html
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
```

### Form Styling

**File:** [style.css](style.css)

```css
.add-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid var(--border-color);
}

.add-form input,
.add-form select {
    flex: 1;
    min-width: 120px;
    padding: 10px 12px;
    background: var(--input-bg);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.add-form input:focus,
.add-form select:focus {
    outline: none;
    border-color: #0066ff;
    box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
}

.add-form button {
    padding: 10px 20px;
    background: #0066ff;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 102, 255, 0.2);
}

.add-form button:hover {
    background: #0052cc;
    box-shadow: 0 4px 8px rgba(0, 102, 255, 0.3);
    transform: translateY(-1px);
}
```

**Features:**
- Input field for task description
- Category dropdown (General, School, Work, Personal)
- Priority dropdown (Low, Medium, High)
- Add button with blue color (#0066ff)
- Focus state with blue glow on inputs
- Hover effect on button (darker blue + lift animation)
- Responsive: wraps on smaller screens

**Backend Handler:** [add.php](add.php)

```php
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
```

**Screenshot Placement:** Show the form at the top with input field, category dropdown, priority dropdown, and blue Add button

---

## Task Markers & Badges

### Category Badge

**File:** [style.css](style.css)

```css
.cat {
    background: #0066ff;
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    margin: 0 8px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

body.dark-mode .cat {
    background: #3b82f6;
    color: #ffffff;
}
```

### Priority Badge

**File:** [style.css](style.css)

```css
.priority-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    color: white;
    white-space: nowrap;
    margin: 0 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.priority-badge.low {
    background: #10b981;
    box-shadow: 0 2px 6px rgba(16, 185, 129, 0.4);
}

.priority-badge.medium {
    background: #f59e0b;
    box-shadow: 0 2px 6px rgba(245, 158, 11, 0.4);
}

.priority-badge.high {
    background: #ef4444;
    box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
}

body.dark-mode .priority-badge.low {
    background: #34d399;
    box-shadow: 0 2px 8px rgba(52, 211, 153, 0.5);
}

body.dark-mode .priority-badge.medium {
    background: #fbbf24;
    box-shadow: 0 2px 8px rgba(251, 191, 36, 0.5);
}

body.dark-mode .priority-badge.high {
    background: #f87171;
    box-shadow: 0 2px 8px rgba(248, 113, 113, 0.5);
}
```

**HTML Integration:** [index.php](index.php) (lines 57-64)

```html
<small class="cat">
    <?php echo htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8'); ?>
</small>

<small class="priority-badge <?php echo strtolower($row['priority']); ?>">
    <?php echo htmlspecialchars($row['priority'], ENT_QUOTES, 'UTF-8'); ?>
</small>
```

**Badge Colors:**
- **Category:** Blue (#0066ff in light, #3b82f6 in dark)
- **Priority - Low:** Green (#10b981)
- **Priority - Medium:** Orange (#f59e0b)
- **Priority - High:** Red (#ef4444)

**Features:**
- Uppercase text with letter-spacing for clarity
- Rounded corners (border-radius: 12px)
- Shadows for depth
- Bold font-weight (700)
- Dark mode variants with brighter colors

**Screenshot Placement:** Show a task list item with visible category badge (blue) and priority badge (color-coded green/orange/red)

---

## Action Buttons (Check, Edit, Delete)

### HTML Structure

**File:** [index.php](index.php) (lines 68-72)

```html
<div class="actions">
    <a href="mark.php?id=<?php echo $row['id']; ?>">✔</a>
    <a href="edit.php?id=<?php echo $row['id']; ?>">✏</a>
    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete();">🗑</a>
</div>
```

### Button Styling

**File:** [style.css](style.css)

```css
.actions {
    display: flex;
    gap: 8px;
}

.actions a {
    padding: 8px 12px;
    font-size: 18px;
    text-decoration: none;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease;
    background: rgba(0, 102, 255, 0.1);
    color: #0066ff;
    border: 1px solid #0066ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.actions a:hover {
    background: #0066ff;
    color: white;
    transform: scale(1.2);
    box-shadow: 0 4px 8px rgba(0, 102, 255, 0.3);
}

/* Edit button - Orange */
.actions a:nth-child(2) {
    color: #f59e0b;
    border-color: #f59e0b;
    background: rgba(245, 158, 11, 0.1);
}

.actions a:nth-child(2):hover {
    background: #f59e0b;
    color: white;
    box-shadow: 0 4px 8px rgba(245, 158, 11, 0.3);
}

/* Delete button - Red */
.actions a:nth-child(3) {
    color: #ef4444;
    border-color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

.actions a:nth-child(3):hover {
    background: #ef4444;
    color: white;
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

/* Dark mode variants */
body.dark-mode .actions a {
    background: rgba(255, 255, 255, 0.1);
    color: #3b82f6;
    border-color: #3b82f6;
}

body.dark-mode .actions a:hover {
    background: #3b82f6;
    color: white;
}

body.dark-mode .actions a:nth-child(2) {
    color: #fbbf24;
    border-color: #fbbf24;
    background: rgba(251, 191, 36, 0.1);
}

body.dark-mode .actions a:nth-child(2):hover {
    background: #fbbf24;
    color: #000;
}

body.dark-mode .actions a:nth-child(3) {
    color: #f87171;
    border-color: #f87171;
    background: rgba(248, 113, 113, 0.1);
}

body.dark-mode .actions a:nth-child(3):hover {
    background: #f87171;
    color: white;
}
```

### Button Functions

**1. Check/Mark Button (✔)**
- **File:** [mark.php](mark.php)
- **Color:** Blue (#0066ff)
- **Function:** Toggle task completion status

```php
<?php
$conn = new mysqli("localhost","root","","todo");

$id = $_GET['id'];

$conn->query("UPDATE tasks SET status = NOT status WHERE id=$id");

header("Location: index.php");
?>
```

**2. Edit Button (✏)**
- **File:** [edit.php](edit.php)
- **Color:** Orange (#f59e0b)
- **Function:** Load task edit form

```php
<?php
$conn = new mysqli("localhost", "root", "", "todo");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tasks WHERE id = $id");
$row = $result->fetch_assoc();
?>
<!-- Form to edit task -->
```

**3. Delete Button (🗑)**
- **File:** [delete.php](delete.php)
- **Color:** Red (#ef4444)
- **Function:** Remove task from database

```php
<?php
$conn = new mysqli("localhost", "root", "", "todo");

$id = $_GET['id'];

$conn->query("DELETE FROM tasks WHERE id = $id");

header("Location: index.php");
?>
```

### Confirmation Dialogs

**File:** [script.js](script.js)

```javascript
function confirmAdd() {
    return confirm('Add this task to your to-do list?');
}

function confirmDelete() {
    return confirm('Are you sure you want to delete this task?');
}

function confirmEdit() {
    return confirm('Save changes to this task?');
}
```

**Button Features:**
- Colored borders (blue, orange, red) with transparent backgrounds
- On hover: fills with solid color + white text + shadow + scale animation
- Different colors for each action
- Dark mode variants with brighter colors
- Smooth transitions (0.3s ease)
- Confirmation dialogs before submission

**Screenshot Placement:** Show action buttons with:
- Normal state (bordered, with icon)
- Hover state (filled with color, enlarged)
- Include all three buttons (check, edit, delete)

---

## Sorting Functionality

### Sort Links HTML

**File:** [index.php](index.php) (lines 48-51)

```html
<div class="sort">
    <a href="index.php">Default</a>
    <a href="index.php?sort=priority">Sort by Priority</a>
</div>
```

### Sort Links Styling

**File:** [style.css](style.css)

```css
.sort {
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
}

.sort a {
    padding: 6px 12px;
    color: #0066ff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
    border-bottom: 2px solid transparent;
}

.sort a:hover {
    color: #0052cc;
    border-bottom-color: #0066ff;
}
```

### Backend Sorting Logic

**File:** [index.php](index.php) (lines 9-19)

```php
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

if ($sort == 'priority') {
    $result = $conn->query("SELECT * FROM tasks ORDER BY 
        CASE 
            WHEN priority='High' THEN 1
            WHEN priority='Medium' THEN 2
            WHEN priority='Low' THEN 3
        END, id DESC");
} else {
    $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
}
```

**Sorting Modes:**

| Mode | Query | Display Order |
|------|-------|---|
| Default | `ORDER BY id DESC` | Newest first (by creation) |
| Priority | Custom CASE statement | High → Medium → Low (newest first within each level) |

**How It Works:**
1. User clicks "Default" or "Sort by Priority"
2. URL updates with `?sort=priority` parameter
3. Server reads `$_GET['sort']` and adjusts SQL query
4. Tasks re-render in sorted order
5. No page reload needed (query parameter method)

**Screenshot Placement:** Show:
- Sort links at the top
- Tasks sorted by creation date (default)
- Tasks sorted by priority (High red, Medium orange, Low green)

---

## Setup & Installation

### Prerequisites
- XAMPP or similar PHP/MySQL stack
- Web browser (Chrome, Firefox, Safari, Edge)
- Text editor (VS Code recommended)

### Installation Steps

1. **Create Database**
   ```bash
   mysql -u root -p < create_todo.sql
   ```

2. **Place Files in Web Root**
   ```
   C:\xampp\htdocs\todo_app\
   ├── index.php
   ├── add.php
   ├── edit.php
   ├── update.php
   ├── delete.php
   ├── mark.php
   ├── db.php
   ├── style.css
   ├── script.js
   └── create_todo.sql
   ```

3. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start Apache
   - Start MySQL

4. **Access Application**
   - Open browser
   - Navigate to: `http://localhost/todo_app/`

### File Structure

```
todo_app/
│
├── Frontend Files
│   ├── index.php          # Main task list page
│   ├── style.css          # All styling (light/dark modes)
│   └── script.js          # Dark mode toggle + confirmations
│
├── Backend Files
│   ├── db.php             # Database connection
│   ├── add.php            # Add task handler
│   ├── edit.php           # Edit task form
│   ├── update.php         # Update task handler
│   ├── delete.php         # Delete task handler
│   └── mark.php           # Mark complete/incomplete
│
└── Database
    └── create_todo.sql    # Database initialization
```

---

## Feature Summary

| Feature | Status | Location |
|---------|--------|----------|
| Add Tasks | ✅ | index.php (form) + add.php (handler) |
| Edit Tasks | ✅ | edit.php + update.php |
| Delete Tasks | ✅ | delete.php with confirmation |
| Mark Complete | ✅ | mark.php |
| Categories | ✅ | form + database |
| Priorities | ✅ | form + color-coded badges |
| Dark Mode | ✅ | script.js + style.css |
| Sorting | ✅ | index.php SQL logic |
| Responsive | ✅ | CSS media queries |
| Confirmations | ✅ | script.js dialogs |

---

## Code Highlights

### Technology Stack
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Charset:** UTF-8 (utf8mb4)

### Security Features
- `htmlspecialchars()` for XSS prevention
- `mysqli` prepared statements ready (can be enhanced)
- Input validation on forms

### Performance Features
- CSS variables for theme switching (no layout recalculation)
- localStorage for dark mode persistence (no server call)
- Indexed database primary key
- Optimized SQL queries

---

## Customization Guide

### Change Button Colors
Edit [style.css](style.css) - Search for `.actions a:nth-child()`

### Change Theme Colors
Edit [style.css](style.css) - Modify `:root` and `body.dark-mode` variables

### Add New Categories
Edit [index.php](index.php) - Add `<option>` in category select

### Add New Priority Levels
Edit [style.css](style.css) and database schema

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| "No database selected" | Run `create_todo.sql` first |
| Dark mode not working | Hard refresh (Ctrl+Shift+R) |
| Buttons not visible | Check browser console for JS errors |
| Tasks not saving | Verify MySQL is running |

---

**Version:** 1.0  
**Last Updated:** December 2025  
**Author:** Todo App Development Team
