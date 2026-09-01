<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password · Aurora Library</title>
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
            <a href="edit_profile.php" class="sidebar__link"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>Edit Profile</a>
            <a href="change_password.php" class="sidebar__link is-active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Change Password</a>
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
                <span class="eyebrow">Security</span>
                <h1 class="page-head__title">Change <em>Password</em></h1>
                <p class="page-head__sub">Update your password to keep your account secure.</p>
            </div>
        </div>

        <div class="grid grid--2 stagger">
            <div class="card" style="grid-column:span 1;">
                <span class="eyebrow">Update</span>
                <h3 class="card__title" style="margin:6px 0 24px;">Set a new password</h3>
                <form action="update_password.php" method="post">
                    <div class="field">
                        <label class="field__label" for="old_password">Current Password</label>
                        <div class="input--with-icon" style="position:relative;">
                            <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input class="input" type="password" name="old_password" id="old_password" placeholder="Enter your current password" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="new_password">New Password</label>
                        <div class="input--with-icon" style="position:relative;">
                            <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <input class="input" type="password" name="new_password" id="new_password" placeholder="At least 6 characters" required minlength="6">
                        </div>
                        <p class="field__hint">Use a mix of letters, numbers & symbols for a stronger password.</p>
                    </div>
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="update" class="btn btn--primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Update Password
                        </button>
                        <a href="user-dashboard.php" class="btn btn--ghost">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="card card--dark">
                <span class="eyebrow" style="color:var(--gold-400);">Security Tips</span>
                <h3 class="card__title" style="margin:6px 0 18px;">Stay protected</h3>
                <div style="display:grid;gap:16px;">
                    <div class="flex gap-3" style="align-items:flex-start;">
                        <div style="width:32px;height:32px;border-radius:8px;background:rgba(212,175,55,0.15);display:grid;place-items:center;flex-shrink:0;">
                            <span style="color:var(--gold-400);font-weight:700;">1</span>
                        </div>
                        <div>
                            <h4 style="color:#fff;font-family:'Inter',sans-serif;font-size:14px;margin-bottom:4px;">Use 12+ characters</h4>
                            <p style="color:rgba(255,255,255,0.6);font-size:13px;">Longer passwords are exponentially harder to crack.</p>
                        </div>
                    </div>
                    <div class="flex gap-3" style="align-items:flex-start;">
                        <div style="width:32px;height:32px;border-radius:8px;background:rgba(212,175,55,0.15);display:grid;place-items:center;flex-shrink:0;">
                            <span style="color:var(--gold-400);font-weight:700;">2</span>
                        </div>
                        <div>
                            <h4 style="color:#fff;font-family:'Inter',sans-serif;font-size:14px;margin-bottom:4px;">Mix character types</h4>
                            <p style="color:rgba(255,255,255,0.6);font-size:13px;">Combine uppercase, lowercase, numbers and symbols.</p>
                        </div>
                    </div>
                    <div class="flex gap-3" style="align-items:flex-start;">
                        <div style="width:32px;height:32px;border-radius:8px;background:rgba(212,175,55,0.15);display:grid;place-items:center;flex-shrink:0;">
                            <span style="color:var(--gold-400);font-weight:700;">3</span>
                        </div>
                        <div>
                            <h4 style="color:#fff;font-family:'Inter',sans-serif;font-size:14px;margin-bottom:4px;">Avoid reuse</h4>
                            <p style="color:rgba(255,255,255,0.6);font-size:13px;">Don't reuse passwords across different websites.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

