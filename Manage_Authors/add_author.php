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
    <title>Add Author · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('addauthor'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Authors</span>
                <h1 class="page-head__title">Add New <em>Author</em></h1>
                <p class="page-head__sub">Add a new author to the library catalog.</p>
            </div>
            <div class="page-head__actions">
                <a href="manage_author.php" class="btn btn--ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid--3 stagger">
            <div class="card" style="grid-column:span 2;">
                <span class="eyebrow">New Author</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Author details</h3>
                <form action="" method="post">
                    <div class="field">
                        <label class="field__label" for="author_name">Author Name</label>
                        <input class="input" type="text" name="author_name" id="author_name" placeholder="e.g. J.K. Rowling" required>
                        <p class="field__hint">Use the full legal name or pen name of the author.</p>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="add_author" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            Add Author
                        </button>
                        <button type="reset" class="btn btn--ghost">Reset</button>
                    </div>
                </form>
                <?php
                    if(isset($_POST['add_author'])){
                        $connection = mysqli_connect("localhost","root","");
                        $db = mysqli_select_db($connection,"lms");
                        $query = "insert into authors values('','$_POST[author_name]')";
                        $query_run = mysqli_query($connection,$query);
                        if($query_run){
                            echo '<script>Aurora.toast("Author added successfully","success");</script>';
                        } else {
                            echo '<script>Aurora.toast("Failed to add author","error");</script>';
                        }
                    }
                ?>
            </div>

            <div class="card card--dark">
                <span class="eyebrow" style="color:var(--gold-400);">Tip</span>
                <h3 class="card__title" style="margin:6px 0 14px;">Author guidelines</h3>
                <div style="display:grid;gap:14px;color:rgba(255,255,255,0.7);font-size:14px;line-height:1.6;">
                    <p>• Use the author's most recognized name for consistency.</p>
                    <p>• Authors can be assigned when adding or editing books.</p>
                    <p>• Author names cannot be duplicated — check the manage page first.</p>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

