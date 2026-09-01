<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");

    // Default admin credentials
    $name     = "Administrator";
    $email    = "admin@aurora.library";
    $password = "admin123";
    $mobile   = 9999999999;

    $log = [];

    // Step 1: Ensure database exists
    if (!$db) {
        mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS lms");
        mysqli_select_db($connection, "lms");
        $log[] = ["Created database `lms`.", "ok"];
    } else {
        $log[] = ["Database `lms` already exists.", "ok"];
    }

    // Step 2: Ensure admins table exists
    $tableCheck = mysqli_query($connection, "SHOW TABLES LIKE 'admins'");
    if (mysqli_num_rows($tableCheck) == 0) {
        $create = "CREATE TABLE admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(100) NOT NULL,
            mobile BIGINT
        )";
        if (mysqli_query($connection, $create)) {
            $log[] = ["Created table `admins`.", "ok"];
        } else {
            $log[] = ["Failed to create table `admins`: " . mysqli_error($connection), "err"];
        }
    } else {
        $log[] = ["Table `admins` already exists.", "ok"];
    }

    // Step 3: Ensure users table exists (in case signup was never used)
    $usersCheck = mysqli_query($connection, "SHOW TABLES LIKE 'users'");
    if (mysqli_num_rows($usersCheck) == 0) {
        $createUsers = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(100) NOT NULL,
            mobile BIGINT,
            address VARCHAR(255)
        )";
        if (mysqli_query($connection, $createUsers)) {
            $log[] = ["Created table `users`.", "ok"];
        }
    } else {
        $log[] = ["Table `users` already exists.", "ok"];
    }

    // Step 4: Ensure books table exists
    $booksCheck = mysqli_query($connection, "SHOW TABLES LIKE 'books'");
    if (mysqli_num_rows($booksCheck) == 0) {
        $createBooks = "CREATE TABLE books (
            book_id INT AUTO_INCREMENT PRIMARY KEY,
            book_name VARCHAR(255) NOT NULL,
            author_id INT,
            cat_id INT,
            book_no VARCHAR(50),
            book_price DECIMAL(10,2)
        )";
        if (mysqli_query($connection, $createBooks)) {
            $log[] = ["Created table `books`.", "ok"];
        }
    } else {
        $log[] = ["Table `books` already exists.", "ok"];
    }

    // Step 5: Ensure category table exists
    $catCheck = mysqli_query($connection, "SHOW TABLES LIKE 'category'");
    if (mysqli_num_rows($catCheck) == 0) {
        $createCat = "CREATE TABLE category (
            cat_id INT AUTO_INCREMENT PRIMARY KEY,
            cat_name VARCHAR(100) NOT NULL
        )";
        if (mysqli_query($connection, $createCat)) {
            $log[] = ["Created table `category`.", "ok"];
        }
    } else {
        $log[] = ["Table `category` already exists.", "ok"];
    }

    // Step 6: Ensure issued_books table exists
    $issuedCheck = mysqli_query($connection, "SHOW TABLES LIKE 'issued_books'");
    if (mysqli_num_rows($issuedCheck) == 0) {
        $createIssued = "CREATE TABLE issued_books (
            id INT AUTO_INCREMENT PRIMARY KEY,
            book_no VARCHAR(50),
            book_name VARCHAR(255),
            book_author VARCHAR(255),
            student_id INT,
            status TINYINT DEFAULT 1,
            issue_date DATE
        )";
        if (mysqli_query($connection, $createIssued)) {
            $log[] = ["Created table `issued_books`.", "ok"];
        }
    } else {
        $log[] = ["Table `issued_books` already exists.", "ok"];
    }

    // Step 7: Ensure authors table exists
    $authorCheck = mysqli_query($connection, "SHOW TABLES LIKE 'authors'");
    if (mysqli_num_rows($authorCheck) == 0) {
        $createAuthors = "CREATE TABLE authors (
            author_id INT AUTO_INCREMENT PRIMARY KEY,
            author_name VARCHAR(100) NOT NULL
        )";
        if (mysqli_query($connection, $createAuthors)) {
            $log[] = ["Created table `authors`.", "ok"];
        }
    } else {
        $log[] = ["Table `authors` already exists.", "ok"];
    }

    // Step 8: Insert the default admin
    $check = mysqli_query($connection, "SELECT * FROM admins WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $log[] = ["Admin with email <strong>$email</strong> already exists — no changes made.", "warn"];
    } else {
        $query = "INSERT INTO admins VALUES('', '$name', '$email', '$password', $mobile)";
        if (mysqli_query($connection, $query)) {
            $log[] = ["Admin account <strong>$email</strong> created successfully.", "ok"];
        } else {
            $log[] = ["Failed to insert admin: " . mysqli_error($connection), "err"];
        }
    }

    $allOk = !in_array("err", array_column($log, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup · Aurora Library</title>
    <link rel="stylesheet" href="static/css/aurora.css">
</head>
<body class="app-bg" style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;">
    <div class="auth__card fade-up" style="max-width:560px;width:100%;">
        <div class="flex" style="align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,<?php echo $allOk ? 'var(--emerald),#0f4d2c' : 'var(--crimson),#7f1d1d'; ?>);display:grid;place-items:center;flex-shrink:0;">
                <?php if($allOk): ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                <?php else: ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v5m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="auth__title" style="font-size:26px;margin:0;"><?php echo $allOk ? 'Setup complete.' : 'Setup finished with errors.'; ?></h2>
                <p class="auth__subtitle" style="margin:2px 0 0;font-size:13px;">Database initialized & admin account created</p>
            </div>
        </div>

        <div style="background:var(--ink-50);border:1px solid var(--ink-100);border-radius:14px;padding:16px 20px;margin-bottom:20px;">
            <div style="display:grid;gap:8px;">
                <?php foreach($log as $entry): ?>
                    <div class="flex gap-2" style="align-items:center;font-size:13px;">
                        <?php if($entry[1] === 'ok'): ?>
                            <span style="color:var(--emerald);font-weight:700;">✓</span>
                        <?php elseif($entry[1] === 'warn'): ?>
                            <span style="color:var(--gold-700);font-weight:700;">⚠</span>
                        <?php else: ?>
                            <span style="color:var(--crimson);font-weight:700;">✕</span>
                        <?php endif; ?>
                        <span><?php echo $entry[0]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="text-align:left;background:linear-gradient(135deg,#0a0e1a,#1f2937);border-radius:14px;padding:20px;margin-bottom:24px;">
            <div style="font-size:11px;color:var(--gold-400);text-transform:uppercase;letter-spacing:0.16em;font-weight:600;margin-bottom:12px;">Default Admin Credentials</div>
            <div style="display:grid;gap:6px;font-family:'JetBrains Mono',monospace;font-size:14px;">
                <div><span style="color:rgba(255,255,255,0.5);">Email:</span> <strong style="color:#fff;">admin@aurora.library</strong></div>
                <div><span style="color:rgba(255,255,255,0.5);">Password:</span> <strong style="color:#fff;">admin123</strong></div>
            </div>
        </div>

        <div class="flex gap-3" style="justify-content:center;">
            <a href="login_module/admin_login.php" class="btn btn--primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Go to Admin Login</span>
            </a>
            <a href="login_module/index.php" class="btn btn--ghost">Member Login</a>
        </div>

        <p class="text-sm text-muted mt-6 text-center">
            For security, delete <code style="background:var(--ink-100);padding:2px 6px;border-radius:4px;">create_admin.php</code> from your server after setup.
        </p>
    </div>
</body>
</html>

