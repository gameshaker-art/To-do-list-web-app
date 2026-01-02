# 📝 To-Do Application

A lightweight to-do list web application built with **PHP** and **MySQL**, designed to explore **data-driven task prioritization** and explainable, AI-inspired decision logic.

---

## 🚀 Overview

This project goes beyond basic CRUD functionality by introducing **Smart Task Prioritization** — a behavior-aware sorting mechanism that ranks tasks using multiple signals instead of a single rule.

The focus is on:
- Clear decision logic
- Explainability
- A clean foundation for future machine learning features

---

## ✨ Key Features

- Create, edit, and delete tasks  
- Assign categories and priority levels  
- Mark tasks as completed  
- Multiple sorting options:
  - Default order
  - Priority-based order
  - **Smart Order (AI-inspired)**

---

## 🧠 Smart Task Prioritization

The **Smart Order** feature ranks tasks using a heuristic-based scoring system.

Each task is evaluated using:
- Priority level (High, Medium, Low)
- Task category (e.g., Work, School)
- Task age

Tasks are then ordered by a computed relevance score rather than a single attribute.

> This approach was intentionally designed as a foundation for future machine learning–based task completion prediction, while remaining fully explainable.

---

## 📸 Screenshots

### Default Task View
Shows the standard task list without intelligent ranking.

![Default Task View](screenshots/default-view.png)

---

### Smart Task Sorting
Tasks ranked using behavior-aware scoring.

![Smart Task Sorting](screenshots/smart-order.png)

---

## ⚙️ Setup

1. Clone the repository  
2. Create a MySQL database named `todo`  
3. Import `sql/schema.sql` to create the required tables  
4. Configure the database connection in `db.php`  
5. Run the project on a local server (e.g., XAMPP)

---

## 🧪 Usage

- Add tasks with descriptions, categories, and priorities  
- Switch between sorting modes using the interface  
- Update, complete, or delete tasks as needed  

---

## 🔮 Future Improvements

- Machine learning–based task completion prediction  
- Task duration estimation  
- Personalized prioritization based on user behavior  

---

## 📌 Notes

This project intentionally avoids black-box automation.  
The goal is to demonstrate **how intelligent behavior emerges from structured data and clear decision logic**, not to over-engineer solutions.

---

## 📂 Project Structure (Simplified)

```text
├── index.php
├── add.php
├── delete.php
├── update.php
├── db.php
├── style.css
├── script.js
├── sql/
│   └── schema.sql
└── screenshots/
    ├── default-view.png
    └── smart-order.png
