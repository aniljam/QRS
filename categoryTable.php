
<div class="col-md-12">
	<div class="ui segment">
<script type="text/javascript">
$(document).ready(function() {
	var table = $('#DispTable').DataTable( {
	lengthChange: false
	}); 
});
</script>

		<div class="ui pink ribbon label">Category Table
		</div>
		<button class="mini circular ui right floated pink icon button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</button>
		<div class="ui basic segment" style="overflow-x: auto;">
		<table class="ui mini green table table-responsive" id="DispTable">
			<thead><tr class="single line">
				<th>Category Name</th>
				<th>Sub-Category</th>
				<th>Assigned HR Specialist</th>
				<th>Created By</th>
				<th>Created Date</th>
				<!--<th>Edited By</th>
				<th>Edited Date</th>-->
				<th>Active</th>
				<th></th>

			</tr></thead>
			<?php 
			global $db;
			$db->join('tbl_users tCreate','tCat.createdby = tCreate.userid','LEFT');
			$db->join('tbl_users tEdit','tCat.editedby = tEdit.userid','LEFT');
			$db->join('tbl_rolecategoryref tRC','tCat.catid = tRC.catid','LEFT');
			$db->join('tbl_users tAss','tRC.userid = tAss.userid','LEFT');
			$selCatData = $db->get("tbl_category tCat",null,"tCat.catid,tCat.catdesc,tCreate.fullname AS CrBy, tCreate.nickname AS CrByNickName,tCat.createddate dateCreate,tEdit.fullname AS EdBy,tCat.editeddate AS dateEdit, tAss.fullname AssTo"); 
			//echo $db->getLastQuery();
			 ?>
			<tbody>
			<?php foreach ($selCatData as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['catdesc']; ?></td>
				<td>
				<?php 
					viewSubCat($value['catid']);
				 ?></td>
				<td><?php echo $Ass = ($value['AssTo']) ? ($value['AssTo']) : ""; ?></td>
				<td><?php echo $cBy = ($value['CrByNickName']) ? ($value['CrByNickName']) : ""; ?></td>
				<td><?php echo $cDate = ($value['dateCreate']) ? date("M j, y, g:i a ",strtotime($value['dateCreate'])): ""; ?></td>
				<?php /*<td><?php echo $eBy = ($value['EdBy']) ? ($value['EdBy']) : "";?></td>
				<td><?php echo $eDate = ($value['dateEdit']) ? date("M j, y, g:i a ",strtotime($value['dateEdit'])): ""; ?></td>*/?>
				<td><a href="#"><i class="large green checkmark icon"></i></a></td>
				<td><a href="modCategory.php?id=<?php echo $value['catid']; ?>"><i class="fa fa-pencil-square-o"></i></a></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
		</div>

	</div>
</div>