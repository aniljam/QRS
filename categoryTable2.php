
<div class="col-md-12">
	<div class="ui segment">
<script type="text/javascript">
$(document).ready(function() {
	var table = $('#DispTable').DataTable( {
	lengthChange: false
	}); 
});
</script>

		<div class="ui teal ribbon label pageLabel"><i class="fa fa-keyboard-o"></i>&nbsp;&nbsp;Category Table
		</div>
		<?php /*<a href="modAddCat.php">
		<button class="mini circular ui right floated pink icon button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</button>
		</a>*/?>
			
		<div class="ui basic segment" style="overflow-x: auto;">
				<?php include('actionMessage.php'); ?>
		<table class="ui mini celled structured green table table-responsive" id="DispTable">
			<thead><tr class="single line">
				<th>Category Name <a href="modAddCat.php" data-position="left center" data-variation="mini" data-tooltip="Add Category" class="circular tiny ui right floated icon teal basic button"><i class="add icon"></i></a></th>
				<th>Sub-Category</th>
				<th>Assigned HR Specialist</th>
				<th>Active</th>
				<th></th>

			</tr></thead>
			<?php 
			global $db;
			$db->where('catstatus',1);
			$selCatData = $db->get("tbl_category"); 
			//echo $db->getLastQuery();
			 ?>
			<tbody>
			<?php foreach ($selCatData as $key => $value) {
			?>
			<tr>
				<?php $cntSC = getTotSubCatCount($value['catid']); ?>
					
				<td rowspan="<?php echo $cntSC; ?>">
				<?php echo $value['catdesc']; ?>
				
					
					<a href="modAddSubCat.php?id=<?php echo $value['catid']; ?>" data-position="top center" data-variation="mini" data-tooltip="Add Subcategory" class="circular mini ui right floated icon basic button"><i class="add icon"></i></a>
					<a href="modEditCat.php?id=<?php echo $value['catid']; ?>" data-position="top center" data-variation="mini" data-tooltip="Edit Category" class="circular mini ui right floated icon basic button"><i class="edit icon"></i></a>
				
				</td>
				<?php viewSubCatNAssigned($value['catid']); ?>
				
			</tr>
			<?php } ?>
			</tbody>
		</table>
		</div>

	</div>
</div>

<script type="text/javascript">
                            $(document).ready(function(){
                                $('#notif')
                                  .on('click', function() {
                                    $(this)
                                      .closest('.message')
                                      .transition('fade')
                                    ;
                                    window.location='home.php';
                                  })
                                ;

                                $('#notif').delay(3000).slideUp	(1000);

                            });
                            
                        </script>