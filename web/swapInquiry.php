<?php
require_once ('authenticate.php');
require_once ('session_control.php');

if (Authenticate::getSessionStatus() == false)
{
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>iDea | Home Shop</title>
        <meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
        <meta name="author" content="htmlcoder.me">

        <?php include ('includes/stylesheets.php') ?>

        <script type="text/javascript">

            function saveSwapInquiry()
            {

                if (validateForm())
                {

                    var sp_id     = <?=$_GET['id']?>;
                    var spi_us_id   =   <?=$_SESSION['us_id']?>;
                    var spi_title = document.getElementById('txtTitle').value;
                    var spi_message = document.getElementById('txtMessage').value;

                    var data = {spi_title: spi_title, spi_message: spi_message, sp_id: sp_id, spi_us_id:spi_us_id};

                    //Send Ajax Request
                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "swapInquiry", action: 'saveSwapInquiry', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    //If Save Success
                                    if (data.success == true)
                                    {
                                        //Show Success Message
                                        showNotification(data.message, 'notice');
                                        clearForm();
                                        location.replace('viewSentInquiry.php');
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
            
            function swapSearch()
            {

                var sp_id     = <?=$_GET['id']?>;


                var data = {sp_id: sp_id};

                //Send Ajax Request
                $.ajax
                    ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: {controller: "swap", action: 'search', data: data},
                        success: function (response)
                        {
                            var data = JSON.parse(response);

                            document.getElementById('txtSwapName').value = data.sp_name;

                        }
                    });
                
            }



            function clearForm()
            {
                document.getElementById('txtTitle').value = "";
                document.getElementById('txtMessage').value = "";
            }

            //Clear validation error messages
            function clearErrorMessages()
            {
                document.getElementById('spnTitle').innerHTML = "";
                document.getElementById('spnMessage').innerHTML = "";

            }



            //Validate Form before submitting
            function validateForm()
            {

                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();

                    if (validateEmpty("txtTitle") == false)
                    {
                        throw 1012;
                    }
                    if (validateEmpty("txtMessage") == false)
                    {
                        throw 1013;
                    }

                    return true;

                } catch (err)
                {
                    if (err == 1012)
                    {
                        document.getElementById("spnTitle").innerHTML = "Title is Required !";
                        ScrollToElement("spnTitle");
                    }
                    if (err == 1013)
                    {
                        document.getElementById("spnMessage").innerHTML = "Message is Required !";
                        ScrollToElement("spnMessage");
                    }

                    return false;


                }

            }

        </script>

    </head>


    <body onload="swapSearch()">

        <div class="scrollToTop"><i class="icon-up-open-big"></i></div>

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
                                <h2 class="title">Swap Inquiry</h2>
                                <hr>
                                <form class="form-horizontal" role="form">

                                    <div class="form-group">
                                        <label>Swap  Name</label>
                                        <input type="text"  class="form-control" id="txtSwapName" readonly=""/>
                                    </div>
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
                                            <button type="button" class="btn btn-default" onclick="saveSwapInquiry()">Save</button>
                                            <button type="button" class="btn btn-warning" onclick="clearForm()" align="right">Clear</button>
                                        </div>
                                    </div>
                                </form>


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

