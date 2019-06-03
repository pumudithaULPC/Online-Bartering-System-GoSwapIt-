<?php
require_once ('authenticate.php');
require_once ('session_control.php');

if (Authenticate::getSessionStatus() == true)
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
            function ResetPassword()
            {

                if (validateForm())
                {
                    var us_username = document.getElementById('txtUsername').value;

                    var data = {us_username: us_username};

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "swapper", action: 'resetpw', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    //If Save Success
                                    if (data.success == true)
                                    {
                                        //Show Success Message
                                        showNotification(data.message, 'notice');

                                    } else
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
            }


            function validateForm()
            {

                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();


                    if (validateEmpty("txtUsername") == false)
                    {
                        throw 1013;
                    }
                    
                    return true;
                } 
                catch (err)
                {

                    if (err == 1013)
                    {
                        document.getElementById("spnUsername").innerHTML = "Username Required !";
                        ScrollToElement("spnUsername");
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


            </section>
            <!-- main-container end -->


            <section class="main-container">

                <div class="container">
                    <div class="row">

                        <!-- main start -->
                        <!-- ================ -->
                        <div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
                            <div class="form-block center-block">
                                <h2 class="title">Forgot Password?</h2>
                                <hr>
                                <form class="form-horizontal" role="form">

                                    <div class="form-group has-feedback">
                                        <label for="txtUsername" class="col-sm-3 control-label">Username <span class="text-danger small">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txtUsername" placeholder="Enter Username" required>
                                            <i class="fa fa-envelope form-control-feedback"></i>
                                            <span id="spnUsername" class="label label-danger"></span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-8">
                                            <button type="button" class="btn btn-default" onclick="ResetPassword()">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
