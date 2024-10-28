<div class="container">
    <div class="banner wow lightSpeedIn">
        <div class="row">
            <?php
            require_once("connect.php");
            $sql = "SELECT image FROM slides WHERE status=2";
            $result = mysqli_query($conn, $sql);

            while ($kq = mysqli_fetch_assoc($result)) {

                ?>
                <div class="col-md-3 col-sm-4">
                    <div class="thumbnail">
                        <div class="banner">
                            <img src="<?php echo $kq['image']; ?>" alt="Generic placeholder thumbnail" width="100%"
                                height="160">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>