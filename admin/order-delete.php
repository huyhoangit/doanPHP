<?php
require_once("../model_test/connect.php");
session_start();

// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit();
// }

if (isset($_GET['orderId'])) {
    $order_id = intval($_GET['orderId']);
    $check_order = $conn->query("SELECT id FROM orders WHERE id = $order_id");
    if ($check_order && $check_order->num_rows > 0) {
        $conn->query("DELETE FROM product_order WHERE order_id = $order_id");
        $delete_result = $conn->query("DELETE FROM orders WHERE id = $order_id");

        if ($delete_result) {
            header("Location: order-list.php?ps=1");
        } else {
            header("Location: order-list.php?pf=1");
        }
    } else {
        header("Location: order-list.php?pf=1");
    }
} else {
    header("Location: order-list.php");
}
exit();
