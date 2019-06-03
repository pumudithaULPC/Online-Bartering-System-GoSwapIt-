<?php
session_start();
?>
<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>GoSwapIt ! Beyond the Trend.</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                                
                                var imgurl = "http://api.goswapit.store/upload/images/";

                                var SwapHTML = "";

                                for (var i = 0; i < data.totalItems; i++)
                                {
                                   if((i%4)==0)
                                   {
                                       SwapHTML = SwapHTML + "<div class='row'>";
                                   }
                                   
                                   SwapHTML = SwapHTML + "<div class='col-md-3 col-sm-6 masonry-grid-item'>"+
                                        "<div class='listing-item'>"+
                                            "<div class='overlay-container'>"+
                                                "<img src='"+imgurl+data.lists[i].sp_default_img+"' alt=''>"+
                                                "<a href='swapview.php?id="+data.lists[i].sp_id+"' class='overlay small'>"+
                                                    "<i class='fa fa-plus'></i>"+
                                                    "<span>View Details</span>"+
                                                "</a>"+
                                            "</div>"+
                                            "<div class='listing-item-body clearfix'>"+
                                                "<h3 class='title'><a href='swapview.php?id="+data.lists[i].sp_id+"'>"+data.lists[i].sp_name+"</a></h3>"+
                                                "Posted By: "+data.lists[i].sp_us_id.us_username+"<br/>"+
                                                "Posted Date: "+data.lists[i].sp_posted_date+"<br/>"+
                                                "Expire Date: "+data.lists[i].sp_expire_date+"<br/>"+
                                                "<div class='elements-list pull-right'>"+
                                                    "<a href='swapview.php?id="+data.lists[i].sp_id+"'>View Swap</a>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>";
                            
                                   if((i%4)==3)
                                   {
                                       SwapHTML = SwapHTML + "</div>";
                                   }

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
    <body class="front no-trans" onload="displaySwapList()">
        <!-- scrollToTop -->
        <!-- ================ -->
        <div class="scrollToTop"><i class="icon-up-open-big"></i></div>

        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">

<?php include ('includes/menu.php') ?>

            <!-- banner start -->
            <!-- ================ -->
            <div class="banner shop-banner">

                <!-- slideshow start -->
                <!-- ================ -->
                <div class="slideshow white-bg">

                    <!-- slider revolution start -->
                    <!-- ================ -->
                    <div class="slider-banner-container">
                        <div class="slider-banner">
                            <ul>
                                <!-- slide 1 start -->
								<li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on" data-title="Slide 1">
								
								<!-- main image -->
								<img src="images/img1.jpg"  alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

								<!-- Translucent background -->
								<div class="tp-caption light-translucent-bg"
									data-x="center"
									data-y="bottom"
									data-speed="800"
									data-start="0"
									style="background-color:rgba(255,255,255,0.4);">
								</div>

								<!-- LAYER NR. 1 -->
								<div class="tp-caption very_large_text hidden-sm black sfl tp-resizeme"
									data-x="center"
									data-y="150" 
									data-speed="200"
									data-start="0"
									data-end="10000"
									data-endspeed="200"
									data-splitin="chars"
									data-elementdelay="0.07"
									data-endelementdelay="0.1"
									data-splitout="chars">Go! Swap Your Items
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption tp-resizeme hidden-sm sfb"
									data-x="center"
									data-y="230" 
									data-speed="700"
									data-start="600"
									data-end="10000"
									data-endspeed="600"><a href="register.php" class="btn btn-dark">Create Account <i class="fa fa-angle-right pl-10"></i></a>
								</div>

								</li>
								<!-- slide 1 end -->

								<!-- slide 2 start -->
								<li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on" data-title="Slide 2">
								
								<!-- main image -->
								<img src="images/img2.jpg"  alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

								<!-- Translucent background -->
								<div class="tp-caption light-translucent-bg"
									data-x="center"
									data-y="bottom"
									data-speed="800"
									data-start="0"
									style="background-color:rgba(255,255,255,0.4);">
								</div>

								<!-- LAYER NR. 1 -->
								<div class="tp-caption very_large_text hidden-sm sft black tp-resizeme"
									data-x="center"
									data-y="150" 
									data-speed="700"
									data-start="200"
									data-end="10000"
									data-endspeed="600">Post Your Items
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption tp-resizeme hidden-sm sfb"
									data-x="center"
									data-y="230" 
									data-speed="700"
									data-start="600"
									data-end="10000"
									data-endspeed="600"><a href="swap.php" class="btn btn-dark">Post Swap <i class="fa fa-angle-right pl-10"></i></a>
								</div>

								</li>
								<!-- slide 2 end -->
                                                                
                                                                
                                                                <!-- slide 3 start -->
								<li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on" data-title="Slide 3">
								
								<!-- main image -->
								<img src="images/img3.jpg"  alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

								<!-- Translucent background -->
								<div class="tp-caption light-translucent-bg"
									data-x="center"
									data-y="bottom"
									data-speed="800"
									data-start="0"
									style="background-color:rgba(255,255,255,0.4);">
								</div>

								<!-- LAYER NR. 1 -->
								<div class="tp-caption very_large_text hidden-sm sft black tp-resizeme"
									data-x="center"
									data-y="150" 
									data-speed="700"
									data-start="200"
									data-end="10000"
									data-endspeed="600">Inquire about the Items
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption tp-resizeme hidden-sm sfb"
									data-x="center"
									data-y="230" 
									data-speed="700"
									data-start="600"
									data-end="10000"
									data-endspeed="600"><a href="swapInquiries.php" class="btn btn-dark">Messaging <i class="fa fa-angle-right pl-10"></i></a>
								</div>

								</li>
								<!-- slide 3 end -->
                                                                
                                                                <!-- slide 4 start -->
								<li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-saveperformance="on" data-title="Slide 4">
								
								<!-- main image -->
								<img src="images/img4.jpg"  alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

								<!-- Translucent background -->
								<div class="tp-caption light-translucent-bg"
									data-x="center"
									data-y="bottom"
									data-speed="800" 
									data-start="0"
									style="background-color:rgba(255,255,255,0.4);">
								</div>

								<!-- LAYER NR. 1 -->
								<div class="tp-caption very_large_text hidden-sm sft black tp-resizeme"
									data-x="center"
									data-y="150" 
									data-speed="700"
									data-start="200"
									data-end="10000"
									data-endspeed="600">For More Details
								</div>

								<!-- LAYER NR. 2 -->
								<div class="tp-caption tp-resizeme hidden-sm sfb"
									data-x="center"
									data-y="230" 
									data-speed="700"
									data-start="600"
									data-end="10000"
									data-endspeed="600"><a href="helpTicket.php" class="btn btn-dark">Contact Admin <i class="fa fa-angle-right pl-10"></i></a>
								</div>

								</li>
								<!-- slide 4 end -->

                            </ul>
                        </div>
                    </div>
                    <!-- slider revolution end -->

                </div>


            </div>
            <!-- banner end -->

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
                            <h1 class="page-title">Latest Swaps</h1>
                            <div class="separator-2"></div>
                            <p class="lead">View the latest swaps here and start your exchange as you wish!</p>
                            <!-- page-title end -->

                            <!-- shop items start -->
                            <div class="masonry-grid-fitrows row grid-space-20" id="divSwaps">
                                
                            </div>
                            <!-- shop items end -->

                            <div class="clearfix"></div>

                            <!-- pagination start 
                            <ul class="pagination">
                                <li><a href="#">«</a></li>
                                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                             pagination end -->

                        </div>
                        <!-- main end -->

                    </div>
                </div>
            </section>
            <!-- main-container end -->

            <!-- section start -->
            <!-- ================ -->
            <div class="section gray-bg clearfix">
                <div class="container">
                    <div class="call-to-action">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="title text-center">Waste no more time</h1>
                                <p class="text-center">Post Your Swap and Start Exchange. </p>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <a href="swap.php" class="btn btn-default btn-lg">Post</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- section end -->



<?php include ('includes/footer.php') ?>

        </div>
        <!-- page-wrapper end -->

<?php include ('includes/scripts.php') ?>

    </body>
</html>
