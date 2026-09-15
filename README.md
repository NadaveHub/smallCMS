
# Content Management System (CMS)

A PHP-based Content Management System.

---

## 🚀 Getting Started

### 1. Requirements
* PHP 7.4+
* MySQL / MariaDB
* PDO PHP Extension

### 2. Installation & Configuration

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/your-username/your-repo-name.git](https://github.com/your-username/your-repo-name.git)
   cd your-repo-name

    Create the database configuration file:

    Create a file in lib/db.php and insert your database credentials:
    PHP

    <?php
    define('DB_NAME', 'YOUR_DATABASE_NAME');
    define('DB_USER', 'YOUR_DATABASE_USER');
    define('DB_PASSWORD', 'YOUR_DATABASE_PASSWORD');
    define('DB_HOST', 'YOUR_DATABASE_HOST'); // e.g., 127.0.0.1 or localhost

    global $db;
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASSWORD
    );
    ?>
