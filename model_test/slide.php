<?php
require_once('model_test/connect.php');
error_reporting(2);
?>
<content>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 wow zoomIn">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php
                        require_once('connect.php');
                        $sql = "SELECT image FROM slides WHERE status=1";
                        $result = mysqli_query($conn, $sql);

                        if ($result == true) {
                            $i = 0;
                            while ($kq = mysqli_fetch_assoc($result)) {
                                $i++;
                                ?>
                                <div class="item" id="<?php if (isset($i))
                                    echo "a" . $i ?>">
                                        <img src="<?php echo $kq['image']; ?>" alt="Slideshow" style="width:100%; height: 100%;">
                                </div>
                            <?php }
                        } ?>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <!-- <span class="fa fa-chevron-left"></span> -->
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <!-- <span class="fa fa-chevron-right"></span> -->
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><!-- /col -->
        </div><!-- /row -->

        <script type="text/javascript">
            var e = document.getElementById('a1');
            e.classList.add("active");
        </script>

    </div><!-- /container -->
</content>