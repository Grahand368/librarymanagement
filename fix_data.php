<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $log = [];
    $err = 0;

    // ── 1. Fix duplicate user emails ──
    $users = [
        ["Aarav Sharma", "aurora.library"],
        ["Priya Patel", "aurora.library"],
        ["Bikash Thapa", "aurora.library"],
        ["Sita Rai", "aurora.library"],
        ["Rohan Gupta", "aurora.library"],
        ["Anita KC", "aurora.library"],
        ["Sujan Maharjan", "aurora.library"],
        ["Nisha Adhikari", "aurora.library"],
        ["Kiran Tamang", "aurora.library"],
        ["Meera Shrestha", "aurora.library"],
        ["Ravi Khadka", "aurora.library"],
        ["Pooja Neupane", "aurora.library"]
    ];
    $fixed = 0;
    foreach ($users as $i => $u) {
        $nameEsc = mysqli_real_escape_string($connection, $u[0]);
        $newEmail = strtolower(str_replace(' ', '', $u[0])) . "@aurora.library";
        $newEmailEsc = mysqli_real_escape_string($connection, $newEmail);
        $upd = mysqli_query($connection, "UPDATE users SET email = '$newEmailEsc' WHERE name = '$nameEsc' AND email = 'aurora.library'");
        if ($upd && mysqli_affected_rows($connection) > 0) {
            $fixed++;
        }
    }
    $log[] = ["Fixed $fixed duplicate user emails → unique @aurora.library addresses.", "ok"];

    // ── 2. Add missing book_qty column if needed ──
    $check = mysqli_query($connection, "SHOW COLUMNS FROM books LIKE 'book_qty'");
    if (mysqli_num_rows($check) > 0) {
        $log[] = ["Column <code>book_qty</code> already exists.", "warn"];
    } else {
        mysqli_query($connection, "ALTER TABLE books ADD COLUMN book_qty INT NOT NULL DEFAULT 5 AFTER book_price");
        $log[] = ["Added <code>books.book_qty</code> column.", "ok"];
    }

    // ── 3. Update any books with 0 or NULL quantity ──
    $upd = mysqli_query($connection, "UPDATE books SET book_qty = 5 WHERE book_qty IS NULL OR book_qty = 0");
    $affected = mysqli_affected_rows($connection);
    $log[] = ["Updated $affected book(s) to 5 copies.", "ok"];

    // ── 4. Add issued_books.book_return_date column if missing ──
    $check2 = mysqli_query($connection, "SHOW COLUMNS FROM issued_books LIKE 'book_return_date'");
    if (mysqli_num_rows($check2) == 0) {
        mysqli_query($connection, "ALTER TABLE issued_books ADD COLUMN book_return_date DATE NULL AFTER issue_date");
        $log[] = ["Added <code>issued_books.book_return_date</code> column.", "ok"];
    } else {
        $log[] = ["Column <code>book_return_date</code> already exists.", "warn"];
    }

    // ── 5. Fix any invalid email formats in users table ──
    $fixEmails = mysqli_query($connection, "UPDATE users SET email = CONCAT(LOWER(REPLACE(name, ' ', '')), '@aurora.library') WHERE email NOT LIKE '%@%'");
    $fixedEmails = mysqli_affected_rows($connection);
    if ($fixedEmails > 0) {
        $log[] = ["Fixed $fixedEmails malformed email(s).", "ok"];
    }

    // ── Summary ──
    $totals = [
        'authors' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM authors"))['c'],
        'categories' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM category"))['c'],
        'books' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM books"))['c'],
        'users' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM users"))['c'],
        'issued_books' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM issued_books"))['c'],
    ];
    $totalCopies = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COALESCE(SUM(book_qty), 0) as s FROM books"))['s'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fix Data · Aurora Library</title>
    <link rel="stylesheet" href="static/css/aurora.css">
</head>
<body class="app-bg" style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;">
    <div class="auth__card fade-up" style="max-width:600px;width:100%;">
        <div class="flex" style="align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,var(--emerald),#0f4d2c);display:grid;place-items:center;flex-shrink:0;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div>
                <h2 class="auth__title" style="font-size:26px;margin:0;">Data fixed.</h2>
                <p class="auth__subtitle" style="margin:2px 0 0;font-size:13px;">All inconsistencies resolved</p>
            </div>
        </div>

        <div style="background:var(--ink-50);border:1px solid var(--ink-100);border-radius:14px;padding:16px 20px;margin-bottom:20px;">
            <div style="display:grid;gap:8px;">
                <?php foreach($log as $entry): ?>
                    <div class="flex gap-2" style="align-items:flex-start;font-size:13px;">
                        <?php if($entry[1] === 'ok'): ?><span style="color:var(--emerald);font-weight:700;">✓</span>
                        <?php elseif($entry[1] === 'warn'): ?><span style="color:var(--gold-700);font-weight:700;">⚠</span>
                        <?php else: ?><span style="color:var(--crimson);font-weight:700;">✕</span>
                        <?php endif; ?>
                        <span><?php echo $entry[0]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;">
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['authors']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Authors</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totals['books']; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Books</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--emerald);"><?php echo $totalCopies; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Total Copies</div>
            </div>
        </div>

        <div class="flex gap-3" style="justify-content:center;flex-wrap:wrap;">
            <a href="Admin_Dashboard_Module/admin_dashboard.php" class="btn btn--primary">Go to Admin Dashboard</a>
            <a href="login_module/index.php" class="btn btn--ghost">Member Login</a>
        </div>
    </div>
</body>
</html>

