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

//Load Category Combo List
            function loadCategoryList()
            {
                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "category", action: 'loadSuperCategories'},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Clear all values first
                                $('#cmbCategory').empty();
                                //Append "None" item
                                $('#cmbCategory').append($('<option>').text("None").attr('value', ""));

                                //Insert item from the response
                                for (var i = 0; i < data.result.totalItems; i++)
                                {
                                    var item = data.result.lists[i];
                                    $('#cmbCategory').append($('<option>').text(item.ca_name).attr('value', item.ca_id));
                                }

                            }
                        });
            }

            function loadBrandList(ca_id)
            {
                var data = {ca_id: ca_id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "brand", action: 'loadBrands', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Clear all values first
                                $('#cmbBrand').empty();
                                //Append "None" item
                                $('#cmbBrand').append($('<option>').text("None").attr('value', ""));

                                //Insert item from the response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    var item = data.lists[i];
                                    $('#cmbBrand').append($('<option>').text(item.br_name).attr('value', item.br_id));
                                }

                            }
                        });
            }

            function loadModelList()
            {
                var br_id = document.getElementById("cmbBrand").value;

                var data = {br_id: br_id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "model", action: 'searchByBrand', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Clear all values first
                                $('#cmbModel').empty();
                                //Append "None" item
                                $('#cmbModel').append($('<option>').text("None").attr('value', ""));

                                //Insert item from the response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    var item = data.lists[i];
                                    $('#cmbModel').append($('<option>').text(item.md_name).attr('value', item.md_id));
                                }

                            }
                        });
            }

            function CheckBrandStatus()
            {
                var ca_id = document.getElementById("cmbCategory").value;

                var data = {ca_id: ca_id};

                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "category", action: 'search', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                if (data.ca_br_status == 0)
                                {
                                    $('#cmbBrand').empty();
                                    $('#cmbModel').empty();
                                    document.getElementById('cmbBrand').disabled = true;
                                    document.getElementById('cmbModel').disabled = true;
                                } else
                                {
                                    loadBrandList(ca_id);
                                    document.getElementById('cmbBrand').disabled = false;
                                    document.getElementById('cmbModel').disabled = false;
                                }

                                getCatAttributes();

                            }
                        });
            }

            function getCatAttributes()
            {
                var ca_id = document.getElementById("cmbCategory").value;

                var data = {ca_id: ca_id};

                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "categoryAttributes", action: 'getCategoryAttributes', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                var AttributeHTML = "";

                                for (var i = 0; i < data.total; i++)
                                {
                                    AttributeHTML = AttributeHTML + "<div class='form-group has-feedback'><label for='txtAttribute_" + data.list[i].at_id + "' class='col-sm-3 control-label'> " + data.list[i].at_name + " <span class='text-danger small'></span></label><div class='col-sm-8'><input type='text' class='form-control' id='txtAttribute_" + data.list[i].at_id + "' placeholder='" + data.list[i].at_name + "' required></div></div>";
                                }

                                document.getElementById('divAttributes').innerHTML = AttributeHTML;
                            }
                        });

            }

            function SaveItem()
            {
                if(validateFormItem())
                {
                    var sp_id = document.getElementById("txtSwapId").value;
                    var ca_id = document.getElementById("cmbCategory").value;
                    var md_id = document.getElementById("cmbModel").value;
                    var im_name = document.getElementById("txtName").value;
                    var im_desc = document.getElementById("txtDesc").value;
                    var im_img_name = document.getElementById("hdnImageName").value;
                    var attributeElements = document.querySelectorAll('input[id^="txtAttribute_"]');

                    var attribute_data = [];

                    for (var i = 0; i < attributeElements.length; i++)
                    {
                        var v_name = attributeElements[i].id;
                        var v_value = attributeElements[i].value;

                        var temp = v_name.split("_");
                        var v_id = temp[1];

                        attribute_data.push({id: v_id, value: v_value});
                    }

                    var data = {sp_id: sp_id, im_name: im_name, im_desc: im_desc, ca_id: ca_id, md_id: md_id, im_img_name: im_img_name, attributes: attribute_data};

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "swapItem", action: 'saveItem', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    if (data.success == true)
                                    {
                                        //Show Success Message
                                        showNotification(data.message, 'notice');
                                        displayItemList();
                                        clearItemForm();
                                    } else
                                    {
                                        //If not success, show error message
                                        showNotification(data.message, 'error');
                                    }

                                }
                            });
                }
            }



            function CompleteSwap()
            {

                var sp_id = document.getElementById("txtSwapId").value;

                var data = {sp_id: sp_id};

                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swap", action: 'complete', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

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

            function SaveSwap()
            {
                if(validateFormSwap())
                {
                    var sp_name = document.getElementById("txtTitle").value;
                    var sp_id = document.getElementById("txtSwapId").value;

                    var data = {sp_id: sp_id, sp_name: sp_name, sp_us_id: <?= $_SESSION['us_id'] ?>};

                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "swap", action: 'save', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    if (data.success == true)
                                    {
                                        //Show Success Message
                                        showNotification(data.message, 'notice');
                                        document.getElementById("txtSwapId").value = data.sp_id;
                                        $("#divItemAdd").fadeIn();
                                    } else
                                    {
                                        //If not success, show error message
                                        showNotification(data.message, 'error');
                                    }

                                }
                            });
                        }
            }

            function LoadIncompletedSwap()
            {

                var data = {sp_us_id: <?= $_SESSION['us_id'] ?>};

                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swap", action: 'loadIncompletedSwap', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                if (data.success == true)
                                {
                                    if (data.totalItems == 1)
                                    {
                                        document.getElementById("txtSwapId").value = data.lists[0].sp_id;
                                        document.getElementById("txtTitle").value = data.lists[0].sp_name;
                                        $("#divItemAdd").fadeIn();
                                        displayItemList();
                                    }
                                }

                            }
                        });
            }

