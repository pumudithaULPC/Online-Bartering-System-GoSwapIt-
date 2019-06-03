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

	<title>GoSwapIt - Change Password </title>
	
	<?php include ('includes/stylesheets.php') ?>
        
	
</head>
<body>
	<div id="theme-wrapper">
		
				<div id="content-wrapper">
                                      <?php include ('includes/menu.php') ?>
					<section class="main-container">
                                            
                                             <script type="text/javascript">
            

            
			
           function changePassword()
            {   
				
				if(validateForm())
				{ 
					
					
					var us_password  =   document.getElementById('txtPassword').value;
                                        
                                        
					
					var data         =   {us_password : us_password,};

					//Send Ajax Request
					$.ajax
					({ 
							type: 'POST',
							url: 'request_handle.php',
							data: { controller : "swapper", action: 'changePassword', data : data},
							success: function(response) 
							{
								var data	=	JSON.parse(response);
								
								//If Save Success
								if(data.success==true)
								{
									//Show Success Message
									showNotification(data.message,'notice');

									
								
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
            
			
           
            
            



			//Clear validation error messages
			function clearErrorMessages()
			{ 
				
                                document.getElementById('spnPassword').innerHTML 		=	"";
                                document.getElementById('spnConfirmPassword').innerHTML 	=	"";
                                
                                
				
			}
                        
                        
                        
			//Validate Form before submitting
			function validateForm()
			{ 
                              
				try
				{
					//Clear error messages before validating
					clearErrorMessages();
					
					
                                        
                                       
                                            if(validateEmpty("txtPassword")==false)
                                            { 
                                                throw 1015;
                                            }
                                            if(validateEmpty("txtConfirmPassword")==false)
                                            {
                                                throw 1016;
                                            }
                                            
                                             if(document.getElementById('txtPassword').value!=document.getElementById('txtConfirmPassword').value)
                                            {
                                                throw 1020;
                                            }   
                                       
                                        
                                        
					
					return true;
				}
				
				catch(err)
				{
					
                                       
					if(err==1015) 
					{
						document.getElementById("spnPassword").innerHTML = "Password is Required !";	
						ScrollToElement("spnPassword");
					}
                                        if(err==1016) 
					{
						document.getElementById("spnConfirmPassword").innerHTML = "Confirm Password !";	
						ScrollToElement("spnConfirmPassword");
                                                
					}
                                        
					
                                       
                                         if(err==1020) 
					{
						document.getElementById("spnPassword").innerHTML = " Invalid password";	
						ScrollToElement("spnPassword");
					}
                                        
					return false;
                                        
                                              
				}
                                 
			}
                        
                        
                         function LoadPassword2Edit(UserId)
            {
                    var data         =   {us_id : UserId};

                    //send ajax request
                    $.ajax                            
                    ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: { controller : "swapper", action: 'search', data : data},
                            success: function(response) 
                            {
                                var data	=	JSON.parse(response);

                                //Load response to form
                                
                                document.getElementById('txtPassword').value           =	data.result.us_password;
                                
                               
                                
                                //Disable Unedit Fields
                               
                                document.getElementById('txtConfirmPassword').disabled=true;
                                
                                ScrollToElement('txtUserId');

                            }
                     });			
            }


                        
                        
			
			  
	
                        
        
                        
           

        </script>


				<div class="container">
					<div class="row">

						<!-- main start -->
						<!-- ================ -->
						<div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
							<div class="form-block center-block">
								<h2 class="title">Update</h2>
								<hr>
								<form class="form-horizontal" role="form">
									
								  <div class="form-group has-feedback">
										
										<div class="col-sm-8">
                                                                                    <input type="hidden" class="form-control" id="txtUserId" placeholder="User Id" required>
											
                                                                                        
										</div>
									</div>
									
									
                                                                    <div class="form-group has-feedback">
										<label for="txtPassword" class="col-sm-3 control-label">Password <span class="text-danger small">*</span></label>
										<div class="col-sm-8">
											<input type="password" class="form-control" id="txtPassword" placeholder="Password" required>
											<i class="fa fa-lock form-control-feedback"></i>
                                                                                        <span id="spnPassword" class="label label-danger"></span>
										</div>
                                                                                
									</div>
                                                                    
                                                                    
                                                                    <div class="form-group has-feedback">
										<label for="txtConfirmPassword" class="col-sm-3 control-label">Confirm Password <span class="text-danger small">*</span></label>
										<div class="col-sm-8">
											<input type="password" class="form-control" id="txtConfirmPassword" placeholder="ConfirmPassword" required>
											<i class="fa fa-lock form-control-feedback"></i>
                                                                                        <span id="spnConfirmPassword" class="label label-danger"></span>
										</div>
									</div>
                                                                    
                                                                             
                                                                      
                                                                     
									
                                                                    
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-8">
                                                                                    <button type="button" class="btn btn-default" onclick=" changePassword()">update</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- main end -->

					</div>
				</div>
			</section>
			<!-- main-container end -->
					
					<?php include('includes/footer.php') ?>
				</div>
			</div>

	
		
		
	<?php include('includes/scripts.php') ?>
	
</body>
</html>