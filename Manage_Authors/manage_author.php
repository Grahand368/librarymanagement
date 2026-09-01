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
    <title>Manage Authors · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">
    <?php include("../Admin_Dashboard_Module/sidebar.php"); admin_sidebar('manageauthor'); ?>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Catalog · Authors</span>
                <h1 class="page-head__title">Manage <em>Authors</em></h1>
                <p class="page-head__sub">Edit, update, or remove authors from the catalog.</p>
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
                        <th style="text-align:right;width:240px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $connection = mysqli_connect("localhost","root","");
                    $db = mysqli_select_db($connection,"lms");
                    $query = "select * from authors";
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
                                <td style="text-align:right;">
                                    <div class="flex gap-2" style="justify-content:flex-end;">
                                        <a href="edit_author.php?aid='.urlencode($row['author_id']).'" class="btn btn--sm btn--ghost" style="padding:6px 12px;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                            Edit
                                        </a>
                                        <a href="delete_author.php?aid='.urlencode($row['author_id']).'" data-confirm="Delete this author permanently?" class="btn btn--sm" style="padding:6px 12px;background:rgba(155,28,28,0.10);color:var(--crimson);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2" style="text-align:center;padding:60px 20px;">
                            <div style="font-family:Playfair Display,serif;font-size:48px;color:var(--ink-200);margin-bottom:8px;">∅</div>
                            <p style="color:var(--ink-500);">No authors yet. Add your first one.</p>
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

