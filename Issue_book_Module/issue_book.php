<?php
    require("../Admin_Dashboard_Module/functions.php");
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('issue'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Circulation</span>
                <h1 class="page-head__title">Issue <em>Book</em></h1>
                <p class="page-head__sub">Issue a book to a registered member. Inventory decreases by 1.</p>
            </div>
        </div>

        <div class="grid grid--3 stagger">
            <div class="card" style="grid-column:span 2;">
                <span class="eyebrow">New Issue</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Book & member details</h3>
                <form action="" method="post">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="book_name">Book Title</label>
                            <input class="input" type="text" name="book_name" id="book_name" placeholder="e.g. The Great Gatsby" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="book_no">Book Number</label>
                            <input class="input" type="text" name="book_no" id="book_no" placeholder="ISBN" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="book_author">Author</label>
                        <select class="select" name="book_author" id="book_author" required>
                            <option value="">— Select author —</option>
                            <?php
                                $connection = mysqli_connect("localhost","root","");
                                $db = mysqli_select_db($connection,"lms");
                                $query = "select author_name from authors";
                                $query_run = mysqli_query($connection,$query);
                                while($row = mysqli_fetch_assoc($query_run)){
                                    echo '<option>'.htmlspecialchars($row['author_name']).'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="student_id">Student ID</label>
                            <input class="input" type="text" name="student_id" id="student_id" placeholder="e.g. 1" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="issue_date">Issue Date</label>
                            <input class="input" type="text" name="issue_date" id="issue_date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="issue_book" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            Issue Book
                        </button>
                        <button type="reset" class="btn btn--ghost">Reset</button>
                    </div>
                </form>
                <?php
                    if(isset($_POST['issue_book'])){
                        $connection = mysqli_connect("localhost","root","");
                        $db = mysqli_select_db($connection,"lms");
                        $bookNo = intval($_POST['book_no']);

                        // Check inventory
                        $check = mysqli_query($connection, "SELECT book_qty, book_name FROM books WHERE book_no = $bookNo");
                        if(mysqli_num_rows($check) == 0){
                            echo '<script>Aurora.toast("Book number not found in catalog","error");</script>';
                        } else {
                            $book = mysqli_fetch_assoc($check);
                            if($book['book_qty'] <= 0){
                                echo '<script>Aurora.toast("Out of stock — no copies available","error");</script>';
                            } else {
                                // Insert issued book
                                $query = "insert into issued_books values(null,$_POST[book_no],'$_POST[book_name]','$_POST[book_author]',$_POST[student_id],1,'$_POST[issue_date]',null)";
                                $query_run = mysqli_query($connection,$query);
                                if($query_run){
                                    // Decrement inventory
                                    mysqli_query($connection, "UPDATE books SET book_qty = book_qty - 1 WHERE book_no = $bookNo");
                                    $remaining = $book['book_qty'] - 1;
                                    echo '<script>Aurora.toast("Book issued — '.$remaining.' copies left","success");</script>';
                                } else {
                                    echo '<script>Aurora.toast("Failed to issue book","error");</script>';
                                }
                            }
                        }
                    }
                ?>
            </div>

            <div class="card card--dark">
                <span class="eyebrow" style="color:var(--gold-400);">Reminder</span>
                <h3 class="card__title" style="margin:6px 0 14px;">Issuing guidelines</h3>
                <div style="display:grid;gap:14px;color:rgba(255,255,255,0.7);font-size:14px;line-height:1.6;">
                    <p>• Standard loan period is <strong style="color:var(--gold-400);">14 days</strong>.</p>
                    <p>• Each member may have a maximum of <strong style="color:var(--gold-400);">5 active loans</strong>.</p>
                    <p>• Inventory is automatically decremented on issue.</p>
                    <p>• Books with 0 copies cannot be issued.</p>
                </div>
            </div>
        </div>

        <div class="table-wrap fade-up" style="animation-delay:0.2s;margin-top:32px;">
            <div style="padding:20px 24px;border-bottom:1px solid var(--ink-100);">
                <span class="eyebrow">Active Loans</span>
                <h3 style="margin:4px 0 0;font-size:18px;font-family:'Playfair Display',serif;">Currently Issued Books</h3>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Author</th>
                        <th>Issued To</th>
                        <th>Date</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $connection = mysqli_connect("localhost","root","");
                    $db = mysqli_select_db($connection,"lms");
                    $query = "SELECT ib.*, u.name as student_name FROM issued_books ib LEFT JOIN users u ON ib.student_id = u.id WHERE ib.status = 1 ORDER BY ib.issue_date DESC LIMIT 20";
                    $query_run = mysqli_query($connection,$query);
                    if($query_run && mysqli_num_rows($query_run) > 0){
                        while ($row = mysqli_fetch_assoc($query_run)){
                            echo '<tr>
                                <td><div class="table__title">'.htmlspecialchars($row['book_name']).'</div><div class="table__sub">#'.htmlspecialchars($row['book_no']).'</div></td>
                                <td>'.htmlspecialchars($row['book_author']).'</td>
                                <td>
                                    <div class="flex gap-2" style="align-items:center;">
                                        <div class="avatar" style="width:28px;height:28px;font-size:11px;">'.strtoupper(substr($row['student_name'] ?? 'U', 0, 1)).'</div>
                                        <span>'.htmlspecialchars($row['student_name'] ?? 'Unknown').'</span>
                                    </div>
                                </td>
                                <td><span class="mono" style="color:var(--ink-500);">'.htmlspecialchars($row['issue_date']).'</span></td>
                                <td style="text-align:right;">
                                    <a href="return_book.php?id='.urlencode($row['id']).'" data-confirm="Mark this book as returned? This will add 1 copy back to inventory." class="btn btn--sm" style="padding:6px 12px;background:rgba(31,111,67,0.10);color:var(--emerald);">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 14 4 9 20 9 15 14"/><line x1="4" y1="20" x2="20" y2="20"/></svg>
                                        Return
                                    </a>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5" style="text-align:center;padding:60px 20px;">
                            <div style="font-family:Playfair Display,serif;font-size:48px;color:var(--ink-200);margin-bottom:8px;">∅</div>
                            <p style="color:var(--ink-500);">No active loans.</p>
                        </td></tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

