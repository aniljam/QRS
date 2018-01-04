<div class="col-md-10">
	<div class="ui segment">
		<div class="ui pink ribbon label">Role Assignment per Category
		</div>

		<table class="ui table">
			<thead><tr>
				<th>User Name</th>
				<th>Role Description</th>
				<th>Assigned Category</th>
			</tr></thead>
			<tbody>
			<?php 
				global $db;
				$prms = Array();
				$seldb = $db->rawQuery("SELECT tbl_users.userid usID, fullname, tbl_category.catid cID,catdesc,roledesc FROM tbl_rolecategoryref
				 						INNER JOIN tbl_users ON tbl_rolecategoryref.`userid` = tbl_users.`userid`
										INNER JOIN tbl_category ON tbl_rolecategoryref.`catid` = tbl_category.`catid`
										INNER JOIN tbl_roles ON tbl_rolecategoryref.roleid = tbl_roles.roleid
										",$prms);
				foreach ($seldb as $key => $value) {
					
			 ?>
			 <tr>
			 <td><?php echo $value[fullname];?></td>
			 <td><?php echo $value[roledesc]; ?></td>
			 <td><?php echo $value[catdesc];?></td>
			 </tr>
			 <?php } ?>
			</tbody>
		</table>
	</div>
</div>