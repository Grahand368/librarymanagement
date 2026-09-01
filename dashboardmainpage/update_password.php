<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/index.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $password = "";
    $query = "select * from users where email = '$_SESSION[email]'";
    $query_run = mysqli_query($connection,$query);
    while ($row = mysqli_fetch_assoc($query_run)){
        $password = $row['password'];
    }
    $success = false;
    if($password == $_POST['old_password']){
        $query = "update users set password = '$_POST[new_password]' where email = '$_SESSION[email]'";
        $query_run = mysqli_query($connection,$query);
        $success = true;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $success ? 'Password Updated' : 'Update Failed'; ?> · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg" onload="Aurora.toast('<?php echo $success ? 'Password updated successfully' : 'Wrong current password'; ?>','<?php echo $success ? 'success' : 'error'; ?>'); setTimeout(()=>{window.location.href='<?php echo $success ? 'user-dashboard.php' : 'change_password.php'; ?>';}, 1400);">
<div class="auth__panel" style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
    <div class="auth__card fade-up text-center" style="max-width:460px;">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,<?php echo $success ? 'var(--emerald),#0f4d2c' : 'var(--crimson),#7f1d1d'; ?>);margin:0 auto 24px;display:grid;place-items:center;box-shadow:0 12px 32px rgba(0,0,0,0.18);">
            <?php if($success): ?>
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
            <?php else: ?>
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            <?php endif; ?>
        </div>
        <h2 class="auth__title" style="font-size:32px;"><?php echo $success ? 'Password updated.' : 'Incorrect password.'; ?></h2>
        <p class="auth__subtitle"><?php echo $success ? 'Your password has been changed successfully.' : 'The current password you entered is incorrect. Please try again.'; ?></p>
        <p class="text-sm text-muted mt-4">Redirecting…</p>
    </div>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

