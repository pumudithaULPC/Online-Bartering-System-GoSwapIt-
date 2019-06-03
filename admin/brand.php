<?php 

require_once ('authenticate.php');
require_once ('session_control.php');

if(Authenticate::getSessionStatus()==false)
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

	<title>GoSwapIt - Item Brands</title>
	
	<?php include ('includes/stylesheets.php') ?>
        
        <script type="text/javascript">
            
            //Load Super Category Combo List
            function loadCategoryList()
            {
                //Send Ajax Request
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "category", action: 'loadCategoriesforBrand'},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

                            //Clear all values first
                            $('#cmbCategory').empty();
                            //Append "None" item
                            $('#cmbCategory').append($('<option>').text("None").attr('value', ""));

                            //Insert item from the response
                            for(var i = 0; i < data.result.totalItems; i++)
                            {
                                var item = data.result.lists[i];
                                $('#cmbCategory').append($('<option>').text(item.ca_name).attr('value', item.ca_id));
                            }
                            
                        }
                 });
            }
            
            //Save Brand
            function saveBrand()
            {
                //If form validated
                
                if(validateForm())
                {
                    
                        var br_id	 =   document.getElementById('txtBrandId').value;
                        var br_name      =   document.getElementById('txtBrandName').value;
                        var ca_id     =   document.getElementById('cmbCategory').value;

                        var data         =   {'br_id' : br_id, 'br_name' : br_name, 'ca_id' : ca_id};

                        //Send Ajax Request
                        $.ajax
                        ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: { controller : "brand", action: 'saveBrand', data : data},
                                success: function(response) 
                                {
                                        var data	=	JSON.parse(response);

                                        //If Save Success
                                        if(data.success==true)
                                        {

                                                //Show Success Message
                                                showNotification(data.message,'notice');
                                                //Reload Super Categories
                                                loadCategoryList();
                                                //Category display table reload
                                                displayBrandList();
                                                //Clear Form
                                                clearForm();
                                        }
                                        else
                                        {
                                                //If not success, show error message
                                                showNotification(data.message,'error');
                                        }

                                }
                        });
                }
                                
                                
            }
            
            //Disaplay Existing brand in a table
            function displayBrandList()
            {
		//Send Ajax request
                var data         =   {'br_id' : 15};
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "brand", action: 'displayBrands', data : data},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);
 
                            //Remove all records first
                            $("#tblBrands > tbody:last").children().remove();

                            //Display new records from response
                            for(var i = 0; i < data.totalItems; i++)
                            {
                                tr = $('<tr/>');
                                tr.append("<td>" + data.lists[i].br_name + "</td>"); //Brand Name
                                tr.append("<td>" + data.lists[i].ca_id.ca_name + "</td>"); //Category

                                //Show "Edit" and "Delete" buttons
                                tr.append("<td>" + "<button type='button' class='btn btn-warning' onClick='LoadItem2Edit("+data.lists[i].br_id+")'>Edit</button>&nbsp;<button type='button' class='btn btn-danger' onClick='ConfirmDeleteItem("+data.lists[i].br_id+")'>Delete</button>" + "</td>");

                                $('#tblBrands').append(tr);
                            }
                            
                            //Initiate DataTable
                            $('#tblBrands').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                            });
                        }
                 });
            }

            //Load Brand Details to form when "Edit" button clicked
            function LoadItem2Edit(BrandId)
            {
                    var data         =   {'br_id' : BrandId};

                    //send ajax request
                    $.ajax
                    ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: { controller : "brand", action: 'search', data : data},
                            success: function(response) 
                            {
                                var data	=	JSON.parse(response);

                                //Load response to form
                                document.getElementById('txtBrandId').value 		=	data.br_id;
                                document.getElementById('txtBrandName').value           =	data.br_name;

                                if(data.ca_id==null)
                                {
                                        document.getElementById('cmbCategory').selectedIndex	=	0;
                                }
                                else
                                {
                                        selectList('cmbCategory',data.ca_id);
                                }

                                ScrollToElement('txtBrandId');

                            }
                     });			
            }

            //Clear form feilds
            function clearForm()
            { 
                    document.getElementById('txtBrandId').value 				=	"";
                    document.getElementById('txtBrandName').value                           =	"";
                    document.getElementById('cmbCategory').selectedIndex               =	0;
            }

            //Clear validation error messages
            function clearErrorMessages()
            {
                    document.getElementById('spnBrandName').innerHTML 			=	"";
                    document.getElementById('spnCategory').innerHTML 			=	"";
            }

            //Validate Form before submitting
            function validateForm()
            {

                    try
                    {
                            //Clear error messages before validating
                            clearErrorMessages();
                            
                            if(validateEmpty("txtBrandName")==false)
                            {
                                    throw 1000;
                            }

                            if(validateList("cmbCategory")==false)
                            {
                                    throw 1001;
                            }

                            return true;
                    }

                    catch(err)
                    {
                            if(err==1000) //Empty Brand Name
                            {
                                    document.getElementById("spnBrandName").innerHTML = "Brand Name is Required !";	
                                    ScrollToElement("spnBrandName");

                            }

                            if(err==1001) //Empty Category
                            {
                                    document.getElementById("spnCategory").innerHTML = "Category is Required !";	
                                    ScrollToElement("spnCategory");
                            }

                            return false;
                    }
            }

            //Show confirm box before deleting brand
            function ConfirmDeleteItem(id)
            {
                    ConfirmAction("Confirm Delete","Are you sure to delete this item ?", "Yes", "No", DeleteItem,[id]);
            }

            function DeleteItem(id)
            {
                var data         =   {'br_id' : id};

                //Send Ajax Request
                $.ajax
                ({
                    type: 'POST',
                    url: 'request_handle.php',
                    data: { controller : "brand", action: 'deleteBrand', data : data},
                    success: function(response) 
                    {
                            var data	=	JSON.parse(response);

                            //If Save Success
                            if(data.success==true)
                            {
                                    //Show Success Message
                                    showNotification(data.message,'warning');
                                    //Reload Super Categories
                                    loadCategoryList();
                                    //Brand display table reload
                                    displayBrandList();
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
<body onload="loadCategoryList();displayBrandList();">
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
										<li class="active"><span>Brands</span></li>
									</ol>
									
									<h1>Item Brands <small>Setup Item Brands...</small></h1>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2>Add Brand</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<form role="form">
												<div class="form-group">
													<label for="txtBrandId">Brand Id</label>
													<input type="text" class="form-control" id="txtBrandId" placeholder="" disabled>
												</div>

												<div class="form-group">
													<label for="txtCategoryName">Brand Name</label>
													<input type="text" class="form-control" id="txtBrandName" placeholder="Enter  name">
													<span id="spnBrandName" class="label label-danger"></span>
												</div>
                                                                                            
												<div class="form-group">
													<label>Category</label>
                                                                                                        <select class="form-control" id="cmbCategory" name="cmbCategory">
                                                                                                                
													</select>
                                                                                                        <span id="spnCategory" class="label label-danger"></span>
                                                                                                        
												</div>
                                                                                            
												<div class="form-group">
													<div class="pull-right">
                                                            <button type="button" class="btn btn-success" onclick="saveBrand()">Save</button>
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
											<h2 class="pull-left">Item Brand List</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<div class="table-responsive">
                                                <table class="table table-responsive" id="tblBrands">
													<thead>
														<tr>
															<th class="text-center">Brand Name</th>
															<th class="text-center">Category</th>
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