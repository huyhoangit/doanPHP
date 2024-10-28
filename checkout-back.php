<!-- <?php
include 'model_test/connect.php';
session_start();

if (!isset($_SESSION['id-user'])) {
    header('Location: users/login.php');
    exit();
}

if (empty($_SESSION['cart']) || empty($_SESSION['checkout_products'])) {
    echo "Giỏ hàng trống!";
    session_write_close();
    exit();
}

$user_id = $_SESSION['id-user'];
$cart = $_SESSION['cart'];
$selected_products = $_SESSION['checkout_products'];
$order_total = 0;
foreach ($selected_products as $product_id) {
    if (isset($cart[$product_id])) {
        $quantity = $cart[$product_id]['quantity'];
        $product_result = $conn->query("SELECT * FROM products WHERE id = $product_id");
        $product_info = $product_result->fetch_assoc();

        if ($product_info) {
            $subtotal = $product_info['price'] * $quantity;
            $order_total += $subtotal;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $address = $conn->real_escape_string(trim($_POST['address']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    if (empty($full_name) || empty($email) || empty($address) || empty($phone)) {
        $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin.";
        header("Location: checkout.php");
        exit();
    }

    $conn->query("INSERT INTO orders (total, date_order, status, user_id) VALUES ($order_total, NOW(), 0, $user_id)");

    $order_id = $conn->insert_id;

    foreach ($selected_products as $product_id) {
        if (isset($cart[$product_id])) {
            $quantity = $cart[$product_id]['quantity'];
            $conn->query("INSERT INTO product_order (product_id, order_id, quantity) VALUES ($product_id, $order_id, $quantity)");
            $conn->query("UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id");
        }
    }

    foreach ($selected_products as $product_id) {
        unset($_SESSION['cart'][$product_id]);
    }

    unset($_SESSION['checkout_products']);

    $_SESSION['message'] = "Thanh toán thành công! Tổng: " . number_format($order_total, 0, ',', '.') . " VND";
    header("Location: index.php");
    exit();
}
?> -->