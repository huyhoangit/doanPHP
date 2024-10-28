<div class="container">
    <div class="banner wow bounceInLeft">
        <div class="row">
            <?php
                require_once("connect.php");
                $sql = "SELECT image FROM slides WHERE status=3";
                $result = mysqli_query($conn,$sql);
                
                while ($kq = mysqli_fetch_assoc($result)) {
                    
            ?>                        
                    <div class="col-md-2 col-sm-4">
                        <div class="thumbnail">
                            <div class="banner">
                                <img src= "<?php echo $kq['image']; ?>" alt="Generic placeholder thumbnail" width="100%" height="100">
                            </div>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
</div>