<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "delete from category where cat_id = $_GET[cid]";
    $query_run = mysqli_query($connection,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleted · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg" onload="Aurora.toast('Category deleted successfully','success'); setTimeout(()=>{window.location.href='manage_cat.php';}, 1000);">
<div class="auth__panel" style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
    <div class="auth__card fade-up text-center" style="max-width:420px;">
        <p class="text-muted">Redirecting…</p>
    </div>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

