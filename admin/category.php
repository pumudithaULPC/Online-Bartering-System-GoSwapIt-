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

	<title>GoSwapIt - Item Categories</title>
	
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
                        data: { controller : "category", action: 'loadSuperCategories'},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

							//Clear all values first
                            $('#cmbSuperCategory').empty();
							//Append "None" item
                            $('#cmbSuperCategory').append($('<option>').text("None").attr('value', ""));

							//Insert item from the response
                            for(var i = 0; i < data.result.totalItems; i++)
                            {
                                var item = data.result.lists[i];
                                $('#cmbSuperCategory').append($('<option>').text(item.ca_name).attr('value', item.ca_id));
                            }
                            
                        }
                 });
            }
            
			//Save Category
            function saveCategory()
            {
				//If form validated
				if(validateForm())
				{
					var ca_id	     =   document.getElementById('txtCategoryId').value;
					var ca_name      =   document.getElementById('txtCategoryName').value;
					var ca_supid     =   document.getElementById('cmbSuperCategory').value;
					var ca_desc      =   document.getElementById('txtDescription').value;
					var ca_br_status =   document.getElementById('cmbBrandStatus').value;
					
					var data         =   {ca_id : ca_id, ca_name : ca_name, ca_supid : ca_supid, ca_desc : ca_desc, ca_br_status : ca_br_status};

					//Send Ajax Request
					$.ajax
					({
							type: 'POST',
							url: 'request_handle.php',
							data: { controller : "category", action: 'saveCategory', data : data},
							success: function(response) 
							{
								var data	=	JSON.parse(response);
								
								//If Save Success
								if(data.success==true)
								{
									//Show Success Message
									showNotification(data.message,'notice');
									//Reload Super Categories
									loadSuperCategoryList();
									//Category display table reload
									displayCategoryList();
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
            
			//Disaplay Existing categories in a table
            function displayCategoryList()
            {
				//Send Ajax request
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "category", action: 'displayCategories'},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

							//Remove all records first
							$("#tblCategories > tbody:last").children().remove();

							//Display new records from response
                            for(var i = 0; i < data.totalItems; i++)
                            {
                                tr = $('<tr/>');
								tr.append("<td>" + data.lists[i].ca_name + "</td>"); //Category Name

								//If category doesnt have a super category
								if(data.lists[i].ca_supid==null)
								{
									//display dash (-)
									tr.append("<td>" + "-" + "</td>");
								}
								else
								{
									//If category has a super category display it
									tr.append("<td>" + data.lists[i].ca_supid.ca_name + "</td>");
								}
								
								tr.append("<td>" + data.lists[i].ca_desc + "</td>"); //Category Description

								//Brand Status
								if(data.lists[i].ca_br_status==1)
								{
									tr.append("<td><span class='label label-success'>" + "Yes" + "</span></td>");
								}
								else
								{
									tr.append("<td><span class='label label-warning'>" + "No" + "</span></td>");
								}

								//Show "Edit" and "Delete" buttons
								tr.append("<td>" + "<button type='button' class='btn btn-warning' onClick='LoadItem2Edit("+data.lists[i].ca_id+")'>Edit</button>&nbsp;<button type='button' class='btn btn-danger' onClick='ConfirmDeleteItem("+data.lists[i].ca_id+")'>Delete</button>" + "</td>");
								
								$('#tblCategories').append(tr);
                            }

							//Initiate DataTable
							$('#tblCategories').dataTable({
								'info': false,
								'pageLength': 10,
								retrieve: true
							});
                            
                        }
                 });
            }

			//Load Category Details to form when "Edit" button clicked
			function LoadItem2Edit(CategoryId)
			{
				var data         =   {ca_id : CategoryId};

				//send ajax request
				$.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "category", action: 'search', data : data},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

							//Load response to form
							document.getElementById('txtCategoryId').value 		=	data.ca_id;
							document.getElementById('txtCategoryName').value 	=	data.ca_name;

							if(data.ca_supid==null)
							{
								document.getElementById('cmbSuperCategory').selectedIndex	=	0;
							}
							else
							{
								selectList('cmbSuperCategory',data.ca_supid);
							}

							document.getElementById('txtDescription').value 	=	data.ca_desc;
							selectList('cmbBrandStatus',data.ca_br_status);

							ScrollToElement('txtCategoryId');
                           
                        }
                 });			
			}

			//Clear form feilds
			function clearForm()
			{
				document.getElementById('txtCategoryId').value 				=	"";
				document.getElementById('txtCategoryName').value 			=	"";
				document.getElementById('cmbSuperCategory').selectedIndex	=	0;
				document.getElementById('txtDescription').value 			=	"";
				document.getElementById('cmbBrandStatus').selectedIndex		=	0;
			}

			//Clear validation error messages
			function clearErrorMessages()
			{
				document.getElementById('spnCategoryName').innerHTML 			=	"";
				document.getElementById('spnDescription').innerHTML 			=	"";
			}

			//Validate Form before submitting
			function validateForm()
			{

				try
				{
					//Clear error messages before validating
					clearErrorMessages();
					
					if(validateEmpty("txtCategoryName")==false)
					{
						throw 1000;
					}
					
					if(validateEmpty("txtDescription")==false)
					{
						throw 1001;
					}
					
					return true;
				}
				
				catch(err)
				{
					if(err==1000) //Empty Category Name
					{
						document.getElementById("spnCategoryName").innerHTML = "Category Name is Required !";	
						ScrollToElement("spnCategoryName");
					}
					
					if(err==1001) //Empty Description
					{
						document.getElementById("spnDescription").innerHTML = "Description is Required !";	
						ScrollToElement("spnDescription");
					}
					
					return false;
				}
			}

			//Show confirm box before deleting category
			function ConfirmDeleteItem(id)
			{
				ConfirmAction("Confirm Delete","Are you sure to delete this item ?", "Yes", "No", DeleteItem,[id]);
			}

			function DeleteItem(id)
			{
					var data         =   {ca_id : id};

					//Send Ajax Request
					$.ajax
					({
							type: 'POST',
							url: 'request_handle.php',
							data: { controller : "category", action: 'deleteCategory', data : data},
							success: function(response) 
							{
								var data	=	JSON.parse(response);
								
								//If Save Success
								if(data.success==true)
								{
									//Show Success Message
									showNotification(data.message,'warning');
									//Reload Super Categories
									loadSuperCategoryList();
									//Category display table reload
									displayCategoryList();
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
										<li class="active"><span>Categories</span></li>
									</ol>
									
									<h1>Item Categories <small>Setup Item Categories...</small></h1>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2>Add Category</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<form role="form">
												<div class="form-group">
													<label for="txtCategoryId">Category Id</label>
													<input type="text" class="form-control" id="txtCategoryId" placeholder="" disabled>
												</div>

												<div class="form-group">
													<label for="txtCategoryName">Category Name</label>
													<input type="text" class="form-control" id="txtCategoryName" placeholder="Enter category name">
													<span id="spnCategoryName" class="label label-danger"></span>
												</div>
                                                                                            
												<div class="form-group">
													<label>Super Category</label>
                                                    <select class="form-control" id="cmbSuperCategory" name="cmbSuperCategory">
                                                                                                                
													</select>
												</div>
                                                                                            
												<div class="form-group">
													<label for="txtDescription">Description</label>
													<textarea class="form-control" id="txtDescription" rows="3"></textarea>
													<span id="spnDescription" class="label label-danger"></span>
												</div>
												
												
												
												<div class="form-group">
													<label>Brand Status</label>
                                                    <select class="form-control" id="cmbBrandStatus">
                                                        <option value="1">Yes</option>
														<option value="0">No</option>
													</select>
												</div>
												
												<div class="form-group">
													<div class="pull-right">
                                                            <button type="button" class="btn btn-success" onclick="saveCategory()">Save</button>
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
											<h2 class="pull-left">Item Category List</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<div class="table-responsive">
                                                <table class="table table-responsive" id="tblCategories">
													<thead>
														<tr>
															<th class="text-center">Category Name</th>
															<th class="text-center">Super Category</th>
															<th class="text-center">Description</th>
															<th class="text-center">Brand Status</th>
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