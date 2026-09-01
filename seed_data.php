<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $log = [];

    // ── 1. AUTHORS ──
    $authors = [
        "J.K. Rowling", "Stephen King", "Agatha Christie", "George Orwell",
        "J.R.R. Tolkien", "Dan Brown", "Paulo Coelho", "Harper Lee",
        "Leo Tolstoy", "Fyodor Dostoevsky", "Jane Austen", "Mark Twain",
        "Ernest Hemingway", "Virginia Woolf", "Charles Dickens", "Oscar Wilde",
        "Rudyard Kipling", "Rabindranath Tagore", "Premchand", "Chetan Bhagat",
        "Amish Tripathi", "Arundhati Roy", "Khaled Hosseini", "R.K. Narayan",
        "Salman Rushdie"
    ];
    $existing = mysqli_query($connection, "SELECT COUNT(*) as c FROM authors");
    $row = mysqli_fetch_assoc($existing);
    if ($row['c'] == 0) {
        foreach ($authors as $a) {
            mysqli_query($connection, "INSERT INTO authors (author_name) VALUES ('".mysqli_real_escape_string($connection, $a)."')");
        }
        $log[] = ["Inserted ".count($authors)." authors.", "ok"];
    } else {
        $log[] = ["Authors table already has ".$row['c']." records — skipped.", "warn"];
    }

    // ── 2. CATEGORIES ──
    $categories = [
        "Fiction", "Non-Fiction", "Science Fiction", "Fantasy", "Mystery",
        "Romance", "Horror", "Biography", "History", "Self-Help",
        "Poetry", "Drama", "Adventure", "Philosophy", "Technology",
        "Health & Wellness", "Travel", "Art & Design", "Business", "Children's Books"
    ];
    $existing = mysqli_query($connection, "SELECT COUNT(*) as c FROM category");
    $row = mysqli_fetch_assoc($existing);
    if ($row['c'] == 0) {
        foreach ($categories as $c) {
            mysqli_query($connection, "INSERT INTO category (cat_name) VALUES ('".mysqli_real_escape_string($connection, $c)."')");
        }
        $log[] = ["Inserted ".count($categories)." categories.", "ok"];
    } else {
        $log[] = ["Category table already has ".$row['c']." records — skipped.", "warn"];
    }

    // ── 3. BOOKS ──
    $books = [
        ["Harry Potter and the Philosopher's Stone", 1, 4, "978-0747532699", 1299.00],
        ["The Shining", 2, 7, "978-0307743657", 899.00],
        ["Murder on the Orient Express", 3, 5, "978-0062693662", 750.00],
        ["1984", 4, 1, "978-0451524935", 699.00],
        ["The Hobbit", 5, 4, "978-0547928227", 1100.00],
        ["The Da Vinci Code", 6, 5, "978-0307474278", 950.00],
        ["The Alchemist", 7, 1, "978-0062315007", 799.00],
        ["To Kill a Mockingbird", 8, 1, "978-0061120084", 850.00],
        ["War and Peace", 9, 1, "978-0199232765", 1500.00],
        ["Crime and Punishment", 10, 1, "978-0486415871", 899.00],
        ["Pride and Prejudice", 11, 6, "978-0141439518", 650.00],
        ["The Adventures of Tom Sawyer", 12, 13, "978-0486400778", 550.00],
        ["The Old Man and the Sea", 13, 1, "978-0684801223", 720.00],
        ["Mrs Dalloway", 14, 1, "978-0156628709", 680.00],
        ["Great Expectations", 15, 1, "978-0141439563", 799.00],
        ["The Picture of Dorian Gray", 16, 1, "978-0141439570", 750.00],
        ["The Jungle Book", 17, 13, "978-0141325297", 599.00],
        ["Gitanjali", 18, 10, "978-8171679962", 499.00],
        ["Godan", 19, 1, "978-8126514560", 450.00],
        ["Five Point Someone", 20, 9, "978-8129135490", 599.00],
        ["The Immortals of Meluha", 21, 4, "978-9386224583", 899.00],
        ["The God of Small Things", 22, 1, "978-0060934707", 999.00],
        ["The Kite Runner", 23, 1, "978-1594631931", 950.00],
        ["Malgudi Days", 24, 1, "978-8185986177", 550.00],
        ["Midnight's Children", 25, 1, "978-0812976300", 1100.00],
        ["Sita: Warrior of Mithila", 21, 4, "978-9386224583", 999.00],
        ["Origin", 6, 5, "978-0385542692", 1050.00],
        ["Inferno", 6, 5, "978-0385513753", 999.00],
        ["Animal Farm", 4, 1, "978-0451526342", 599.00],
        ["The Lord of the Rings", 5, 4, "978-0544003415", 2200.00],
        ["Gone Girl", 3, 5, "978-0307588371", 899.00],
        ["The Girl on the Train", 3, 5, "978-1594634024", 850.00],
        ["Educated", 2, 8, "978-0399590504", 1199.00],
        ["Becoming", 2, 8, "978-1524763138", 1299.00],
        ["Sapiens", 4, 9, "978-0062316097", 1499.00],
        ["Atomic Habits", 2, 10, "978-0735211292", 1099.00],
        ["The Subtle Art of Not Giving a F*ck", 2, 10, "978-0062457714", 899.00],
        ["Think and Grow Rich", 2, 10, "978-1585424337", 799.00],
        ["Rich Dad Poor Dad", 2, 18, "978-1612680100", 699.00],
        ["The Art of War", 15, 11, "978-1599869773", 599.00],
        ["The Lean Startup", 2, 18, "978-0735211292", 1399.00]
    ];
    $existing = mysqli_query($connection, "SELECT COUNT(*) as c FROM books");
    $row = mysqli_fetch_assoc($existing);
    if ($row['c'] == 0) {
        foreach ($books as $b) {
            mysqli_query($connection, sprintf(
                "INSERT INTO books (book_name, author_id, cat_id, book_no, book_price) VALUES ('%s', %d, %d, '%s', %.2f)",
                mysqli_real_escape_string($connection, $b[0]), $b[1], $b[2],
                mysqli_real_escape_string($connection, $b[3]), $b[4]
            ));
        }
        $log[] = ["Inserted ".count($books)." books.", "ok"];
    } else {
        $log[] = ["Books table already has ".$row['c']." records — skipped.", "warn"];
    }

    // ── 4. MEMBERS (USERS) ──
    $users = [
        ["Aarav Sharma", "aurora.library", "pass123", 9800000001, "Kathmandu"],
        ["Priya Patel", "aurora.library", "pass123", 9800000002, "Pokhara"],
        ["Bikash Thapa", "aurora.library", "pass123", 9800000003, "Lalitpur"],
        ["Sita Rai", "aurora.library", "pass123", 9800000004, "Bhaktapur"],
        ["Rohan Gupta", "aurora.library", "pass123", 9800000005, "Biratnagar"],
        ["Anita KC", "aurora.library", "pass123", 9800000006, "Chitwan"],
        ["Sujan Maharjan", "aurora.library", "pass123", 9800000007, "Lalitpur"],
        ["Nisha Adhikari", "aurora.library", "pass123", 9800000008, "Kathmandu"],
        ["Kiran Tamang", "aurora.library", "pass123", 9800000009, "Pokhara"],
        ["Meera Shrestha", "aurora.library", "pass123", 9800000010, "Butwal"],
        ["Ravi Khadka", "aurora.library", "pass123", 9800000011, "Dharan"],
        ["Pooja Neupane", "aurora.library", "pass123", 9800000012, "Hetauda"]
    ];
    $existing = mysqli_query($connection, "SELECT COUNT(*) as c FROM users");
    $row = mysqli_fetch_assoc($existing);
    if ($row['c'] == 0) {
        foreach ($users as $u) {
            mysqli_query($connection, sprintf(
                "INSERT INTO users (name, email, password, mobile, address) VALUES ('%s', '%s', '%s', %d, '%s')",
                mysqli_real_escape_string($connection, $u[0]),
                mysqli_real_escape_string($connection, $u[1]),
                mysqli_real_escape_string($connection, $u[2]),
                $u[3], mysqli_real_escape_string($connection, $u[4])
            ));
        }
        $log[] = ["Inserted ".count($users)." members.", "ok"];
    } else {
        $log[] = ["Users table already has ".$row['c']." records — skipped.", "warn"];
    }

    // ── 5. ISSUED BOOKS ──
    $issued = [
        [1, "Harry Potter and the Philosopher's Stone", "J.K. Rowling", 1, 1, "2026-09-01"],
        [5, "The Hobbit", "J.R.R. Tolkien", 3, 1, "2026-08-25"],
        [19, "Godan", "Premchand", 5, 1, "2026-08-28"],
        [28, "Animal Farm", "George Orwell", 7, 1, "2026-09-02"],
        [7, "The Alchemist", "Paulo Coelho", 9, 1, "2026-08-20"],
        [33, "Educated", "Tara Westover", 2, 0, "2026-08-15"],
        [25, "Midnight's Children", "Salman Rushdie", 11, 1, "2026-08-30"],
        [40, "The Lean Startup", "Eric Ries", 4, 1, "2026-09-03"],
        [15, "The Picture of Dorian Gray", "Oscar Wilde", 8, 1, "2026-09-01"],
        [36, "Atomic Habits", "James Clear", 10, 0, "2026-08-10"]
    ];
    $existing = mysqli_query($connection, "SELECT COUNT(*) as c FROM issued_books");
    $row = mysqli_fetch_assoc($existing);
    if ($row['c'] == 0) {
        foreach ($issued as $i) {
            mysqli_query($connection, sprintf(
                "INSERT INTO issued_books (book_no, book_name, book_author, student_id, status, issue_date) VALUES ('%s', '%s', '%s', %d, %d, '%s')",
                mysqli_real_escape_string($connection, $i[0]),
                mysqli_real_escape_string($connection, $i[1]),
                mysqli_real_escape_string($connection, $i[2]),
                $i[3], $i[4], $i[5]
            ));
        }
        $log[] = ["Inserted ".count($issued)." issued books (8 active, 2 returned).", "ok"];
    } else {
        $log[] = ["Issued books table already has ".$row['c']." records — skipped.", "warn"];
    }

    $allOk = !in_array("err", array_column($log, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Seeded · Aurora Library</title>
    <link rel="stylesheet" href="static/css/aurora.css">
</head>
<body class="app-bg" style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;">
    <div class="auth__card fade-up" style="max-width:600px;width:100%;">
        <div class="flex" style="align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,<?php echo $allOk ? 'var(--emerald),#0f4d2c' : 'var(--crimson),#7f1d1d'; ?>);display:grid;place-items:center;flex-shrink:0;">
                <?php if($allOk): ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                <?php else: ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v5m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="auth__title" style="font-size:26px;margin:0;"><?php echo $allOk ? 'Database seeded.' : 'Seeding finished with errors.'; ?></h2>
                <p class="auth__subtitle" style="margin:2px 0 0;font-size:13px;">Realistic data is ready for all tables</p>
            </div>
        </div>

        <div style="background:var(--ink-50);border:1px solid var(--ink-100);border-radius:14px;padding:16px 20px;margin-bottom:20px;">
            <div style="display:grid;gap:8px;">
                <?php foreach($log as $entry): ?>
                    <div class="flex gap-2" style="align-items:center;font-size:13px;">
                        <?php if($entry[1] === 'ok'): ?><span style="color:var(--emerald);font-weight:700;">✓</span>
                        <?php elseif($entry[1] === 'warn'): ?><span style="color:var(--gold-700);font-weight:700;">⚠</span>
                        <?php else: ?><span style="color:var(--crimson);font-weight:700;">✕</span>
                        <?php endif; ?>
                        <span><?php echo $entry[0]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;">
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);">25</div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Authors</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);">20</div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Categories</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);">40</div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Books</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:24px;">
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);">12</div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Members</div>
            </div>
            <div style="text-align:center;padding:16px;background:linear-gradient(135deg,var(--ink-50),var(--cream));border-radius:14px;border:1px solid var(--ink-100);">
                <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:600;color:var(--ink-900);">10</div>
                <div style="font-size:11px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.1em;">Issued Books</div>
            </div>
        </div>

        <div class="flex gap-3" style="justify-content:center;">
            <a href="Admin_Dashboard_Module/admin_dashboard.php" class="btn btn--primary">
                <span>Go to Admin Dashboard</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </a>
            <a href="login_module/index.php" class="btn btn--ghost">Member Login</a>
        </div>

        <p class="text-sm text-muted mt-6 text-center">
            Delete <code style="background:var(--ink-100);padding:2px 6px;border-radius:4px;">seed_data.php</code> after use. Safe to re-run — skips existing data.
        </p>
    </div>
</body>
</html>

