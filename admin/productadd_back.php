<meta charset="utf-8">
<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once('../model_test/connect.php');
error_reporting(2);

$target_file = "../" . basename($_FILES["FileImage"]["name"]);
$uploadOk = 1;

if (isset($_POST['addProduct'])) {
    $keywordPr = '';
    $descriptPr = '';
    $status = 0;

    $image = basename($_FILES["FileImage"]["name"]);
    if ($image == null || $image = '') {
        $image = $_POST['image'];
        $uploadOk = 0;
    } else {
        $check = getimagesize($_FILES["FileImage"]["tmp_name"]);
        if ($check !== false) {
            $image = basename($_FILES["FileImage"]["name"]);
            $uploadOk = 1;
        } else {
            $image = '';
            ?>
            <script type="text/javascript">
                window.location = 'product-add.php?notimage=notimage';
            </script>
            <?php
            $uploadOk = 0;
        }
    }


    //Upload image
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
    } else {
        if (move_uploaded_file($_FILES["FileImage"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["FileImage"]["name"]) . " has been uploaded.";
        } else {
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

    // truy vấn
    $sql = "INSERT INTO products(name, category_id, image, description, price, saleprice, created, quantity,  keyword, status) 
                VALUES('$namePr', '$categoryPr', '$image', '$descriptPr', '$pricePr', '$salePricePr', now(), '$quantityPr', '$keywordPr', '$status');";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("location:product-list.php?addps=success");
        exit();
    } else {
        header("location:product-list.php?addpf=fail");
        exit();
    }
}
?>