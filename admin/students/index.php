<style>
    .img-thumb-path{
        width:100px;
        height:80px;
        object-fit:scale-down;
        object-position:center center;
    }
</style>
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">List of students</h3>
		<div class="card-tools">
			<a href="./?page=students/manage_student" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Add New Student</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-bordered table-hover table-striped">
				<colgroup>
					<col width="7%">
					<col width="9%">
					<col width="25%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr class="bg-gradient-dark text-light">
						<th class="text-center">#</th>
						<th class="text-center">Roll</th>
						<th class="text-center">Name</th>
						<th class="text-center">Registration number</th>
						<th class="text-center">Status</th>
						<th class="text-center">Date Created</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT *,concat(firstname,' ',middlename,' ',lastname) as fullname from `student_list` order by concat(firstname,' ',middlename,' ',lastname) asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><p class="m-0 truncate-1"><?php echo $row['roll'] ?></p></td>
							<td class="text-center"><a href="./?page=students/view_student&id=<?= $row['id'] ?>" class="btn"><?php echo $row['fullname'] ?></a></td>
							<td class="text-center"><p class="m-0 truncate-1"><?php echo $row['reg_no'] ?></p></td>
							<td class="text-center">
								<?php 
									switch ($row['status']){
										case 0:
											echo '<span class="rounded-pill badge badge-danger bg-gradient-danger px-3">Inactive</span>';
											break;
										case 1:
											echo '<span class="rounded-pill badge badge-success bg-gradient-success px-3">Active</span>';
											break;
									}
								?>
							</td>
							<td class="text-center"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.table td, .table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_student($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_student",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>