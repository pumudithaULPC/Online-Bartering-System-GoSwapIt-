<?php
require_once ('authenticate.php');

require_once ('session_control.php');

if (Authenticate::getSessionStatus() == false)
{
    header('Location: login.php');
}
?>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>iDea | Home Shop</title>
        <meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
        <meta name="author" content="htmlcoder.me">
        <?php include ('includes/stylesheets.php') ?>
        <script type="text/javascript">
            // Disaplay Existing categories in a table
            function clearErrorMessages()
            {
                document.getElementById('spnText').innerHTML = "";
            }

            function clearForm()
            {
                document.getElementById('txtText').value = "";
            }

            function validateReply()
            {

                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();

                    if (validateEmpty("txtText") == false)
                    {
                        throw 1001;
                    }

                    return true;
                } catch (err)
                {
                    if (err == 1001) //Empty Message
                    {
                        document.getElementById("spnText").innerHTML = "Reply is Required !";
                        ScrollToElement("spnText");
                    }

                    return false;
                }
            }
            function MyInquiryList()//display existing inquiries
            {
                var us_id = <?= $_SESSION['us_id'] ?>;
                
                var data = {us_id : us_id};
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapInquiry", action: 'searchReceivedInquiries', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblInquiries > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    
                                    tr.append("<td>" + data.lists[i].sp_id.sp_name + "</td>");
                                    tr.append("<td>" + data.lists[i].spi_title + "</td>");
                                    tr.append("<td>" + data.lists[i].spi_message + "</td>");
                                    tr.append("<td>" + data.lists[i].spi_datetime + "</td>");

                                    if (data.lists[i].spi_status == 0)
                                    {
                                        tr.append("<td><span class='label label-warning'>Opened</span></td>");
                                    } 
                                    else if (data.lists[i].spi_status == 1)
                                    {
                                        tr.append("<td><span class='label label-success'>Answered</span></td>");
                                    } 
                                    else if (data.lists[i].spi_status == 2)
                                    {
                                        tr.append("<td><span class='label label-danger'>Closed</span></td>");
                                    }

                                    //Show "Edit" and "Delete" buttons
                                    tr.append("<td>" + "<button type='button' class='btn btn-info' onClick='ViewInquiry(" + data.lists[i].spi_id + ")'>view</button>");
                                    $('#tblInquiries').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblInquiries').dataTable({
                                    'info': false,
                                    'pageLength': 14,
                                    retrieve: true
                                });

                            }
                        });
            }



            function viewInquiryReplies(id)
            {
                var data = {spi_id: id};

                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "inquiryReply", action: 'searchAll', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblInquiryReplies > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].spir_datetime + "</td>");
                                    tr.append("<td>" + data.lists[i].us_id.us_username + "</td>");
                                    tr.append("<td>" + data.lists[i].spir_text + "</td>");
                                    $('#tblInquiryReplies').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblInquiryReplies').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                                });

                            }
                        });
            }

            function ViewInquiry(id)
            {
                var data = {spi_id: id};
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapInquiry", action: 'search', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                $('#mdlViewInq').modal('show');

                                document.getElementById('txtInqId').value = data.spi_id;
                                document.getElementById('spnTitle').innerHTML = data.spi_title;
                                document.getElementById('spnDateTime').innerHTML = data.spi_datetime;
                                document.getElementById('spnMessage').innerHTML = data.spi_message;

                                if (data.spi_status == 0)
                                {
                                    document.getElementById('spnStatus').innerHTML = "<span class='label label-warning'>Opened</span>";
                                } else if (data.spi_status == 1)
                                {
                                    document.getElementById('spnStatus').innerHTML = "<span class='label label-success'>Answered</span>";
                                } else if (data.spi_status == 2)
                                {
                                    document.getElementById('spnStatus').innerHTML = "<span class='label label-danger'>Closed</span>";
                                }

                                if (data.spi_status != 2)
                                {
                                    $('#divReply').fadeIn();
                                    $('#btnCloseInquiry').fadeIn();
                                } else
                                {
                                    $('#divReply').fadeOut();
                                    $('#btnCloseInquiry').fadeOut();
                                }

                                viewInquiryReplies(id);

                            }
                        });
            }
            function reply()
            {
                var spi_id = document.getElementById('txtInqId').value;
                var us_id = <?= $_SESSION['us_id'] ?>;
                var spir_text = document.getElementById('txtText').value;

                if (validateReply())
                {

                    var data = {spi_id: spi_id, us_id: us_id, spir_text: spir_text};

                    //Send Ajax Request
                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "inquiryReply", action: 'save', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    if (data.success == true)
                                    {
                                        showNotification(data.message, 'notice');
                                        viewInquiryReplies(spi_id);
                                        clearForm();
                                    } else
                                    {
                                        showNotification(data.message, 'error');
                                    }
                                }
                            });
                }
            }
            
            function closeInquiry()
            {
                var spi_id = document.getElementById('txtInqId').value;

                var data = {spi_id: spi_id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapInquiry", action: 'close', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                if (data.success == true)
                                {
                                    showNotification(data.message, 'notice');
                                    $('#mdlViewInq').modal('hide');
                                    MyInquiryList();
                                } else
                                {
                                    showNotification(data.message, 'error');
                                }
                            }
                        });
            }


        </script>      
    </head>
    <body  onload="MyInquiryList();">
        <div class="scrollToTop"><i class="icon-up-open-big"></i></div>
        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">
            <?php include ('includes/menu.php') ?>
            <!-- main-container start -->
            <!-- ================ -->
            <div class="container">
                <div class="row">
                    <div class="main col-md-18">

                        <h1 class="page-title margin-top-clear">Received Inquiry List</h1>
                        <!--</header>-->


                        <div class="main-box-body clearfix">

                            <div class="table-responsive">
                                <div class="space"></div>
                                <table class="table table-responsive" id="tblInquiries">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Swap</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Message</th>
                                            <th class="text-center">Datetime</th>
                                            <th class="text-center">Status</th>

                                            <th class="text-center" data-orderable="false">Action</th>

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
</div>
<!-- main end -->





