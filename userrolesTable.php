
<div class="col-md-12">

	<div class="ui segment">
		<div class="ui teal ribbon label pageLabel"><i class="fa fa-users"></i>&nbsp;&nbsp;
		User Role Table
		</div>
		<a href="modAddUser.php" data-position="left center" data-variation="mini" data-tooltip="Add User Role" class="circular tiny ui right floated icon teal basic button"><i class="add icon"></i></a>
			
				
								<script type="text/javascript">
                                    $(document).ready(function(){
                                        var table = $('#DispTable').DataTable({
                                            lengthChange: false,
                                            "order": [[ 0, "asc" ]]
                                        }); 
                                    });
                               </script>
<div class="ui basic segment" style="overflow-x: auto;">
		 								<?php if($_GET['action'] == "Success"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>User role was added successfully!</p>
                                        </div>
                                        <?php } ?>
                                        <?php if($_GET['action'] == "Failed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Adding of User Role was failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                                        <?php } ?>
                                        <?php if($_GET['action'] == "DelSuccess"){?>
                                        <div class="ui red message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>User Role Deleted!</p>
                                        </div>
                                        <?php } ?>
                                        <?php if($_GET['action'] == "UpdSuccess"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>User Role Updated!</p>
                                        </div>
                                        <?php } ?>
                                        <?php if($_GET['action'] == "UpdFailed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Updating to User Role Failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                                        <?php } ?>

		<table class="ui mini green table" id="DispTable">
			<thead><tr class="single line">
				<!--<th>Employee ID</th>-->
				<th>Name</th>
				<th>Role Name</th>
				<th>Remarks</th>
				<th>Created By</th>
				<th>Created Date</th>
				<th>Edited By</th>
				<th>Edited Date</th>
				<!--<th>Active</th>-->
				<th>&nbsp;&nbsp;</th>
				<!--<th>&nbsp;&nbsp;</th>-->
			</tr></thead>
			<tbody>
			<?php 
				global $db;
				$prms = Array();
				$seldb = $db->rawQuery("SELECT Tusers.userid IDuser, fullname,empid,roledesc,roleremarks,Tref.createdby CRby, 
										Tref.createddate CRdate, Tref.editedby EDby, Tref.editeddate EDdate, Tref.userrolestat URstat 
										FROM tbl_users Tusers
										LEFT JOIN tbl_userroles Tref ON Tusers.`userid` = Tref.`userid`
										LEFT JOIN tbl_roles Troles ON Tref.`roleid` = Troles.`roleid`
										WHERE Tref.userrolestat = 1",$prms);
				//echo $db->getLastQuery();
				foreach ($seldb as $key => $value) {
					/*if($value['URstat'] == 0){
						$trClass = "disabled";
					}
					else{
						$trClass = "";
					}*/
			 ?>
			 <tr >
			 <!--<td><?php //echo $value[empid]; ?></td>-->
			 <td><?php echo $value['fullname'];?></td>
			 <td><?php echo $value['roledesc'];?></td>
			 <td><?php echo $value['roleremarks']; ?></td>
			 <td><?php $crUser = getUser($value['CRby']);
			 			echo $crUser['nickname']; ?></td>
			 <td><?php echo $CRdate = ($value['CRdate']) ? date("M j, y, g:i a ",strtotime($value['CRdate'])): "";?></td>
			 <td><?php $edUser = getUser($value['EDby']);
			 			echo $edUser['nickname']; ?></td>
			 <td><?php echo $eddate = ($value['EDdate']) ? date("M j, y, g:i a ",strtotime($value['EDdate'])): "";?></td>
			 
			 <?php /*
			 <td><?php if($trClass != "disabled"){
			 	echo "<i class='large green checkmark icon'></i>";
			 	}
			 	 ?></td>*/ ?>
			 	 <?php //$empVal = base64_encode($value['empid']); ?>
			<td><a href="modEditUser.php?id=<?php echo $value['IDuser']; ?>" data-position="left center" data-variation="mini" data-tooltip="Edit Role" class="circular mini ui icon basic button"><i class="fa fa-pencil-square-o" ></i></a></td>
			<?php /*<td><a href="modDelete.php?id=<?php echo $value['IDuser']; ?>" data-position="left center" data-variation="mini" data-tooltip="Delete Role"><i class="fa fa-trash-o"></i></a></td>*/?>
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

                                $('#notif').delay(3000).slideUp(1000);


                            });
                            
                        </script>