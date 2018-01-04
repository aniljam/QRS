<?php if (isset($_GET['id'])) {
	$userid = $_GET['id'];
} 

if($userid){
	global $db;

	$db->where('tbl_users.userid',$userid);
	$selUser = $db->getOne("tbl_users");
}

?>
<div class="col-md-10">

	<div class="ui segment">
		<div class="ui pink ribbon label" >User Role</div>
		<form class="ui tiny form segment">
		<div class="ui horizontal divider">User Profile</div>
			<div class="inline field">
			 <label>Employee ID</label>
			 <input type="text" name="EmpID" id="EmpID" value="<?php echo $selUser['empid']; ?>">
			</div>
			<div class="three fields">
				<div class="field">
					<label>First Name</label>
					<input type="text" name="Fname" id="Fname" value="<?php echo $selUser['firstname']; ?>">
				</div>
				<div class="field">
					<label>Last Name</label>
					<input type="text" name="Lname" id="Lname" value="<?php echo $selUser['lastname']; ?>">
				</div>
				<div class="field">
					<label>Middle</label>
				<input type="text" name="Mname" id="Mname" value="<?php echo $selUser['middlename']; ?>">
				</div>
			</div>
			<div class="three fields">
				<div class="field">
					<label>Nick Name</label>
					<input type="text" name="nickname" id="nickname" value="<?php echo $selUser['nickname']; ?>">
				</div>
				<div class="field">
					<label>Email Address</label>
					<input type="text" name="emailadd" id="emailadd" value="<?php echo $selUser['email']; ?>">
				</div>
				<div class="field">
					<label>Contact</label>
					<input type="text" name="contact" id="contact" value="<?php echo $selUser['contact']; ?>">
				</div>
			</div>
			<table class="ui padded table">
				<thead><tr><th colspan="2">My Roles</th></tr></thead>
				<tbody>
					<?php 
						if($selUser['userid']){
							global $db;

							$db->where('tbl_userroles.userid',$selUser['userid']);
							$db->join("tbl_roles","tbl_userroles.roleid = tbl_roles.roleid","INNER");

							$selRole = $db->WithTotalCount()->get("tbl_userroles",null,"tbl_userroles.userroleid URid, tbl_roles.roledesc RName");
						}
						//echo $db->getLastQuery();
						if($db->totalCount != 0){
					 		foreach ($selRole as $key => $value) {
					 		
					 ?>
					 <tr><td><?php echo $value['RName']; ?></td></tr>
					 <?php 
					}
					 }else{ ?>
				<tr>
				<td>No Roles</td>
				<td></td>
				</tr><?php } ?>
				</tbody>
			</table>
		</form>
	</div>
</div>