<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../model_test/connect.php';
error_reporting(2);

$target_file = "../" . basename($_FILES["FileImage"]["name"]);
$uploadOk = 1;

if (isset($_GET['idProduct'])) {
    $idProduct = $_GET['idProduct'];
}

if (isset($_POST['editProduct'])) {
    $keywordPr = '';
    $descriptPr = '';
    $status = 0;
    if (empty($_FILES["FileImage"]["name"])) {
        $image = $_POST['currentImage'];
    } else {
        $image = basename($_FILES["FileImage"]["name"]);
        $check = getimagesize($_FILES["FileImage"]["tmp_name"]);
        if ($check === false) {
            header("location:product-edit.php?idProduct=$idProduct&notimage=notimage");
            exit();
        }
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Image đã tồn tại!";
        } else {
            if (move_uploaded_file($_FILES["FileImage"]["tmp_name"], $target_file)) {
            } else {
                echo "Có lỗi xảy ra khi tải lên hình ảnh.";
            }
        }
    }

    if (isset($_POST['txtName'])) {
        $namePr = $_POST['txtName'];
    }

    if (isset($_POST['category'])) {
        $categoryPr = $_POST['category'];
    }

    if (isset($_POST['txtPrice'])) {
        $pricePr = $_POST['txtPrice'];
    }

    if (isset($_POST['txtSalePrice'])) {
        $salePricePr = $_POST['txtSalePrice'];
    } else {
        $salePricePr = 0;
    }

    if (isset($_POST['txtNumber'])) {
        $quantityPr = $_POST['txtNumber'];
    }

    if (isset($_POST['txtKeyword'])) {
        $keywordPr = $_POST['txtKeyword'];
    }

    if (isset($_POST['txtDescript'])) {
        $descriptPr = $_POST['txtDescript'];
    }

    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    }
    $sql = "UPDATE products SET name = '$namePr', category_id = $categoryPr, image ='$image', description = '$descriptPr', price = '$pricePr', saleprice = '$salePricePr', quantity = '$quantityPr', keyword = '$keywordPr', status = '$status' WHERE id = $idProduct";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        ?>
        <script type="text/javascript">
            window.location.href = 'product-edit.php?idProduct=<?php echo $idProduct; ?>&es=success';
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            window.location.href = 'product-edit.php?idProduct=<?php echo $idProduct; ?>&ef=fail';
        </script>
        <?php
    }
}
?>