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
    <title>Add Category · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('addcat'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Categories</span>
                <h1 class="page-head__title">Add <em>Category</em></h1>
                <p class="page-head__sub">Create a new category to organize the collection.</p>
            </div>
            <div class="page-head__actions">
                <a href="manage_cat.php" class="btn btn--ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid--3 stagger">
            <div class="card" style="grid-column:span 2;">
                <span class="eyebrow">New Category</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Category details</h3>
                <form action="" method="post">
                    <div class="field">
                        <label class="field__label" for="cat_name">Category Name</label>
                        <input class="input" type="text" name="cat_name" id="cat_name" placeholder="e.g. Science Fiction" required>
                        <p class="field__hint">Choose a clear, descriptive name for the category.</p>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="add_cat" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            Create Category
                        </button>
                        <button type="reset" class="btn btn--ghost">Reset</button>
                    </div>
                </form>
                <?php
                    if(isset($_POST['add_cat'])){
                        $connection = mysqli_connect("localhost","root","");
                        $db = mysqli_select_db($connection,"lms");
                        $query = "insert into category values('','$_POST[cat_name]')";
                        $query_run = mysqli_query($connection,$query);
                        if($query_run){
                            echo '<script>Aurora.toast("Category created successfully","success");</script>';
                        } else {
                            echo '<script>Aurora.toast("Failed to create category","error");</script>';
                        }
                    }
                ?>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

