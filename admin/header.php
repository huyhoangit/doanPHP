<?php
session_start();
if (!isset($_SESSION)) {
    session_start();
}

require_once('../model_test/connect.php');
if (!file_exists('../model_test/connect.php')) {
    exit('File connect.php không tồn tại');
}
//error_reporting(2);

// Đếm số lượt liên hệ về shop
$sqlContacts = "SELECT COUNT(*) AS newContacts FROM contacts WHERE status = 0";
$stmt = mysqli_prepare($conn, $sqlContacts);
mysqli_stmt_execute($stmt);
$resultContacts = mysqli_stmt_get_result($stmt);

if ($resultContacts) {
    $rows = mysqli_stmt_num_rows($stmt);
    if ($rows == 0) {
        $resultContacts = 0;
    } else {
        while ($row = mysqli_stmt_fetch($stmt)) {
            $resultContacts = $row['newContacts'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Đây là trang quản lý mylishop's shop">
    <meta name="author" content="Hôih My">
    <title>Admin-Fashion MyLiShop</title>
    <link rel="icon" type="image/png" href="../images/logohong.png">
    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <style type="text/css" media="screen">
        a {
            color: #B4BCC8;
        }

        .top-message {
            position: absolute;
            top: 5px;
            background-color: #fff;
            border-radius: 100%;
            color: black;
            width: 16px;
            height: 18px;
            left: 10px;
            padding-left: 4px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class=" navbar navbar-default navbar-static-top" role="navigation"
            style="margin-bottom: 0;     background: #2b3643; border-color: #2b3643">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="" style="margin-top: -15px;"><img src="../images/logohong.png" alt=""
                        width="150px;" height="52px;"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li><!-- Danh sách liên hệ -->
                    <a href="contact-new.php" title="Danh sách liên hệ mới"> <i class="fa fa-envelope-o"
                            aria-hidden="true" style="font-size: 20px;"></i>
                        <div class="top-message">
                            <?php echo $resultContacts; ?>
                        </div>
                    </a>
                </li><!-- /.Danh sách liên hệ -->

                <li><!-- Đơn đặt hàng mới -->
                    <a href="neworder.php" title="Đơn đặt hàng mới"> <i class="fa fa-building"
                            style="font-size: 20px;"></i>
                        <div class="top-message">
                            <?php
                            $sql = "SELECT COUNT(*) AS newOrders FROM view_groupby_idorder WHERE status = 0";
                            $resOrder = mysqli_query($conn, $sql);
                            if ($resOrder) {
                                $rows = mysqli_num_rows($resOrder);
                                if ($rows == 0) {
                                    $newOrders = 0;
                                } else {
                                    while ($row = mysqli_fetch_assoc($resOrder)) {
                                        $newOrders = $row['newOrders'];
                                    }
                                }
                                echo $newOrders;
                            }
                            ?>
                        </div>
                    </a>
                </li><!-- /.Đơn đặt hàng mới -->

                <!-- Admin -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i>
                            <?php
                            if (isset($_SESSION['usernameAdmin'])) {
                                echo $_SESSION['usernameAdmin'];
                            }
                            ?>
                        </i>
                        <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../users/logout.php"><i class="fa fa-sign-out fa-lg"></i> Đăng xuất </a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.Admin-->
            </ul>
            <!-- /.navbar-top-links -->

            <div style="margin-top: 2px;"></div>

            <!-- menu left -->
            <div class="navbar-default sidebar" role="navigation" style="background: #364150">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li style="background-color: red;">
                            <a href="" style="color: white;"><i class="fa fa-dashboard fa-fw"></i> Dashboard </a>
                        </li>
                        <li>
                            <a href="category-list.php"><i class="fa fa-bar-chart-o fa-fw"></i> Danh mục sản phẩm </a>
                        </li>
                        <li>
                            <a href=""><i class="fa fa-cube fa-fw"></i> Sản phẩm <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="product-list.php"> Danh sách sản phẩm </a>
                                </li>
                                <li>
                                    <a href="product-add.php"> Thêm sản phẩm </a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Đơn hàng <span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="order-list.php"> Danh sách đơn hàng </a>
                                </li>
                                <li>
                                    <a href="neworder.php"> Đơn đặt hàng mới </a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="user-list.php"><i class="fa fa-users fa-fw"></i> Tài khoản người dùng </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i> Liên hệ <span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="contact-list.php"> Tin nhắn liên hệ </a>
                                </li>
                                <li>
                                    <a href="contact-new.php"> Tin nhắn chưa đọc </a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side /menu left -->
        </nav>
    </div> <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- DataTables JavaScript -->
    <script src="bower_components/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>