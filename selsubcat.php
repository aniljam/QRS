<?php require_once('dbfunc/panksyons.php'); ?>

<?php 
global $db;

$q = Array($_GET['q']);
$selSubCat = $db ->rawQuery("SELECT * FROM tbl_subcategory 
							WHERE catid = ? AND subcatstatus = 1",$q);

?>
			<div class="field">
                <label>Sub-Category</label>
                <select class="ui dropdown" name="transsubcat" id="transsubcat">
                    <option value="" selected disabled></option>
                    	<?php foreach ($selSubCat as $key => $value) {
                    	 ?>
                    	 <option value="<?php echo $value['subcatid']; ?>"><?php echo $value['subcatdesc']; ?></option>
                    	 <?php } ?>
                </select>
            </div>



