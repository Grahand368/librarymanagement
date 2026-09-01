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
    <title>Add Book · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('addbook'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Books</span>
                <h1 class="page-head__title">Add New <em>Book</em></h1>
                <p class="page-head__sub">Expand the collection by adding a new title to the library.</p>
            </div>
            <div class="page-head__actions">
                <a href="manage_book.php" class="btn btn--ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid--3 stagger">
            <div class="card" style="grid-column:span 2;">
                <span class="eyebrow">New Entry</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Book details</h3>
                <form action="" method="post">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="book_name">Book Title</label>
                            <input class="input" type="text" name="book_name" id="book_name" placeholder="The Great Gatsby" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="book_no">Book Number / ISBN</label>
                            <input class="input" type="text" name="book_no" id="book_no" placeholder="ISBN-13" required>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="book_author">Author ID</label>
                            <input class="input" type="text" name="book_author" id="book_author" placeholder="1" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="book_category">Category ID</label>
                            <input class="input" type="text" name="book_category" id="book_category" placeholder="1" required>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="book_price">Price (NPR)</label>
                            <input class="input" type="text" name="book_price" id="book_price" placeholder="0.00" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="book_qty">Number of Copies</label>
                            <input class="input" type="number" name="book_qty" id="book_qty" placeholder="5" value="5" min="1" required>
                            <p class="field__hint">Default: 5 copies in inventory.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="add_book" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            Add to Library
                        </button>
                        <button type="reset" class="btn btn--ghost">Reset</button>
                    </div>
                </form>
                <?php
                    if(isset($_POST['add_book'])){
                        $connection = mysqli_connect("localhost","root","");
                        $db = mysqli_select_db($connection,"lms");
                        $qty = max(1, intval($_POST['book_qty']));
                        $query = "insert into books values(null,'$_POST[book_name]','$_POST[book_author]','$_POST[book_category]',$_POST[book_no],$_POST[book_price],$qty)";
                        $query_run = mysqli_query($connection,$query);
                        if($query_run){
                            echo '<script>Aurora.toast("Book added with '.$qty.' copies","success");</script>';
                        } else {
                            echo '<script>Aurora.toast("Failed to add book","error");</script>';
                        }
                    }
                ?>
            </div>

            <div class="card card--dark">
                <span class="eyebrow" style="color:var(--gold-400);">Tip</span>
                <h3 class="card__title" style="margin:6px 0 14px;">Cataloging best practices</h3>
                <div style="display:grid;gap:14px;color:rgba(255,255,255,0.7);font-size:14px;line-height:1.6;">
                    <p>• Use the <strong style="color:var(--gold-400);">ISBN-13</strong> as the unique book number when available.</p>
                    <p>• Reference existing <strong style="color:var(--gold-400);">author</strong> and <strong style="color:var(--gold-400);">category</strong> IDs to keep relationships consistent.</p>
                    <p>• Prices should be entered in NPR without currency symbols.</p>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

