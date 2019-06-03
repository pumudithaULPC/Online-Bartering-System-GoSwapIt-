<?php 

require_once ('authenticate.php');
require_once ('session_control.php');

if(Authenticate::getSessionStatus()==false)
{
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>GoSwapIt - Dashboard</title>
	
	<?php include ('includes/stylesheets.php') ?>
	
</head>
<body>
	<div id="theme-wrapper">
		<?php include('includes/topheader.php') ?>
		<div id="page-wrapper" class="container">
			<div class="row">
				<?php include('includes/sidebar.php') ?>
				<div id="content-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12">
									<ol class="breadcrumb">
										<li><a href="#">Home</a></li>
										<li class="active"><span>Dashboard</span></li>
									</ol>
									
									<h1>Dashboard</h1>
								</div>
                                                            
                                                            
                                                            <div class="row">
								<div class="col-lg-3 col-sm-6 col-xs-12">
                                                                    <div class="main-box infographic-box" style="background-color:#4db8ff;">
										<i class="fa fa-cog  pull-right"></i>
										<span class="headline"></span>
										<span class="value">
                                                                                    <a href="category.php" style="color: #FFFFFF; font-size:65%;">
											<span class="timer">
												Category Setup
											</span>
                                                                                        
                                                                                        </a>    
										</span>
                                                                                 <p style="color:#FFFFFF;padding: 10px 5px 10px 5px;">Add New Category </p>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box" style="background-color:#009933;">
										<i class="fa  fa-cog pull-right "></i>
										<span class="headline"></span>
										<span class="value">
                                                                                    <a href="brand.php" style="color: #FFFFFF;font-size:65%;">
											<span class="timer">
											     Brand Setup
											</span>
                                                                                        </a>    
										</span>
                                                                                 <p style="color:#FFFFFF;padding: 10px 5px 10px 5px;">Add New Brand </p>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box" style="background-color:#ffa31a;">
										<i class="fa fa-cog pull-right "></i>
										<span class="headline"></span>
										<span class="value">
                                                                                       <a href="brand.php" style="color: #FFFFFF;font-size:65%;">
											<span class="timer">
												Models Setup
											</span>
                                                                                        </a>   
										</span>
                                                                                 <p style="color:#FFFFFF;padding: 10px 5px 10px 5px;">Add New Models </p>
									</div>
								</div>
								<div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box" style="background-color:#e60000;">
										<i class="fa fa-cog pull-right "></i>
										<span class="headline"></span>
										<span class="value">
                                                                                    <a href="categoryAttributes.php" style="color: #FFFFFF;font-size:65%;"> 
											<span class="timer" >
												 Attributes
											</span>
                                                                                        </a>   
										</span>
                                                                                 <p style="color:#FFFFFF;padding: 10px 5px 10px 5px;"> category attributes</p>
									</div>
								</div>
                                                                
                                                                <div class="col-lg-3 col-sm-6 col-xs-12">
									<div class="main-box infographic-box" style="background-color:#b300b3;">
										<i class="fa fa-comments-o pull-right"></i>
										<span class="headline"></span>
										<span class="value">
                                                                                    <a href="viewHelpTicket.php" style="color: #FFFFFF;font-size:65%;"> 
											<span class="timer">
											Help Ticket
											</span>
                                                                                        </a>   
										</span>
                                                                                 <p style="color:#FFFFFF;padding: 10px 5px 10px 5px;">Reply to swapper  </p>
									</div>
								</div>
							</div>
							</div>
							
						</div>
					</div>
					
				<?php include('includes/footer.php') ?>	
				</div>
			</div>
		</div>
	</div>
		
		
	<?php include('includes/scripts.php') ?>
	
</body>
</html>