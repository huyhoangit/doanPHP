<?php
error_reporting(0);
session_start();
include("model_test/connect.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            if (is_numeric($quantity) && $quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = intval($quantity);
            } else {
                $_SESSION['cart'][$product_id]['quantity'] = 1;
            }
        }
    }
    if (isset($_POST['checkout'])) {
        $_SESSION['checkout_products'] = array_filter($_POST['selected_products']);
        header('Location: checkout.php');
    }
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f5;
            color: #4a4a4a;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            background-color: #fff;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border: 0.5px black solid;
            border-bottom: 1px solid #e5e5e5;
        }

        th {
            background-color: #3944bc;
            color: #fff;
            text-align: center;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        tr td img {
            height: auto;
            width: 70px;
            margin: 0 auto;
            display: block;
            border-radius: 5px;
        }

        .button,
        .update_cart,
        #checkoutButton,
        .button-disabled {
            padding: 12px 20px;
            font-size: 0.9em;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s;
        }

        .button:not(:disabled):hover,
        .update_cart:not(:disabled):hover,
        #checkoutButton:not(:disabled):hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .button:disabled,
        #checkoutButton:disabled {
            background-color: #cccccc;
            color: #666666;
            cursor: not-allowed;
        }

        .total-container {
            font-size: 1.2em;
            font-weight: bold;
            color: #3944bc;
            text-align: right;
            margin-top: 20px;
        }

        .checkout-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 15px;
        }

        .update_cart {
            background-color: #f39c12;
            height: 45px;
            cursor: pointer;
            text-align: center;
        }
    </style>

</head>

<body>
    <h2>Giỏ hàng của bạn</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form method="POST" action="view-cart.php">
            <table>
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                        </th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $product):
                        $product_total = $product['price'] * $product['quantity'];
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_products[]"
                                    value="<?php echo htmlspecialchars($product_id); ?>" class="product-checkbox"
                                    onclick="toggleCheckoutButton()">
                            </td>
                            <td><img src="<?php echo htmlspecialchars($product['image']); ?>" width="50" height="50"></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo number_format($product['price']); ?> VND</td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product_id; ?>]"
                                    value="<?php echo $product['quantity']; ?>" min="1" onchange="updateTotal()" />
                            </td>
                            <td class="product-total"><?php echo number_format($product_total); ?> VND</td>
                        </tr>
                        <?php
                        $total += $product_total;
                    endforeach; ?>
                </tbody>
            </table>

            <div class="buttons">
                <div>
                    <input class="update_cart" type="submit" value="Cập nhật giỏ hàng" />
                    <h3 style="display:inline">Tổng tiền: <span id="totalAmount"><?php echo number_format($total); ?></span>
                        VND</h3>
                </div>
                <div>
                    <button type="submit" name="checkout" class="button" id="checkoutButton" disabled>Tiến hành mua
                        hàng</button>
                    <a href="index.php" class="button">Tiếp tục mua hàng</a>
                </div>
            </div>
        </form>
    <?php else: ?>
        <p>Giỏ hàng trống!</p>
    <?php endif; ?>

    <script>
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            toggleCheckoutButton();
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            const checkboxes = document.querySelectorAll('.product-checkbox');

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    const price = parseFloat(row.cells[3].innerText.replace(/ VND/, '').replace(/,/g, ''));
                    const quantity = parseInt(row.cells[4].querySelector('input').value);
                    total += price * quantity;
                }
            });

            document.getElementById('totalAmount').innerText = total.toLocaleString();
            updateSelectAllCheckbox();
        }

        function toggleCheckoutButton() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const checkoutButton = document.getElementById('checkoutButton');

            const isAnySelected = Array.from(checkboxes).some(checkbox => checkbox.checked);
            checkoutButton.disabled = !isAnySelected;
        }

        function updateSelectAllCheckbox() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            selectAllCheckbox.checked = allChecked;
        }
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                updateTotal();
                toggleCheckoutButton();
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            toggleCheckoutButton();
            updateTotal();
        });
    </script>

</body>

</html>