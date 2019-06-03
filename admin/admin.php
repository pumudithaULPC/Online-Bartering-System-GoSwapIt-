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

	<title>GoSwapIt - Administrator Registration</title>
	
	<?php include ('includes/stylesheets.php') ?>
        
        <script type="text/javascript">
            

            
			
            function createAdmin()
            {
				
				if(validateForm())
				{
					var us_id	 =   document.getElementById('txtUserId').value;
					var us_username      =   document.getElementById('txtUserName').value;
                                        var us_email     =   document.getElementById('txtEmail').value;
					var us_password  =   document.getElementById('txtPassword').value;
                                        var us_contact_no =   document.getElementById('txtContactNo').value;
					var us_status     =   document.getElementById('cmbStatus').value;
                                        var us_nic_no    =   document.getElementById('txtNICNo').value;
                                        
					
					var data         =   {us_id : us_id, us_username : us_username,us_email :us_email, us_password : us_password,us_contact_no:us_contact_no, us_status:us_status,us_nic_no:us_nic_no };

					//Send Ajax Request
					$.ajax
					({
							type: 'POST',
							url: 'request_handle.php',
							data: { controller : "admin", action: 'createAdmin', data : data},
							success: function(response) 
							{
								var data	=	JSON.parse(response);
								
								//If Save Success
								if(data.success==true)
								{
									//Show Success Message
									showNotification(data.message,'notice');

									displayNameList();
									//Clear Form
									clearForm();
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
            
			
            //Disaplay Existing details in a table
            function displayNameList()
            {
		//Send Ajax request
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "admin", action: 'displayNames'},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);
                            
                            //Remove all records first
                            $("#tblAdmin > tbody:last").children().remove();

                            //Display new records from response
                            for(var i = 0; i < data.totalItems; i++)
                            {
                                tr = $('<tr/>');             
                                
                                tr.append("<td>" + data.lists[i].us_username + "</td>"); //User Name
                                tr.append("<td>" + data.lists[i].us_email + "</td>"); //User id
                                tr.append("<td>" + data.lists[i].us_nic_no + "</td>");
                                //Show "Edit" and "Delete" buttons
                                tr.append("<td>" + "<button type='button' class='btn btn-warning' onClick='LoadAdmin2Edit("+data.lists[i].us_id+")'>Edit</button>&nbsp;<button type='button' class='btn btn-danger' onClick='ConfirmDeleteAdmin("+data.lists[i].us_id+")'>Delete</button>" + "</td>");

                                $('#tblAdmin').append(tr);
                            }
                            
                            //Initiate DataTable
                            $('#tblAdmin').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                            });
                        }
                 });
            }
            
            function LoadAdmin2Edit(UserId)
            {
                    var data         =   {us_id : UserId};

                    //send ajax request
                    $.ajax                            
                    ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: { controller : "admin", action: 'search', data : data},
                            success: function(response) 
                            {
                                var data	=	JSON.parse(response);

                                //Load response to form
                                document.getElementById('txtUserId').value 	       =	data.result.us_id;
                                document.getElementById('txtUserName').value           =	data.result.us_username;
                                document.getElementById('txtEmail').value            =	data.result.us_email;
                                document.getElementById('txtPassword').value           =	data.result.us_password;
                                document.getElementById('txtContactNo').value          =        data.result.us_contact_no;
                                document.getElementById('cmbStatus').value             =	data.result.us_status;
                                document.getElementById('txtNICNo').value              =        data.result.us_nic_no;

                               if(data.us_id==null)
                                {
                                        document.getElementById('cmbStatus').selectedIndex	=	0;
                                }
                                else
                                {
                                        selectList('cmbStatus',data.result.us_id);
                                }
                                
                                //Disable Unedit Fields
                                document.getElementById('txtUserName').disabled=true;
                                document.getElementById('txtPassword').disabled=true;
                                document.getElementById('txtConfirmPassword').disabled=true;
                                
                                ScrollToElement('txtUserId');

                            }
                     });			
            }



			//Clear form feilds
			function clearForm()
			{
				document.getElementById('txtUserId').value 			=	"";
				document.getElementById('txtUserName').value 			=	"";
				document.getElementById('txtPassword').value 			=	"";
                                document.getElementById('txtContactNo').value                   =       "";
				document.getElementById('cmbStatus').selectedIndex		=	0;
				document.getElementById('txtNICNo').selectedIndex		=	0;
                                
                                //Enable Unedit Fields
                                document.getElementById('txtUserName').disabled=false;
                                document.getElementById('txtPassword').disabled=false;
                                document.getElementById('txtConfirmPassword').disabled=false;
			}

			//Clear validation error messages
			function clearErrorMessages()
			{
				document.getElementById('spnUserName').innerHTML 		=	"";
                                document.getElementById('spnEmail').innerHTML 			=	"";
                                document.getElementById('spnEmail').innerHTML 			=	"";
                                document.getElementById('spnPassword').innerHTML 		=	"";
                                document.getElementById('spnContactNo').innerHTML 		=	"";
                                document.getElementById('spnContactNo').innerHTML 		=	"";
                                document.getElementById('spnConfirmPassword').innerHTML 	=	"";
                                document.getElementById('spnNICNo').innerHTML 			=	"";
				
			}
                        
                        
                        
			//Validate Form before submitting
			function validateForm()
			{

				try
				{
					//Clear error messages before validating
					clearErrorMessages();
					
					if(validateEmpty("txtUserName")==false)
					{
						throw 1004;
					}
					if(validateEmpty("txtEmail")==false)
                                        {
                                            throw 1005;
                                        }
                                        if(validateEmail("txtEmail")==false)
                                        {
                                            throw 1006;
                                        }
                                        if(document.getElementById('txtUserId').value=="")
                                        {
                                            if(validateEmpty("txtPassword")==false)
                                            {
                                                throw 1007;
                                            }
                                            if(validateEmpty("txtConfirmPassword")==false)
                                            {
                                                throw 1008;
                                            }
                                            
                                            if(document.getElementById('txtPassword').value!=document.getElementById('txtConfirmPassword').value)
                                            {
                                                throw 1012;
                                            }
                                        }
                                        if(validateEmpty("txtContactNo")==false)
                                        {
                                            throw 1009;
                                        }
                                         if(validatePhone("txtContactNo")==false)
                                        {
                                            throw 1010;
                                        }
                                        
                                        if(validateEmpty("txtNICNo")==false)
                                        {
                                            throw 1011;
                                        }
                                        
					
					return true;
				}
				
				catch(err)
				{
					if(err==1004) 
					{
						document.getElementById("spnUserName").innerHTML = "User Name is Required !";	
						ScrollToElement("spnUserName");
					}
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
					if(err==1007) 
					{
						document.getElementById("spnPassword").innerHTML = "Password is Required !";	
						ScrollToElement("spnPassword");
					}
                                        if(err==1008) 
					{
						document.getElementById("spnConfirmPassword").innerHTML = "Confirm Password !";	
						ScrollToElement("spnConfirmPassword");
                                                
					}
                                         if(err==1009) 
					{
						document.getElementById("spnContactNo").innerHTML = "Contact No is Required !";	
						ScrollToElement("spnContactNo");
					}
                                        if(err==1010) 
					{
						document.getElementById("spnContactNo").innerHTML = "This phone number format is not recognized. Please check !";	
						ScrollToElement("spnContactNo");
					}
					
                                        if(err==1011) 
					{
						document.getElementById("spnNICNo").innerHTML = "NIC No is Required !";	
						ScrollToElement("spnNICNo");
					}
                                        
                                         if(err==1012) 
					{
						document.getElementById("spnPassword").innerHTML = " Invalid password";	
						ScrollToElement("spnPassword");
					}
					return false;
                                        
                                              
				}
                                 
			}
                        
                        
                        
                        

			
			function ConfirmDeleteAdmin(id)
			{
				ConfirmAction("Confirm Delete","Are you sure to delete this Admin ?", "Yes", "No", DeleteAdmin,[id]);
			}
                        
                       

			function DeleteAdmin(id)
			{
					var data         =   {us_id : id};

					//Send Ajax Request
					$.ajax
					({
							type: 'POST',
							url: 'request_handle.php',
							data: { controller : "admin", action: 'deleteAdmin', data : data},
							success: function(response) 
							{
								var data	=	JSON.parse(response);
								
								//If Save Success
								if(data.success==true)
								{
									//Show Success Message
									showNotification(data.message,'warning');
									displayNameList();
									
								}
								else
								{
									//If not success, show error message
									showNotification(data.message,'error');
								}
								
							}
                                                        
                                                        
					});
			}
                        
        
                        
           

        </script>
	
