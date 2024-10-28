<?php
session_start();
require_once("model_test/connect.php");
error_reporting(0);

$_GET['id'];
$id = $_GET['id'];

$query = "SELECT *from products where id = $id";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $products = mysqli_fetch_array($result);
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

if (isset($_SESSION["cart"][$id])) {
    $_SESSION["cart"][$id]['quantity'] += 1;
} else {
    $_SESSION["cart"][$id] = array(
        'id' => $products['id'],
        'name' => $products['name'],
        'category_id' => $products['category_id'],
        'image' => $products['image'],
        'description' => $products['description'],
        'price' => $products['price'],
        'saleprice' => $products['saleprice'],
        'created' => $products['created'],
        'quantity' => 1,
    );
}

header("Location: index.php");
exit;