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

	<title>GoSwapIt - Item Models</title>
	
	<?php include ('includes/stylesheets.php') ?>
        
        <script type="text/javascript">
            
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
            
            function loadBrandList()
            {
                var ca_id	 =   document.getElementById('cmbCategory').value;
                
                var data = {ca_id : ca_id};
                
                //Send Ajax Request
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "brand", action: 'loadBrands', data:data},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);

                            //Clear all values first
                            $('#cmbBrand').empty();
                            //Append "None" item
                            $('#cmbBrand').append($('<option>').text("None").attr('value', ""));

                            //Insert item from the response
                            for(var i = 0; i < data.totalItems; i++)
                            {
                                var item = data.lists[i];
                                $('#cmbBrand').append($('<option>').text(item.br_name).attr('value', item.br_id));
                            }
                            
                        }
                 });
            }
            
            //Save Brand
            function saveModel()
            {
                //If form validated
                
                if(validateForm())
                {
                    
                        var md_id	 =   document.getElementById('txtModelId').value;
                        var md_name      =   document.getElementById('txtModelName').value;
                        var br_id     =   document.getElementById('cmbBrand').value;

                        var data         =   {md_id : md_id, md_name : md_name, br_id : br_id};

                        //Send Ajax Request
                        $.ajax
                        ({
                                type: 'POST',
                                url: 'request_handle.php',
                                data: { controller : "model", action: 'saveModel', data : data},
                                success: function(response) 
                                {
                                        var data	=	JSON.parse(response);

                                        //If Save Success
                                        if(data.success==true)
                                        {

                                                //Show Success Message
                                                showNotification(data.message,'notice');
                                                //Reload Super Categories
                                                loadBrandList();
                                                //Category display table reload
                                                displayModelList();
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
            function displayModelList()
            {
		//Send Ajax request
                $.ajax
                ({
                        type: 'POST',
                        url: 'request_handle.php',
                        data: { controller : "model", action: 'displayModels'},
                        success: function(response) 
                        {
                            var data	=	JSON.parse(response);
 
                            //Remove all records first
                            $("#tblModels > tbody:last").children().remove();

                            //Display new records from response
                            for(var i = 0; i < data.totalItems; i++)
                            {
                                tr = $('<tr/>');
                                tr.append("<td>" + data.lists[i].md_name + "</td>"); //Brand Name
                                tr.append("<td>" + data.lists[i].br_id.br_name + "</td>"); //Category

                                //Show "Edit" and "Delete" buttons
                                tr.append("<td>" + "<button type='button' class='btn btn-warning' onClick='LoadItem2Edit("+data.lists[i].md_id+")'>Edit</button>&nbsp;<button type='button' class='btn btn-danger' onClick='ConfirmDeleteItem("+data.lists[i].md_id+")'>Delete</button>" + "</td>");

                                $('#tblModels').append(tr);
                            }
                            
                            //Initiate DataTable
                            $('#tblModels').dataTable({
                                    'info': false,
                                    'pageLength': 10,
                                    retrieve: true
                            });
                        }
                 });
            }

            //Load Brand Details to form when "Edit" button clicked
            function LoadItem2Edit(ModelId)
            {
                    var data         =   {md_id : ModelId};

                    //send ajax request
                    $.ajax
                    ({
                            type: 'POST',
                            url: 'request_handle.php',
                            data: { controller : "model", action: 'search', data : data},
                            success: function(response) 
                            {
                                var data	=	JSON.parse(response);

                                //Load response to form
                                document.getElementById('txtModelId').value 		=	data.md_id;
                                document.getElementById('txtModelName').value           =	data.md_name;

                                if(data.br_id==null)
                                {
                                        document.getElementById('cmbBrand').selectedIndex	=	0;
                                }
                                else
                                {
                                        selectList('cmbCategory',data.br_id.ca_id.ca_id);
                                        loadBrandList();
                                        setTimeout(function(){ selectList('cmbBrand',data.br_id); }, 3000);
                                        
                                }

                                ScrollToElement('txtModelId');

                            }
                     });			
            }

            //Clear form feilds
            function clearForm()
            { 
                    document.getElementById('txtModelId').value 		=	"";
                    document.getElementById('txtModelName').value               =	"";
                    document.getElementById('cmbCategory').selectedIndex        =	0;
                    $('#cmbBrand').empty();
            }

            //Clear validation error messages
            function clearErrorMessages()
            {
                    document.getElementById('spnModelName').innerHTML 			=	"";
                    document.getElementById('spnBrand').innerHTML 			=	"";
                    document.getElementById('spnCategory').innerHTML 			=	"";
            }

            //Validate Form before submitting
            function validateForm()
            {

                    try
                    {
                            //Clear error messages before validating
                            clearErrorMessages();
                            
                            if(validateList("cmbCategory")==false)
                            {
                                    throw 1001;
                            }

                            if(validateList("cmbBrand")==false)
                            {
                                    throw 1001;
                            }
                            
                            if(validateEmpty("txtModelName")==false)
                            {
                                    throw 1000;
                            }

                            return true;
                    }

                    catch(err)
                    {
                            if(err==1000) //Empty Brand Name
                            {
                                    document.getElementById("spnModelName").innerHTML = "Model Name is Required !";	
                                    ScrollToElement("spnModelName");

                            }

                            if(err==1001) //Empty Category
                            {
                                    document.getElementById("spnBrand").innerHTML = "Brand is Required !";	
                                    ScrollToElement("spnBrand");
                            }
                            
                            if(err==1002) //Empty Category
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
                var data         =   {md_id : id};

                //Send Ajax Request
                $.ajax
                ({
                    type: 'POST',
                    url: 'request_handle.php',
                    data: { controller : "model", action: 'deleteModel', data : data},
                    success: function(response) 
                    {
                            var data	=	JSON.parse(response);

                            //If Save Success
                            if(data.success==true)
                            {
                                    //Show Success Message
                                    showNotification(data.message,'warning');
                                    //Reload Super Categories
                                    loadBrandList();
                                    //Brand display table reload
                                    displayModelList();
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
<body onload="loadCategoryList();displayModelList();">
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
										<li class="active"><span>Models</span></li>
									</ol>
									
									<h1>Item Models <small>Setup Item Models...</small></h1>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="main-box">
										<header class="main-box-header clearfix">
											<h2>Add Model</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<form role="form">
												<div class="form-group">
													<label for="txtModelId">Model Id</label>
													<input type="text" class="form-control" id="txtModelId" placeholder="" disabled>
												</div>
                                                                                            
                                                                                                <div class="form-group">
													<label>Category</label>
                                                                                                        <select class="form-control" id="cmbCategory" name="cmbCategory" onchange="loadBrandList()">
                                                                                                                
													</select>
                                                                                                        <span id="spnCategory" class="label label-danger"></span>
                                                                                                        
												</div>
                                                                                            
                                                                                                <div class="form-group">
													<label>Brand</label>
                                                                                                        <select class="form-control" id="cmbBrand" name="cmbBrand">
                                                                                                                
													</select>
                                                                                                        <span id="spnBrand" class="label label-danger"></span>
                                                                                                        
												</div>

												<div class="form-group">
													<label for="txtModelName">Model Name</label>
													<input type="text" class="form-control" id="txtModelName" placeholder="Enter  name">
													<span id="spnModelName" class="label label-danger"></span>
												</div>
                                                                                            
												
                                                                                            
												<div class="form-group">
													<div class="pull-right">
                                                            <button type="button" class="btn btn-success" onclick="saveModel()">Save</button>
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
											<h2 class="pull-left">Item Model List</h2>
										</header>
										
										<div class="main-box-body clearfix">
											<div class="table-responsive">
                                                <table class="table table-responsive" id="tblModels">
													<thead>
														<tr>
															<th class="text-center">Model Name</th>
															<th class="text-center">Brand</th>
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