<?php 

require_once ('authenticate.php');
require_once ('session_control.php');

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
        <title>iDea | Home Shop</title>
        <meta name="description" content="iDea a Bootstrap-based, Responsive HTML5 Template">
        <meta name="author" content="htmlcoder.me">

        <?php include ('includes/stylesheets.php') ?>
        <script type="text/javascript">
            //Disaplay Existing categories in a table
            function MyOfferList()
            {
                var us_id   =   <?=$_SESSION['us_id']?>;
                var data    = {us_id: us_id};
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "offer", action: 'displayMyOffers',data:data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblOffers > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td><b>" + data.lists[i].of_from_sp_id.sp_us_id.us_username + "</b> - " + data.lists[i].of_from_sp_id.sp_name + "</td>");
                                    tr.append("<td><b>" + data.lists[i].of_to_sp_id.sp_us_id.us_username + "</b> - " + data.lists[i].of_to_sp_id.sp_name + "</td>");
                                    tr.append("<td>" + data.lists[i].of_datetime + "</td>");
                                    
                                    if(data.lists[i].of_status==0)
                                    {
                                        tr.append("<td><span class='label label-warning'>Pending</span></td>");
                                    }
                                    else if(data.lists[i].of_status==1)
                                    {
                                        tr.append("<td><span class='label label-success'>Accepted</span></td>");
                                    }
                                    else if(data.lists[i].of_status==2)
                                    {
                                        tr.append("<td><span class='label label-danger'>Rejected</span></td>");
                                    }
                                    else if(data.lists[i].of_status==3)
                                    {
                                        tr.append("<td><span class='label label-default'>Closed</span></td>");
                                    }
                                    
                                    if(data.lists[i].of_status==0)
                                    {
                                        if(us_id == data.lists[i].of_from_sp_id.sp_us_id.us_id)
                                        {
                                            tr.append("<td>" + "<button type='button' class='btn btn-sm btn-warning' onClick='openInquiry("+data.lists[i].of_to_sp_id.sp_id+")'>openinquiry</button>");
                                        }
                                        else if(us_id == data.lists[i].of_to_sp_id.sp_us_id.us_id)
                                        {
                                            tr.append("<td>" + "<button type='button' class='btn btn-sm btn-warning' onClick='accept("+data.lists[i].of_id+")'>Accept</button>&nbsp;<button type='button' class='btn btn-sm btn-danger' onClick='reject("+data.lists[i].of_id+")'>Reject</button>");
                                        }
                                    }
                                    else
                                    {
                                        tr.append("<td></td>");
                                    }
                                    //Show "Edit" and "Delete" buttons
                                    
                                    $('#tblOffers').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblOffers').dataTable({
                                    'info': false,
                                    'pageLength': 14,
                                    retrieve: true
                                });

                            }
                        });
            }
            
            function accept(id)
            {
                var data = {of_id: id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "offer", action: 'accept', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //If Save Success
                                if (data.success == true)
                                {
                                    //Show Success Message
                                    showNotification(data.message, 'notice');
                                    location.reload();
                                    
                                } else
                                {
                                    //If not success, show error message
                                    showNotification(data.message, 'error');
                                }

                            }
                        });
            }
            
            function reject(id)
            {
                var data = {of_id: id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "offer", action: 'reject', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //If Save Success
                                if (data.success == true)
                                {
                                    //Show Success Message
                                    showNotification(data.message, 'warning');
                                    location.reload();
                                    
                                } else
                                {
                                    //If not success, show error message
                                    showNotification(data.message, 'error');
                                }

                            }
                        });
            }

            function openInquiry(id)
            {
                window.location.href='swapInquiry.php?id='+id;
                return false;
            }
        </script>      
    </head>
    <body  onload="MyOfferList();">
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
                          
                          <div class="row">
                            <div class="col-lg-12">
                                <div class="main-box clearfix">
                                    <header class="main-box-header clearfix">
                                        <h2 class="pull-left">My Offer List</h2>
                                    </header>

                                    <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table class="table table-responsive" id="tblOffers">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center">Offer From</th>
                                                        <th class="text-center">Offer To</th>
                                                        <th class="text-center">Date time</th>
                                                        <th class="text-center"> Status</th>                    

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
                <!-- main end -->

            </div>
        </div>

        <!-- main-container end -->

        <?php include ('includes/footer.php') ?>

        <!-- page-wrapper end -->

        <?php include ('includes/scripts.php') ?>

    </body>
</html>


