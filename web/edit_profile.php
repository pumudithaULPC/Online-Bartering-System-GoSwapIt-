<?php
require_once ('authenticate.php');
require_once ('session_control.php');

if (Authenticate::getSessionStatus() == false)
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

        <title>GoSwapIt - Edit Profile</title>

        <?php include ('includes/stylesheets.php') ?>

        <script type="text/javascript">


            function createSwapper()
            {
                
                if (validateForm())
                {
                    var us_email = document.getElementById('txtEmail').value;
                    var us_contact_no = document.getElementById('txtContactNo').value;
                    var us_address = document.getElementById('txtAddress').value;

                    var data = {us_id: <?= $_SESSION['us_id'] ?>,  us_email: us_email, us_contact_no: us_contact_no, us_address: us_address};

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

                                    } else
                                    {
                                        //If not success, show error message
                                        showNotification(data.message, 'error');
                                    }

                                }
                            });
                }
            }



            function LoadSwapper2Edit()
            {
                var data = {us_id:<?= $_SESSION['us_id'] ?>};

                //send ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapper", action: 'search', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

               
                                document.getElementById('txtUserName').value = data.result.us_username;
                                document.getElementById('txtEmail').value = data.result.us_email;
                                document.getElementById('txtContactNo').value = data.result.us_contact_no;
                                document.getElementById('txtAddress').value = data.result.us_address;



                            }
                        });
            }


            function clearErrorMessages()
            {
                document.getElementById('spnEmail').innerHTML = "";
                document.getElementById('spnContactNo').innerHTML = "";
                document.getElementById('spnAddress').innerHTML = "";
            }

            //Validate Form before submitting
            function validateForm()
            {
                
                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();
            
                    
                    if (validateEmpty("txtEmail") == false)
                    {
                        throw 1013;
                    }
                    if (validateEmail("txtEmail") == false)
                    {
                        throw 1014;
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
                } 
                catch (err)
                {
                    
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

                    return false;
                }

            }





        </script>

    </head>
    <body onload="LoadSwapper2Edit();">
        <div id="theme-wrapper">

            <div id="content-wrapper">
                <?php include ('includes/menu.php') ?>
                <section class="main-container">

                    <div class="container">
                        <div class="row">

                            <!-- main start -->
                            <!-- ================ -->
                            <div class="main object-non-visible" data-animation-effect="fadeInDownSmall" data-effect-delay="300">
                                <div class="form-block center-block">
                                    <h2 class="title">Edit Profile</h2>
                                    <hr>
                                    <form class="form-horizontal" role="form">
                                       

                                        <div class="form-group has-feedback">
                                            <label for="txtUserName" class="col-sm-3 control-label">User Name <span class="text-danger small">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="txtUserName" placeholder="User Name" disabled="">
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
                                                <input type="button" class="btn btn-default" onclick="createSwapper()" value="update">
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