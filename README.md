# 🏆 LAMP Scoreboard App

A minimal web application built with the LAMP stack (Linux, Apache, MySQL, PHP) that allows predefined judges to score participants. The total scores are displayed on a public scoreboard in descending order.

---

## 📦 Features

- **Admin Panel** to add judges (no login required for demo)
- **Judge Portal** to submit/update scores for participants
- **Public Scoreboard** that shows total points, auto-sorted, and auto-refreshing
- Built on pure PHP with MySQL backend
- Fully working on any LAMP environment (XAMPP, WAMP, Ubuntu+Apache+MySQL)

---

## ⚙️ Tech Stack

- **Linux (Ubuntu 20.04+)**
- **Apache2**
- **MySQL**
- **PHP 7.4+**

---

## 🚀 Setup Instructions

### 1. Clone or Copy Project

```bash
cd /var/www/html
git clone <your-repo-url> scoreboard-app
cd scoreboard-app
```

### 2. MySQL Database Setup

Start MySQL:

```bash
sudo mysql -u root
```

Run the following:

```sql
CREATE DATABASE scoreboard_app;
USE scoreboard_app;
```

### 3. Database Schema

Execute the following SQL to create the required tables:

```sql
-- Judges table
CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL
);

-- Participants table
CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Scores table
CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    participant_id INT NOT NULL,
    score INT NOT NULL CHECK (score BETWEEN 1 AND 100),
    UNIQUE (judge_id, participant_id),
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    FOREIGN KEY (participant_id) REFERENCES participants(id)
);
```

**Optional:** Insert sample participants:

```sql
INSERT INTO participants (name) VALUES
('Alice'), ('Bob'), ('Charlie'), ('Diana');
```

### 4. Project Structure

```
scoreboard-app/
├── config/
│   └── db.php
├── admin_add_judge.php
├── judge/
│   └── submit_score.php
├── public/
│   └── scoreboard.php
├── index.php
├── init.sql
└── README.md
```

---

## 🌐 Usage

1. **Add judges** via: `http://localhost/scoreboard-app/admin_add_judge.php`
2. **Submit scores** via: `http://localhost/scoreboard-app/judge/submit_score.php`
3. **View public scoreboard**: `http://localhost/scoreboard-app/public/scoreboard.php`

---

## 💡 Design Notes

- **Why PDO**: It offers secure, modern DB handling and prevents SQL injection
- **Auto-refresh**: The scoreboard page uses `<meta refresh>` every 10 seconds
- **No login**: Left out intentionally to focus on core logic (can easily be added with sessions)

---

## ⏳ If I Had More Time...

- Add login/auth for judges and admins
- Prevent multiple scoring edits after locking
- Improve UI/UX with Bootstrap
- Use AJAX for live scoreboard updates
- Deploy it publicly (e.g., on DigitalOcean or Heroku with a LAMP droplet)

---

## 🔧 Configuration

Make sure to update the database connection settings in `config/db.php` according to your MySQL setup:

```php
<?php
$host = 'localhost';
$dbname = 'scoreboard_app';
$username = 'root';
$password = 'your_password';
?>
```

---

## 📝 License

This project is open source and available under the [MIT License](LICENSE).