<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>GoSwapIt|Multi_Swap_view</title>
        <meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
        <meta name="author" content="htmlcoder.me">

        <?php include ('includes/stylesheets.php') ?>



        <script type="text/javascript">

            //Disaplay Existing brand in a table
            function displaySwapList()
            {
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swap", action: 'displaySwaps'},
                            success: function (response)
                            {

                                var data = JSON.parse(response);

                                var SwapHTML = "";

                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    
                                   SwapHTML = SwapHTML + "<div class='col-md-3 col-sm-6 masonry-grid-item'>"+
                                        "<div class='listing-item'>"+
                                            "<div class='overlay-container'>"+
                                                "<img src='images/product-1.png' alt=''>"+
                                                "<a href='SingleSwapView.php' class='overlay small'>"+
                                                    "<i class='fa fa-plus'></i>"+
                                                    "<span>View Details</span>"+
                                                "</a>"+
                                            "</div>"+
                                            "<div class='listing-item-body clearfix'>"+
                                                "<h3 class='title'><a href='shop-product.html'>"+data.lists[i].sp_name+"</a></h3>"+
                                                "<p>Posted By: "+data.lists[i].sp_us_id.us_username+"</p>"+
                                                "<p>Posted Date: "+data.lists[i].sp_posted_date+"</p>"+
                                                "<p>Expire Date: "+data.lists[i].sp_expire_date+"</p>"+
                                                //"<span class='price'>$199.00</span>"+
                                                "<div class='elements-list pull-right'>"+
                                                    "<a href='#' class='wishlist' title='wishlist'><i class='fa fa-heart-o'></i></a>"+
                                                    "<a href='swapview.php?id="+data.lists[i].sp_id+"'>View Swap</a>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>";

                                  }

                                document.getElementById('divSwaps').innerHTML = SwapHTML;

                            }
                        });
            }




        </script>

    </head>

    <!-- body classes: 
                    "boxed": boxed layout mode e.g. <body class="boxed">
                    "pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> 
    -->
    <body class="front no-trans" onload="displaySwapList();">
        <!-- scrollToTop -->
        <!-- ================ -->
        <div class="scrollToTop"><i class="icon-up-open-big"></i></div>

        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">

            <?php include ('includes/menu.php') ?>



            <!-- main-container start -->
            <!-- ================ -->
            <section class="main-container">

                <div class="container">
                    <div class="row">

                        <!-- main start -->
                        <!-- ================ -->
                        <div class="main col-md-12">

                            <!-- page-title start -->
                            <!-- ================ -->
                            <h1 class="page-title">Swap List View</h1>
                            <div class="separator-2"></div>
                            <p class="lead">swap list items  <br class="hidden-sm hidden-xs"> </p>
                            <!-- page-title end -->

                            <!-- shop items start -->
                            <div class="masonry-grid-fitrows row grid-space-20" id="divSwaps">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- shop items end -->

                <div class="clearfix"></div>

                <!-- pagination start -->
                <ul class="pagination">
                    <li><a href="#">«</a></li>
                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">»</a></li>
                </ul>
                <!-- pagination end -->

        </div>
        <!-- main end -->

    </div>
</div>
</section>					
<?php include ('includes/footer.php') ?>

</div>
<!-- page-wrapper end -->

<?php include ('includes/scripts.php') ?>

</body>
</html>





