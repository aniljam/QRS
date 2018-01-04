<?php require_once('dbfunc/panksyons.php'); ?>

<?php 
$uID = $_GET['q'];

if($uID){
	global $db;

	$db->where('tbl_assignedref.userid',$uID);
	$selU = $db->getOne('tbl_assignedref');
	if($selU){
		$procDel = "Error Deleting: There is Assigned Category in User Role you wish to Delete";
		echo json_encode($procDel);
	}else{
		$db->where('tbl_users.userid', $uID);
		$DelUser = $db->delete('tbl_users');
		$db->where('tbl_userroles.userid' ,$uID);
		$DelUserRole = $db->delete('tbl_userroles');

		$procDel = "Deleted Successful";
		echo json_encode($procDel);
	}

	

	/*reserved this for logging of deletion of roles*/
	/*if($db->getLastErrno() === 0){
		header('location:userroles.php?action=Success');
	}else{
		$errMes = $db->getLastError();
		header('location:userroles.php?action=Failed&err='.$errMes);
	}*/
}



?>