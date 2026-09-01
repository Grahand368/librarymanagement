<?php
    require("../Admin_Dashboard_Module/functions.php");
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "select books.book_name,books.book_no,book_price,authors.author_name from books left join authors on books.author_id = authors.author_id";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('regbooks'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Books</span>
                <h1 class="page-head__title">Book <em>Catalog</em></h1>
                <p class="page-head__sub">Complete view of all books in the library collection.</p>
            </div>
            <div class="page-head__actions">
                <a href="add_book.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                    Add Book
                </a>
            </div>
        </div>

        <div class="table-wrap fade-up" style="animation-delay:0.1s;">
            <table class="table" id="booksTable">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Price (NPR)</th>
                            <th style="text-align:center;">Available</th>
                            <th>Number</th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                    $query_run = mysqli_query($connection,$query);
                    if(mysqli_num_rows($query_run) > 0){
                        while ($row = mysqli_fetch_assoc($query_run)){
                            echo '<tr>
                                <td><div class="table__title">'.htmlspecialchars($row['book_name']).'</div></td>
                                <td>'.htmlspecialchars($row['author_name'] ?? '—').'</td>
                                <td><span class="fw-600">NPR '.number_format((float)$row['book_price'], 2).'</span></td>
                                <td style="text-align:center;"><span class="badge '.($row['book_qty'] ?? 0 > 0 ? 'badge--emerald' : 'badge--crimson').'">'.($row['book_qty'] ?? 0).'</span></td>
                                <td><span class="mono" style="color:var(--ink-500);">#'.htmlspecialchars($row['book_no']).'</span></td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4" style="text-align:center;padding:60px 20px;">
                            <div style="font-family:Playfair Display,serif;font-size:48px;color:var(--ink-200);margin-bottom:8px;">∅</div>
                            <p style="color:var(--ink-500);">No books found.</p>
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

