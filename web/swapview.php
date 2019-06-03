<?php
require_once ('authenticate.php');
require_once ('session_control.php');

session_start();

?>

<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>GoSwapIt ! Beyond the Trend.</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include ('includes/stylesheets.php') ?>

        <script type="text/javascript">

            //Disaplay Existing brand in a table
            function displaySwap()
            {
                //Send Ajax request

                var data = {sp_id: <?= $_GET['id'] ?>};
                var session_status  =   "<?=(Authenticate::getSessionStatus()==true)?>";
                var session_id      =   "<?=$_SESSION['us_id']?>";

                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swap", action: 'searchswapwithitems', data: data},
                            success: function (response)
                            {

                                var data = JSON.parse(response);
                                var imgurl = "http://api.goswapit.store/upload/images/";
                                
                                document.getElementById('spnTitle').innerHTML = data.swap.sp_name;
                                document.getElementById('spnPostedBy').innerHTML = data.swap.sp_us_id.us_username;
                                document.getElementById('spnPostedDate').innerHTML = data.swap.sp_posted_date;
                                document.getElementById('spnExpireDate').innerHTML = data.swap.sp_expire_date;
                                
                                if(session_status==1 && data.swap.sp_us_id.us_id!=session_id)
                                {
                                    document.getElementById('divOffer').innerHTML = 
                                     "<div class='row'>"+
                                        "<div class='col-md-12'>"+
                                            "<select id='cmbMySwaps' class='form-control'></select>"+
                                        "</div>"+
                                     "</div>"+
                                     "<div class='row'>"+
                                        "<div class='col-md-12'>"+
                                            "<input type='button' value='Offer' onclick='OfferToSwap()' class='btn btn-lg btn-default btn-block pull-right'>"+
                                        "</div>"+
                                    "</div>";
                            
                                    loadMySwaps();
                                }
                                else if(session_status=="")
                                {
                                    document.getElementById('divOffer').innerHTML = "<div class='row'>"+
                                        "<div class='col-md-12'>"+
                                            "<h3 align='center' style='color: red'><b>Please login to Offer !</b></h3>"+
                                        "</div>"+
                                    "</div>";
                                }
                                
                                
                                document.getElementById('divImages').innerHTML = "<div class='overlay-container'>" +
                                            "<img src='" + imgurl+data.swap.sp_default_img + "' alt=''>" +
                                            "<a href='" + imgurl+data.swap.sp_default_img + "' class='popup-img overlay' title='image title' target='_blank'><i class='fa fa-search-plus'></i></a>" +
                                            "</div>";;

                                var TabHeaderHTML = "<ul class='nav nav-tabs' role='tablist'>";
                                var TabHTML = "<div class='tab-content padding-top-clear padding-bottom-clear'>";


                                for (var i = 0; i < data.items.totalItems; i++)
                                {
                                    var item = data.items.lists[i];

                                    var image = item.im_img_name;
                                    
                                    if (image == null)
                                    {
                                        var imagepath = "";
                                    } 
                                    else
                                    {
                                        var imagepath = imgurl + image;
                                    }


                                    if (i == 0)
                                    {
                                        var tabheaderclass = "class='active'";
                                        var tabclass = "in active";
                                    } 
                                    else
                                    {
                                        var tabheaderclass = "";
                                        var tabclass = "";
                                    }

                                    var attributes = item.attributes;
                                    var attributesHTML = "";

                                    for (var x = 0; x < attributes.totalItems; x++)
                                    {
                                        var attribute = attributes.lists[x];
                                        attributesHTML = attributesHTML +
                                                "<dt>" + attribute.at_name + "</dt>" +
                                                "<dd>" + attribute.ia_value + "</dd>";
                                    }

                                    if (item.md_id == null)
                                    {
                                        var ModelHTML = "";
                                    } else
                                    {
                                        var ModelHTML = "<h4 class='title'>Brand & Model</h4>" +
                                                "<p>" + item.md_id.br_id.br_name + " - " + item.md_id.md_name + "</p>";
                                    }

                                    TabHeaderHTML = TabHeaderHTML + "<li " + tabheaderclass + "><a href='#tab_" + item.im_id + "' role='tab' data-toggle='tab'><i class='fa fa-file-text-o pr-5'></i>" + item.im_name + "</a></li>";

                                    TabHTML = TabHTML +
                                            "<div class='tab-pane fade " + tabclass + "' id='tab_" + item.im_id + "'>" +
                                            "<h4 class='title'>Category</h4>" +
                                            "<p>" + item.ca_id.ca_name + "</p>" +
                                            ModelHTML +
                                            "<h4 class='title'>Description</h4>" +
                                            "<p>" + item.im_desc + "</p>" +
                                            "<h4 class='space-top'>Specifications</h4>" +
                                            "<hr>" +
                                            "<dl class='dl-horizontal'>" +
                                            attributesHTML +
                                            "</dl>" +
                                            "<hr>" +
                                            "<img src='" + imagepath + "' alt='' >" +
                                            "</div>";

                                }

                                TabHeaderHTML = TabHeaderHTML + "</ul>";
                                TabHTML = TabHTML + "</div>";

                                document.getElementById('divItems').innerHTML = TabHeaderHTML + TabHTML;
                       
                                
                                
                            }
                        });
            }
            
            function loadMySwaps()
            {
                var data = {sp_us_id: "<?=$_SESSION['us_id']?>"};
                
                //Send Ajax Request
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "swap", action: 'loadMySwaps', data:data},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

                            //Clear all values first
                            $('#cmbMySwaps').empty();
                            //Append "None" item
                            $('#cmbMySwaps').append($('<option>').text("None").attr('value', ""));

                            //Insert item from the response
                            for(var i = 0; i < data.totalItems; i++)
                            {
                                var item = data.lists[i];
                                $('#cmbMySwaps').append($('<option>').text(item.sp_name).attr('value', item.sp_id));
                            }
                            
                        }
                 });
            }
            
            function OfferToSwap()
            {
                var of_from_sp_id               = document.getElementById("cmbMySwaps").value;
                var of_to_sp_id                 = <?= $_GET['id'] ?>;
                
                var data = {of_from_sp_id:of_from_sp_id, of_to_sp_id : of_to_sp_id , sp_us_id : '<?=$_SESSION['us_id']?>'};
                
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "offer", action: 'save', data:data},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

                           if(data.success==true)
                            {
                                    //Show Success Message
                                    showNotification(data.message,'notice');
                            }
                            else
                            {
                                    //If not success, show error message
                                    showNotification(data.message,'error');
                            }
                            
                        }
                 });
            }

        </script>
    </head>

    <!-- body classes: 
                    "boxed": boxed layout mode e.g. <body class="boxed">
                    "pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> 
    -->
    <body class="no-trans" onload="displaySwap()">
        <!-- scrollToTop -->
        <!-- ================ -->
        <div class="scrollToTop"><i class="icon-up-open-big"></i></div>

        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">

