<?php
    require("functions.php");
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
    <title>Admin Dashboard · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="shell">

    <aside class="sidebar">
        <div class="sidebar__brand">
            <a href="admin_dashboard.php" class="brand">
                <span class="brand__mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="brand__text"><strong>Aurora Library</strong><span>Admin Console</span></span>
            </a>
        </div>

        <div class="sidebar__group">
            <span class="sidebar__label">Overview</span>
            <a href="admin_dashboard.php" class="sidebar__link is-active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="view_issued_book.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Issued Books
            </a>
        </div>

        <div class="sidebar__group">
            <span class="sidebar__label">Catalog</span>
            <a href="../Add_books_lms/add_book.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Add Book
            </a>
            <a href="../Add_books_lms/manage_book.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Manage Books
            </a>
            <a href="../Manage_Book_Categories/add_cat.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                Add Category
            </a>
            <a href="../Manage_Book_Categories/manage_cat.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                Manage Categories
            </a>
            <a href="../Issue_book_Module/issue_book.php" class="sidebar__link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Issue Book
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
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'] ?? 'A', 0, 1)); ?></div>
                <div class="sidebar__user-meta"><strong><?php echo $_SESSION['name'] ?? 'Admin'; ?></strong><span><?php echo $_SESSION['email'] ?? ''; ?></span></div>
            </div>
            <a href="../logout.php" class="btn btn--ghost btn--sm" style="margin-top:14px;width:100%;border-color:rgba(255,255,255,0.12);color:rgba(255,255,255,0.7);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </a>
        </div>
    </aside>

    <main class="main">
        <div class="page-head fade-up">
            <div>
                <span class="eyebrow">Administration</span>
                <h1 class="page-head__title">Library <em>Overview</em></h1>
                <p class="page-head__sub">Real-time insights into your collection, members, and circulation.</p>
            </div>
            <div class="page-head__actions">
                <a href="../Add_books_lms/add_book.php" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                    Add New Book
                </a>
                <a href="../Issue_book_Module/issue_book.php" class="btn btn--ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Issue Book
                </a>
            </div>
        </div>

        <div class="grid grid--5 stagger mb-8">
            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--indigo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                </div>
                <div class="stat__value" data-count="<?php echo get_user_count(); ?>">0</div>
                <div class="stat__label">Registered Users</div>
            </div>

            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--gold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                </div>
                <div class="stat__value" data-count="<?php echo get_book_count(); ?>">0</div>
                <div class="stat__label">Books in Catalog</div>
            </div>

            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    </div>
                </div>
                <div class="stat__value" data-count="<?php echo get_category_count(); ?>">0</div>
                <div class="stat__label">Categories</div>
            </div>

            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                </div>
                <div class="stat__value" data-count="<?php echo get_author_count(); ?>">0</div>
                <div class="stat__label">Authors</div>
            </div>

            <div class="stat">
                <div class="stat__row">
                    <div class="stat__icon stat__icon--crimson">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                </div>
                <div class="stat__value" data-count="<?php echo get_issue_book_count(); ?>">0</div>
                <div class="stat__label">Books Issued</div>
            </div>
        </div>

        <div class="grid grid--2 stagger">
            <div class="card">
                <div class="flex-between mb-6">
                    <div>
                        <span class="eyebrow">Quick Actions</span>
                        <h3 class="card__title" style="margin-top:6px;">Manage your library</h3>
                    </div>
                </div>
                <div style="display:grid;gap:12px;">
                    <a href="../Add_books_lms/add_book.php" class="flex-between" style="padding:16px;border:1px solid var(--ink-100);border-radius:14px;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--gold-500)';this.style.background='rgba(184,134,11,0.04)';" onmouseout="this.style.borderColor='var(--ink-100)';this.style.background='transparent';">
                        <div class="flex gap-3" style="align-items:center;">
                            <div class="stat__icon stat__icon--gold" style="width:40px;height:40px;margin:0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                            </div>
                            <div>
                                <div class="fw-600" style="color:var(--ink-900);">Add New Book</div>
                                <div class="text-sm text-muted">Expand the collection</div>
                            </div>
                        </div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--ink-400)" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a href="../Manage_Authors/add_author.php" class="flex-between" style="padding:16px;border:1px solid var(--ink-100);border-radius:14px;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--gold-500)';this.style.background='rgba(184,134,11,0.04)';" onmouseout="this.style.borderColor='var(--ink-100)';this.style.background='transparent';">
                        <div class="flex gap-3" style="align-items:center;">
                            <div class="stat__icon stat__icon--amber" style="width:40px;height:40px;margin:0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                            </div>
                            <div>
                                <div class="fw-600" style="color:var(--ink-900);">Add Author</div>
                                <div class="text-sm text-muted">Add a new writer</div>
                            </div>
                        </div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--ink-400)" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a href="../Add_books_lms/manage_book.php" class="flex-between" style="padding:16px;border:1px solid var(--ink-100);border-radius:14px;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--gold-500)';this.style.background='rgba(184,134,11,0.04)';" onmouseout="this.style.borderColor='var(--ink-100)';this.style.background='transparent';">
                        <div class="flex gap-3" style="align-items:center;">
                            <div class="stat__icon stat__icon--indigo" style="width:40px;height:40px;margin:0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <div>
                                <div class="fw-600" style="color:var(--ink-900);">Manage Books</div>
                                <div class="text-sm text-muted">Edit or remove titles</div>
                            </div>
                        </div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--ink-400)" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a href="../Manage_Book_Categories/manage_cat.php" class="flex-between" style="padding:16px;border:1px solid var(--ink-100);border-radius:14px;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--gold-500)';this.style.background='rgba(184,134,11,0.04)';" onmouseout="this.style.borderColor='var(--ink-100)';this.style.background='transparent';">
                        <div class="flex gap-3" style="align-items:center;">
                            <div class="stat__icon stat__icon--teal" style="width:40px;height:40px;margin:0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            </div>
                            <div>
                                <div class="fw-600" style="color:var(--ink-900);">Manage Categories</div>
                                <div class="text-sm text-muted">Organize the collection</div>
                            </div>
                        </div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--ink-400)" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a href="regusers.php" class="flex-between" style="padding:16px;border:1px solid var(--ink-100);border-radius:14px;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--gold-500)';this.style.background='rgba(184,134,11,0.04)';" onmouseout="this.style.borderColor='var(--ink-100)';this.style.background='transparent';">
                        <div class="flex gap-3" style="align-items:center;">
                            <div class="stat__icon stat__icon--emerald" style="width:40px;height:40px;margin:0;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            </div>
                            <div>
                                <div class="fw-600" style="color:var(--ink-900);">View All Members</div>
                                <div class="text-sm text-muted">Browse registered users</div>
                            </div>
                        </div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--ink-400)" stroke-width="2" stroke-linecap="round"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                </div>
            </div>

            <div class="card card--dark">
                <span class="eyebrow" style="color:var(--gold-400);">System Status</span>
                <h3 class="card__title" style="margin:6px 0 20px;">All systems operational</h3>
                <div style="display:grid;gap:14px;">
                    <div class="flex-between" style="padding:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);border-radius:12px;">
                        <div class="flex gap-3" style="align-items:center;">
                            <div style="width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 12px #4ade80;"></div>
                            <span style="color:#fff;font-size:14px;font-weight:500;">Database</span>
                        </div>
                        <span style="color:rgba(255,255,255,0.5);font-size:13px;">Connected</span>
                    </div>
                    <div class="flex-between" style="padding:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);border-radius:12px;">
                        <div class="flex gap-3" style="align-items:center;">
                            <div style="width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 12px #4ade80;"></div>
                            <span style="color:#fff;font-size:14px;font-weight:500;">Authentication</span>
                        </div>
                        <span style="color:rgba(255,255,255,0.5);font-size:13px;">Active</span>
                    </div>
                    <div class="flex-between" style="padding:14px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.06);border-radius:12px;">
                        <div class="flex gap-3" style="align-items:center;">
                            <div style="width:8px;height:8px;border-radius:50%;background:#4ade80;box-shadow:0 0 12px #4ade80;"></div>
                            <span style="color:#fff;font-size:14px;font-weight:500;">Catalog Engine</span>
                        </div>
                        <span style="color:rgba(255,255,255,0.5);font-size:13px;">Running</span>
                    </div>
                </div>
                <div class="divider" style="background:rgba(255,255,255,0.08);margin:20px 0 16px;"></div>
                <p style="color:rgba(255,255,255,0.6);font-size:13px;line-height:1.6;">
                    <span style="color:var(--gold-400);font-weight:600;">Last backup:</span> Today, 03:00 AM
                </p>
            </div>
        </div>
    </main>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

