<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "update admins set name = '$_POST[name]',email = '$_POST[email]',mobile = '$_POST[mobile]'";
    $query_run = mysqli_query($connection,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updated · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg" onload="Aurora.toast('Profile updated successfully','success'); setTimeout(()=>{window.location.href='admin_dashboard.php';}, 1200);">
<div class="auth__panel" style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
    <div class="auth__card fade-up text-center" style="max-width:460px;">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--gold-500),var(--gold-700));margin:0 auto 24px;display:grid;place-items:center;box-shadow:0 12px 32px rgba(184,134,11,0.32);">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h2 class="auth__title" style="font-size:32px;">Profile updated.</h2>
        <p class="auth__subtitle" style="margin-bottom:8px;">Your changes have been saved successfully.</p>
        <p class="text-sm text-muted">Redirecting to dashboard…</p>
    </div>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

