<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "select issued_books.id,issued_books.book_name,issued_books.book_author,issued_books.book_no,users.name from issued_books left join users on issued_books.student_id = users.id where issued_books.status = 1";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">

    <aside class="sidebar">
        <div class="sidebar__brand">
            <a href="admin_dashboard.php" class="brand">
                <span class="brand__mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></span>
                <span class="brand__text"><strong>Aurora Library</strong><span>Admin Console</span></span>
            </a>
        </div>
        <div class="sidebar__group">
            <span class="sidebar__label">Overview</span>
            <a href="admin_dashboard.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a>
            <a href="view_issued_book.php" class="sidebar__link is-active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>Issued Books</a>
        </div>
        <div class="sidebar__group">
            <span class="sidebar__label">Catalog</span>
            <a href="../Add_books_lms/add_book.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>Add Book</a>
            <a href="../Add_books_lms/manage_book.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>Manage Books</a>
            <a href="../Manage_Book_Categories/add_cat.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>Add Category</a>
            <a href="../Manage_Book_Categories/manage_cat.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>Manage Categories</a>
            <a href="../Issue_book_Module/issue_book.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>Issue Book</a>
        </div>
        <div class="sidebar__group">
            <span class="sidebar__label">Account</span>
            <a href="view_profile.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>My Profile</a>
            <a href="edit_profile.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>Edit Profile</a>
            <a href="change_password.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Change Password</a>
        </div>
        <div class="sidebar__foot">
            <div class="sidebar__user">
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'] ?? 'A', 0, 1)); ?></div>
                <div class="sidebar__user-meta"><strong><?php echo $_SESSION['name']; ?></strong><span><?php echo $_SESSION['email']; ?></span></div>
            </div>
            <a href="../logout.php" class="btn btn--ghost btn--sm" style="margin-top:14px;width:100%;border-color:rgba(255,255,255,0.12);color:rgba(255,255,255,0.7);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Sign Out
            </a>
        </div>
    </aside>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Circulation</span>
                <h1 class="page-head__title">Issued <em>Books</em></h1>
                <p class="page-head__sub">All books currently issued to members across the library.</p>
            </div>
            <div class="page-head__actions">
                <a href="../Issue_book_Module/issue_book.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Issue New Book
                </a>
            </div>
        </div>

        <div class="table-wrap fade-up" style="animation-delay:0.1s;">
            <table class="table" id="issuedTable">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>ISBN / Number</th>
                        <th>Issued To</th>
                        <th>Issued</th>
                        <th>Status</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $query_run = mysqli_query($connection,$query);
                    if(mysqli_num_rows($query_run) > 0){
                        while ($row = mysqli_fetch_assoc($query_run)){
                            echo '<tr>
                                <td><div class="table__title">'.htmlspecialchars($row['book_name']).'</div></td>
                                <td>'.htmlspecialchars($row['book_author']).'</td>
                                <td><span class="mono" style="color:var(--ink-500);">#'.htmlspecialchars($row['book_no']).'</span></td>
                                <td>
                                    <div class="flex gap-2" style="align-items:center;">
                                        <div class="avatar" style="width:28px;height:28px;font-size:11px;">'.strtoupper(substr($row['name'], 0, 1)).'</div>
                                        <span>'.htmlspecialchars($row['name']).'</span>
                                    </div>
                                </td>
                                <td><span class="mono" style="color:var(--ink-500);">'.htmlspecialchars($row['issue_date'] ?? '—').'</span></td>
                                <td><span class="badge badge--emerald">● Active</span></td>
                                <td style="text-align:right;">
                                    <a href="../Issue_book_Module/return_book.php?id='.urlencode($row['id']).'" data-confirm="Mark as returned? Inventory will be updated." class="btn btn--sm" style="padding:6px 12px;background:rgba(31,111,67,0.10);color:var(--emerald);">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 14 4 9 20 9 15 14"/><line x1="4" y1="20" x2="20" y2="20"/></svg>
                                        Return
                                    </a>
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7" style="text-align:center;padding:60px 20px;">
                            <div style="font-family:Playfair Display,serif;font-size:48px;color:var(--ink-200);margin-bottom:8px;">∅</div>
                            <p style="color:var(--ink-500);">No books are currently issued.</p>
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

