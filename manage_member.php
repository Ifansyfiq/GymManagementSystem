<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM members where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<form action="" id="manage-member">
		<div id="msg"></div>
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label">ID No.</label>
					<input type="number" name="member_id" class="form-control" value="<?php echo isset($member_id) ? $member_id:'' ?>" >
					<small><i>Please enter you 6 digit ID no. for future reference.</i></small>
				<br></div>
			</div>
		<div class="form-group">
			<div class="col-md-12">
				<label class="control-label">First Name</label>
				<input type="text" name="firstname" class="form-control" value="<?php echo isset($firstname) ? $firstname:'' ?>" required>
			<br></div>
			<div class="col-md-12">
				<label class="control-label">Middle Name</label>
				<input type="text" name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename:'' ?>">
			<br></div>
			<div class="col-md-12">
				<label class="control-label">Last Name</label>
				<input type="text" name="lastname" class="form-control" value="<?php echo isset($lastname) ? $lastname:'' ?>" required>
			<br></div>
			<div class="col-md-12">
				<label class="control-label">Email</label>
				<input type="email" name="email" class="form-control" value="<?php echo isset($email) ? $email:'' ?>" required>
			<br></div>
			<div class="col-md-12">
				<label class="control-label">Contact</label>
				<input type="text" name="contact" class="form-control" value="<?php echo isset($contact) ? $contact:'' ?>" required>
			<br></div>
			<div class="col-md-12">
				<label class="control-label">Gender</label>
				<select name="gender" required="" class="custom-select" id="">
					<option <?php echo isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male</option>
					<option <?php echo isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>Female</option>
				</select>
			</div><br>
			<div class="col-md-12">
				<label class="control-label">Address</label>
				<textarea name="address" class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
			</div>
		</div>
</div>
		
	</form>
</div>

<script>
	$('#manage-member').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_member',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}else if(resp == 2){
					$('#msg').html('<div class="alert alert-danger">ID No already existed.</div>')
					end_load();
				}
			}
		})
	})
</script>
