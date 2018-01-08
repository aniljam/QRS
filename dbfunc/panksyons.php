<?php
include 'mysqlidb/MysqliDb.php';
require_once('mailer/SendMailer.php');
include_once '../../../dbconn_portal.php';
include_once '../../../dbfunc_portal.php';

$db = new MysqliDb('localhost','genyo','diwa2012','db_qrs_test');
$dbportal = odbc_connect("Driver={SQL Server};Server=192.16.10.104;DATABASE=diwaportal;", "diwaportaluser", "diwaportaluser2013");
//$dbportal = odbc_connect("Driver={SQL Server};Server=ANIL\SQLEXPRESS;DATABASE=diwaportal;", "sa", "@bbelazon1991");

date_default_timezone_set('Asia/Manila');
$datenow = date("Y-m-d G:i:s");/*datetime format for mysql datetime datatype*/
$IDuserLogged = ($_SESSION['uID']) ? ($_SESSION['uID']) : ($_SESSION['portal_loguser']);


#############################################################################################################################
/**
for selection of Diwaportal User
* 
*/
class GetUserDportal
{
	public $u_empID, $u_FN, $u_LN, $u_MN, $u_gender, $u_FullName, $u_email, $u_Roles, $dept, $Dfullname;

	function getActiveUser($empid)
	{
		global $dbportal;
		$qry = "SELECT * FROM Employee_reference INNER JOIN users ON Employee_reference.EmployeeID = users.emp_id WHERE Employee_reference.EmployeeID = '".$empid."' AND AOI = 'ACTIVE' AND DateResigned IS NULL";

		$res = odbc_exec($dbportal, $qry);
		$u_Arr = odbc_fetch_array($res);
		//print_r($u_Arr);
		
			$this -> u_empID = $u_Arr['EmployeeID'];
			$this -> u_FN = $u_Arr['FName'];
			$this -> u_LN = $u_Arr['LName'];
			$this -> u_MN = $u_Arr['MName'];
			$this -> u_gender = $u_Arr['Gender'];
			$this -> u_FullName = $u_Arr['Full Name'];
			$this -> u_email = $u_Arr['emp_email'];
			$this -> dept = $u_Arr['Department Number'];
			$this -> Dfullname = $u_Arr['Full Name'];
			$this -> u_gender = $u_Arr['Gender'];
	}

	function getMyDPortalRole($empid)
	{
		global $dbportal;
		
		if($empid)
		{
			$sqlQ = "SELECT * FROM user_roles WHERE [emp_id] = '".$empid."' ORDER BY [rowidx] ASC";
			$rs = odbc_exec($dbportal, $sqlQ);
			$roleArr = Array();
			while ($row = odbc_fetch_array($rs)) {
				array_push($roleArr, $row['role_id']);		
			}

			$this -> u_Roles = $roleArr;
		}
	}
}
	/*test function for checking of diwaportal role using array as 2nd parameters(ref: diwaportal chk_role function)*/
	function chk_DPortalrole($empid, $roleid) 
	{
	global $dbportal;
		if($roleid){
			$rIDs = implode(",", $roleid);
		}

		$query = "SELECT * FROM user_roles WHERE emp_id = '" . $empid . "' AND role_id IN (" . $rIDs . ");";
		$resultfunc = odbc_exec($dbportal, $query);
		
		$returnval = False;
		while(odbc_fetch_row($resultfunc)) { 
			$returnval = True;
		}
		
		return $returnval;
		//return $query;
	}

	/*for other function usage -- returns associative array of diwaportal user info*/
	function getDPortalUser($empid)
	{
		global $dbportal;

		if($empid){
			$q = "SELECT * FROM Employee_reference INNER JOIN users ON Employee_reference.[EmployeeID] = users.[emp_id] WHERE Employee_reference.[EmployeeID] = '".$empid."'";

			$res = odbc_exec($dbportal, $q);
			$u_arr = odbc_fetch_array($res);

			return $u_arr;
		}

	}

#############################################################################################################################

class LoggedAccount{

		public $uID, $Pname, $QFName, $QLName, $QMName, $fullname, $Dept, $contact, $email, $empid, $roledesc, $roleid, $userstatus, $Ugen, $QRarrayID, $QRarray, $Uavatar;
			