</head>
<body onload="displayNameList();">
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
										<header class="main-box-header clearfix">
											<h2>New User</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<form role="form">
												<div class="form-group">
													<label for="txtUserId">User Id</label>
													<input type="text" class="form-control" id="txtUserId" placeholder="" disabled>
												</div>

												<div class="form-group">
													<label for="txtUserName">User Name</label>
													<input type="text" class="form-control" id="txtUserName" placeholder="Enter User name">
													<span id="spnUserName" class="label label-danger"></span>
												</div>
                                                                                            
												<div class="form-group">
													<label for="txtEmail">Email</label>
													<input type="email" class="form-control" pattern="/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"  id="txtEmail" placeholder="Email">
													<span id="spnEmail" class="label label-danger"></span>
												</div>
                                                                                            
												<div class="form-group">
													<label for="txtPassword">Password</label>
													<input type="password" class="form-control" id="txtPassword" placeholder="Password">
													<span id="spnPassword" class="label label-danger"></span>
												</div>
												
                                                                                            <div class="form-group">
													<label for="txtPassword">Confirm Password </label>
													<input type="Password" class="form-control" id="txtConfirmPassword" placeholder="Confirm Password">
													<span id="spnConfirmPassword" class="label label-danger"></span>
												</div>
											
                                                                                            
                                                                                            <div class="form-group">
													<label for="txtContactNo">Contact No</label>
													<input type="text" class="form-control" id="txtContactNo" placeholder="Contact No">
													<span id="spnContactNo" class="label label-danger"></span>
												</div>
												
                                                                                            <div class="form-group">
													<label for="txtNICno">NIC No</label>
													<input type="text" class="form-control" id="txtNICNo" placeholder="NIC No">
													<span id="spnNICNo" class="label label-danger"></span>
												</div>
												
												<div class="form-group">
													<label> User Status</label>
                                                                                                        <select class="form-control" id="cmbStatus">
                                                                                                            <option value="1">Yes</option>
														<option value="0">No</option>
													</select>
												</div>
												
												<div class="form-group">
													<div class="pull-right">
                                                            <button type="button" class="btn btn-success" onclick="createAdmin()">Register</button>
                                                            
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
								
							</div>
							
							<div class="row">
								<div class="col-lg-12">
									<div class="main-box clearfix">
										<header class="main-box-header clearfix">
											<h2 class="pull-left">Administrators Name List</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<div class="table-responsive">
                                                                                            <table class="table table-responsive" id="tblAdmin">
													
                                                                                                        <thead>
														<tr>
                                                                                                                         
															<th class="text-center">Name</th>
															<th class="text-center">Email</th>
															<th class="text-center">NIC No</th>
															<th class="text-center" data-orderable="false"></th>
															
														</tr>
													</thead>
													<tbody>
														
													</tbody>
												</table>
											</div>
											
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