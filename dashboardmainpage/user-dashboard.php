<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/index.php");
        exit;
    }
    function get_user_issue_book_count(){
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"lms");
        $user_issue_book_count = 0;
        $query = "select count(*) as user_issue_book_count from issued_books where student_id = $_SESSION[id]";
        $query_run = mysqli_query($connection,$query);
        while ($row = mysqli_fetch_assoc($query_run)){
            $user_issue_book_count = $row['user_issue_book_count'];
        }
        return($user_issue_book_count);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar__brand">
            <a href="user-dashboard.php" class="brand">
                <span class="brand__mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="brand__text">
                    <strong>Aurora Library</strong>
                    <span>Member Portal</span>
                </span>
            </a>
        </div>

        <div class="sidebar__group">
            <span class="sidebar__label">Library</span>
            <a href="user-dashboard.php" class="sidebar__link is-active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="view_issued_book.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                My Books
            </a>
        </div>

        <div class="sidebar__group">
            <span class="sidebar__label">Account</span>
            <a href="view_profile.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                My Profile
            </a>
            <a href="edit_profile.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Edit Profile
            </a>
            <a href="change_password.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Change Password
            </a>
        </div>

        <div class="sidebar__foot">
            <div class="sidebar__user">
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)); ?></div>
                <div class="sidebar__user-meta">
                    <strong><?php echo $_SESSION['name'] ?? 'Guest'; ?></strong>
                    <span><?php echo $_SESSION['email'] ?? ''; ?></span>
                </div>
            </div>
            <a href="../logout.php" class="btn btn--ghost btn--sm" style="margin-top:14px;width:100%;border-color:rgba(255,255,255,0.12);color:rgba(255,255,255,0.7);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="main">

        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Welcome back</span>
                <h1 class="page-head__title">Good to see you, <em><?php echo explode(' ', $_SESSION['name'] ?? 'Guest')[0]; ?></em>.</h1>
                <p class="page-head__sub">Here's a quick overview of your reading activity at Aurora Library.</p>
            </div>
            <div class="page-head__actions">
                <a href="view_issued_book.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    View My Books
                </a>
            </div>
        </div>

        <div class="grid grid--3 stagger mb-8">
            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--gold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                </div>
                <div class="stat__value" data-count="<?php echo get_user_issue_book_count(); ?>">0</div>
                <div class="stat__label">Books Currently Issued</div>
                <span class="stat__trend">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
                    Active loans
                </span>
            </div>

            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <div class="stat__value">14</div>
                <div class="stat__label">Days Left This Month</div>
                <span class="stat__trend" style="color:var(--ink-500);">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Renew anytime
                </span>
            </div>

            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--indigo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                </div>
                <div class="stat__value">Gold</div>
                <div class="stat__label">Membership Tier</div>
                <span class="stat__trend">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Verified member
                </span>
            </div>
        </div>

        <div class="grid grid--2 stagger">
            <div class="card">
                <div class="flex-between mb-4">
                    <div>
                        <span class="eyebrow">Quick Action</span>
                        <h3 class="card__title" style="margin-top:6px;">Browse the Collection</h3>
                    </div>
                    <div class="card__icon" style="margin:0;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </div>
                <p class="card__desc">Explore thousands of titles across every genre. From timeless classics to contemporary releases, your next favorite read awaits.</p>
                <a href="view_issued_book.php" class="btn btn--ghost btn--sm mt-4">
                    View issued books
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="card card--dark">
                <div class="flex-between mb-4">
                    <div>
                        <span class="eyebrow" style="color:var(--gold-400);">Today's Quote</span>
                        <h3 class="card__title" style="margin-top:6px;">A Daily Inspiration</h3>
                    </div>
                </div>
                <p style="font-family:'Playfair Display',serif;font-size:22px;font-style:italic;line-height:1.5;color:var(--gold-200);margin-bottom:16px;">
                    "A reader lives a thousand lives before he dies. The man who never reads lives only one."
                </p>
                <span style="font-size:12px;letter-spacing:0.14em;text-transform:uppercase;color:rgba(255,255,255,0.5);">— George R.R. Martin</span>
            </div>
        </div>

    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