		function getaccountuser($empid){
				global $db;
				$prm = Array($empid);

				$seluser = $db->rawQuery("SELECT tbl_users.userid AS uID,tbl_users.gender AS Ugen,tbl_roles.roleid AS 									rID,nickname,firstname,lastname,middlename,fullname,email,empid,contact,deptid,
									roledesc,userstatus,avatar
									FROM tbl_users 
									LEFT JOIN tbl_userroles ON tbl_users.userid = tbl_userroles.userid
									LEFT JOIN tbl_roles ON tbl_userroles.roleid = tbl_roles.roleid
									WHERE tbl_users.empid = ?",$prm);

					foreach ($seluser as $key => $value) {
						$this -> uID = $value['uID'];
						$this -> Pname = $value['nickname'];
						$this -> fullname = $value['fullname'];
						$this -> QFName = $value['firstname'];
						$this -> QLName = $value['lastname'];
						$this -> QMName = $value['middlename'];
						$this -> email = $value['email'];
						$this -> empid = $value['empid'];
						$this -> contact = $value['contact'];
						$this -> Dept = $value['deptid'];
						$this -> roledesc = $value['roledesc'];
						$this -> roleid = $value['rID'];
						$this -> userstatus = $value['userstatus'];
						$this -> Ugen = $value['Ugen'];
						$this -> Uavatar = $value['avatar'];
					}
			}

			function getActiveRole($empid){

				if($empid){
				global $db;
					$db->where('tbl_users.empid',$empid);
					//$db->where('tbl_userroles.userrolestat != 0');
					$db->join('tbl_userroles','tbl_users.`userid` = tbl_userroles.`userid`','LEFT');
					$db->join('tbl_roles','tbl_userroles.`roleid` = tbl_roles.`roleid`','LEFT');

					$sel = $db->get('tbl_users',null,'tbl_users.userid userID, tbl_userroles.roleid userRID, tbl_roles.roledesc userRName, tbl_userroles.userrolestat userRStat');
					$rArray = Array();
					$rArrayID = Array();
						foreach ($sel as $key => $value) {
							array_push($rArrayID, $value['userRID']);
							array_push($rArray, $value['userRName']);
						}

						$rString = implode("__", $rArray);
						$rStringID = implode("__", $rArrayID);

					$this -> QRarray = $rString;
					$this -> QRarrayID = $rStringID;
				}

			}

		}
#############################################################################################################################
class SelTrans{

	public $trnsid, $trnsDT, $trnsStatDesc, $trnsCurrentStat, $trnsStatRem, $trnsType, $trnsCat, 
		   $trnsCatID, $trnsDesc, $trnsSubCat, $trnsCreatedByID, $datecommittedFr, $datecommittedTo, 
		   $date_finished, $trnsAssignToID, $trnsAssignToName, $trnsReassignedID, $trnsReassignedName;

