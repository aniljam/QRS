<!DOCTYPE html>
<html>
<head>
	<title>User Profile Modal</title>
	<!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="ext/semantic.min.css"/>
  <link rel="stylesheet" type="text/css" href="dist/css/mystyle.css"/>
	<script type="text/javascript" src="ext/semantic.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
			 $('#testmodal')
			 .modal({inverted: false})
       .modal('setting', 'closable', false)
			 .modal('setting','transition','vertical flip')
			 .modal('show');

        $('#btnCancel').on("click",function(){
          $('#testmodal')
          .modal('setting','transition','vertical flip')
          .modal('hide');
        });


	});


	</script>
</head>
<?php 
    include("dbfunc/panksyons.php");
?>
<body>
 <?php 
    $url = $_SERVER['HTTP_REFERER'];
    $urlid = substr($url, strrpos($url, '/') + 1);

    if (isset($_GET['id'])) {
        $userid = $_GET['id'];
      } 

      if($userid){
        global $db;

        $db->where('tbl_users.userid',$userid);
        $selUser = $db->getOne("tbl_users");
      }
  ?>

<div class="ui modal" id="testmodal">
  <div class="header">
    User Profile
  </div>
  <div class="image content">
            
            <form class="ui form segment">
              
              <div class="inline field">
                <?php if($selUser['gender']){
                                            if($selUser['gender'] == 1){
                                                $avatar = "images/avatar2-male.png";
                                            }
                                            elseif ($selUser['gender'] == 2) {
                                                $avatar = "images/avatar2-female.png";
                                            }
                                            else{
                                                $avatar = "images/a4.png";
                                            }
                                        } ?>
                                    <img class="ui small circular left floated bordered image" src="<?php echo $avatar; ?>">
               <label>Employee ID</label>
               <input type="text" name="EmpID" id="EmpID" value="<?php echo $selUser['empid']; ?>" readonly>
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
                <thead><tr><th colspan="2">Roles</th></tr></thead>
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
<div class="actions">
  <div class="ui buttons">
  <button class="ui positive button">Save</button>
  <div class="or"></div>
  <a href="<?php echo $urlid; ?>"><button class="ui button" id="btnCancel">Cancel</button></a>
  </div>
</div>
</div>
	
</body>
</html>
<script type="text/javascript">

</script>