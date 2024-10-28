<?php
include 'model_test/connect.php';
session_start();

if (!isset($_SESSION['id-user'])) {
    header('Location: users/login.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$user_id = $_SESSION['id-user'];
if (empty($cart) || empty($_SESSION['checkout_products'])) {
    echo "Your cart is empty!";
    session_write_close();
    exit();
}

$user_result = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $user_result->fetch_assoc();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['checkout_products'])) {
    $order_total = 0;
    $selected_products = $_SESSION['checkout_products'];

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

    if ($order_total > 0) {
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $address = $conn->real_escape_string($_POST['address']);
        $phone = $conn->real_escape_string($_POST['phone']);

        $sql_order = "INSERT INTO orders (total, date_order, status, user_id) VALUES ($order_total, NOW(), 0, $user_id)";

        if ($conn->query($sql_order) === TRUE) {
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
            $message = "Payment successful! Total: " . number_format($order_total, 0, ',', '.') . " VND";
            session_write_close();
            header("Location: view-cart.php?message=" . urlencode($message));
            exit();
        } else {
            $message = "Error: " . $sql_order . "<br>" . $conn->error;
        }
    }
}

session_write_close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #2e3b4e;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
            font-size: 2em;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 25px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #5b6c88;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d9e6;
            border-radius: 5px;
            font-size: 1em;
            color: #495057;
        }

        .form-group input:focus {
            border-color: #4f86ed;
            outline: none;
            box-shadow: 0 0 5px rgba(79, 134, 237, 0.5);
        }

        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 8px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e6ef;
            font-size: 1em;
        }

        th {
            background-color: #4f86ed;
            color: #ffffff;
            font-weight: 600;
        }

        td {
            background-color: #ffffff;
        }

        tr:hover td {
            background-color: #f0f7ff;
        }

        td strong {
            color: #2e3b4e;
        }

        .button {
            background-color: #4f86ed;
            color: #ffffff;
            padding: 12px 30px;
            font-size: 1.1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background-color: #3e6fcb;
            transform: translateY(-2px);
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2em;
            color: #333;
            margin-top: 30px;
            border-top: 2px solid #e0e6ef;
            padding-top: 20px;
        }

        .total-section p {
            margin: 0;
            padding: 0;
            font-weight: bold;
            color: #2e3b4e;
        }

        .message {
            font-size: 1.1em;
            text-align: center;
            color: #1d793a;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="admin/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <h2 style="text-align: center;">Thông tin mua hàng</h2>
    <!-- <p><strong>Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p> -->

    <form method="POST" class="form-container">
        <div class="form-group">
            <label for="full_name">Họ Tên:</label>
            <input type="text" name="full_name" id="full_name"
                value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                required>
        </div>
        <div class="form-group">
            <label for="address">Địa Chỉ:</label>
            <input type="text" name="address" id="address" required>
        </div>
        <div class="form-group">
            <label for="phone">Số Điện Thoại Nhận Hàng:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['checkout_products'] as $product_id) {
                if (isset($cart[$product_id])) {
                    $quantity = $cart[$product_id]['quantity'];
                    $product_result = $conn->query("SELECT * FROM products WHERE id = $product_id");
                    $product_info = $product_result->fetch_assoc();

                    if ($product_info) {
                        $subtotal = $product_info['price'] * $quantity;
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product_info['name']); ?></td>
                            <td><?php echo intval($quantity); ?></td>
                            <td><?php echo number_format($product_info['price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                        </tr>
                    <?php }
                }
            } ?>
            <tr>
                <td colspan="3"><strong>Tổng Tiền Ban Đầu</strong></td>
                <td><strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
            </tr>
            <tr>
                <td colspan="3"><strong>Tổng Tiền Giảm</strong></td>
                <td><strong>0 VND</strong></td>
            </tr>
            <tr>
                <td colspan="3"><strong>Tổng Tiền Sau Giảm</strong></td>
                <td><strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
            </tr>
        </table>

        <?php if ($message): ?>
            <p><strong><?php echo $message; ?></strong></p>
        <?php endif; ?>

        <div style="text-align: center;">
            <button type="submit" class="button">Thanh Toán</button>
        </div>
    </form>
</body>

</html>