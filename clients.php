<?php include('db_connect.php');?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css">
<div class="container-fluid">
	
	<div class="col-lg-12 mt-5">
		<div class="row">
			<!-- FORM Panel -->
			
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Clients</b>
						<span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add_client">
                                <i class="fa fa-plus"></i> New Client
                            </a>
                        </span>
					</div>
					<div class="card-body">
						<table id="example" class="display table table-bordered table-hover">
							<thead>
								<tr>
                                    <th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Email</th>
									<th class="text-center">Phone</th>
                                    <th class="text-center">Id No</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
                            <?php
                                $result = $conn->query("SELECT * FROM clients");
                                if ($result->num_rows > 0) {
                                    $count = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $count++; ?></td>
                                            <td><?php echo $row['full_name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['identification_number']; ?></td>
                                            <td><?php echo $row['gender']; ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-danger" href="#" onclick="editClient(<?php echo $row['id']; ?>)">Edit</a>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteClient(<?php echo $row['id']; ?>)">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No client found.</td></tr>";
                                }
                                ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin: unset;
		padding: unset;
		line-height: 1em;
	}
</style>
<script>
	$('#manage-client').on('reset',function(e){
		$('#msg').html('')
	})
	$('#manage-client').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_client',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Client already exist.</div>')
					end_load()
				}
			}
		})
	})
	$('.edit_client').click(function(){
		start_load()
		var cat = $('#manage-client')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='house_no']").val($(this).attr('data-house_no'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		end_load()
	})
	$('.delete_client').click(function(){
		_conf("Are you sure to delete this client?","delete_client",[$(this).attr('data-id')])
	})
	function deleteClient(id) {
        if (confirm("Are you sure you want to delete this building?")) {
            $.ajax({
                url: 'ajax.php?action=delete_client',
                method: 'POST',
                data: { id: id },
                success: function(resp) {
                    if (resp.includes('1')) {
                        alert('Client deleted successfully.');
                        location.reload(); // Refresh the page to see changes
                    } else {
                        alert('Failed to delete client.');
                    }
                }
            });
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script>
	new DataTable('#example', {
    layout: {
        topStart: {
            buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
        }
    }
});
</script><footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
   <p class="text-muted mb-1 mb-md-0">Copyright © 2024 <a href="https://www.alifhomesltd.com" target="_blank">Apartment Management System Software</a> - Design By Cliffton Afande</p>
   
</footer>