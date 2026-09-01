<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "insert into users values('','$_POST[name]','$_POST[email]','$_POST[password]',$_POST[mobile],'$_POST[address]')";
    $query_run = mysqli_query($connection,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora Library — Welcome</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg">
<div class="auth__panel" style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
    <div class="auth__card fade-up text-center" style="max-width:480px;">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--emerald),#0f4d2c);margin:0 auto 24px;display:grid;place-items:center;box-shadow:0 12px 32px rgba(31,111,67,0.28);">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h2 class="auth__title" style="font-size:32px;">Welcome aboard.</h2>
        <p class="auth__subtitle" style="margin-bottom:32px;">Your Aurora Library membership has been created. You may now sign in to access the collection.</p>
        <a href="index.php" class="btn btn--primary btn--block btn--lg">
            <span>Continue to Sign In</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>
</body>
</html>

