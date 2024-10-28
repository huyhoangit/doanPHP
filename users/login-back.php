<?php
session_start();
error_reporting(E_ALL);  // Show all errors for debugging

require_once('../model_test/connect.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Using prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? AND password = MD5(?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);

        // Set session variables for logged-in user
        $_SESSION['username'] = $username;
        $_SESSION['id-user'] = $user['id'];

        // Check user's role
        if ($user['role'] == 1) {
            header("Location: ../index.php?ls=success");
        } else if ($user['role'] == 0) {
            header("Location: ../admin/product-list.php?ls=success");
        }
        exit();
    } else {
        // Set error message if credentials are invalid
        $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không hợp lệ!';
        header("Location: ../user/login.php?error=wrong");
        exit();
    }
} else {
    // You can add some logging here if needed
}
?>