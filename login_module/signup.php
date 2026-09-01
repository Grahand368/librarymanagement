<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora Library — Join</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">

<div class="auth">
    <!-- Left: Art panel -->
    <aside class="auth__art">
        <div class="auth__art-inner fade-in">
            <span class="eyebrow auth__art-eyebrow">Aurora Library · Become a Member</span>
            <h1>Begin your<br><em>literary</em> voyage.</h1>
            <p>Create your free membership and unlock access to thousands of titles, personalized reading lists, and exclusive library events.</p>

            <div class="auth__art-quote">
                <p>"Until I feared I would lose it, I never loved to read. One does not love breathing."</p>
                <span>— Harper Lee</span>
            </div>
        </div>

        <div class="auth__art-ticker">
            <span><span class="dot"></span> Free Membership</span>
            <span><span class="dot"></span> Instant Access</span>
            <span><span class="dot"></span> No Card Required</span>
        </div>
    </aside>

    <!-- Right: Form panel -->
    <section class="auth__panel">
        <div class="auth__card fade-up" style="max-width:520px;">
            <a href="index.php" class="brand mb-6">
                <span class="brand__mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="brand__text">
                    <strong>Aurora Library</strong>
                    <span>Create Account</span>
                </span>
            </a>

            <div class="auth__header">
                <h2 class="auth__title">Create your account.</h2>
                <p class="auth__subtitle">It only takes a moment to join our community.</p>
            </div>

            <form action="register.php" method="post" autocomplete="on">
                <div class="field">
                    <label class="field__label" for="name">Full Name</label>
                    <div class="input--with-icon">
                        <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input class="input" type="text" name="name" id="name" placeholder="Jane Doe" required>
                    </div>
                </div>

                <div class="field">
                    <label class="field__label" for="email">Email Address</label>
                    <div class="input--with-icon">
                        <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg>
                        <input class="input" type="email" name="email" id="email" placeholder="you@aurora.library" required>
                    </div>
                </div>

                <div class="field">
                    <label class="field__label" for="password">Create Password</label>
                    <div class="input--with-icon" style="position:relative;">
                        <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input class="input" type="password" name="password" id="password" placeholder="At least 8 characters" required minlength="6">
                        <button type="button" data-toggle-password="#password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--ink-400);padding:4px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <p class="field__hint">Must be at least 6 characters long.</p>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="field">
                        <label class="field__label" for="mobile">Mobile</label>
                        <input class="input" type="tel" name="mobile" id="mobile" placeholder="+1 555 0000" required>
                    </div>
                    <div class="field">
                        <label class="field__label" for="address">City</label>
                        <input class="input" type="text" name="address" id="address" placeholder="New York" required>
                    </div>
                </div>

                <label class="flex gap-2 mb-6" style="font-size:13px;color:var(--ink-600);align-items:flex-start;cursor:pointer;">
                    <input type="checkbox" required style="accent-color:var(--gold-600);margin-top:3px;">
                    <span>I agree to the <a href="#" style="color:var(--gold-700);font-weight:600;">Terms of Service</a> and <a href="#" style="color:var(--gold-700);font-weight:600;">Privacy Policy</a>.</span>
                </label>

                <button type="submit" class="btn btn--primary btn--block btn--lg">
                    <span>Create Account</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="auth__footer">
                Already a member? <a href="index.php">Sign in instead</a>
            </div>
        </div>
    </section>
</div>

<script src="../static/js/aurora.js"></script>
</body>
</html>

