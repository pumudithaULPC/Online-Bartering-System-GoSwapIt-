<?php 

require_once ('authenticate.php');
require_once ('session_control.php');

if(Authenticate::getSessionStatus()==true)
{
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>GoSwapIt - Login</title>
	
	<?php include ('includes/stylesheets.php') ?>
        
        
        <script type="text/javascript">

            function loginAuthenticate()
            {
                //If form validated
                if (validateForm())
                {
                    var username = document.getElementById('txtUsername').value;
                    var password = document.getElementById('txtPassword').value;

                    var data = {username: username, password: password};

                    //Send Ajax Request
                    $.ajax
                    ({
                        type: 'POST',
                        url: 'authenticate_control.php',
                        data: {action: 'AuthenticateUser', data: data},
                        success: function (response)
                        {
                            var data = JSON.parse(response);

                            //If Save Success
                            if (data.success == true)
                            {
                                //Show Success Message
                                showNotification(data.message, 'notice');
                                location.replace("index.php");
                            } 
                            else
                            {
                                //If not success, show error message
                                showNotification(data.message, 'error');
                            }

                        }
                    });
                }
            }
            
            function clearErrorMessages()
            {
                document.getElementById('spnUsername').innerHTML = "";
                document.getElementById('spnPassword').innerHTML = "";
            }
            
            function validateForm()
            {

                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();

                    if (validateEmpty("txtUsername") == false)
                    {
                        throw 1000;
                    }
                    
                    if (validateEmpty("txtPassword") == false)
                    {
                        throw 1001;
                    }

                    return true;
                } 
                catch (err)
                {
                    if (err == 1000) //Empty User Name
                    {
                        document.getElementById("spnUsername").innerHTML = "Username is Required !";
                        ScrollToElement("spnUsername");
                    }
                    
                    if (err == 1001) //Empty Password
                    {
                        document.getElementById("spnPassword").innerHTML = "Password is Required !";
                        ScrollToElement("spnPassword");
                    }

                    return false;
                }
            }
        </script>
</head>
<body id="login-page">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div id="login-box">
					<div id="login-box-holder">
						<div class="row">
							<div class="col-xs-12">
								<header id="login-header">
									<div id="login-logo">
										<img src="assets/img/logo.png" alt=""/>
									</div>
								</header>
								<div id="login-box-inner">
									<form role="form" action="index.html">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                                                        <input class="form-control" type="text" placeholder="Username" id="txtUsername" name="txtUsername">
                                                                                        <span class="label label-danger" id="spnUsername"></span>
										</div>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-key"></i></span>
											<input type="password" class="form-control" placeholder="Password" id="txtPassword" name="txtPassword">
                                                                                        <span class="label label-danger" id="spnPassword"></span>
										</div>
										<div id="remember-me-wrapper">
											<div class="row">
                                                                                            <a href="forgot_password.php" id="login-forget-link" class="col-xs-6">
													Forgot password?
												</a>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12">
                                                                                            <button type="button" class="btn btn-success col-xs-12" onclick="loginAuthenticate()">Login</button>
											</div>
										</div>
										

									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php include('includes/scripts.php') ?>
	
</body>
</html>