<div class="modal fade" id="mdlViewInq" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">View Inquiries</h4>
            </div>

            <div class="modal-body">

                <div class="main-box-body clearfix">
                    <form role="form">

                        <input type="hidden" id="txtInqId"/>

                        <div class="form-group row">
                            <label class="col-md-3">Date Opened : </label>
                            <label class="col-md-9"><span id="spnDateTime" style="font-weight: bold;"></span></label>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3">Title : </label>
                            <label class="col-md-9"><span id="spnTitle" style="font-weight: bold;"></span></label>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3">Message : </label>
                            <label class="col-md-9"><span id="spnMessage" style="font-weight: bold;"></span></label>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3">Status : </label>
                            <label class="col-md-9"><span id="spnStatus" style="font-weight: bold;"></span></label>
                        </div>
                        <div id="divReply" style="display: none">
                            <div class="form-group">
                                <label for="txtText">Enter Reply</label>
                                <textarea  cols="10" id="txtText" class="form-control"></textarea>
                                <span id="spnText" class="label label-danger"></span>
                            </div>

                            <div class="form-group">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-success" onclick="reply()">Reply</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="pull-left">Inquiry Replies</h2>
                    </header>

                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table table-responsive" id="tblInquiryReplies">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Message</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </div>
            <div class="modal-footer">            	
                <button class="btn btn-danger" id="btnCloseInquiry" type="button" onclick="closeInquiry()" style="display: none;">Close Inquiry</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!--main-container end--> 

<?php include ('includes/footer.php') ?>

<!-- page-wrapper end -->

<?php include ('includes/scripts.php') ?>

</body>
</html>




