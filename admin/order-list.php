<?php
include 'header.php';
require_once("../model_test/connect.php");
error_reporting(2);
if (isset($_GET['ps'])) {
    echo "<script type=\"text/javascript\">alert(\"Bạn đã xóa sản phẩm thành công!\");</script>";
}
if (isset($_GET['pf'])) {
    echo "<script type=\"text/javascript\">alert(\"Không thể xóa sản phẩm!\");</script>";
}
if (isset($_GET['addps'])) {
    echo "<script type=\"text/javascript\">alert(\"Bạn đã thêm sản phẩm thành công!\");</script>";
}
if (isset($_GET['addpf'])) {
    echo "<script type=\"text/javascript\">alert(\"Thêm sản phẩm thất bại!\");</script>";
}
?>

<!-- page content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="page-header">Danh sách đơn hàng</h1>
            </div><!-- /.col -->

            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>Mã Đơn Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Thông Tin Khách Hàng</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT orders.id AS order_id, orders.total, orders.user_id, 
                                   users.fullname, users.address 
                            FROM orders 
                            JOIN users ON orders.user_id = users.id 
                            ORDER BY orders.id DESC";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr class="odd gradeX" align="center">
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo number_format($row['total'], 0, ',', '.') . ' VND'; ?></td>
                                <td>
                                    <?php echo 'Mã KH: ' . htmlspecialchars($row['user_id']) . '<br>'; ?>
                                    <?php echo 'Họ tên: ' . htmlspecialchars($row['fullname']) . '<br>'; ?>
                                    <?php echo 'Địa chỉ: ' . htmlspecialchars($row['address']); ?>
                                </td>
                                <td class="center">
                                    <a href="order-delete.php?orderId=<?php echo $row['order_id']; ?>">
                                        <i class="fa fa-trash-o fa-lg" title="Xóa"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->