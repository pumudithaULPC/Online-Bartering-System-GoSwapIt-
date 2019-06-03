<?php 

require_once ('authenticate.php');
require_once ('session_control.php');

if(Authenticate::getSessionStatus()==false)
{
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Dashboard</title>
		<meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
		<meta name="author" content="htmlcoder.me">

		<?php include ('includes/stylesheets.php') ?>
                
              

	</head>

	<!-- body classes: 
			"boxed": boxed layout mode e.g. <body class="boxed">
			"pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> 
	-->
	<body class="front no-trans">
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
					
				
               <div class="row" style="margin-right: 40px; margin-left:60px;">       
                    <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        
                        <div class="image-box" style="width: 250px;background-color:#4db8ff;">
                           
                          
                      <!-- small box -->
                         
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="edit_profile.php" style="color: #FFFFFF;">Edit Profile</a>
                                    <a href="edit_profile.php"><i class="fa fa-user  fa-2x pull-right" style="color:#FFFFFF;"></i></a>
                                </h3>

                                   <p style="color:#FFFFFF;padding: 5px 5px 5px 5px;">Manage Profile </p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                
                            
                        
                    </div> 
                 </div>
                   
                 <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#009933;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="change_password.php" style="color: #FFFFFF;">Change Password</a>
                                    <a href="change_password.php"><i class="fa fa-unlock fa-2x pull-right" style="color:#FFFFFF;;"></i></a>
                                </h3>

                                   <p style="color:#FFFFFF;padding: 5px 5px 5px 5px;">Change Login Password</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                           
                        </div>
                    </div> 
                 </div>  
                 
                    <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#ffa31a;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="swap.php" style="color: #FFFFFF;">Post Ad</a>
                                    <a href="swap.php"><i class="fa fa-newspaper-o fa-2x  pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding: 5px 5px 5px 5px;">Post Advertisement</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div>   
                   
                   
                   
                   
                   
                   <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#e60000;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="myoffers.php" style="color: #FFFFFF;">View Offers</a>
                                    <a href="myoffers.php"><i class="fa fa-list-ul fa-2x  pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding: 5px 5px 5px 5px;">View Offers</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div> 
              </div>      
                <div class="row" style="margin-right: 40px; margin-top: 20px; margin-left:60px;">      
                  <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#b300b3;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="helpTicket.php" style="color: #FFFFFF;">Help Desk</a>
                                    <a href="helpTicket.php"><i class="fa fa-eye fa-2x pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding: 5px 5px 5px 5px;">Send Message to Admin</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div>  
                   
                   <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color: #ff5500;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="viewHelpTicket.php" style="color: #FFFFFF;">View Help Desk</a>
                                    <a href="viewHelpTicket.php"><i class="fa fa-navicon fa-2x  pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding:5px 5px 5px 5px;">View All Messages </p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div> 
                   
                   <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#b3b300;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="viewInquiry.php" style="color: #FFFFFF;">Send Message</a>
                                    <a href="viewInquiry.php"><i class="fa fa-comments-o fa-2x  pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding: 5px 5px 5px 5px;">Contact Swappers</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div> 
                    
                 <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#e63900;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="viewInquiry.php" style="color: #FFFFFF;">View Messages</a>
                                    <a href="viewInquiry.php"><i class="fa fa-comments-o fa-2x  pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding: 5px 5px 5px 5px;">View all Messages</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div>    
                </div>  
               <div class="row" style="margin-right: 40px; margin-top: 20px; margin-left:60px;">     
                 <div class="col-lg-3 col-md-4 col-xs-12 col-sm-6">
                        <div class="image-box" style="width: 250px;background-color:#cc0066;">
                      <!-- small box -->
                         <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 style="padding: 10px 10px 10px 10px;">
                                    <a href="index.php" style="color: #FFFFFF;">View items</a>
                                    <a href="index.php"><i class="fa fa-cart-plus fa-2x  pull-right" style="color:#FFFFFF;"> </i></a>
                                </h3>

                                   <p style="color:#FFFFFF; padding: 5px 5px 5px 5px;">View Your Items From the List</p>
                            </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                             
                        </div>
                    </div> 
                 </div>  
                </div>   
            </div>                        
        </div>         
			</section>
			<!-- main-container end -->
                        
                        

			<?php include ('includes/footer.php') ?>

		</div>
		<!-- page-wrapper end -->

		<?php include ('includes/scripts.php') ?>

	</body>
</html>
