<?php
require_once ('authenticate.php');
require_once ('session_control.php');

if (Authenticate::getSessionStatus() == false)
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
        <title>iDea | Home Shop</title>
        <meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
        <meta name="author" content="htmlcoder.me">

<?php include ('includes/stylesheets.php') ?>
        <script type="text/javascript">

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




            //Disaplay Existing categories in a table
            function TicketList()
            {

                var data = {us_id: <?= $_SESSION['us_id'] ?>};

                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "helpTicket", action: 'displayTickets', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblTickets > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].ht_title + "</td>");
                                    tr.append("<td>" + data.lists[i].ht_message + "</td>");
                                    tr.append("<td>" + data.lists[i].ht_datetime + "</td>");

                                    if (data.lists[i].ht_status == 0)
                                    {
                                        tr.append("<td><span class='label label-warning'>Opened</span></td>");
                                    } else if (data.lists[i].ht_status == 1)
                                    {
                                        tr.append("<td><span class='label label-success'>Answered</span></td>");
                                    } else if (data.lists[i].ht_status == 2)
                                    {
                                        tr.append("<td><span class='label label-danger'>Closed</span></td>");
                                    }

                                    //Show "Edit" and "Delete" buttons
                                    tr.append("<td>" + "<button type='button' class='btn btn-info' onClick='ViewTicket(" + data.lists[i].ht_id + ")'>View</button>" + "</td>");
                                    $('#tblTickets').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblTickets').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                                });

                            }
                        });
            }

            function viewTicketReplies(id)
            {
                var data = {ht_id: id};

                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "ticketReply", action: 'searchAll', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblTicketReplies > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].htr_datetime + "</td>");
                                    tr.append("<td>" + data.lists[i].us_id.us_username + "</td>");
                                    tr.append("<td>" + data.lists[i].htr_text + "</td>");
                                    $('#tblTicketReplies').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblTicketReplies').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                                });

                            }
                        });
            }

            function ViewTicket(id)
            {
                var data = {ht_id: id};
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "helpTicket", action: 'search', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                $('#mdlViewTic').modal('show');

                                document.getElementById('txtTicId').value = data.ht_id;
                                document.getElementById('spnTitle').innerHTML = data.ht_title;
                                document.getElementById('spnDateTime').innerHTML = data.ht_datetime;

                                document.getElementById('spnMessage').innerHTML = data.ht_message;


                                if (data.ht_status == 0)
                                {
                                    document.getElementById('spnStatus').innerHTML = "<span class='label label-warning'>Opened</span>";
                                } else if (data.ht_status == 1)
                                {
                                    document.getElementById('spnStatus').innerHTML = "<span class='label label-success'>Answered</span>";
                                } else if (data.ht_status == 2)
                                {
                                    document.getElementById('spnStatus').innerHTML = "<span class='label label-danger'>Closed</span>";
                                }

                                if (data.ht_status != 2)
                                {
                                    $('#divReply').fadeIn();
                                    $('#btnCloseTicket').fadeIn();
                                } else
                                {
                                    $('#divReply').fadeOut();
                                    $('#btnCloseTicket').fadeOut();
                                }

                                viewTicketReplies(id);

                            }
                        });
            }

            function reply()
            {
                var ht_id = document.getElementById('txtTicId').value;
                var us_id = <?= $_SESSION['us_id'] ?>;
                var htr_text = document.getElementById('txtText').value;

                if (validateReply())
                {

                    var data = {ht_id: ht_id, us_id: us_id, htr_text: htr_text};

                    //Send Ajax Request
                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "ticketReply", action: 'save', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    if (data.success == true)
                                    {
                                        showNotification(data.message, 'notice');
                                        viewTicketReplies(ht_id);
                                        clearForm();
                                    } else
                                    {
                                        showNotification(data.message, 'error');
                                    }
                                }
                            });
                }
            }

            function closeTicket()
            {
                var ht_id = document.getElementById('txtTicId').value;

                var data = {ht_id: ht_id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "helpTicket", action: 'close', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                if (data.success == true)
                                {
                                    showNotification(data.message, 'notice');
                                    $('#mdlViewTic').modal('hide');
                                    TicketList();
                                } else
                                {
                                    showNotification(data.message, 'error');
                                }
                            }
                        });
            }



        </script>      
    </head>
    <body  onload="TicketList();">
        <div class="scrollToTop"><i class="icon-up-open-big"></i></div>
        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">
<?php include ('includes/menu.php') ?>
            <!-- main-container start -->
            <!-- ================ -->
            <div class="container">
                <div class="row">
                    <div class="main col-md-12">
                        <!-- main start -->

                        <h1 class="page-title margin-top-clear">My Tickets</h1>
                        <!--</header>-->

                        <div class="main-box-body clearfix">
                            <div class="table-responsive">
                                <div class="space"></div>
                                <table class="table table-responsive" id="tblTickets">
                                    <thead>
                                        <tr>

                                            <th class="text-center">Title</th>
                                            <th class="text-center">Message</th>
                                            <th class="text-center">Date and time</th>
                                            <th class="text-center">Status</th>                    

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

        <!-- main end -->


        <!-- main-container end -->

<?php include ('includes/footer.php') ?>

        <!-- page-wrapper end -->
        <div class="modal fade" id="mdlViewTic" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">View Tickets</h4>
                    </div>

                    <div class="modal-body">

                        <div class="main-box-body clearfix">
                            <form role="form">

                                <input type="hidden" id="txtTicId"/>

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
                                <h2 class="pull-left">Ticket Replies</h2>
                            </header>

                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table class="table table-responsive" id="tblTicketReplies">
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
                        <button class="btn btn-danger" id="btnCloseTicket" type="button" onclick="closeTicket()" style="display: none;">Close Ticket</button>
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>      

<?php include ('includes/scripts.php') ?>

    </body>
</html>


