<?php
    session_start();
    if(empty($_SESSION['email'])){
        header("Location: ../login_module/admin_login.php");
        exit;
    }
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $success = false;
    $bookName = '';

    if($id > 0){
        // Get the issued book details
        $check = mysqli_query($connection, "SELECT book_no, book_name, status FROM issued_books WHERE id = $id");
        if(mysqli_num_rows($check) > 0){
            $row = mysqli_fetch_assoc($check);
            if($row['status'] == 0){
                $msg = "Book already returned";
            } else {
                $bookName = $row['book_name'];
                $bookNo = intval($row['book_no']);
                $today = date('Y-m-d');
                // Mark as returned
                $upd = mysqli_query($connection, "UPDATE issued_books SET status = 0, book_return_date = '$today' WHERE id = $id");
                if($upd){
                    // Increment inventory
                    mysqli_query($connection, "UPDATE books SET book_qty = book_qty + 1 WHERE book_no = $bookNo");
                    $success = true;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Returned · Aurora Library</title>
    <link rel="stylesheet" href="../static/css/aurora.css">
</head>
<body class="app-bg" onload="Aurora.toast('<?php echo $success ? "Book returned — inventory updated" : "Could not return book"; ?>','<?php echo $success ? 'success' : 'error'; ?>'); setTimeout(()=>{window.location.href='../Issue_book_Module/issue_book.php';}, 1400);">
<div class="auth__panel" style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
    <div class="auth__card fade-up text-center" style="max-width:460px;">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,<?php echo $success ? 'var(--emerald),#0f4d2c' : 'var(--crimson),#7f1d1d'; ?>);margin:0 auto 24px;display:grid;place-items:center;box-shadow:0 12px 32px rgba(0,0,0,0.18);">
            <?php if($success): ?>
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 14 4 9 20 9 15 14"/><line x1="4" y1="20" x2="20" y2="20"/></svg>
            <?php else: ?>
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            <?php endif; ?>
        </div>
        <h2 class="auth__title" style="font-size:32px;"><?php echo $success ? 'Book returned.' : 'Return failed.'; ?></h2>
        <p class="auth__subtitle"><?php echo $success ? htmlspecialchars($bookName) . ' is back on the shelf.' : 'Please try again or contact support.'; ?></p>
        <p class="text-sm text-muted mt-4">Redirecting…</p>
    </div>
</div>
<script src="../static/js/aurora.js"></script>
</body>
</html>

