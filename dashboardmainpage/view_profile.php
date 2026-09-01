<?php
    session_start();
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $name = "";
    $email = "";
    $mobile = "";
    $address = "";
    $query = "select * from users where email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection,$query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $address = $row['address'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">

    <aside class="sidebar">
        <div class="sidebar__brand">
            <a href="user-dashboard.php" class="brand">
                <span class="brand__mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="brand__text"><strong>Aurora Library</strong><span>Member Portal</span></span>
            </a>
        </div>
        <div class="sidebar__group">
            <span class="sidebar__label">Library</span>
            <a href="user-dashboard.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a>
            <a href="view_issued_book.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>My Books</a>
        </div>
        <div class="sidebar__group">
            <span class="sidebar__label">Account</span>
            <a href="view_profile.php" class="sidebar__link is-active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>My Profile</a>
            <a href="edit_profile.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>Edit Profile</a>
            <a href="change_password.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Change Password</a>
        </div>
        <div class="sidebar__foot">
            <div class="sidebar__user">
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'] ?? 'U', 0, 1)); ?></div>
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
                <span class="eyebrow">Account</span>
                <h1 class="page-head__title">My <em>Profile</em></h1>
                <p class="page-head__sub">Your personal information and membership details.</p>
            </div>
            <div class="page-head__actions">
                <a href="edit_profile.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="grid grid--2 stagger">
            <div class="card card--dark" style="grid-row:span 2;">
                <div style="text-align:center;padding:24px 0;">
                    <div class="avatar" style="width:96px;height:96px;font-size:38px;margin:0 auto 20px;box-shadow:0 16px 40px rgba(212,175,55,0.3);"><?php echo strtoupper(substr($name, 0, 1)); ?></div>
                    <h3 style="color:#fff;margin-bottom:6px;"><?php echo $name; ?></h3>
                    <p style="color:rgba(255,255,255,0.6);font-size:14px;"><?php echo $email; ?></p>
                </div>
                <div class="divider" style="background:rgba(255,255,255,0.08);"></div>
                <div style="display:grid;gap:16px;">
                    <div class="flex-between">
                        <span style="color:rgba(255,255,255,0.5);font-size:12px;letter-spacing:0.14em;text-transform:uppercase;">Member Since</span>
                        <span style="color:#fff;font-weight:500;"><?php echo date('M Y'); ?></span>
                    </div>
                    <div class="flex-between">
                        <span style="color:rgba(255,255,255,0.5);font-size:12px;letter-spacing:0.14em;text-transform:uppercase;">Status</span>
                        <span class="badge badge--gold">Active</span>
                    </div>
                    <div class="flex-between">
                        <span style="color:rgba(255,255,255,0.5);font-size:12px;letter-spacing:0.14em;text-transform:uppercase;">Tier</span>
                        <span style="color:var(--gold-400);font-weight:600;">Gold Member</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <span class="eyebrow">Contact</span>
                <h3 class="card__title" style="margin:6px 0 20px;">Personal Information</h3>
                <div style="display:grid;gap:18px;">
                    <div>
                        <div style="font-size:12px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.12em;font-weight:600;margin-bottom:6px;">Full Name</div>
                        <div style="font-size:15px;color:var(--ink-900);font-weight:500;"><?php echo $name; ?></div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.12em;font-weight:600;margin-bottom:6px;">Email Address</div>
                        <div style="font-size:15px;color:var(--ink-900);font-weight:500;"><?php echo $email; ?></div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.12em;font-weight:600;margin-bottom:6px;">Mobile</div>
                        <div style="font-size:15px;color:var(--ink-900);font-weight:500;"><?php echo $mobile; ?></div>
                    </div>
                    <div>
                        <div style="font-size:12px;color:var(--ink-500);text-transform:uppercase;letter-spacing:0.12em;font-weight:600;margin-bottom:6px;">Address</div>
                        <div style="font-size:15px;color:var(--ink-900);font-weight:500;"><?php echo $address; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

