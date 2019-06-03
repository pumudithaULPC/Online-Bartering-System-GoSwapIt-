<?php 

require_once ('authenticate.php');
require_once ('session_control.php');

if(Authenticate::getSessionStatus()==true)
{
    header('Location: dashboard.php');
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
		<title>iDea | Home Shop</title>
		<meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
		<meta name="author" content="htmlcoder.me">

		<?php include ('includes/stylesheets.php') ?>
                
                
                <script type="text/javascript">
                    		
           function authenticateSwapper()
            {   
				
				if(validateForm())
				{ 
					
					var us_username  =   document.getElementById('txtUserName').value;
                                        var us_password  =   document.getElementById('txtPassword').value;

                                        var data         =   { us_username : us_username,us_password : us_password };

					//Send Ajax Request
					$.ajax
					({ 
							type: 'POST',
							url: 'authenticate_control.php',
							data: { action: 'AuthenticateUser', data : data},
							success: function(response) 
							{
								var data	=	JSON.parse(response);
								
								//If Save Success
								if(data.success==true)
								{
									//Show Success Message
									showNotification(data.message,'notice');
                                                                        location.replace('dashboard.php');
                                                                        
								}
								else
								{
									//If not success, show error message
									showNotification(data.message,'error');
								}
								
							}
					});
				}
            }
            
            
            function clearErrorMessages()
			{ 
				document.getElementById('spnUserName').innerHTML 		=	"";
                                document.getElementById('spnPassword').innerHTML 		=	"";
			}
            
            
            function validateForm()
			{ 
                              
				try
				{
                                   
					//Clear error messages before validating
					clearErrorMessages();
					
					if(validateEmpty("txtUserName")==false)
					{  
                                            throw 1012;
					}
                                        if(validateEmpty("txtPassword")==false)
                                        { 
                                            throw 1015;
                                        }  
                                            
                                        return true;
                                    }
                                     catch(err)
				{
					if(err==1012) 
					{
						document.getElementById("spnUserName").innerHTML = "User Name is Required !";	
						ScrollToElement("spnUserName");
					}
                                        
                                        if(err==1015) 
					{
						document.getElementById("spnPassword").innerHTML = "Password is Required !";	
						ScrollToElement("spnPassword");
					}
                                        
                                 return false;
                                        
                                              
				}
                                 
			}
                    
                
                
                </script>
                
               

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

						<!-- main start -->
						<!-- ================ -->
						<div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
							<div class="form-block center-block">
								<h2 class="title">Login</h2>
								<hr>
								<form class="form-horizontal">
									<div class="form-group has-feedback">
										<label for="txtUserName" class="col-sm-3 control-label">User Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="txtUserName" placeholder="User Name" required>
											<i class="fa fa-user form-control-feedback"></i>
                                                                                        <span id="spnUserName" class="label label-danger"></span>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label for="txtPassword" class="col-sm-3 control-label">Password</label>
										<div class="col-sm-8">
											<input type="password" class="form-control" id="txtPassword" placeholder="Password" required>
											<i class="fa fa-lock form-control-feedback"></i>
                                                                                        <span id="spnPassword" class="label label-danger"></span>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-8">
											<div class="checkbox">
												<label>
													<input type="checkbox" required> Remember me.
												</label>
											</div>											
											<button type="button" class="btn btn-default" onclick="authenticateSwapper()">Login</button>
											<ul>
                                                                                            <li><a href="forgot_password.php">Forgot your password?</a></li>
											</ul>
										</div>
									</div>
								</form>
							</div>
							<p class="text-center space-top">Don't have an account yet? <a href="register.php">Sign up</a> now.</p>
						</div>
						<!-- main end -->

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
