<?php
    require("../Admin_Dashboard_Module/functions.php");
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $cat_id = "";
    $cat_name = "";
    $query = "select * from category where cat_id = $_GET[cid]";
    $query_run = mysqli_query($connection,$query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $cat_name = $row['cat_name'];
        $cat_id = $row['cat_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('managecat'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Categories</span>
                <h1 class="page-head__title">Edit <em>Category</em></h1>
                <p class="page-head__sub">Update category information.</p>
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
                <span class="eyebrow">Edit</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Update category</h3>
                <form action="" method="post">
                    <div class="field">
                        <label class="field__label" for="cat_name">Category Name</label>
                        <input class="input" type="text" name="cat_name" id="cat_name" value="<?php echo htmlspecialchars($cat_name); ?>" required>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="update_cat" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                        <a href="manage_cat.php" class="btn btn--ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

