<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $log = [];
    $err = 0;

    // Check if column already exists
    $check = mysqli_query($connection, "SHOW COLUMNS FROM books LIKE 'book_qty'");
    if (mysqli_num_rows($check) > 0) {
        $log[] = ["Column <code>book_qty</code> already exists — skipped.", "warn"];
    } else {
        // Add the book_qty column
        $sql = "ALTER TABLE books ADD COLUMN book_qty INT NOT NULL DEFAULT 5 AFTER book_price";
        if (mysqli_query($connection, $sql)) {
            $log[] = ["Added column <code>books.book_qty</code> with default 5.", "ok"];
        } else {
            $log[] = ["Failed to add column: " . mysqli_error($connection), "err"];
            $err++;
        }
    }

    // Update any existing rows that have 0 (legacy data)
    $res = mysqli_query($connection, "UPDATE books SET book_qty = 5 WHERE book_qty IS NULL OR book_qty = 0");
    $affected = mysqli_affected_rows($connection);
    $log[] = ["Updated $affected existing book(s) to 5 copies each.", "ok"];

    // Add issued_books.book_return_date column if missing (for tracking)
    $check2 = mysqli_query($connection, "SHOW COLUMNS FROM issued_books LIKE 'book_return_date'");
    if (mysqli_num_rows($check2) == 0) {
        mysqli_query($connection, "ALTER TABLE issued_books ADD COLUMN book_return_date DATE NULL AFTER issue_date");
        $log[] = ["Added column <code>issued_books.book_return_date</code> (optional, for future return flow).", "ok"];
    } else {
        $log[] = ["Column <code>book_return_date</code> already exists.", "warn"];
    }

    $totalBooks = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM books"))['c'];
    $totalCopies = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(book_qty) as s FROM books"))['s'] ?? 0;
    $totalIssued = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as c FROM issued_books WHERE status = 1"))['c'];
    $available = $totalCopies - $totalIssued;
    if ($available < 0) $available = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Migration · Inventory System</title>
    <link rel="stylesheet" href="static/css/aurora.css">
</head>
<body class="app-bg" style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;">
    <div class="auth__card fade-up" style="max-width:600px;width:100%;">
        <div class="flex" style="align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,<?php echo $err === 0 ? 'var(--emerald),#0f4d2c' : 'var(--crimson),#7f1d1d'; ?>);display:grid;place-items:center;flex-shrink:0;">
                <?php if($err === 0): ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                <?php else: ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v5m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="auth__title" style="font-size:26px;margin:0;">Inventory migration <?php echo $err === 0 ? 'complete.' : 'had errors.'; ?></h2>
                <p class="auth__subtitle" style="margin:2px 0 0;font-size:13px;">Each book now has a copy count</p>
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
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totalBooks; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Titles</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);"><?php echo $totalCopies; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Total Copies</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--emerald);"><?php echo $available; ?></div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Available</div>
            </div>
        </div>

        <div class="flex gap-3" style="justify-content:center;flex-wrap:wrap;">
            <a href="Add_books_lms/add_book.php" class="btn btn--primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Add a Book
            </a>
            <a href="Add_books_lms/regbooks.php" class="btn btn--ghost">View Catalog</a>
            <a href="Admin_Dashboard_Module/admin_dashboard.php" class="btn btn--ghost">Dashboard</a>
        </div>

        <p class="text-sm text-muted mt-6 text-center">
            Safe to re-run. Delete <code style="background:var(--ink-100);padding:2px 6px;border-radius:4px;">migrate_inventory.php</code> after use.
        </p>
    </div>
</body>
</html>

