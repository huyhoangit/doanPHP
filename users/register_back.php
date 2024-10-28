<?php
session_start();
error_reporting(0);
require_once('../model_test/connect.php');

if (isset($_POST['submit'])) {
    if (isset($_POST['fullname'])) {
        $_fullname = $_POST['fullname'];
    }

    if (isset($_POST['username'])) {
        $_username = $_POST['username'];
    }

    if (isset($_POST['password'])) {
        $_password = $_POST['password'];
    }

    if (isset($_POST['email'])) {
        $_email = $_POST['email'];
    }

    if (isset($_POST['phone'])) {
        $_phone = $_POST['phone'];
    }

    if (isset($_POST['address'])) {
        $_address = $_POST['address'];
    }

    $sql = "INSERT INTO users (fullname, username, password, email, phone, address, role)
    values('$_fullname','$_username',md5('$_password'),'$_email','$_phone','$_address',1)";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "hihi";
        header("location:login.php?rs=success");
        exit();
    } else {
        echo "hehe";
        header("location:login.php?rs=fail");
        exit();
    }
}