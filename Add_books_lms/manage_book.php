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
    <title>Manage Books · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('managebook'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Books</span>
                <h1 class="page-head__title">Manage <em>Books</em></h1>
                <p class="page-head__sub">Edit, update, or remove titles from the library collection.</p>
            </div>
            <div class="page-head__actions">
                <a href="add_book.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                    Add New Book
                </a>
            </div>
        </div>

        <div class="table-wrap fade-up" style="animation-delay:0.1s;">
            <table class="table" id="booksTable">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>ISBN</th>
                            <th>Price (NPR)</th>
                            <th style="text-align:center;">Copies</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                    $connection = mysqli_connect("localhost","root","");
                    $db = mysqli_select_db($connection,"lms");
                    $query = "select * from books";
                    $query_run = mysqli_query($connection,$query);
                    if(mysqli_num_rows($query_run) > 0){
                        while ($row = mysqli_fetch_assoc($query_run)){
                            echo '<tr>
                                <td><div class="table__title">'.htmlspecialchars($row['book_name']).'</div></td>
                                <td>'.htmlspecialchars($row['author_id']).'</td>
                                <td>'.htmlspecialchars($row['cat_id']).'</td>
                                <td><span class="mono" style="color:var(--ink-500);">#'.htmlspecialchars($row['book_no']).'</span></td>
                                <td><span class="fw-600">NPR '.number_format($row['book_price'], 2).'</span></td>
                                <td style="text-align:center;">
                                    <span class="badge '.($row['book_qty'] ?? 0 > 0 ? 'badge--emerald' : 'badge--crimson').'">'.($row['book_qty'] ?? 0).' in stock</span>
                                </td>
                                <td style="text-align:right;">
                                    <div class="flex gap-2" style="justify-content:flex-end;">
                                        <a href="edit_book.php?bn='.urlencode($row['book_no']).'" class="btn btn--sm btn--ghost" style="padding:6px 12px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                            Edit
                                        </a>
                                        <a href="delete_book.php?bn='.urlencode($row['book_no']).'" data-confirm="Delete this book permanently?" class="btn btn--sm" style="padding:6px 12px;background:rgba(155,28,28,0.10);color:var(--crimson);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6" style="text-align:center;padding:60px 20px;">
                            <div style="font-family:Playfair Display,serif;font-size:48px;color:var(--ink-200);margin-bottom:8px;">∅</div>
                            <p style="color:var(--ink-500);">No books in the catalog yet. Add your first book to get started.</p>
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

