<?php
    require("../Admin_Dashboard_Module/functions.php");
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $book_name = "";
    $book_no = "";
    $author_id = "";
    $cat_id = "";
    $book_price = "";
    $book_qty = 5;
    $query = "select * from books where book_no = $_GET[bn]";
    $query_run = mysqli_query($connection,$query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $book_name = $row['book_name'];
        $book_no = $row['book_no'];
        $author_id = $row['author_id'];
        $cat_id = $row['cat_id'];
        $book_price = $row['book_price'];
        $book_qty = $row['book_qty'] ?? 5;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('managebook'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Books</span>
                <h1 class="page-head__title">Edit <em>Book</em></h1>
                <p class="page-head__sub">Update book details in the catalog.</p>
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
                <span class="eyebrow">Edit</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Update book details</h3>
                <form action="" method="post">
                    <div class="field">
                        <label class="field__label" for="book_no">Book Number / ISBN</label>
                        <input class="input" type="text" name="book_no" id="book_no" value="<?php echo $book_no; ?>" disabled>
                        <p class="field__hint">Book number cannot be changed.</p>
                    </div>
                    <div class="field">
                        <label class="field__label" for="book_name">Book Title</label>
                        <input class="input" type="text" name="book_name" id="book_name" value="<?php echo $book_name; ?>" required>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="author_id">Author ID</label>
                            <input class="input" type="text" name="author_id" id="author_id" value="<?php echo $author_id; ?>" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="cat_id">Category ID</label>
                            <input class="input" type="text" name="cat_id" id="cat_id" value="<?php echo $cat_id; ?>" required>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="book_price">Price (NPR)</label>
                            <input class="input" type="text" name="book_price" id="book_price" value="<?php echo $book_price; ?>" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="book_qty">Number of Copies</label>
                            <input class="input" type="number" name="book_qty" id="book_qty" value="<?php echo $book_qty; ?>" min="0" required>
                            <p class="field__hint">Set to 0 to mark as out of stock.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="update" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                        <a href="manage_book.php" class="btn btn--ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<?php
    if(isset($_POST['update'])){
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"lms");
        $qty = max(0, intval($_POST['book_qty']));
        $query = "update books set book_name = '$_POST[book_name]',author_id = $_POST[author_id],cat_id = $_POST[cat_id],book_price = '$_POST[book_price]',book_qty = $qty where book_no = $_GET[bn]";
        $query_run = mysqli_query($connection,$query);
        if($query_run){
            echo '<script>Aurora.toast("Book updated successfully","success"); setTimeout(()=>{window.location.href="manage_book.php";}, 1200);</script>';
        } else {
            echo '<script>Aurora.toast("Failed to update book","error");</script>';
        }
    }
?>
<script src="../static/js/aurora.js"></script>
</body>
</html>

