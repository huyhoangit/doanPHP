<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../model_test/connect.php';
error_reporting(2);

// Xóa sản phẩm theo id
if (isset($_GET['idProducts'])) {
        $idProduct = $_GET['idProducts'];
        $sql = "DELETE FROM products WHERE id = " . $idProduct;
        $result = mysqli_query($conn, $sql);
        if ($result) {
                ?>
                <script type="text/javascript">
                        window.location = 'product-list.php?ps=success';
                </script>
                <?php

        } else {
                ?>
                <script type="text/javascript">
                        window.location = 'product-list.php?pf=fail';
                </script>
                <?php
        }
}
?>