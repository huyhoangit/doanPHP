<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fashion MyLiShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logohong.png">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="admin/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'> -->

    <!-- customer js -->
    <script src='js/wow.js'></script>
    <script type="text/javascript" src="js/mylishop.js"></script>
    <!-- customer css -->
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
    <!-- button top -->
    <a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a>

    <?php
    require_once("model_test/connect.php");
    include 'model_test/header.php';
    error_reporting(2);

    $sql = "SELECT * FROM products WHERE id = " . $_GET['id'];
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo $sql;
        die('error');
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['image'] == null || $row['image'] == '') {
                $thum_Image = "";
            } else {
                $thum_Image = $row['image'];
            }
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="detail-product">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <div class="product-frame">
                                        <div class="" style="margin-bottom: 20px; margin-top: 10px;">
                                            <img src="<?php echo $thum_Image; ?>" width="100%" height="450">
                                        </div>
                                    </div>
                                </div>
                                <!-- // hình ảnh -->

                                <div class="col-md-7 col-xs-6 col-xs-12">
                                    <h2><?php echo $row['name']; ?></h2>
                                    <hr>
                                    <?php
                                    if ($row['saleprice'] > 0) {
                                        $gia = $row['price'] - ($row['price'] / 100);
                                        ?>
                                        <p class="price">Giá củ: <?php echo $row['price']; ?><sup>đ</sup></p>
                                        <p class="price">Giá giảm còn: <?php echo $gia; ?><sup>đ</sup></p>
                                        <?php
                                    } else {
                                        ?>
                                        <p class="price">Giá sản phẩm: <?php echo $row['price']; ?><sup>đ</sup></p>
                                        <?php
                                    }
                                    ?>
                                    <hr>
                                    <div class="button-order">
                                        <div class="row">
                                            <!-- <div class ="col-md-6">
                                                <div class="form-group">
                                                    <input type="number" name="soluong" class="form-control" placeholder="Nhập số lượng sản phẩm cần mua" >
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <a href="addcart.php?id=<?php echo $row['id']; ?>">
                                                    <button class="btn btn-warning btn-md"> Đặt mua </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <p style="padding-top: 30px;">
                                        <span class="fa fa-check-circle"></span>&nbsp;&nbsp;&nbsp;GIAO HÀNG TOÀN QUỐC<br>
                                        <span class="fa fa-check-circle"></span> &nbsp;&nbsp;THANH TOÁN KHI NHẬN HÀNG<br>
                                        <span class="fa fa-check-circle"></span>&nbsp;&nbsp; ĐỔI HÀNG TRONG 15 NGÀY
                                    </p>
                                </div><!-- /.col -->
                                <!-- // Thông tin sản phẩm -->
                            </div><!-- /.row -->
                        </div><!-- /.detail-product -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
            <?php
        }
    }
    include 'model_test/footer.php';
    ?>
    <script>
        new WOW().init();
    </script>
</body>

</html>