	function getTransactions($QRSid){
		global $db;
		$prms = Array($QRSid);

		$seltr = $db->rawQuery("SELECT Ttrans.transid,Ttrans.transdatetime,Ttrans.transcat,Ttrans.transsubcat,
								Ttrans.transstat,Ttrans.transdesc,Ttrans.datecommitted_from,Ttrans.datecommitted_to,
								Ttrans.datefinished, Ttrans.transby, Ttrans.transassignto AssignID, 
								Ttrans.relativeid ReassignedID, tbl_status.statdesc, 
								tbl_status.statremarks, tbl_servicetype.servtypedesc, tbl_category.catdesc, tbl_subcategory.subcatdesc,
								Tassign.fullname AssignName, Treassign.fullname ReassignedName
								FROM tbl_transactions Ttrans
								LEFT JOIN tbl_status ON Ttrans.`transstat` = tbl_status.`statid`
								LEFT JOIN tbl_servicetype ON Ttrans.`transservtypeid` = tbl_servicetype.`servtypeid`
								LEFT JOIN tbl_category ON Ttrans.`transcat` = tbl_category.`catid`
								LEFT JOIN tbl_subcategory ON Ttrans.`transsubcat` = tbl_subcategory.`subcatid`
								LEFT JOIN tbl_users Tassign ON Ttrans.`transassignto` = Tassign.`userid`
								LEFT JOIN tbl_users Treassign ON Ttrans.`relativeid` = Treassign.`userid`
								WHERE Ttrans.`transid` = ?",$prms);


			foreach ($seltr as $key => $value) 
			{
				$this -> trnsid = $value['transid'];
				$this -> trnsDT = $value['transdatetime'];
				$this -> trnsType = $value['servtypedesc'];
				$this -> trnsCurrentStat = $value['transstat'];
				$this -> trnsStatDesc = $value['statdesc'];
				$this -> trnsCat = $value['catdesc'];
				$this -> trnsCatID = $value['transcat'];
				$this -> trnsDesc = $value['transdesc'];
				$this -> trnsSubCat = $value['subcatdesc'];
				$this -> trnsCreatedByID = $value['transby'];
				$this -> trnsStatRem = $value['statremarks'];
				$this -> datecommittedFr = $value['datecommitted_from'];
				$this -> datecommittedTo = $value['datecommitted_to'];
				$this -> date_finished = $value['datefinished'];
				$this -> trnsAssignToID = $value['AssignID'];
				$this -> trnsAssignToName = $value['AssignName'];
				$this -> trnsReassignedID = $value['ReassignedID'];
				$this -> trnsReassignedName = $value['ReassignedName'];
			}
	}
}
#######################################################################################################################################
/**
* for adding User Roles
*/
function addUserRole(){
	global $db, $datenow, $IDuserLogged;

	$uEmpID = $_POST['EmpNumber'];
	$uLName = $_POST['LName'];
	$uFName = $_POST['FName'];
	$uMName = $_POST['MName'];
	$uFullname = $uFName." ".$uMName." ".$uLName;
	$uNickName = $_POST['PName'];
	$uGender = $_POST['Ugender'];
	$uEmail = $_POST['emailadd'];
	$uDept = $_POST['DeptName'];
	$uContact = $_POST['CNumber'];
	
	$uRoleID = $_POST['rolename'];

	$insUserArr = Array('firstname'=>$uFName, 'lastname'=>$uLName, 'middlename'=> $uMName, 'nickname'=>$uNickName, 'empid'=>$uEmpID, 'deptid'=>$uDept, 'contact'=>$uContact, 'email'=>$uEmail, 'gender'=>$uGender, 'fullname'=>$uFullname,'createdby'=>$IDuserLogged,'createddate'=>$datenow);

	$ins = $db -> insert('tbl_users', $insUserArr);
	
	$insUserID = $db->getInsertId();

				if ($db->getLastErrno() === 0){
					$insUserRoleArr = Array('userid'=>$insUserID, 'roleid'=> $uRoleID, 'userrolestat'=> 1,'createdby'=>$IDuserLogged,'createddate'=>$datenow);
					$insR = $db->insert('tbl_userroles',$insUserRoleArr);
					
					header('location:userroles.php?action=Success');

				}
		    	else{
		    		$errMes = $db->getLastError();
		    		header('location:userroles.php?action=Failed&err='.$errMes);
		    	}

}

/*bukod sa kanya, wla pa akong maisip*/
function setupRole($action){
	if($action){
		global $db;

		if($action == "add"){

		}
		elseif($action == "edit"){

		}
	}
}

#################################################################################################################################################################
/*Return value Array of ID Roles*/ 
function getMyRoles($empid)
{
	if($empid){
	global $db;
	$db->where("tbl_users.empid",$empid);
	$db->join("tbl_users","tbl_userroles.userid = tbl_users.userid","LEFT");
	$db->join("tbl_roles","tbl_userroles.roleid = tbl_roles.roleid","LEFT");

	$selRoles = $db->get("tbl_userroles");
	$roleArr = Array();
	foreach ($selRoles as $key => $value)
		{
			if($value['userrolestat'] != 0)
			{
			array_push($roleArr, $value['roleid']);
			}
		}
	}
	//$roleStr = implode(", ", $roleArr);
	return $roleArr;
}
/*For Displaying of Roles Description inside HR-QRS DB --
 return string*/
function getHRRoles($id){
	global $db;
	if($id){
		$db->where("tbl_users.userid",$id);
		$db->join("tbl_users","tbl_userroles.userid = tbl_users.userid","LEFT");
		$db->join("tbl_roles","tbl_userroles.roleid = tbl_roles.roleid","LEFT");

		$sel = $db -> get("tbl_userroles");
		$roleArr = Array();
		foreach ($sel as $key => $value) {
			array_push($roleArr, $value['roledesc']);
		}

		$strRole = implode(" | ", $roleArr);

		return $strRole;
	}
}

function editUserRoles($id, $usRoleID){

	if ($id) {
	
	global $db, $datenow, $IDuserLogged;
		

      $UsDataArr = Array('empid'=>$_POST['EmpNumber'],'lastname'=>$_POST['LName'],'firstname'=>$_POST['FName'],'middlename'=>$_POST['MName'], 'fullname'=>$_POST['FName']." ".$_POST['MName']." ".$_POST['LName'],'email'=>$_POST['emailadd'],'nickname'=>$_POST['PName'],'gender'=>$_POST['Ugender'],'deptid'=>$_POST['DeptName'],'contact'=>$_POST['CNumber'],'editedby'=>$IDuserLogged,'editeddate'=>$datenow);

      $db->where('tbl_users.userid',$id);
      $updUserData = $db->update('tbl_users',$UsDataArr);
			

	}
	if ($usRoleID) {
		
      $db->where('tbl_userroles.userroleid',$usRoleID);
      $UpdateRole = $db->update("tbl_userroles", Array('roleid'=>$_POST['rolename'], 'userrolestat'=>$_POST['userrolestat'],'editedby'=>$IDuserLogged,'editeddate'=>$datenow));
	}
      

            if($db->getLastErrno() === 0){
            header('location:userroles.php?action=UpdSuccess');
            }
            else{

              $errMes = $db->getLastError();
              header('location:userroles.php?action=UpdFailed&err='.$errMes);
            }
    
}



function viewCat(){

	global $db;
	$db->where('catstatus',1);
	$db->orderBy('catdesc', ASC);
	$selCat = $db->get("tbl_category");
	foreach ($selCat as $key => $value) {
		echo "<option value=".$value['catid'].">".$value['catdesc']."</option>";
	}
}


function viewSubCat($catid){
	
	global $db;
	$db->where('catid',$catid);
	$selsubcat = $db->get("tbl_subcategory");

	foreach ($selsubcat as $key => $value) {
		echo "<option value=".$value['subcatid'].">".$value['subcatdesc']."</option>";
	}
}
function viewSubCatNAssigned($catid){
	global $db;
	$db->where('tbl_subcategory.catid',$catid);
	$db->orderBy('subcatdesc', ASC);
	$db->join('tbl_category','tbl_subcategory.`catid` = tbl_category.`catid`','INNER');
	$db->join('tbl_assignedref','tbl_subcategory.`subcatid` = tbl_assignedref.`subcatid`','INNER');
	$db->join('tbl_users','tbl_assignedref.`userid` = tbl_users.`userid`','INNER');

	$selData = $db->get("tbl_subcategory",null,"tbl_subcategory.subcatid SCID,tbl_subcategory.subcatdesc SCName,tbl_subcategory.subcatstatus SCstat,tbl_users.userid SCAssID, tbl_users.fullname SCAssName");

	foreach ($selData as $key => $value) {
		if($key == 0){
			echo "<td>".$value['SCName']."</td><td>".$value['SCAssName']."</td>";
			if($value['SCstat'] == 1){
			echo "<td><i class='large green checkmark icon'></i></td>";	
			}
			else{
				echo "<td></td>";
			}
			echo "<td><a href='modEditSubcat.php?id=$value[SCID]' data-position='left center' data-variation='mini' data-tooltip='Edit Subcategory' class='circular mini ui right floated icon basic button'><i class='fa fa-pencil-square-o'></i></a></td>";
		}else{
			echo "<tr>";
			echo "<td>".$value['SCName']."</td><td>".$value['SCAssName']."</td>";
			if($value['SCstat'] == 1){
			echo "<td><i class='large green checkmark icon'></i></td>";
				
			}
			else{
				echo "<td></td>";
			}
			echo "<td><a href='modEditSubcat.php?id=$value[SCID]' data-position='left center' data-variation='mini' data-tooltip='Edit Subcategory' class='circular mini ui right floated icon basic button'><i class='fa fa-pencil-square-o'></i></a></td>";
			echo "</tr>";
		} 
	}
}
function getTotSubCatCount($catid){
	global $db;
	$db->where('catid',$catid);
	$selCnt = $db->getValue("tbl_subcategory","count(subcatid)");

	return $selCnt;
}
function editSC(){
	global $db, $datenow, $IDuserLogged;

	$subcatID = $_POST['subcatID'];
	$subcatname = $_POST['subcatname'];
	$subcatAssID = $_POST['HRassign'];
	$subcatStatus = $_POST['subcatstat'];

	$arrUp = Array('subcatdesc'=>$subcatname,'subcatstatus'=>$subcatStatus, 'editeddate'=>$datenow, 'editedby'=>$IDuserLogged);
	
	$db->where('tbl_subcategory.subcatid',$subcatID);
	$upd = $db->update('tbl_subcategory',$arrUp);
	
	$arrUp2 = Array('userid'=>$subcatAssID, 'edittimestamp'=>$datenow);
	$db->where('tbl_assignedref.subcatid',$subcatID);
	$upd2 = $db->update('tbl_assignedref',$arrUp2);

	if($db->getLastErrno() === 0){
		header('location:category.php?action=UpSCsuccess');
	}
	else{
		$errMes = $db->getLastError();
		header('location:category.php?action=UpSCfailed&err'.$errMes);
	}

}
function AddSC($catid){
	if($catid){
		global $db, $datenow, $IDuserLogged;
			$subcatname = $_POST['subcatname'];
			$subcatAssID = $_POST['HRassign'];
			$subcatStatus = $_POST['subcatstat'];

			$insSC = $db->insert('tbl_subcategory',Array('subcatdesc'=>$subcatname,'subcatStatus'=>$subcatStatus,'catid'=>$catid, 'createddate'=>$datenow, 'createdby'=>$IDuserLogged));
			$insID = $db->getInsertId();
			if($insID){
				$insAss = $db->insert('tbl_assignedref',Array('subcatid'=>$insID,'userid'=>$subcatAssID, 'roleid'=>3, 'edittimestamp'=>$datenow));
			}
				if($db->getLastErrno() === 0)
				{
					header('location:category.php?action=AddSCsuccess');
				}
				else{
					$errMes = $db->getLastError();
					header('location:category.php?action=AddSCfailed&err'.$errMes);
				}
			}
}
function editCat($catid){
	if($catid){
			$catname = $_POST['catname'];
			$catstat = $_POST['catstat'];
		global $db, $datenow, $IDuserLogged;
		 $db->where('catid',$catid);
		 $updCat = $db->update('tbl_category',Array('catdesc'=>$catname,'catstatus'=>$catstat,'editeddate'=>$datenow,'editedby'=>$IDuserLogged));
		 		if($db->getLastErrno() === 0)
				{
					header('location:category.php?action=UpCatsuccess');
				}
				else{
					$errMes = $db->getLastError();
					header('location:category.php?action=UpCatfailed&err'.$errMes);
				}
	}
}

function addCat(){
	
		$catname = $_POST['catname'];
		$catstat = $_POST['catstat'];
		global $db, $datenow, $IDuserLogged;
		 $insCat = $db->insert('tbl_category',Array('catdesc'=>$catname,'catstatus'=>$catstat,'createddate'=>$datenow,'createdby'=>$IDuserLogged));
		 		if($db->getLastErrno() === 0)
				{
					header('location:category.php?action=AddCatsuccess');
				}
				else{
					$errMes = $db->getLastError();
					header('location:category.php?action=AddCatfailed&err'.$errMes);
				}
}
function viewUsers($roleid, $relID){
	global $db;
	$db->where("roleid",$roleid);
	$db->where("userrolestat = 1");
	$db->join("tbl_users","tbl_userroles.userid = tbl_users.userid",'LEFT');
	$selUsers = $db->get("tbl_userroles",null,"tbl_userroles.userid AS myID,tbl_userroles.roleid,tbl_users.fullname AS myName");

	foreach ($selUsers as $key => $value) {
		if($relID != $value['myID']){
		echo "<option value=".$value['myID'].">".$value['myName']."</option>";
	}
	}
}

function selAssignUserinCat($catid){
	global $db;
	if($catid){
		$db->where("tbl_rolecategoryref.catid",$catid);
		
		$selUser = $db->getOne("tbl_rolecategoryref");

		echo $selUser['userid'];
	}
}

#####################################################################################################################################

function createTrans(){
	
		$typeName = $_POST['type'];
		$typeval = $_POST['typeval'];
		$cat = $_POST['transcat'];
		$subcat = $_POST['transsubcat'];
		$tdesc = $_POST['transdesc'];
		$trnsby = $_SESSION['portal_loguser'];
		$AssignToID = getTransAssigned($subcat);/*get User Assigned based on subcategory*/
		
		
		global $db, $datenow;
		$insData = Array('transdatetime'=>$datenow, 'transby'=>$trnsby, 'transservtypeid'=>$typeval, 'transcat'=>$cat, 'transsubcat'=>$subcat,'transstat'=>'1', 'transdesc'=>$tdesc, 'transassignto'=>$AssignToID);

		$TransIns = $db -> insert('tbl_transactions', $insData);
		$InsId = $db->getInsertId();

					$Attach = attachFileTrns($InsId, 1);
				if ($db->getLastErrno() === 0){
					$emailFunc = eMailer($InsId, $typeName, 1, $trnsby, $tdesc, $cat, $subcat, $datenow, $AssignToID, "");
					//header('location:qrscreate.php?type='.$typeName.'&action=Added');
					header('location:details2.php?QRSid='.$InsId.'&action=newlyCreated');
				}
		    	else{
		    		$errMes = $db->getLastError();
		    		header('location:qrscreate.php?type='.$typeName.'&action=Failed&err='.$errMes);
		    	}

}

function getTransAssigned($id){
	global $db;

	if($id){
		$db->where('subcatid',$id);
		$sel = $db->getOne('tbl_assignedref');
	}

	return $sel['userid'];
}

#######################################################################################################################################
function Response(){
	global $db, $datenow;

	$trnsID = $_POST['transID'];
	$actualResp = $_POST['res_actual'];
	$newStat = $_POST['res_stat'];
	$prevStat = $_POST['currStatID'];
	$AssUserID = $_POST['AssUserID'];

	$datecommittedTo = ($_POST['comdate_to'] != "") ? date("Y-m-d",strtotime($_POST['comdate_to'])) : null;
	$datecommittedFr = ($_POST['comdate_fr'] != "") ? date("Y-m-d",strtotime($_POST['comdate_fr'])) : null;
	$datefinished = ($_POST['finishdate'] != "") ? date("Y-m-d",strtotime($_POST['finishdate'])) : null;

	$reassign = ($_POST['reassignID'] != "") ? ($_POST['reassignID']) : (($_POST['reassigntoID']) ? ($_POST['reassigntoID']) : null);

	//$respDate = date("Y-m-d G:i:s");

		

	$trnsUpData = Array('transstat'=>$newStat,
		'transprevstat'=>$prevStat,
		'datecommitted_from'=>$datecommittedFr,
		'datecommitted_to'=>$datecommittedTo, 
		'datefinished'=>$datefinished,
		'relativeid'=>$reassign,
		);


	$resInsData = Array('respdatetime'=>$datenow, 'resptransid'=>$trnsID, 'respby'=>$_SESSION['portal_loguser'], 'respactual'=>$actualResp, 'respstatus'=>$newStat, 'relativeid'=>$_SESSION['uID']);

		$db->where('transid',$trnsID);
		$TrnsUpd = $db -> update('tbl_transactions', $trnsUpData);

		$ResIns = $db->insert('tbl_response',$resInsData);
		$ResInsId = $db->getInsertId();

		/*temp function--for recording of ID of HR Last Response */
		$ArrStat = Array(2,3,4);
		if(in_array($newStat, $ArrStat)){
			$upLastRespHR = Array('relativeid2'=>$_SESSION['uID']);
			$db->where('transid',$trnsID);
			$TrnsUpd = $db -> update('tbl_transactions', $upLastRespHR);
		}

		/*select Transaction Data*/
		$db->where('transid',$trnsID);
		$db->join('tbl_servicetype','tbl_transactions.transservtypeid = tbl_servicetype.servtypeid','INNER');
		$activeTrns = $db->getOne("tbl_transactions","tbl_servicetype.servtypedesc, tbl_transactions.transby, tbl_transactions.transdesc, tbl_transactions.transcat, tbl_transactions.transsubcat, tbl_transactions.transdatetime, tbl_transactions.transassignto, tbl_transactions.relativeid RSID");

			$RespAttach = attachFileTrns($trnsID, 2, $ResInsId);

		if($db->getLastErrno == 0)
		{
		$emailFunc = eMailer($trnsID, $activeTrns['servtypedesc'], $newStat, $activeTrns['transby'], $activeTrns['transdesc'], $activeTrns['transcat'], $activeTrns['transsubcat'], $activeTrns['transdatetime'], $activeTrns['transassignto'], $activeTrns['RSID']);

		header('Location: '.$_SERVER['PHP_SELF'].'?QRSid='.$trnsID);
		}
}
########################################################################################################################################
function eMailer($trID, $trType, $stat, $RepUID, $trDesc, $trCat, $trSubCat, $trDate, $trAssTo, $trReAssTo){
global $db;

if($stat){	
	$db->where('statid',$stat);
	$selStat = $db->getOne('tbl_status');
}

if($RepUID){

	$repU_info = getDPortalUser($RepUID);
}

if($trCat){
	$db->where('catid',$trCat);
	$selC = $db->getOne('tbl_category');
}

if($trSubCat){
	$db->where('subcatid',$trSubCat);
	$selSC = $db->getOne('tbl_subcategory');
}

$mytrDate = date("F j, Y,  h:i A",strtotime($trDate));

$Subject = "HR-QRS - ".$trType." # ".$trID." - ".$selStat['statremarks'];

if($stat == 1){
	$messageHead = "This is an automated message informing that you have ".$trType." from ".$repU_info['FName']." ".$repU_info['LName'];
	
}
else{
	$messageHead = "This is an automated message informing that ".$trType." was updated and ".$selStat['statremarks']; 
}

$message = "
<html>
<head>
</head>
<body>
<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px'>
<div style='margin-top:10px;'>

	<div style='padding-left:1px; padding-top:8px'>
	".$messageHead.".
	</div>
	<br/>

	<div style='border:1px solid black'>
	<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px'>

			<div style='padding-left:5px'>
				<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px'>
					<table style='font-family:Arial, Helvetica, sans-serif; font-size:12px; border-collapse:collapse; border:1px solid black' width='90%' >

					<tr>
					<td width='25%' style='border:1px solid black'><span style='padding:5px'><strong>Category:</strong></span></td>
					<td style='border:1px solid black'><span style='padding:5px'>".$selC['catdesc']." - ".$selSC['subcatdesc']."</span></td>
					</tr>

					<tr>
					<td width='25%' style='border:1px solid black'><span style='padding:5px'><strong>Description:</strong></span></td>
					<td style='border:1px solid black'><span style='padding:5px'>".$trDesc."</span></td>
					</tr>

					<tr>
					<td width='25%' style='border:1px solid black'><span style='padding:5px'><strong>Reported By:</strong></span></td>
					<td style='border:1px solid black'><span style='padding:5px'>".$repU_info['FName']." ".$repU_info['LName']."</span></td>
					</tr>

					<tr>
					<td width='25%' style='border:1px solid black'><span style='padding:5px'><strong>Date Created:</strong></span></td>
					<td style='border:1px solid black'><span style='padding:5px'>".$mytrDate."</span></td>
					</tr>

					<tr>
					<td width='25%' style='border:1px solid black'><span style='padding:5px'><strong>Status:</strong></span></td>
					<td style='border:1px solid black'><span style='padding:5px'>".$selStat['statdesc']." - ".$selStat['statremarks']."</span></td>
					</tr>

					</table>
				</p>
			</div>

		<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px'>
		<div style='padding-left:5px; padding-top:8px'>
		You can view the issue through this address <a href='https://www.batobalani.com/diwaportal'>https://batobalani.com/diwaportal</a> then choose HR-Query and Request System under HR Tab.
		</div>
		</p>

	</p>
	</div>

	<p style='font-family:Arial, Helvetica, sans-serif; font-size:11px'>
	<i>This is a system-generated email. Please do not reply. If you have questions or comments, you may contact us directly at local 381.</i>
	</p>

</div>
</p>

</body>
</html>
";

	
	$userEmail = Array();

	//Open, Closed, Cancelled, Back to HR Specialist
	if(in_array($stat, Array(1,6,7,8))){
		
		$db->where('tbl_users.userid',$trAssTo);
		$s = $db->getOne("tbl_users");

		array_push($userEmail, $s['email']);

	}
	//In Progress, Closed, For User Approval, Back to Requestor
	if(in_array($stat, Array(2,3,4,6))){

		array_push($userEmail, $repU_info['emp_email']);
	}
	//Open(Reassignment), Closed
	if (in_array($stat, Array(5,6))) {
		
			$db->where('tbl_users.userid',$trReAssTo);
			$sc = $db->getOne("tbl_users");

			array_push($userEmail, $sc['email']);
	}
	
	
	//HR Coordinator Email
	$db->where('tbl_userroles.roleid',2);
	$db->join('tbl_users','tbl_userroles.userid = tbl_users.userid','LEFT');
	$selHRCoorEmail = $db->get('tbl_userroles',null,'tbl_userroles.userid HRCoorID, tbl_users.email HRCoorEmail');
		foreach ($selHRCoorEmail as $key => $value) {
			array_push($userEmail, $value['HRCoorEmail']);
		}

	if ($userEmail) {
		SendMail($userEmail, $Subject, $message);

		/*print_r($userEmail);
		echo "<br/>";
		echo $Subject;
		echo "<br/>";
		echo $message;*/
	}

}

#########################################################################################################################################
/*refid = Trans ID, $type  = if 1=> for transaction, 2=> for response, $relid = response id*/
function attachFileTrns($refid, $type, $relid){
	date_default_timezone_set('Asia/Manila');	
	$date =  date("mdYgis__");
	//$Attachdate = date("Y-m-d G:i:s");
		

	if(isset($refid)){
		global $db, $datenow;

		$attachName = $_FILES['trnsAttach']['name'];
		
			foreach($attachName as $key => $value){
				
			if($value){
			$str = preg_replace('/[\"\*\/\:\<\>\?\'\#\|]+/', '', $date.$_FILES['trnsAttach']['name'][$key]);
			$attachNamenew = str_replace(" ", "_", $str);
			$attachPathtemp = $_FILES['trnsAttach']['tmp_name'][$key];
			$location = "attachments/$attachNamenew";
			move_uploaded_file($attachPathtemp, $location);

			$AttachData = Array('attachpathname' => $location, 'attachtype' => $type, 'referenceid' => $refid, 'attachdatetime' => $datenow,'relativeid'=> $relid);
			
			$InsAttach = $db -> insert("tbl_attachments", $AttachData);
			}
			}
	}
}

#########################################################################################################################################
function dispAttachment($refid, $type, $relid){
	if($refid){
		global $db;

		if($refid){
		$db->where('referenceid',$refid);
		}
		if($type){
		$db->where('attachtype',$type);
		}
		if($relid){
			$db->where('relativeid', $relid);
		}

		$selAttachment = $db -> get('tbl_attachments',null,'attachid AS id,attachpathname AS path, referenceid AS trnsref, relativeid respRefID');

		foreach ($selAttachment as $key => $value) {
			$Trimfilename = substr($value['path'], strrpos($value['path'], '__') + 2);
			echo "<a href=".$value['path'].">".$Trimfilename."</a><br/>";
		}
	}
}
#########################################################################################################################################
/*for checking of array existence (multiple needle)	*/
function in_array_any($needles, $haystack) {
   return (bool)array_intersect($needles, $haystack);
}

/*return String of Status in Progress*/
function getStatProg($Roles, $statid){
	global $db;
	if($Roles){
		$db->where('roleid', $Roles, 'IN');
	}

	if($statid){
		$db->where('tbl_statprogressref.statid',$statid);
	}
	$selStatProg = $db->getOne("tbl_statprogressref");

	//$str = $db->getLastQuery();
	return $selStatProg['relativedata'];
}

function getSTProg($Role, $Stat){
	global $db;
	if($Role){
		$db->where('roleid',$Role);
	}
	if($Stat){
		$db->where('statid', $Stat);
	}

	$sel = $db->getOne("tbl_StatusProgRef", "relativedata");

	return $sel['relativedata'];
}

function getAssignedUser($catid, $userid){
		global $db;
		if($catid){
				$db->where('tbl_rolecategoryref.catid', $catid);
			}
		if($userid){
			$db->where('tbl_rolecategoryref.userid', $userid);
		} 

		$db->join('tbl_users','tbl_rolecategoryref.userid = tbl_users.userid','LEFT');
		$db->join('tbl_roles','tbl_rolecategoryref.roleid = tbl_roles.roleid','LEFT');

		$selAssUser = $db->getOne('tbl_rolecategoryref','tbl_users.userid AS myID,tbl_users.fullname AS myName, tbl_roles.roledesc AS myRole');

	return $selAssUser;
}

function chkTrnsCnt($trnsFilter, $type){
	global $db;

		if($trnsFilter == "active")
		{

		    $db->where("transstat",Array(6,7),"NOT IN");

			if(chk_role($_SESSION['portal_loguser'], 73)){
			 $db->where("transby",$_SESSION['portal_loguser']);
			}
			elseif(chk_role($_SESSION['portal_loguser'], 72)){

				 $db->where("((transstat = 1 AND transassignto = ".$_SESSION['uID'].") OR (transstat = 5 AND tbl_transactions.relativeid = ".$_SESSION['uID'].") OR (transstat IN(2,8) AND tbl_transactions.relativeid2 = ".$_SESSION['uID']."))");
			}

			if($type){
				$db->where("transservtypeid",$type);
				}
		}

		elseif($trnsFilter == "completed")
		{
				if($type){
				$db->where("transservtypeid",$type);
				}

			$db->where("transstat",Array(6,7),"IN");

	 		if(chk_role($_SESSION['portal_loguser'], 73)){
			 $db->where("transby",$_SESSION['portal_loguser']);
			}elseif(chk_role($_SESSION['portal_loguser'], 72)){
				$db->where("((transassignto = ".$_SESSION['uID']." AND tbl_transactions.relativeid IS NULL) OR (tbl_transactions.relativeid = ".$_SESSION['uID']."))");
			}
		}
		elseif($trnsFilter == "all")
		{

			if(chk_role($_SESSION['portal_loguser'], 73)){
			 $db->where("transby",$_SESSION['portal_loguser']);
			}elseif(chk_role($_SESSION['portal_loguser'], 72)){
				$db->where("((transassignto = ".$_SESSION['uID']." AND tbl_transactions.relativeid IS NULL) OR (tbl_transactions.relativeid = ".$_SESSION['uID']."))");
			}

				if($type){
				$db->where("transservtypeid",$type);
				}
		}

	$selmyCnt = $db->getValue("tbl_transactions","count(transid)");

	//return $db->getLastQuery();
	return $selmyCnt;

}

function getUser($id){
	global $db;

	if($id){
		$db->where('tbl_users.userid',$id);
		$selU = $db->getOne('tbl_users','fullname,nickname');
	}
	return $selU;
}

function getRoleDesc($id){
 global $db;

 $db->where("roleid",$id);
 $sel = $db->getOne("tbl_roles");

 return $sel['roledesc'];
}
##########################################################################################################################################
/**
Get Possible Next Status Based on Roles
**/

function getStatAccess($statID){
	if ($statID) {
		
		global $db;

		if(chk_role($_SESSION['portal_loguser'], 73)){
		$db->where("roledesc = 'User'");
		}
		elseif(chk_role($_SESSION['portal_loguser'], 72)){
		$db->where("roledesc = 'Support'");
		}
		elseif(chk_role($_SESSION['portal_loguser'], 71)){
		$db->where("roledesc = 'Admin'");
		}

			$db->where("statid", $statID);
			$sel = $db->getOne("tbl_statusprogref","relativedata");

		return $sel['relativedata'];
	}


}

#############################################################################################################################
/**
* new class for checking of profile
*/
class getUserProfile
{
	public $UPempid, $UPpname, $UPfname, $UPlname, $UPmname, $UPcontact, $UPgender, $UPdeptname, $UPavatar;
	function getbyID($uid)
	{
		global $db;
		$db->where('userid',$uid);
		$sel = $db->get('tbl_users');
		foreach ($sel as $key => $value) {
			$this -> UPempid = $value['empid'];
			$this -> UPpname = $value['nickname'];
			$this -> UPfname = $value['firstname'];
			$this -> UPlname = $value['lastname'];
			$this -> UPmname = $value['middlename'];
			$this -> UPcontact = $value['contact'];
			$this -> UPgender = $value['gender'];
			$this -> UPdeptname = $value['deptid'];
			$this -> UPavatar = $value['avatar'];
 		}

	}

