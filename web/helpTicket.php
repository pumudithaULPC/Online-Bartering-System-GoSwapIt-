<?php 

require_once ('authenticate.php');//us and pw macth da keyala balanawa
require_once ('session_control.php');//

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
		<title>goswapit | Home Shop</title>
		<meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
		<meta name="author" content="htmlcoder.me">

		<?php include ('includes/stylesheets.php') ?>
                
                <script type="text/javascript">
            

            
			
            function saveHelpTicket()
            {   
				
                if(validateForm())
                { 


                       var ht_title      =   document.getElementById('txtTitle').value;
                        var ht_message     =   document.getElementById('txtMessage').value;
                        
                        



                        var data         =   {ht_title :ht_title, ht_message : ht_message, us_id: <?=$_SESSION['us_id']?>};

                        //Send Ajax Request
                        $.ajax
                        ({
                                        type: 'POST',
                                        url: 'request_handle.php',
                                        data: { controller : "helpTicket", action: 'saveHelpTicket', data : data},
                                        success: function(response) 
                                        {
                                                var data	=	JSON.parse(response);

                                                //If Save Success
                                                if(data.success==true)
                                                {
                                                        //Show Success Message
                                                        showNotification(data.message,'notice');

                                                        //displayNameList();
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
            
			
           
            function clearForm()
			{
				document.getElementById('txtTitle').value 			=	"";
				document.getElementById('txtMessage').value 			=	"";
				
                                //Enable Unedit Fields
                                document.getElementById('txtTitle').disabled=false;
                                document.getElementById('txtMessage').disabled=false;
                                
			}
            



			//Clear validation error messages
			function clearErrorMessages()
			{ 
				document.getElementById('spnTitle').innerHTML 		=	"";
                                document.getElementById('spnMessage').innerHTML 	=	"";
				
			}
                        
                        
                        
			//Validate Form before submitting
			function validateForm()
			{ 
                              
				try
				{
					//Clear error messages before validating
					clearErrorMessages();
					
					if(validateEmpty("txtTitle")==false)
					{ 
						throw 1012;
					}
					if(validateEmpty("txtMessage")==false)
                                        {
                                            throw 1013;
                                        }
                                        
					return true;
				}
				
				catch(err)
				{
					if(err==1012) 
					{
						document.getElementById("spnTitle").innerHTML = "Title is Required !";	
						ScrollToElement("spnTitle");
					}
					if(err==1013) 
					{
						document.getElementById("spnMessage").innerHTML = "Message is Required !";	
						ScrollToElement("spnMessage");
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
								<h2 class="title">Help Desk</h2>
								<hr>
								<form class="form-horizontal" role="form">
									
									
									<div class="form-group">
                                                        <label for="txtTitle">Title</label>
                                                        <input type="text"  class="form-control" id="txtTitle" placeholder="Enter title..."/>
                                                        <span id="spnTitle" class="label label-danger"></span>
                                                    </div>
									<div class="form-group">
                                                        <label for="txtMessage">Message</label>
                                                        <textarea  cols="20" rows="5" id="txtMessage" class="form-control"></textarea>
                                                        <span id="spnMessage" class="label label-danger"></span>
                                                    </div>
									
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-8">
                                                                                    <button type="button" class="btn btn-default" onclick="saveHelpTicket()">Save</button>
                                                                                    <button type="button" class="btn btn-warning" onclick="clearForm()" align="right">Clear</button>
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

			<?php include ('includes/footer.php') ?>

		</div>
		<!-- page-wrapper end -->

		<?php include ('includes/scripts.php') ?>

	</body>
</html>