//Disaplay items in a table
            function displayItemList()
            {

                var sp_id = document.getElementById("txtSwapId").value;

                var data = {sp_id: sp_id};

                //Send Ajax request

                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapItem", action: 'displayItems', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                var imgurl = "http://api.goswapit.store/upload/images/";

                                //Remove all records first
                                $("#tblItems > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].im_name + "</td>"); //Item Name
                                    tr.append("<td>" + data.lists[i].im_desc + "</td>");//Item Description
                                    if (data.lists[i].im_img_name == null)
                                    {
                                        tr.append("<td>-</td>");
                                    } else
                                    {
                                        tr.append("<td><a href='" + imgurl + data.lists[i].im_img_name + "' target='_blank'><img src='" + imgurl + data.lists[i].im_img_name + "' width='50px'></a></td>");//Item Image
                                    }
                                    tr.append("<td>" + data.lists[i].ca_id.ca_name + "</td>");
                                    if (data.lists[i].md_id != null)
                                    {
                                        tr.append("<td>" + data.lists[i].md_id.br_id.br_name + " - " + data.lists[i].md_id.md_name + "</td>");
                                    } else
                                    {
                                        tr.append("<td>-</td>");
                                    }

                                    //Show "Edit" and "Delete" buttons
                                    tr.append("<td>" + "<button type='button' class='btn btn-danger' onClick='DeleteItem(" + data.lists[i].im_id + ")'>Delete</button>" + "</td>");

                                    $('#tblItems').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblItems').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                                });
                            }
                        });


                
            }

            function DeleteItem(id)
            {
                var data = {im_id: id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "swapItem", action: 'deleteItem', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //If Save Success
                                if (data.success == true)
                                {
                                    //Show Success Message
                                    showNotification(data.message, 'warning');
                                    displayItemList();
                                   
                                } else
                                {
                                    //If not success, show error message
                                    showNotification(data.message, 'error');
                                }

                            }
                        });
            }


            function clearItemForm()
            {
                document.getElementById('divAttributes').innerHTML = "";
                document.getElementById("txtName").value = "";
                document.getElementById("txtDesc").value = "";
                document.getElementById("cmbCategory").selectedIndex = 0;
                document.getElementById("fileImg").value = "";
                $('#cmbBrand').empty();
                $('#cmbModel').empty();
            }

            function uploadImage()
            {

                var file_data = $('#fileImg').prop('files')[0];

                var form_data = new FormData();
                form_data.append('file', file_data);

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            url: 'http://api.goswapit.store/upload/image.php',
                            data: form_data,
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //If Save Success
                                if (data.success == true)
                                {
                                    document.getElementById("hdnImageName").value = data.filename;
                                    showNotification(data.message, 'notice');
                                } else
                                {
                                    document.getElementById("hdnImageName").value = "";
                                    showNotification(data.message, 'warning');
                                }

                            }
                        });

            }
            
            function clearErrorMessagesSwap()
            {
                document.getElementById('spnSwapTitle').innerHTML = "";
            }

            //Validate Form before submitting
            function validateFormSwap()
            {
                
                try
                {
                    //Clear error messages before validating
                    clearErrorMessagesSwap();
            
                    
                    if (validateEmpty("txtTitle") == false)
                    {
                        throw 1013;
                    }
                    
                    return true;
                } 
                catch (err)
                {
                    
                    if (err == 1013)
                    {
                        document.getElementById("spnSwapTitle").innerHTML = "Title is Required !";
                        ScrollToElement("spnSwapTitle");
                    }

                    return false;
                }

            }
            
            function clearErrorMessagesItem()
            {
                document.getElementById('spnSwapItemName').innerHTML = "";
                document.getElementById('spnDescription').innerHTML = "";
                document.getElementById('spnCategory').innerHTML = "";
                document.getElementById('spnImage').innerHTML = "";
            }

            //Validate Form before submitting
            function validateFormItem()
            {
                
                try
                {
                    //Clear error messages before validating
                    clearErrorMessagesItem();
            
                    
                    if (validateEmpty("txtName") == false)
                    {
                        throw 1013;
                    }
                    
                    if (validateEmpty("txtDesc") == false)
                    {
                        throw 1014;
                    }
                    
                    if (validateList("cmbCategory") == false)
                    {
                        throw 1015;
                    }
                    
                    if (validateEmpty("hdnImageName") == false)
                    {
                        throw 1016;
                    }
                    
                    return true;
                } 
                catch (err)
                {
                    
                    if (err == 1013)
                    {
                        document.getElementById("spnSwapItemName").innerHTML = "Title is Required !";
                        ScrollToElement("spnSwapItemName");
                    }
                    
                    if (err == 1014)
                    {
                        document.getElementById("spnDescription").innerHTML = "Description is Required !";
                        ScrollToElement("spnDescription");
                    }
                    
                    if (err == 1015)
                    {
                        document.getElementById("spnCategory").innerHTML = "Category is Required !";
                        ScrollToElement("spnCategory");
                    }
                    
                    if (err == 1016)
                    {
                        document.getElementById("spnImage").innerHTML = "Image is Required !";
                        ScrollToElement("spnImage");
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
    <body class="front no-trans" onload="LoadIncompletedSwap();
            loadCategoryList();">
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
                                <h2 class="title">Post Your Swap here...</h2>

                                <form class="form-horizontal" role="form">
                                    <div class="form-group has-feedback">
                                        <label for="txtTitle" class="col-sm-3 control-label">Title <span class="text-danger small"></span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="txtTitle" placeholder="Swap Title" required>
                                            <input type="hidden" class="form-control" id="txtSwapId">
                                            <span id="spnSwapTitle" class="label label-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-8">
                                            <button type="button" class="btn btn-default" onclick="SaveSwap()">Save Swap</button>
                                        </div>
                                    </div>
                                </form>

                                <hr>
                                <div id="divItemAdd" style="display: none;">

                                    <h3 class="title">Add Items</h3>

                                    <form class="form-horizontal" role="form">
                                        <div class="form-group has-feedback">
                                            <label for="txtName" class="col-sm-3 control-label"> Item Name <span class="text-danger small"></span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="txtName" placeholder="Item Name" required>
                                                <span id="spnSwapItemName" class="label label-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="txtDesc" class="col-sm-3 control-label"> Item Description <span class="text-danger small"></span></label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="3" placeholder="Description" required id="txtDesc" name="txtDesc"></textarea>
                                                <span id="spnDescription" class="label label-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="cmbCategory" class="col-sm-3 control-label">Select Category <span class="text-danger small"></span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="cmbCategory" name="cmbCategory" onchange="CheckBrandStatus();">
                                                </select>
                                                <span id="spnCategory" class="label label-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="cmbBrand" class="col-sm-3 control-label">Select Brand <span class="text-danger small"></span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="cmbBrand" name="cmbBrand" onchange="loadModelList()">
                                                </select>
                                                <span id="spnCategory" class="label label-danger"></span>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="cmbModel" class="col-sm-3 control-label">Select Model <span class="text-danger small"></span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="cmbModel" name="cmbModel" onchange="">
                                                </select>
                                                <span id="spnCategory" class="label label-danger"></span>
                                            </div>
                                        </div>


                                        <div id="divAttributes">

                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="fileImg" class="col-sm-3 control-label">Images <span class="text-danger small"></span></label>
                                            <div class="col-sm-8">
                                                <input type="file" class="form-control" id="fileImg" name="fileImg">
                                                <input type="hidden" id="hdnImageName"/>
                                                <span id="spnImage" class="label label-danger"></span>
                                                <input type="button" onclick="uploadImage()" value="Upload" class="btn btn-default"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-8">
                                                <button type="button" class="btn btn-default" onclick="SaveItem();">Save Item</button>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class=" col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary btn-lg" onclick="CompleteSwap();">Complete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <!-- main end -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-box clearfix">
                                    <header class="main-box-header clearfix">
                                        <h2 class="pull-left">Item List</h2>
                                    </header>

                                    <div class="main-box-body clearfix">
                                        <div class="table-responsive">
                                            <table class="table table-responsive" id="tblItems">
                                                <thead>
                                                    <tr>

                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Description</th>
                                                        <th class="text-center">Image</th>
                                                        <th class="text-center">Category</th>
                                                        <th class="text-center">Brand & Model</th>


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
                </div>
            </section>
            <!-- main-container end -->

<?php include ('includes/footer.php') ?>

        </div>
        <!-- page-wrapper end -->

<?php include ('includes/scripts.php') ?>

    </body>
</html>
