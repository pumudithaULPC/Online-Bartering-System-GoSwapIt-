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
            function MySwapList()
            {
                var us_id   =   <?=$_SESSION['us_id']?>;
                var data    = {us_id: us_id};
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swap", action:'searchByUserID',data:data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblSwaps > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].sp_name + "</td>");
                                    tr.append("<td>"+data.lists[i].sp_posted_date+"</td>");
                                    tr.append("<td>" + data.lists[i].sp_expire_date + "</td>");
                                    
                                    if(data.lists[i].sp_status==2)
                                    {
                                        tr.append("<td><span class='label label-success'>Processed.</span></td>");
                                    }
                                    else if(data.lists[i].sp_status==1)
                                    {
                                        tr.append("<td><span class='label label-warning'>Pending</span></td>");
                                    }
                                    
                                    else
                                    {
                                        tr.append("<td></td>");
                                    }
                                    
                                   tr.append("<td>" + "<button type='button' class='btn btn-info' onClick='ViewSwap(" + data.lists[i].sp_id + ")'>view</button>");
                                    
                                    
                                    //Show "Edit" and "Delete" buttons
                                    
                                    $('#tblSwaps').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblSwaps').dataTable({
                                    'info': false,
                                    'pageLength': 14,
                                    retrieve: true
                                });

                            }
                        });
            }
            
            function ViewSwap(id)
            {
                var data = {sp_id: id};
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapItem", action: 'displayItems', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                $('#mdlViewSwp').modal('show');
                                {
                               //Remove all records first
                                $("#tblItems > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].im_name + "</td>");
                                    tr.append("<td>"+data.lists[i].im_desc+"</td>");
                                    tr.append("<td>" + data.lists[i].ca_id.ca_name+ "</td>");
                                    
                                   
                                    
                                   
                                    
                                    
                                    //Show "Edit" and "Delete" buttons
                                    
                                    $('#tblItems').append(tr);
                                }
                                     //Initiate DataTable
                                    $('#tblItems').dataTable({
                                    'info': false,
                                    'pageLength': 14,
                                    retrieve: true
                                });
                                }
                            }
                        });
            }
            
           
            

           
        </script>      
    </head>
    <body  onload="MySwapList();">
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
                                        <h2 class="pull-left">View Swap Items</h2>
                                    </header>

                                    <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table class="table table-responsive" id="tblSwaps">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Swap Name</th>
                                                        <th class="text-center">Swap Posted Date</th>
                                                        <th class="text-center">Swap Expired Date</th>
                                                        <th class="text-center"> Status</th>
                                                        <th class="text-center"> Action</th>

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
        
        
        <div class="modal fade" id="mdlViewSwp" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">View Swaps</h4>
            </div>

            <div class="modal-body">

                <div class="main-box-body clearfix">
                     <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table class="table table-responsive" id="tblItems">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Item description</th>
                                                        <th class="text-center">Category</th>
                                                        
						       
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

        <!-- main-container end -->

        <?php include ('includes/footer.php') ?>

        <!-- page-wrapper end -->

        <?php include ('includes/scripts.php') ?>

    </body>
</html>


