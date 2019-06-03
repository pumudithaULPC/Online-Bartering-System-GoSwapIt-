<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>GoSwapIt</title>
	
	<?php include ('includes/stylesheets.php') ?>
        
        <script type="text/javascript">
            

            
			
//            function createAdmin()
//            {
//				
//				if(validateForm())
//				{
//					var us_id	 =   document.getElementById('txtUserId').value;
//					var us_username      =   document.getElementById('txtUserName').value;
//                                        var us_email     =   document.getElementById('txtEmail').value;
//					var us_password  =   document.getElementById('txtPassword').value;
//                                        var us_contact_no =   document.getElementById('txtContactNo').value;
//					var us_status     =   document.getElementById('cmbStatus').value;
//                                        var us_nic_no    =   document.getElementById('txtNICNo').value;
//                                        
//					
//					var data         =   {us_id : us_id, us_username : us_username,us_email :us_email, us_password : us_password,us_contact_no:us_contact_no, us_status:us_status,us_nic_no:us_nic_no };
//
//					//Send Ajax Request
//					$.ajax
//					({
//							type: 'POST',
//							url: 'request_handle.php',
//							data: { controller : "admin", action: 'createAdmin', data : data},
//							success: function(response) 
//							{
//								var data	=	JSON.parse(response);
//								
//								//If Save Success
//								if(data.success==true)
//								{
//									//Show Success Message
//									showNotification(data.message,'notice');
//
//									displayNameList();
//									//Clear Form
//									clearForm();
//								}
//								else
//								{
//									//If not success, show error message
//									showNotification(data.message,'error');
//								}
//								
//							}
//					});
//				}
//            }
            
			
            //Disaplay Existing details in a table
           
           

			

			//Clear validation error messages
			function clearErrorMessages()
			{
				
                                document.getElementById('spnEmail').innerHTML 			=	"";
                                document.getElementById('spnEmail').innerHTML 			=	"";
                                
				
			}
                        
                        
                        
			//Validate Form before submitting
			function validateForm()
			{

				try
				{
					//Clear error messages before validating
					clearErrorMessages();
					
					if(validateEmpty("txtEmail")==false)
                                        {
                                            throw 1005;
                                        }
                                        if(validateEmail("txtEmail")==false)
                                        {
                                            throw 1006;
                                        }
                                        
					
					return true;
				}
				
				catch(err)
				{
					if(err==1005) 
					{
						document.getElementById("spnEmail").innerHTML = "Email Required !";	
						ScrollToElement("spnEmail");
					}
                                        if(err==1006) 
					{
						document.getElementById("spnEmail").innerHTML = "Enter your full email address, including the '@'.";	
						ScrollToElement("spnEmail");
					}
					
					return false;
                                        
                                              
				}
                                 
			}
                        
                  </script>       
      
        
                        
           

       
	
</head>
<body onload="">
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
										<li class="active"><span>System Administrator Accounts</span></li>
									</ol>
									
									<h1>System Administrator Accounts</h1>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="main-box">
										
										
										<div class="main-box-body clearfix">
											<form role="form">
												

												
                                                                                            
												<div class="form-group">
													<label for="txtEmail">Email</label>
													<input type="email" class="form-control" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"  id="txtEmail" placeholder="Email">
													<span id="spnEmail" class="label label-danger"></span>
												</div>
                                                                                            
												
					
												
												<div class="form-group">
													<div class="pull-right">
                                                            <button type="button" class="btn btn-success" onclick="createAdmin()">Send</button>
                                                            
													</div>
												</div>
											</form>
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
