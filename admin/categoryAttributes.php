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

        <title>GoSwapIt - Category Attributes</title>

<?php include ('includes/stylesheets.php') ?>

        <script type="text/javascript">

            //Load Super Category Combo List
            function loadSuperCategoryList()

            {
                displayCategoryList();

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
                                $('#cmbSuperCategory').empty();
                                //Append "None" item
                                $('#cmbSuperCategory').append($('<option>').text("None").attr('value', ""));

                                //Insert item from the response
                                for (var i = 0; i < data.result.totalItems; i++)
                                {
                                    var item = data.result.lists[i];
                                    $('#cmbSuperCategory').append($('<option>').text(item.ca_name).attr('value', item.ca_id));
                                }

                            }
                        });
            }
            //Save Category
            function saveCategoryAttributes()
            {
                //If form validated
                if (validateForm())
                {
                    var at_id = document.getElementById('txtCategoryattributeId').value;
                    var at_name = document.getElementById('txtCategoryattributeName').value;
                    var ca_id = document.getElementById('cmbSuperCategory').value;


                    var data = {at_id: at_id, at_name: at_name, ca_id: ca_id};

                    //Send Ajax Request
                    $.ajax
                            ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: {controller: "categoryAttributes", action: 'saveCategoryAttributes', data: data},
                                success: function (response)
                                {
                                    var data = JSON.parse(response);

                                    //If Save Success
                                    if (data.success == true)
                                    {
                                        //Show Success Message
                                        showNotification(data.message, 'notice');
                                        //Reload Super Categories
                                        loadSuperCategoryList();
                                        //Category display table reload
                                        displayCategoryList();
                                        //Clear Form
                                        clearForm();
                                    } else
                                    {
                                        //If not success, show error message
                                        showNotification(data.message, 'error');
                                    }

                                }
                            });
                }
            }

            //Disaplay Existing categories in a table
            function displayCategoryList()
            {
                //Send Ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "categoryAttributes", action: 'displayCategories'},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Remove all records first
                                $("#tblCategoriesa > tbody:last").children().remove();

                                //Display new records from response
                                for (var i = 0; i < data.totalItems; i++)
                                {
                                    tr = $('<tr/>');
                                    tr.append("<td>" + data.lists[i].at_name + "</td>"); //Category Attribute Name

                                    tr.append("<td>" + data.lists[i].ca_id.ca_name + "</td>"); //Category



                                    //Show "Edit" and "Delete" buttons
                                    tr.append("<td>" + "<button type='button' class='btn btn-warning' onClick='LoadItem2Edit(" + data.lists[i].at_id + ")'>Edit</button>&nbsp;<button type='button' class='btn btn-danger' onClick='ConfirmDeleteItem(" + data.lists[i].at_id + ")'>Delete</button>" + "</td>");

                                    $('#tblCategoriesa').append(tr);
                                }

                                //Initiate DataTable
                                $('#tblCategoriesa').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                                });

                            }
                        });
            }

            //Load Category Details to form when "Edit" button clicked
            function LoadItem2Edit(CategoryAttributesId)
            {
                var data = {ca_id: CategoryAttributesId};

                //send ajax request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "categoryAttributes", action: 'search', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //Load response to form
                                document.getElementById('txtCategoryattributeId').value = data.at_id;
                                document.getElementById('txtCategoryattributeName').value = data.at_name;

                                if (data.ca_id == null)
                                {
                                    document.getElementById('cmbSuperCategory').selectedIndex = 0;
                                } else
                                {
                                    selectList('cmbSuperCategory', data.ca_id);
                                }




                                ScrollToElement('txtCategoryattributeId');

                            }
                        });
            }

            //Clear form feilds
            function clearForm()
            {
                document.getElementById('txtCategoryattributeId').value = "";
                document.getElementById('txtCategoryattributeName').value = "";
                document.getElementById('cmbSuperCategory').selectedIndex = 0;

            }

            //Clear validation error messages

            function clearErrorMessages()
            {
                document.getElementById('spnCategoryAttributeName').innerHTML = "";

            }

            //Validate Form before submitting

            function validateForm()
            {

                try
                {
                    //Clear error messages before validating
                    clearErrorMessages();

                    if (validateEmpty("txtCategoryattributeName") == false)
                    {
                        throw 1000;
                    }
                    if (validateList("cmbSuperCategory") == false)
                    {
                        throw 1001;
                    }




                    return true;
                } catch (err)
                {
                    if (err == 1000) //Empty Category Name
                    {
                        document.getElementById("spnCategoryAttributeName").innerHTML = "Category Attribute Name is Required !";
                        ScrollToElement("spnCategoryAttributeName");
                    }
                    if (err == 1001) //Empty Category
                    {
                        document.getElementById("spnCategory").innerHTML = "Category is Required !";
                        ScrollToElement("spnCategory");
                    }



                    return false;
                }
            }

            //Show confirm box before deleting category
            function ConfirmDeleteItem(id)
            {
                ConfirmAction("Confirm Delete", "Are you sure to delete this item ?", "Yes", "No", DeleteItem, [id]);
            }

            function DeleteItem(id)
            {
                var data = {at_id: id};

                //Send Ajax Request
                $.ajax
                        ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: {controller: "categoryAttributes", action: 'deleteCategoryAttributes', data: data},
                            success: function (response)
                            {
                                var data = JSON.parse(response);

                                //If Save Success
                                if (data.success == true)
                                {
                                    //Show Success Message
                                    showNotification(data.message, 'warning');
                                    //Reload Super Categories
                                    loadSuperCategoryList();
                                    //Category display table reload
                                    displayCategoryList();
                                } else
                                {
                                    //If not success, show error message
                                    showNotification(data.message, 'error');
                                }

                            }
                        });
            }

        </script>



    </head>
    <body onload="loadSuperCategoryList()">
        <div id="theme-wrapper">
