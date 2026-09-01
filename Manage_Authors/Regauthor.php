<?php
    require("../Admin_Dashboard_Module/functions.php");
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "select * from authors";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('manageauthor'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Authors</span>
                <h1 class="page-head__title">All <em>Authors</em></h1>
                <p class="page-head__sub">Browse all authors in the library.</p>
            </div>
            <div class="page-head__actions">
                <a href="add_author.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                    Add Author
                </a>
            </div>
        </div>

        <div class="table-wrap fade-up" style="animation-delay:0.1s;">
            <table class="table" id="authorTable">
                <thead>
                    <tr>
                        <th>Author Name</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query_run = mysqli_query($connection,$query);
                    if(mysqli_num_rows($query_run) > 0){
                        while ($row = mysqli_fetch_assoc($query_run)){
                            echo '<tr>
                                <td>
                                    <div class="flex gap-3" style="align-items:center;">
                                        <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--gold-100),var(--gold-200));color:var(--gold-900);display:grid;place-items:center;font-weight:700;">'.strtoupper(substr($row['author_name'], 0, 1)).'</div>
                                        <div class="table__title">'.htmlspecialchars($row['author_name']).'</div>
                                    </div>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td style="text-align:center;padding:60px 20px;">
                            <div style="font-family:Playfair Display,serif;font-size:48px;color:var(--ink-200);margin-bottom:8px;">∅</div>
                            <p style="color:var(--ink-500);">No authors yet.</p>
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