	function getbyEmpID($EmpID){
		global $dbportal;
		$query = "SELECT * FROM Employee_reference INNER JOIN users ON Employee_reference.EmployeeID = users.emp_id WHERE Employee_reference.EmployeeID = '".$EmpID."' AND AOI = 'ACTIVE' AND DateResigned IS NULL";

		$rs = odbc_exec($dbportal, $query);
		$u_Arr = odbc_fetch_array($rs);
	
			$this -> UPempid = $u_Arr['EmployeeID'];
			$this -> UPpname = $u_Arr['FName'];
			$this -> UPfname = $u_Arr['FName'];
			$this -> UPlname = $u_Arr['LName'];
			$this -> UPmname = $u_Arr['MName'];
			$this -> UPgender = $u_Arr['Gender'];
			$this -> UPdeptname = $u_Arr['Department Number'];

	}

	function upUserData($EmpID){


			global $db, $datenow, $IDuserLogged;

			$picFileName = $_FILES['prefPicture']['name'];

					$str = preg_replace('/[\"\*\/\:\<\>\?\'\#\|]+/', '', $picFileName);
					$newStr = $EmpID."_".str_replace(" ", "_", $str);
					$fileTemp = $_FILES['prefPicture']['tmp_name'];
					$newLoc = "images/profiles/$newStr";
					move_uploaded_file($fileTemp, $newLoc);

					$db->where('empid',$_SESSION['portal_loguser']);
					$selU = $db->getOne('tbl_users');

					if($selU){
						$arrData = Array('firstname'=>$_POST['fname'], 'lastname'=>$_POST['lname'],'middlename'=>$_POST['mname'],'nickname'=>$_POST['Pname'], 'contact'=>$_POST['contact'], 'email'=>$_POST['email'], 'deptid'=>$_POST['deptname'],'avatar'=>$newLoc, 'editedby'=>$IDuserLogged, 'editeddate'=>$datenow);
						$db->where('empid',$_SESSION['portal_loguser']);
						$upD = $db -> update('tbl_users', $arrData);
					}else{

						$insData = Array('firstname'=>$_POST['fname'], 'lastname'=>$_POST['lname'],'middlename'=>$_POST['mname'],'nickname'=>$_POST['Pname'], 'contact'=>$_POST['contact'], 'email'=>$_POST['email'], 'deptid'=>$_POST['deptname'], 'avatar'=>$newLoc, 'userstatus'=>1, 'createdby'=>$IDuserLogged, 'createddate'=>$datenow);

						$ins = $db -> insert("tbl_users", $insData);
						$InsId = $db->getInsertId();
							
							$insDataURole = Array('userid'=>$InsId, 'roleid'=>4, 'userrolestat'=>1, 'createddate'=>$datenow, 'createdby'=>$IDuserLogged);
							$ins = $db -> insert("tbl_userroles", $insDataURole);

					}
					header('location:UserProfile.php');
	}

}

?>