<?php include('includes/topheader.php') ?>
            <div id="page-wrapper" class="container">
                <div class="row">
<?php include('includes/sidebar.php') ?>
                    <div id="content-wrapper">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <ol class="breadcrumb">
                                            <li><a href="#">Home</a></li>
                                            <li class="active"><span>Category Attributes</li>
                                        </ol>

                                        <h1>Item Category Attributes <small>Setup Item Category Attributes...</small></h1>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="main-box">
                                            <header class="main-box-header clearfix">
                                                <h2>Add Category Attributes</h2>
                                            </header>

                                            <div class="main-box-body clearfix">
                                                <form role="form">
                                                    <div class="form-group">
                                                        <label for="txtCategoryId">Category Attributes Id</label>
                                                        <input type="text" class="form-control" id="txtCategoryattributeId" placeholder="" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="txtCategoryName">Category Attribute Name</label>
                                                        <input type="text" class="form-control" id="txtCategoryattributeName" placeholder="Enter category name">
                                                        <span id="spnCategoryAttributeName" class="label label-danger"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Category Name</label>
                                                        <select class="form-control" id="cmbSuperCategory" name="cmbSuperCategory">

                                                        </select>
                                                        <span id="spnCategory" class="label label-danger"></span>
                                                    </div>







                                                    <div class="form-group">
                                                        <div class="pull-right">
                                                            <button type="button" class="btn btn-success" onclick="saveCategoryAttributes()">Save</button>
                                                            <button type="button" class="btn btn-warning" onclick="clearForm()">Clear</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="main-box clearfix">
                                            <header class="main-box-header clearfix">
                                                <h2 class="pull-left">Item Category Attributes List</h2>
                                            </header>

                                            <div class="main-box-body clearfix">
                                                <div class="table-responsive">
                                                    <table class="table table-responsive" id="tblCategoriesa">
                                                        <thead>
                                                            <tr>

                                                                <th class="text-center">Category Attribute Name</th>
                                                                <th class="text-center">Category Name</th>


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

<?php include('includes/footer.php') ?>
                    </div>
                </div>
            </div>
        </div>


<?php include('includes/scripts.php') ?>

    </body>
</html>


