<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/index.php");
        exit;
    }
    #fetch data from database
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
    <title>Edit Profile · Aurora Library</title>
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
            <a href="view_profile.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>My Profile</a>
            <a href="edit_profile.php" class="sidebar__link is-active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>Edit Profile</a>
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
                <span class="eyebrow">Account Settings</span>
                <h1 class="page-head__title">Edit <em>Profile</em></h1>
                <p class="page-head__sub">Keep your information up to date for a seamless library experience.</p>
            </div>
            <div class="page-head__actions">
                <a href="view_profile.php" class="btn btn--ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid--3 stagger">
            <div class="card" style="grid-column:span 2;">
                <span class="eyebrow">Personal Information</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Update your details</h3>

                <form action="update.php" method="post">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="name">Full Name</label>
                            <input class="input" type="text" name="name" id="name" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="email">Email</label>
                            <input class="input" type="email" name="email" id="email" value="<?php echo $email; ?>" required>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="field">
                            <label class="field__label" for="mobile">Mobile</label>
                            <input class="input" type="tel" name="mobile" id="mobile" value="<?php echo $mobile; ?>" required>
                        </div>
                        <div class="field">
                            <label class="field__label" for="address">Address</label>
                            <input class="input" type="text" name="address" id="address" value="<?php echo $address; ?>" required>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="update" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                        <a href="view_profile.php" class="btn btn--ghost">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="card card--dark">
                <span class="eyebrow" style="color:var(--gold-400);">Tip</span>
                <h3 class="card__title" style="margin:6px 0 14px;">Stay in sync</h3>
                <p style="color:rgba(255,255,255,0.7);font-size:14px;line-height:1.7;">Keeping your contact details current ensures you never miss a book due-date notification or library event invitation.</p>
                <div class="divider" style="background:rgba(255,255,255,0.08);"></div>
                <div class="flex gap-3" style="align-items:center;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(212,175,55,0.15);display:grid;place-items:center;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold-400)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <p style="font-size:13px;color:rgba(255,255,255,0.6);line-height:1.5;">Changes are saved instantly to your account.</p>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

