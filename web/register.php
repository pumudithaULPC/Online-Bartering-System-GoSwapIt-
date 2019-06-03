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




            function createSwapper()
            {

                if (validateForm())
                {

                    var us_username = document.getElementById('txtUserName').value;
                    var us_email = document.getElementById('txtEmail').value;
                    var us_password = document.getElementById('txtPassword').value;
                    var us_contact_no = document.getElementById('txtContactNo').value;
                    var us_address = document.getElementById('txtAddress').value;



                    var data = {us_username: us_username, us_email: us_email, us_password: us_password, us_contact_no: us_contact_no, us_address: us_address};

                    //Send Ajax Request
                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "swapper", action: 'createSwapper', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    //If Save Success
                                    if (data.success == true)
                                    {
                                        //Show Success Message
                                        showNotification(data.message, 'notice');

                                        location.replace("login.php");

                                    } else
                                    {
                                        //If not success, show error message
                                        showNotification(data.message, 'error');
                                    }

                                }
                            });
                }
            }








            //Clear validation error messages
            function clearErrorMessages()
            {
                document.getElementById('spnUserName').innerHTML = "";
                document.getElementById('spnEmail').innerHTML = "";
                document.getElementById('spnEmail').innerHTML = "";
                document.getElementById('spnPassword').innerHTML = "";
                document.getElementById('spnContactNo').innerHTML = "";
                document.getElementById('spnContactNo').innerHTML = "";
                document.getElementById('spnConfirmPassword').innerHTML = "";
                document.getElementById('spnAddress').innerHTML = "";

            }



            //Validate Form before submitting
            function validateForm()
            {

                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();

                    if (validateEmpty("txtUserName") == false)
                    {
                        throw 1012;
                    }
                    if (validateEmpty("txtEmail") == false)
                    {
                        throw 1013;
                    }
                    if (validateEmail("txtEmail") == false)
                    {
                        throw 1014;
                    }

                    if (validateEmpty("txtPassword") == false)
                    {
                        throw 1015;
                    }
                    if (validateEmpty("txtConfirmPassword") == false)
                    {
                        throw 1016;
                    }

                    if (document.getElementById('txtPassword').value != document.getElementById('txtConfirmPassword').value)
                    {
                        throw 1020;
                    }

                    if (validateEmpty("txtContactNo") == false)
                    {
                        throw 1017;
                    }
                    if (validatePhone("txtContactNo") == false)
                    {
                        throw 1018;
                    }

                    if (validateEmpty("txtAddress") == false)
                    {
                        throw 1019;
                    }


                    return true;
                } catch (err)
                {
                    if (err == 1012)
                    {
                        document.getElementById("spnUserName").innerHTML = "User Name is Required !";
                        ScrollToElement("spnUserName");
                    }
                    if (err == 1013)
                    {
                        document.getElementById("spnEmail").innerHTML = "Email Required !";
                        ScrollToElement("spnEmail");
                    }
                    if (err == 1014)
                    {
                        document.getElementById("spnEmail").innerHTML = "Enter your full email address, including the '@'.";
                        ScrollToElement("spnEmail");
                    }
                    if (err == 1015)
                    {
                        document.getElementById("spnPassword").innerHTML = "Password is Required !";
                        ScrollToElement("spnPassword");
                    }
                    if (err == 1016)
                    {
                        document.getElementById("spnConfirmPassword").innerHTML = "Confirm Password !";
                        ScrollToElement("spnConfirmPassword");

                    }
                    if (err == 1017)
                    {
                        document.getElementById("spnContactNo").innerHTML = "Contact No is Required !";
                        ScrollToElement("spnContactNo");
                    }
                    if (err == 1018)
                    {
                        document.getElementById("spnContactNo").innerHTML = "This phone number format is not recognized. Please check !";
                        ScrollToElement("spnContactNo");
                    }

                    if (err == 1019)
                    {
                        document.getElementById("spnAddress").innerHTML = "Address is Required !";
                        ScrollToElement("spnAddress");
                    }
                    if (err == 1020)
                    {
                        document.getElementById("spnPassword").innerHTML = " Invalid password";
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
                                <h2 class="title">Sign Up</h2>
                                <hr>
                                <form class="form-horizontal" role="form">


                                    <div class="form-group has-feedback">
                                        <label for="txtUserName" class="col-sm-3 control-label">User Name <span class="text-danger small">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txtUserName" placeholder="User Name" required>
                                            <i class="fa fa-user form-control-feedback"></i>
                                            <span id="spnUserName" class="label label-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="txtEmail" class="col-sm-3 control-label">Email <span class="text-danger small">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" id="txtEmail" placeholder="Email" required>
                                            <i class="fa fa-envelope form-control-feedback"></i>
                                            <span id="spnEmail" class="label label-danger"></span>
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


                                    <div class="form-group has-feedback">
                                        <label for="txtContactNo" class="col-sm-3 control-label">Contact No<span class="text-danger small">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txtContactNo" placeholder="ContactNo" required>
                                            <i class="fa fa-phone form-control-feedback"></i>
                                            <span id="spnContactNo" class="label label-danger"></span>
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="txtAddress" class="col-sm-3 control-label">Address <span class="text-danger small">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txtAddress" placeholder="Address" required>
                                            <i class="fa fa-user form-control-feedback"></i>
                                            <span id="spnAddress" class="label label-danger"></span>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-8">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" required> Accept our <a href="#">privacy policy</a> and <a href="#">customer agreement</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-8">
                                            <button type="button" class="btn btn-default" onclick="createSwapper()">Sign Up</button>

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