<?php include ('includes/menu.php') ?>

            <!-- page-intro start-->
            <!-- ================ -->
            <div class="page-intro">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ol class="breadcrumb">
                                <li><i class="fa fa-home pr-10"></i><a href="index.php">Home</a></li>
                                <li class="active">Swap</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page-intro end -->

            <!-- main-container start -->
            <!-- ================ -->
            <section class="main-container">

                <div class="container">
                    <div class="row">

                        <!-- main start -->
                        <!-- ================ -->
                        <div class="main col-md-12">

                            <!-- page-title start -->
                            <!-- ================ -->
                            <h1 class="page-title margin-top-clear"><span id="spnTitle"></span></h1>
                            <!-- page-title end -->

                            <div class="row">
                                <div class="col-md-4">


                                    <!-- Tab panes start-->
                                    <div class="tab-content clear-style">
                                        <div class="tab-pane active" id="product-images">
                                            <div class="" id="divImages">

                                            </div>
                                        </div>

                                    </div>
                                    <!-- Tab panes end-->
                                    <hr>
                                    <div class="row">
                                        <p>Posted by : <span id="spnPostedBy"></span></p>
                                        <p>Posted Date : <span id="spnPostedDate"></span></p>
                                        <p>Expire Date : <span id="spnExpireDate"></span></p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                    <div id="divOffer"></div>
                                    
                                     
                                </div>

                                <!-- product side start -->
                                <aside class="col-md-8">
                                    <div class="sidebar">
                                        <div class="side product-item vertical-divider-left">
                                            <div class="tabs-style-2" id="divItems">


                                            </div>
                                        </div>
                                    </div>
                                </aside>
                                <!-- product side end -->
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
