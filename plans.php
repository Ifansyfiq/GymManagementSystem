<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- Form Panel -->
			<div class="col-md-4">
			<form action="" id="manage-plan">
				<div class="card">
					<div class="card-header">
						    Plan Activation Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Duration of Plan (months)</label>
								<input type="number" type="integer" class="form-control" min="1" name="plan" required >
							</div>
							<div class="form-group">
								<label class="control-label">Purchase Amount</label>
								<input type="number" type="integer" class="form-control" min="1" name="amount" required>
							</div>
							
					</div>
							
					<div class="card-header">
						<div class="row">
							<div class="col-md-12">
							<button class="btn btn-md btn-secondary col-sm-3 offset-md-3" type="button" onclick="_reset()"> Reset</button>
							<button class="btn btn-md btn-success col-sm-3 offset"> Save</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- Form Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Plan List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<colgroup>
								<col width="5%">
								<col width="25%">
								<col width="20%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">No </th>
									<th class="text-center">Plan</th>
									<th class="text-center">Amount</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$plan = $conn->query("SELECT * FROM plans order by id asc");
								while($row=$plan->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<p><b><?php echo $row['plan'] ?></b> month/s</p>
									</td>
									<td class="text-center">
										<b><?php echo number_format($row['amount']) ?></b>
									</td>
									<td class="text-center">
										<button class="btn btn-md btn-outline-success edit_plan" type="button" data-id="<?php echo $row['id'] ?>" data-plan="<?php echo $row['plan'] 
										 ?>" data-amount="<?php echo $row['amount'] ?>" >Edit</button>
										<button class="btn btn-md btn-outline-danger delete_plan" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
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
</style>
<script>
	function _reset(){
		$('#manage-plan').get(0).reset()
		$('#manage-plan input,#manage-plan textarea').val('')
	}
	$('#manage-plan').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_plan',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_plan').click(function(){
		start_load()
		var cat = $('#manage-plan')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='plan']").val($(this).attr('data-plan'))
		cat.find("[name='amount']").val($(this).attr('data-amount'))
		end_load()
	})
	$('.delete_plan').click(function(){
		_conf("Are you sure to delete this plan?","delete_plan",[$(this).attr('data-id')])
	})
	function delete_plan($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_plan',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>