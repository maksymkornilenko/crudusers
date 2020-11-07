<!DOCTYPE html>
<html>
	<head>
		<title>REST API CRUD</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div align="right" style="margin-bottom:5px;">
				<button type="button" name="add_button" id="add_button" class="btn btn-success btn-xs">Add</button>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nick</th>
							<th>Password</th>
							<th>Role</th>
							<th>AdditionalData</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</body>
</html>

<div id="apicrudModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="api_crud_form">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Add Data</h4>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
			        	<label>Enter Nick</label>
			        	<input type="text" name="nick" id="nick" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label>Enter Password</label>
			        	<input type="text" name="password" id="password" class="form-control" />
			        </div>
                    <div class="form-group">
			        	<label>Enter Role;</label>
                        <select type="text" name="role_id" id="role_id" class="form-control"></select>
			        </div>
                    <div class="form-group">
			        	<label>Enter Additional</label>
                        <textarea name="additional_data" id="additional_data" class="form-control"></textarea>
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<input type="hidden" name="hidden_id" id="hidden_id" />
			    	<input type="hidden" name="action" id="action" value="insert" />
			    	<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Insert" />
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      		</div>
			</form>
		</div>
  	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){

	fetch_data();
    options();

	function fetch_data()
	{
		$.ajax({
			url:"list.php",
			success:function(data)
			{
                let output = '';
                if(data)
                {
                    $.each(data, function (index, value) {
                            output += '<tr>' +
                                '<td>'+value['nick']+'</td>' +
                                '<td>'+value['password']+'</td>' +
                                '<td>'+value['name']+'</td>' +
                                '<td>'+value['additional_data']+'</td>' +
                                '<td><button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'+value['id']+'">Edit</button></td>' +
                                '<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'+value['id']+'">Delete</button></td>' +
                                '</tr>';
                    });

                } else {
                    output += '<tr><td colspan="4" align="center">No Data Found</td></tr>';
                }
				$('tbody').html(output);
			}
		})
	}
	function options()
	{
		$.ajax({
			url:"options.php",
			success:function(data)
			{
				$('#role_id').html(data);
			}
		})
	}

	$('#add_button').click(function(){
		$('#action').val('create');
		$('#button_action').val('Create');
		$('.modal-title').text('Add Data');
		$('#apicrudModal').modal('show');
	});

	$('#api_crud_form').on('submit', function(event){
		event.preventDefault();
		if($('#nick').val() == '')
		{
			alert("Enter nick");
		}
		else if($('#password').val() == '')
		{
			alert("Enter password");
		}else if($('#role_id').val() == '')
		{
			alert("Enter role");
		}
		else
		{
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					fetch_data();
					$('#api_crud_form')[0].reset();
					$('#apicrudModal').modal('hide');
                    alert(data.status+' '+data.msg);
				}
			});
		}
	});

	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'get';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#hidden_id').val(id);
				$('#nick').val(data.nick);
				$('#password').val(data.password);
				$('#role_id').val(data.role_id);
				$('#additional_data').val(data.additional_data);
				$('#action').val('update');
				$('#button_action').val('Update');
				$('.modal-title').text('Edit Data');
				$('#apicrudModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = 'delete';
		if(confirm("Are you sure you want to remove this data using PHP API?"))
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data)
				{
					fetch_data();
					alert("Data Deleted");
				}
			});
		}
	});

});
</script>