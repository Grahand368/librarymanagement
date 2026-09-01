<?php
    session_start();
    $error = '';
    if(isset($_POST['login'])){
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,"lms");
        $query = "select * from users where email = '$_POST[email]'";
        $query_run = mysqli_query($connection,$query);
        $found = false;
        while ($row = mysqli_fetch_assoc($query_run)) {
            $found = true;
            if($row['email'] == $_POST['email']){
                if($row['password'] == $_POST['password']){
                    $_SESSION['name'] =  $row['name'];
                    $_SESSION['email'] =  $row['email'];
                    $_SESSION['id'] =  $row['id'];
                    header("Location: ../dashboardmainpage/user-dashboard.php");
                    exit;
                } else {
                    $error = 'Incorrect password. Please try again.';
                }
            }
        }
        if(!$found){
            $error = 'No account found with that email.';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora Library — Sign In</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">

<div class="auth">
    <!-- Left: Art panel -->
    <aside class="auth__art">
        <div class="auth__art-inner fade-in">
            <span class="eyebrow auth__art-eyebrow">Aurora Library · Est. 2026</span>
            <h1>Where <em>knowledge</em><br>meets elegance.</h1>
            <p>A curated sanctuary for readers, scholars, and dreamers. Sign in to explore thousands of titles, manage your collection, and continue your literary journey.</p>

            <div class="auth__art-quote">
                <p>"A library is a hospital for the mind."</p>
                <span>— Anonymous</span>
            </div>
        </div>

        <div class="auth__art-ticker">
            <span><span class="dot"></span> Open 9:00 AM — 9:00 PM</span>
            <span><span class="dot"></span> 12,000+ Volumes</span>
            <span><span class="dot"></span> AC Reading Halls</span>
        </div>
    </aside>

    <!-- Right: Form panel -->
    <section class="auth__panel">
        <div class="auth__card fade-up">
            <a href="index.php" class="brand mb-6">
                <span class="brand__mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="brand__text">
                    <strong>Aurora Library</strong>
                    <span>Member Portal</span>
                </span>
            </a>

            <div class="auth__tabs">
                <a href="index.php" class="auth__tab is-active">Member</a>
                <a href="admin_login.php" class="auth__tab">Administrator</a>
            </div>

            <div class="auth__header">
                <h2 class="auth__title">Welcome back.</h2>
                <p class="auth__subtitle">Sign in to your account to continue.</p>
            </div>

            <?php if($error): ?>
                <div data-toast="error" class="text-sm" style="color:var(--crimson);text-align:center;margin-bottom:16px;font-weight:500;padding:10px;background:rgba(155,28,28,0.08);border-radius:10px;">✕ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="" method="post" autocomplete="on">
                <div class="field">
                    <label class="field__label" for="email">Email Address</label>
                    <div class="input--with-icon">
                        <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg>
                        <input class="input" type="email" name="email" id="email" placeholder="you@aurora.library" required>
                    </div>
                </div>

                <div class="field">
                    <label class="field__label" for="password">Password</label>
                    <div class="input--with-icon" style="position:relative;">
                        <svg class="input__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input class="input" type="password" name="password" id="password" placeholder="Enter your password" required>
                        <button type="button" data-toggle-password="#password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--ink-400);padding:4px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex-between mb-6" style="font-size:13px;">
                    <label class="flex gap-2" style="color:var(--ink-600);align-items:center;cursor:pointer;">
                        <input type="checkbox" style="accent-color:var(--gold-600);"> Remember me
                    </label>
                    <a href="#" style="color:var(--gold-700);font-weight:600;">Forgot password?</a>
                </div>

                <button type="submit" name="login" class="btn btn--primary btn--block btn--lg">
                    <span>Sign in</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </button>
            </form>

            <div class="auth__footer">
                New to Aurora? <a href="signup.php">Create an account</a>
            </div>
        </div>
    </section>
</div>

<script src="../static/js/aurora.js"></script>
</body>
</html>

