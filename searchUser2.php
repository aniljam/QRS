<?php require_once('dbfunc/panksyons.php'); ?>

<?php 
$uID = $_GET['q'];

$userData = Array();

//$userRole = Array();

$selQRSaccnt = new LoggedAccount();
$selQRSaccnt -> getaccountuser($uID);
$selQRSaccnt -> getActiveRole($uID);

if($selQRSaccnt -> uID){
    
    $userData['userID'] = $selQRSaccnt -> uID;
    $userData['userEmpID'] = $selQRSaccnt -> empid;
    $userData['userFName'] = $selQRSaccnt -> QFName;
    $userData['userMName'] = $selQRSaccnt -> QMName;
    $userData['userLName'] = $selQRSaccnt -> QLName;
    $userData['userContact'] = $selQRSaccnt -> contact;
    $userData['userDept'] = $selQRSaccnt -> Dept;
    $userData['userEmail'] = $selQRSaccnt -> email;
    $userData['userNickName'] = $selQRSaccnt -> Pname;
    $userData['userFullName'] = $selQRSaccnt -> fullname;
    $userData['userGen'] = $selQRSaccnt -> Ugen;
    $userData['userRoleArrID'] = $selQRSaccnt -> QRarrayID;
    $userData['userRoleArr'] = $selQRSaccnt -> QRarray;
    
    
        //$userRole['roleArr'] = $selQRSaccnt -> QRarray;
    echo json_encode($userData);
    //echo json_encode($userRole);
}else{

$selDUsers = new GetUserDportal();
$selDUsers -> getActiveUser($uID);
    
    $userData['userID'] = "";
    $userData['userEmpID'] = $selDUsers -> u_empID;
    $userData['userFName'] = $selDUsers -> u_FN;
    $userData['userMName'] = $selDUsers -> u_MN;
    $userData['userLName'] = $selDUsers -> u_LN;
    $userData['userGen'] = $selDUsers -> u_gender;
    $userData['userDept'] = $selDUsers -> dept;
    $userData['userEmail'] = $selDUsers -> u_email;
    $userData['userNickName'] = $selDUsers -> u_FN;
    $userData['userFullName'] = $selDUsers -> Dfullname;
    $userData['userContact'] = "";
    $userData['userRoleArrID'] = "";
    $userData['userRoleArr'] = "";
    
    echo json_encode($userData);           
    
}

?>